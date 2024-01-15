<?php

namespace modules\Article\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use modules\Article\Entities\Article;
use modules\Article\Transformers\ArticleResource;

class ArticleController extends ApiController {

    public function show(string $sourceSlug, string $articleSlug): JsonResponse {
        $article = Article::withArticleRelations()->bySourceAndArticleSlug($sourceSlug, $articleSlug)->first();
        if (!$article) {
            return $this->return(404, "Article not found");
        }
        // Filter article object
        $article = new ArticleResource($article);
        return $this->return(200, "Article fetched successfully", ['article' => $article]);
    }
}
