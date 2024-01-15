<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use modules\Article\Entities\Article;
use modules\Article\Transformers\ArticlesResource;
use stdClass;

class HomeController extends ApiController {
    public function topHeadings(): JsonResponse {
        $topHeadings = $this->getTopHeadings();
        $topHeadings = ArticlesResource::collection($topHeadings);
        return $this->return(200, "Top headings fetched successfully", ['headings' => $topHeadings]);
    }

    private function getTopHeadings(): Collection {
        return Article::withArticleRelations()->where("is_head", 1)->orderByDesc("published_at")->limit(5)->get();
    }
}
