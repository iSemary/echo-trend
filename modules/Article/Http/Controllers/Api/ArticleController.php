<?php

namespace modules\Article\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Http\JsonResponse;
use modules\Article\Entities\Article;
use modules\Article\Transformers\ArticleResource;
use modules\User\Interfaces\UserViewsTypes;
use modules\Article\Http\Requests\SearchRequest;

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

    public function find(SearchRequest $searchRequest): JsonResponse {
        $searchRequest = $searchRequest->validated();
        $keyword = $searchRequest['keyword'];

        $articles = Article::withArticleRelations()->where("title", "like", "%" . $keyword . "%")
            ->orWhere("description", "like", "%" . $keyword . "%")
            ->paginate(20);

        return $this->return(200, "Articles fetched successfully", ['articles' => $articles]);
    }

    public function findDeeply(SearchRequest $searchRequest): JsonResponse {
        $searchRequest = $searchRequest->validated();
        $keyword = $searchRequest['keyword'];

        $articles = Article::withArticleRelations()->where("title", "like", "%" . $keyword . "%")
            ->orWhere("description", "like", "%" . $keyword . "%")
            ->orWhere("body", "like", "%" . $keyword . "%")
            ->paginate(20);

        return $this->return(200, "Articles fetched successfully", ['articles' => $articles]);
    }
}
