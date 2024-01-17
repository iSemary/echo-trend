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

class ArticleController extends ApiController {

    /**
     * The function retrieves an article by its source and article slug, marks the user as viewed the
     * article if authenticated, filters the article object, retrieves related articles based on the
     * article's category and source, and returns the article and related articles in a JSON response.
     * 
     * @param string sourceSlug The `sourceSlug` parameter is a string that represents the slug of the
     * source from which the article is being fetched. A slug is a URL-friendly version of a string,
     * typically used in URLs to identify a specific resource. In this case, it is used to identify the
     * source of the article.
     * @param string articleSlug The `articleSlug` parameter is a string that represents the unique
     * identifier or slug of an article. It is used to retrieve a specific article from the database.
     * 
     * @return JsonResponse a JsonResponse with the following data:
     * - Status code: 200
     * - Message: "Article fetched successfully"
     * - Data: An array with two keys:
     *   - 'article': An instance of the ArticleResource class representing the fetched article.
     *   - 'related_articles': An instance of the ArticlesCollection class representing a collection of
     * related articles.
     */
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

    /**
     * The function finds articles based on a search request, including keyword, category ID, source ID,
     * and date order, and returns a JSON response with the fetched articles.
     * 
     * @param SearchRequest searchRequest An object of type SearchRequest, which contains the search
     * parameters such as keyword, category_id, source_id, and date_order.
     * 
     * @return JsonResponse a JsonResponse with a status code of 200, a message of "Articles fetched
     * successfully", and an array containing the 'articles' key with the value of the  variable.
     */
    public function find(SearchRequest $searchRequest): JsonResponse {
        $searchRequest = $searchRequest->validated();
        $keyword = $searchRequest['keyword'];
        $categoryId = $searchRequest['category_id'] ?? "";
        $sourceId = $searchRequest['source_id'] ?? "";

        $articles = Article::withArticleRelations()->where("title", "like", "%" . $keyword . "%")
            ->orWhere("description", "like", "%" . $keyword . "%")
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where("articles.category_id", $categoryId);
            })
            ->when($sourceId, function ($query) use ($sourceId) {
                $query->where("articles.source_id", $sourceId);
            })
            ->orderBy("published_at", $searchRequest['date_order'])
            ->paginate(20);
        $articles = new ArticlesCollection($articles);

        return $this->return(200, "Articles fetched successfully", ['articles' => $articles]);
    }

    // TODO use elasticsearch engine
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

    /**
     * The function retrieves today's articles and returns them as a JSON response.
     * 
     * @return JsonResponse A JsonResponse is being returned.
     */
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
