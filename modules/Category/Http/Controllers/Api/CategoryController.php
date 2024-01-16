<?php

namespace modules\Category\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Interfaces\ItemsInterface;
use Illuminate\Http\JsonResponse;
use modules\Article\Entities\Article;
use modules\Article\Transformers\ArticlesCollection;
use modules\Article\Transformers\ArticlesResource;
use modules\Category\Entities\Category;
use modules\User\Interfaces\UserViewsTypes;

class CategoryController extends ApiController {

    public function index(): JsonResponse {
        $categories = Category::select(['id', 'title', 'slug'])->orderBy("order_number", "DESC")->get();
        return $this->return(200, "Categories fetched successfully", ['categories' => $categories]);
    }

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
