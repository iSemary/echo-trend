<?php

namespace modules\Article\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use modules\Author\Entities\Author;
use modules\Category\Entities\Category;
use modules\Country\Entities\Country;
use modules\Language\Entities\Language;
use modules\Provider\Entities\Provider;
use modules\Source\Entities\Source;

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
        return $query->leftJoin('sources', 'sources.id', 'articles.source_id')
            ->where('sources.slug', $sourceSlug)
            ->where('articles.slug', $articleSlug);
    }

    public function scopeBySourceAndAuthorSlug(Builder $query, string $sourceSlug, string $authorSlug): Builder {
        return $query->leftJoin('sources', 'sources.id', 'articles.source_id')
            ->leftJoin('authors', 'authors.source_id', 'sources.id')
            ->where('sources.slug', $sourceSlug)
            ->where('authors.slug', $authorSlug);
    }

    public function scopeWithArticleRelations(Builder $query): Builder {
        return $query->with(['language', 'country', 'source', 'author', 'category', 'provider']);
    }

    public function scopeByRelatedItemSlug(Builder $query, string $itemSlug, string $itemTable, string $itemForeignKey): Builder {
        return $query->leftJoin($itemTable, $itemTable . '.id', 'articles.' . $itemForeignKey)
            ->where($itemTable . '.slug', $itemSlug);
    }
}
