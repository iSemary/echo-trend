<?php

namespace modules\Article\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use modules\Article\Transformers\ArticlesResource;
use modules\Author\Entities\Author;
use modules\Category\Entities\Category;
use modules\Country\Entities\Country;
use modules\Language\Entities\Language;
use modules\Provider\Entities\Provider;
use modules\Source\Entities\Source;
use modules\User\Entities\User;
use modules\User\Interfaces\UserInterestTypes;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as ArticlesCollection;
use modules\User\Entities\UserInterest;

class Article extends Model {
    use HasFactory, SoftDeletes;

    public static $elasticIndex = "EchoTrendArticles";
    public static $elasticType = "EchoTrendArticlesOwner";

    protected $fillable = ['title', 'slug', 'description', 'reference_url', 'body', 'image', 'is_head', 'provider_id', 'source_id', 'category_id', 'author_id', 'language_id', 'published_at'];

    public function language() {
        return $this->belongsTo(Language::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function source() {
        return $this->belongsTo(Source::class);
    }

    public function author() {
        return $this->belongsTo(Author::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function provider() {
        return $this->belongsTo(Provider::class);
    }

    /**
     * The function returns a query builder instance that joins the "sources" table with the "articles"
     * table and filters the results based on the given source slug and article slug.
     * 
     * @param Builder query The `` parameter is an instance of the `Builder` class, which represents
     * a query builder object in Laravel. It allows you to build and execute database queries.
     * @param string sourceSlug The sourceSlug parameter is a string that represents the slug of a source.
     * A slug is a URL-friendly version of a string, typically used in URLs to identify a resource. In this
     * case, it is used to identify a specific source in the database.
     * @param string articleSlug The `articleSlug` parameter is a string that represents the unique
     * identifier or slug of an article. It is used to filter the query results and retrieve articles with
     * a specific slug value.
     * 
     * @return Builder a Builder instance.
     */
    public function scopeBySourceAndArticleSlug(Builder $query, string $sourceSlug, string $articleSlug): Builder {
        return $query->join('sources', 'sources.id', 'articles.source_id')
            ->where('sources.slug', $sourceSlug)
            ->where('articles.slug', $articleSlug);
    }

    /**
     * The function returns a query builder instance that joins the 'sources' and 'authors' tables and
     * filters the results based on the given source slug and author slug.
     * 
     * @param Builder query The `` parameter is an instance of the `Builder` class, which represents
     * a query builder object. It is used to build and execute database queries.
     * @param string sourceSlug The sourceSlug parameter is a string that represents the slug of a source.
     * A slug is a URL-friendly version of a string, typically used in URLs to identify a resource. In this
     * case, it is used to identify a specific source in the database.
     * @param string authorSlug The `authorSlug` parameter is a string that represents the unique
     * identifier (slug) of an author. It is used to filter the query results based on the specified
     * author.
     * 
     * @return Builder a Builder instance.
     */
    public function scopeBySourceAndAuthorSlug(Builder $query, string $sourceSlug, string $authorSlug): Builder {
        return $query->join('sources', 'sources.id', 'articles.source_id')
            ->join('authors', 'authors.source_id', 'sources.id')
            ->where('sources.slug', $sourceSlug)
            ->where('authors.slug', $authorSlug);
    }

    /**
     * The function "scopeWithArticleRelations" returns a query builder object with eager loaded
     * relationships for language, country, source, author, category, and provider.
     * 
     * @param Builder query The `` parameter is an instance of the `Builder` class. It represents the
     * query builder instance that you can use to build and execute database queries.
     * 
     * @return Builder a Builder instance.
     */
    public function scopeWithArticleRelations(Builder $query): Builder {
        return $query->select(['articles.id', 'articles.title', 'articles.slug', 'description', 'reference_url', 'body', 'image', 'is_head', 'provider_id', 'source_id', 'category_id', 'author_id', 'language_id', 'published_at'])->with([
            'language' => function ($query) {
                $query->select('id', 'name', 'code');
            },
            'country' => function ($query) {
                $query->select('id', 'name', 'code');
            },
            'source' => function ($query) {
                $query->select('id', 'title', 'slug');
            },
            'author' => function ($query) {
                $query->select('id', 'name', 'slug');
            },
            'category' => function ($query) {
                $query->select('id', 'title', 'slug');
            },
            'provider' => function ($query) {
                $query->select('id', 'name');
            },
        ]);
    }

    /**
     * The function allows querying a builder object by a related item's slug.
     * 
     * @param Builder query The `` parameter is an instance of the `Builder` class, which represents
     * the query builder for the current model.
     * @param string itemSlug The itemSlug parameter is a string that represents the slug of the related
     * item. A slug is a URL-friendly version of a string, typically used in URLs to identify a specific
     * resource.
     * @param string itemTable The `itemTable` parameter refers to the name of the table that contains the
     * related items.
     * @param string itemForeignKey The `itemForeignKey` parameter is the foreign key column name in the
     * `articles` table that references the primary key column in the ``.
     * 
     * @return Builder a Builder instance.
     */
    public function scopeByRelatedItemSlug(Builder $query, string $itemSlug, string $itemTable, string $itemForeignKey): Builder {
        return $query->join($itemTable, $itemTable . '.id', 'articles.' . $itemForeignKey)
            ->where($itemTable . '.slug', $itemSlug);
    }

    /**
     * The function `getPreferredSourceArticles` retrieves a collection of preferred source articles for a
     * given user.
     * 
     * @param int userId The `userId` parameter is the unique identifier of the user for whom we want to
     * retrieve the preferred source articles.
     * 
     * @return ArticlesCollection a collection of articles.
     */
    public static function getPreferredSourceArticles(int $userId): ArticlesCollection {
        $sourceIds = UserInterest::getItemIds($userId, UserInterestTypes::SOURCE);
        $sourceArticles = Article::with(['language', 'country', 'source', 'author', 'category', 'provider'])
            ->whereIn("id", $sourceIds)
            ->orderByDesc("published_at")
            ->limit(8)
            ->get();

        return ArticlesResource::collection($sourceArticles);
    }

    /**
     * The function retrieves the preferred category articles for a given user and returns them as a
     * collection.
     * 
     * @param int userId The `userId` parameter is the ID of the user for whom we want to retrieve
     * preferred category articles.
     * 
     * @return ArticlesCollection a collection of articles.
     */
    public static function getPreferredCategoryArticles(int $userId): ArticlesCollection {
        $categoryIds = UserInterest::getItemIds($userId, UserInterestTypes::CATEGORY);
        $categoryArticles = Article::with(['language', 'country', 'source', 'author', 'category', 'provider'])
            ->whereIn("id", $categoryIds)
            ->orderByDesc("published_at")
            ->limit(8)
            ->get();

        return ArticlesResource::collection($categoryArticles);
    }

    /**
     * The function retrieves a collection of articles written by the preferred authors of a user.
     * 
     * @param int userId The `userId` parameter is the ID of the user for whom we want to retrieve
     * preferred author articles.
     * 
     * @return ArticlesCollection a collection of articles that are written by the preferred authors of a
     * user.
     */
    public static function getPreferredAuthorArticles(int $userId): ArticlesCollection {
        $authorIds = UserInterest::getItemIds($userId, UserInterestTypes::AUTHOR);
        $authorArticles = Article::with(['language', 'country', 'source', 'author', 'category', 'provider'])
            ->whereIn("author_id", $authorIds)
            ->orderByDesc("published_at")
            ->limit(8)
            ->get();

        return ArticlesResource::collection($authorArticles);
    }
}
