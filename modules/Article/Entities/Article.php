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
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function scopeBySourceAndArticleSlug(Builder $query, string $sourceSlug, string $articleSlug): Builder {
        return $query->join('sources', 'sources.id', 'articles.source_id')
            ->where('sources.slug', $sourceSlug)
            ->where('articles.slug', $articleSlug);
    }

    public function scopeBySourceAndAuthorSlug(Builder $query, string $sourceSlug, string $authorSlug): Builder {
        return $query->join('sources', 'sources.id', 'articles.source_id')
            ->join('authors', 'authors.source_id', 'sources.id')
            ->where('sources.slug', $sourceSlug)
            ->where('authors.slug', $authorSlug);
    }

    public function scopeWithArticleRelations(Builder $query): Builder {
        return $query->with(['language', 'country', 'source', 'author', 'category', 'provider']);
    }

    public function scopeByRelatedItemSlug(Builder $query, string $itemSlug, string $itemTable, string $itemForeignKey): Builder {
        return $query->join($itemTable, $itemTable . '.id', 'articles.' . $itemForeignKey)
            ->where($itemTable . '.slug', $itemSlug);
    }



    public static function getPreferredSourceArticles(int $userId): ArticlesCollection {
        $sourceIds = UserInterest::getItemIds($userId, UserInterestTypes::SOURCE);
        $sourceArticles = Article::with(['language', 'country', 'source', 'author', 'category', 'provider'])
            ->whereIn("id", $sourceIds)
            ->orderByDesc("published_at")
            ->limit(8)
            ->get();

        return ArticlesResource::collection($sourceArticles);
    }

    public static function getPreferredCategoryArticles(int $userId): ArticlesCollection {
        $categoryIds = UserInterest::getItemIds($userId, UserInterestTypes::CATEGORY);
        $categoryArticles = Article::with(['language', 'country', 'source', 'author', 'category', 'provider'])
            ->whereIn("id", $categoryIds)
            ->orderByDesc("published_at")
            ->limit(8)
            ->get();

        return ArticlesResource::collection($categoryArticles);
    }


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
