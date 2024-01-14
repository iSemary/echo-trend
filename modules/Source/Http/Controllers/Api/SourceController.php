<?php

namespace modules\Source\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use modules\Source\Entities\Source;

class SourceController extends ApiController {

    public function index(): JsonResponse {
        $sources = Source::select(['id', 'title', 'slug', 'url'])->orderBy("title")->get();
        return $this->return(200, "Sources fetched successfully", ['sources' => $sources]);
    }
}
