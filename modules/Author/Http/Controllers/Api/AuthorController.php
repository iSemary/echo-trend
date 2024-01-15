<?php

namespace modules\Author\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Interfaces\ItemsInterface;
use Illuminate\Http\JsonResponse;
use modules\Article\Entities\Article;
use modules\Author\Entities\Author;

class AuthorController extends ApiController {

    public function index(): JsonResponse {
        $authors = Author::select(['id', 'name', 'slug'])->orderBy("name")->get();
        return $this->return(200, "Authors fetched successfully", ['authors' => $authors]);
    }

    public function articles(string $authorSlug): JsonResponse {
        $articles = Article::withArticleRelations()->byRelatedItemSlug($authorSlug, ItemsInterface::AUTHOR, ItemsInterface::AUTHOR_KEY)->paginate(20);
        return $this->return(200, "Author articles fetched successfully", ['articles' => $articles]);
    }
}
