<?php

namespace modules\Source\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Interfaces\ItemsInterface;
use Illuminate\Http\JsonResponse;
use modules\Article\Entities\Article;
use modules\Source\Entities\Source;

class SourceController extends ApiController {

    public function index(): JsonResponse {
        $sources = Source::select(['id', 'title', 'slug', 'url'])->orderBy("title")->get();
        return $this->return(200, "Sources fetched successfully", ['sources' => $sources]);
    }

    public function articles(string $sourceSlug): JsonResponse {
        $articles = Article::withArticleRelations()->byRelatedItemSlug($sourceSlug, ItemsInterface::SOURCE, ItemsInterface::SOURCE_KEY)->paginate(20);
        return $this->return(200, "Source articles fetched successfully", ['articles' => $articles]);
    }
}
