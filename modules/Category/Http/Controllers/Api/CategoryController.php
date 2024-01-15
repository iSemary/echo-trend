<?php

namespace modules\Category\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Interfaces\ItemsInterface;
use Illuminate\Http\JsonResponse;
use modules\Article\Entities\Article;
use modules\Category\Entities\Category;

class CategoryController extends ApiController {

    public function index(): JsonResponse {
        $categories = Category::select(['id', 'title', 'slug'])->orderBy("order_number", "DESC")->get();
        return $this->return(200, "Categories fetched successfully", ['categories' => $categories]);
    }

    public function articles(string $categorySlug): JsonResponse {
        $articles = Article::withArticleRelations()->byRelatedItemSlug($categorySlug, ItemsInterface::CATEGORY, ItemsInterface::CATEGORY_KEY)->paginate(20);
        return $this->return(200, "Category articles fetched successfully", ['articles' => $articles]);
    }
}
