<?php

namespace modules\Category\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Interfaces\ItemsInterface;
use Illuminate\Http\JsonResponse;
use modules\Article\Entities\Article;
use modules\Article\Transformers\ArticlesCollection;
use modules\Category\Entities\Category;
use modules\User\Interfaces\UserViewsTypes;

class CategoryController extends ApiController {

    /**
     * The index function retrieves categories from the database and returns them in a JSON response.
     * 
     * @return JsonResponse a JsonResponse with a status code of 200, a message of "Categories fetched
     * successfully", and an array of categories.
     */
    public function index(): JsonResponse {
        $categories = Category::select(['categories.id', 'categories.title', 'categories.slug'])
            ->leftJoin('articles', 'categories.id', '=', 'articles.category_id')
            ->groupBy('categories.id', 'categories.title', 'categories.slug')
            ->orderByRaw('COUNT(articles.id) DESC')
            ->get();
        return $this->return(200, "Categories fetched successfully", ['categories' => $categories]);
    }

    /**
     * The function retrieves articles belonging to a specific category and returns them in a JSON
     * response, while also recording the user's view if they are authenticated.
     * 
     * @param string categorySlug The parameter "categorySlug" is a string that represents the slug of a
     * category. A slug is a URL-friendly version of a string, typically used in URLs to identify a
     * resource. In this case, the categorySlug is used to find a category in the database based on its
     * slug value.
     * 
     * @return JsonResponse a JsonResponse.
     */
    public function articles(string $categorySlug): JsonResponse {
        $user = $this->getAuthenticatedUser();
        $category = Category::where("slug", $categorySlug)->first();
        if (!$category) {
            return $this->return(400, "Category not exists fetched successfully");
        }
        $articles = Article::withArticleRelations()->byRelatedItemSlug($categorySlug, ItemsInterface::CATEGORY, ItemsInterface::CATEGORY_KEY)->paginate(20);
        $articles = new ArticlesCollection($articles);
        // mark user as viewed this article if user authenticated
        if ($user) $user->recordUserViewItem($user->id, $category->id, UserViewsTypes::CATEGORY);
        return $this->return(200, "Category articles fetched successfully", ['articles' => $articles]);
    }
}
