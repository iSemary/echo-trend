<?php

namespace modules\Author\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use modules\Author\Entities\Author;

class AuthorController extends ApiController {

    public function index(): JsonResponse {
        $authors = Author::select(['id', 'name', 'slug'])->orderBy("name")->get();
        return $this->return(200, "Authors fetched successfully", ['authors' => $authors]);
    }
}
