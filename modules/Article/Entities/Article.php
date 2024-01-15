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

    protected $fillable = ['title', 'slug', 'description', 'reference_url', 'body', 'image', 'provider_id', 'source_id', 'category_id', 'author_id', 'language_id', 'published_at'];

    public function language() {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function source() {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function author() {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function provider() {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function scopeBySourceAndArticleSlug(Builder $query, string $sourceSlug, string $articleSlug): Builder {
        return $query->leftJoin('sources', 'sources.id', 'articles.source_id')
            ->where('sources.slug', $sourceSlug)
            ->where('articles.slug', $articleSlug);
    }

    public function scopeWithArticleRelations(Builder $query): Builder {
        return $query->with(['language', 'country', 'source', 'author', 'category', 'provider']);
    }

    public function scopeByRelatedItemSlug(Builder $query, string $itemSlug, string $itemTable, string $itemForeignKey): Builder {
        return $query->leftJoin($itemTable, $itemTable . '.id', 'articles.' . $itemForeignKey)
            ->where($itemTable . '.slug', $itemSlug);
    }
}
