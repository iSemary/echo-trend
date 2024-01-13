<?php

namespace modules\Category\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use modules\Category\Entities\Category;

class CategoryController extends ApiController {

    public function index(): JsonResponse {
        $categories = Category::select(['id', 'title', 'slug'])->orderBy("order_number", "DESC")->get();
        return $this->return(200, "Categories fetched successfully", ['categories' => $categories]);
    }
}
