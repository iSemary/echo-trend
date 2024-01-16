<?php

namespace modules\Article\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use modules\Article\Entities\Article;
use modules\Article\Transformers\ArticleResource;
use modules\User\Interfaces\UserViewsTypes;
use modules\Article\Http\Requests\SearchRequest;
use modules\Article\Transformers\ArticlesCollection;
use modules\Article\Transformers\ArticlesResource;

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
        // Get Related Articles based on this article's category and source
        $relatedArticles = Article::withArticleRelations()->whereCategoryId($article->category_id)->whereSourceId($article->source_id)->inRandomOrder()->limit(8)->get();
        // Filter the collection
        $relatedArticles = new ArticlesCollection($relatedArticles);
        return $this->return(200, "Article fetched successfully", ['article' => $article, 'related_articles' => $relatedArticles]);
    }

    public function find(SearchRequest $searchRequest): JsonResponse {
        $searchRequest = $searchRequest->validated();
        $keyword = $searchRequest['keyword'];

        $articles = Article::withArticleRelations()->where("title", "like", "%" . $keyword . "%")
            ->orWhere("description", "like", "%" . $keyword . "%")
            ->paginate(20);
        $articles = new ArticlesCollection($articles);

        return $this->return(200, "Articles fetched successfully", ['articles' => $articles]);
    }

    public function findDeeply(SearchRequest $searchRequest): JsonResponse {
        $searchRequest = $searchRequest->validated();
        $keyword = $searchRequest['keyword'];

        $articles = Article::withArticleRelations()->where("title", "like", "%" . $keyword . "%")
            ->orWhere("description", "like", "%" . $keyword . "%")
            ->orWhere("body", "like", "%" . $keyword . "%")
            ->paginate(20);
        $articles = new ArticlesCollection($articles);
        return $this->return(200, "Articles fetched successfully", ['articles' => $articles]);
    }

    public function todayArticles(): JsonResponse {
        $today = Carbon::today();
        $articles = Article::withArticleRelations()->whereDate(
            DB::raw('FROM_UNIXTIME(published_at)'),
            '=',
            $today->toDateString()
        )->paginate(20);
        $articles = new ArticlesCollection($articles);
        return $this->return(200, "Today's articles fetched successfully", ['articles' => $articles]);
    }
}
