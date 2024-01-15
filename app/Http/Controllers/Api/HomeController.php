<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use modules\Article\Entities\Article;
use stdClass;

class HomeController extends ApiController {
    public function index(): JsonResponse {
        $response = new stdClass();
        $response->headings = $this->getTopHeadings();

        return $this->return(200, "Home details fetched successfully", ['data' => $response]);
    }

    private function getTopHeadings(): Collection {
        return Article::where("is_head", 1)->orderByDesc("published_at")->limit(4)->get();
    }
}
