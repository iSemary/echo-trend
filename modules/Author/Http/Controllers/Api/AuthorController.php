<?php

namespace modules\Author\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use modules\Article\Entities\Article;
use modules\Article\Transformers\ArticlesCollection;
use modules\Author\Entities\Author;

class AuthorController extends ApiController {

    /**
     * The index function retrieves a list of authors from the database and returns a JSON response with
     * the authors' id, name, and slug.
     * 
     * @return JsonResponse a JsonResponse with a status code of 200, a message of "Authors fetched
     * successfully", and an array of authors.
     */
    public function index(): JsonResponse {
        $authors = Author::select(['id', 'name', 'slug'])->orderBy("name")->get();
        return $this->return(200, "Authors fetched successfully", ['authors' => $authors]);
    }

    /**
     * The function retrieves a paginated list of articles by a specific author from a specific source and
     * returns it as a JSON response.
     * 
     * @param string sourceSlug The sourceSlug parameter is a string that represents the slug of the
     * source. A slug is a URL-friendly version of a string, typically used in URLs to identify a resource.
     * In this case, it is used to identify the source of the articles.
     * @param string authorSlug The authorSlug parameter is a string that represents the unique identifier
     * or slug of an author. It is used to filter the articles by a specific author.
     * 
     * @return JsonResponse A JsonResponse object is being returned.
     */
    public function articles(string $sourceSlug, string $authorSlug): JsonResponse {
        $articles = Article::withArticleRelations()->bySourceAndAuthorSlug($sourceSlug, $authorSlug)->paginate(20);
        $articles = new ArticlesCollection($articles);
        return $this->return(200, "Author articles fetched successfully", ['articles' => $articles]);
    }
}
