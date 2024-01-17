<?php

namespace modules\Source\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Interfaces\ItemsInterface;
use Illuminate\Http\JsonResponse;
use modules\Article\Entities\Article;
use modules\Article\Transformers\ArticlesCollection;
use modules\Source\Entities\Source;

class SourceController extends ApiController {

    /**
     * The index function retrieves a list of sources and returns a JSON response with the fetched sources.
     * 
     * @return JsonResponse A JSON response is being returned.
     */
    public function index(): JsonResponse {
        $sources = Source::select(['id', 'title', 'slug', 'url'])->orderBy("title")->get();
        return $this->return(200, "Sources fetched successfully", ['sources' => $sources]);
    }

    /**
     * The function retrieves a paginated list of articles related to a specific source slug and returns
     * them as a JSON response.
     * 
     * @param string sourceSlug The `sourceSlug` parameter is a string that represents the slug of a
     * source. It is used to filter the articles based on the source slug.
     * 
     * @return JsonResponse A JsonResponse object is being returned.
     */
    public function articles(string $sourceSlug): JsonResponse {
        $articles = Article::withArticleRelations()->byRelatedItemSlug($sourceSlug, ItemsInterface::SOURCE, ItemsInterface::SOURCE_KEY)->paginate(20);
        $articles = new ArticlesCollection($articles);
        return $this->return(200, "Source articles fetched successfully", ['articles' => $articles]);
    }
}
