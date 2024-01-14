<?php

namespace modules\Article\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class ArticleController extends ApiController {

    public function show(string $sourceSlug, string $articleSlug): JsonResponse {
        $article = [];

        return $this->return(200, "Article fetched successfully", ['article' => $article]);
    }
}
