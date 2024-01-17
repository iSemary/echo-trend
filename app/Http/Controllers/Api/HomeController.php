<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use modules\Article\Entities\Article;
use modules\Article\Transformers\ArticlesResource;
use modules\Category\Entities\Category;
use modules\User\Entities\UserInterest;
use modules\User\Interfaces\UserInterestTypes;
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


    public function preferredArticles(): JsonResponse {
        $preferredArticles = $this->getPreferredArticles();
        return $this->return(200, "Preferred articles fetched successfully", ['articles' => $preferredArticles]);
    }

    public function randomCategoryArticles(): JsonResponse {
        $randomCategory = $this->getRandomCategory();
        $randomArticles = $this->getCategoryArticles($randomCategory);
        $randomArticles = ArticlesResource::collection($randomArticles);
        return $this->return(200, "Top headings fetched successfully", ['articles' => $randomArticles, 'category' => $randomCategory]);
    }

    private function getPreferredArticles(): array {
        $user = $this->getAuthenticatedUser();
        $combinedArticles = [
            'sources' => Article::getPreferredSourceArticles($user->id),
            'authors' => Article::getPreferredAuthorArticles($user->id),
            'categories' => Article::getPreferredCategoryArticles($user->id),
        ];
        return $combinedArticles;
    }

    // If auth then get from the prefer categories and sources
    private function getTopHeadings(): Collection {
        $user = $this->getAuthenticatedUser();
        $categoryIds = $user ? UserInterest::getItemIds($user->id, UserInterestTypes::CATEGORY) : [];
        return Article::withArticleRelations()->where("is_head", 1)
            ->when($categoryIds, function ($query) use ($categoryIds) {
                return $query->whereIn('category_id', $categoryIds);
            })->orderByDesc("published_at")->limit(5)->get();
    }

    // If auth then get from the prefer categories and sources
    private function getTopNews(): Collection {
        $user = $this->getAuthenticatedUser();
        $categoryIds = $user ? UserInterest::getItemIds($user->id, UserInterestTypes::CATEGORY) : [];
        return Article::withArticleRelations()->where("is_head", 0)
            ->when($categoryIds, function ($query) use ($categoryIds) {
                return $query->whereIn('category_id', $categoryIds);
            })->orderByDesc("published_at")->limit(8)->get();
    }

    // If auth then get from the prefer categories else get random category
    private function getRandomCategory(): ?Category {
        $user = $this->getAuthenticatedUser();
        $categoryIds = $user ? UserInterest::getItemIds($user->id, UserInterestTypes::CATEGORY) : [];

        return Category::with('articles')->when($categoryIds, function ($query) use ($categoryIds) {
            return $query->whereIn('id', $categoryIds);
        })
            ->select(['id', 'title', 'slug'])
            ->inRandomOrder()
            ->first();
    }

    private function getCategoryArticles(Category $category): Collection {
        return Article::withArticleRelations()->where("category_id", $category->id)
            ->where("is_head", 0)->orderByDesc("published_at")->limit(8)->get();
    }
}
