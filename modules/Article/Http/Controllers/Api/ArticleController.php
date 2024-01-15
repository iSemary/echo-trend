<?php

namespace modules\Article\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use modules\Article\Entities\Article;
use modules\Article\Transformers\ArticleResource;
use modules\User\Interfaces\UserViewsTypes;

class ArticleController extends ApiController {

    public function show(string $sourceSlug, string $articleSlug): JsonResponse {
        $user = $this->getAuthenticatedUser();
        // Get article by source slug
        $article = Article::withArticleRelations()->bySourceAndArticleSlug($sourceSlug, $articleSlug)->first();
        if (!$article) {
            return $this->return(404, "Article not found");
        }
        // mark user as viewed this article if user authenticated
        if ($user) $user->recordUserViewItem($user->id, $article->id, UserViewsTypes::ARTICLE);
        // Filter article object
        $article = new ArticleResource($article);
        return $this->return(200, "Article fetched successfully", ['article' => $article]);
    }
}
