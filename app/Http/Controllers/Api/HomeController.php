<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use modules\Article\Entities\Article;
use modules\Article\Transformers\ArticlesResource;
use modules\Category\Entities\Category;
use stdClass;

class HomeController extends ApiController {
    public function topHeadings(): JsonResponse {
        $topHeadings = $this->getTopHeadings();
        $topHeadings = ArticlesResource::collection($topHeadings);
        return $this->return(200, "Top headings fetched successfully", ['headings' => $topHeadings]);
    }

    public function topNews(): JsonResponse {
        $topNews = $this->getTopNews();
        $topNews = ArticlesResource::collection($topNews);
        return $this->return(200, "Top headings fetched successfully", ['articles' => $topNews]);
    }

    public function locationArticles(): JsonResponse {
        $locationArticles = $this->getArticlesByLocation();
        $locationArticles = ArticlesResource::collection($locationArticles);
        return $this->return(200, "Top headings fetched successfully", ['articles' => $locationArticles]);
    }

    public function randomCategoryArticles(): JsonResponse {
        $randomCategory = $this->getRandomCategory();
        $randomArticles = $this->getCategoryArticles($randomCategory);
        $randomArticles = ArticlesResource::collection($randomArticles);
        return $this->return(200, "Top headings fetched successfully", ['articles' => $randomArticles, 'category' => $randomCategory]);
    }

    private function getArticlesByLocation(): Collection {
        // If authenticated user, get the location from the user
        // Else get from front end side
    }


    private function getTopHeadings(): Collection {
        // TODO If auth then get from the prefer categories and sources
        return Article::withArticleRelations()->where("is_head", 1)->orderByDesc("published_at")->limit(5)->get();
    }


    private function getTopNews(): Collection {
        // TODO If auth then get from the prefer categories and sources
        return Article::withArticleRelations()->where("is_head", 0)->orderByDesc("published_at")->limit(8)->get();
    }

    private function getRandomCategory(): ?Category {
        // TODO If auth then get from the prefer categories 
        return Category::with('articles')->select(['id', 'title', 'slug'])->inRandomOrder()->first();
    }

    private function getCategoryArticles(Category $category): Collection {
        return Article::withArticleRelations()->where("category_id", $category->id)
            ->where("is_head", 0)->orderByDesc("published_at")->limit(8)->get();
    }
}
