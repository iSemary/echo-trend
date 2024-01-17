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

class HomeController extends ApiController {
    /**
     * The function "topHeadings" fetches the top headings and returns them as a JSON response.
     * 
     * @return JsonResponse a JsonResponse object.
     */
    public function topHeadings(): JsonResponse {
        $topHeadings = $this->getTopHeadings();
        $topHeadings = ArticlesResource::collection($topHeadings);
        return $this->return(200, "Top headings fetched successfully", ['headings' => $topHeadings]);
    }

    /**
     * The function "topNews" fetches the top news headings and returns them as a JSON response.
     * 
     * @return JsonResponse a JsonResponse object.
     */
    public function topNews(): JsonResponse {
        $topNews = $this->getTopNews();
        $topNews = ArticlesResource::collection($topNews);
        return $this->return(200, "Top headings fetched successfully", ['articles' => $topNews]);
    }


    /**
     * The function "preferredArticles" fetches preferred articles and returns a JSON response with the
     * fetched articles.
     * 
     * @return JsonResponse A JsonResponse object is being returned.
     */
    public function preferredArticles(): JsonResponse {
        $preferredArticles = $this->getPreferredArticles();
        return $this->return(200, "Preferred articles fetched successfully", ['articles' => $preferredArticles]);
    }

    /**
     * The function retrieves random articles from a random category and returns them along with the
     * category name.
     * 
     * @return JsonResponse A JsonResponse object is being returned.
     */
    public function randomCategoryArticles(): JsonResponse {
        $randomCategory = $this->getRandomCategory();
        $randomArticles = $this->getCategoryArticles($randomCategory);
        $randomArticles = ArticlesResource::collection($randomArticles);
        return $this->return(200, "Top headings fetched successfully", ['articles' => $randomArticles, 'category' => $randomCategory]);
    }

    /**
     * The function `getPreferredArticles()` retrieves preferred articles for a user based on their
     * sources, authors, and categories.
     * 
     * @return array an array called ``. This array contains three keys: 'sources',
     * 'authors', and 'categories'. The values associated with each key are the results of different
     * methods that retrieve preferred articles based on the authenticated user's ID.
     */
    private function getPreferredArticles(): array {
        $user = $this->getAuthenticatedUser();
        $combinedArticles = [
            'sources' => Article::getPreferredSourceArticles($user->id),
            'authors' => Article::getPreferredAuthorArticles($user->id),
            'categories' => Article::getPreferredCategoryArticles($user->id),
        ];
        return $combinedArticles;
    }

    /**
     * The function `getTopHeadings()` retrieves the top 5 articles that are marked as headlines, ordered
     * by their published date, and filtered based on the authenticated user's interests.
     * If auth then get from the prefer categories and sources
     * 
     * 
     * @return Collection The function `getTopHeadings()` returns a collection of articles that are marked
     * as "head" (is_head = 1) and are ordered by their published date in descending order. The number of
     * articles returned is limited to 5. The articles are filtered based on the user's interests, if the
     * user is authenticated.
     */
    private function getTopHeadings(): Collection {
        $user = $this->getAuthenticatedUser();
        $categoryIds = $user ? UserInterest::getItemIds($user->id, UserInterestTypes::CATEGORY) : [];
        return Article::withArticleRelations()->where("is_head", 1)
            ->when($categoryIds, function ($query) use ($categoryIds) {
                return $query->whereIn('category_id', $categoryIds);
            })->orderByDesc("published_at")->limit(5)->get();
    }

    /**
     * The function `getTopNews()` retrieves the top 8 articles with their related data, excluding the main
     * article, based on the user's interests and sorted by the published date.
     * If auth then get from the prefer categories and sources
     * @return Collection a collection of articles.
     */
    private function getTopNews(): Collection {
        $user = $this->getAuthenticatedUser();
        $categoryIds = $user ? UserInterest::getItemIds($user->id, UserInterestTypes::CATEGORY) : [];
        return Article::withArticleRelations()->where("is_head", 0)
            ->when($categoryIds, function ($query) use ($categoryIds) {
                return $query->whereIn('category_id', $categoryIds);
            })->orderByDesc("published_at")->limit(8)->get();
    }


    /**
     * The getRandomCategory function retrieves a random category with its associated articles, based on
     * the authenticated user's interests.
     * If auth then get from the prefer categories else get random category
     * 
     * @return ?Category a random Category object.
     */
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

    /**
     * The function `getCategoryArticles` retrieves a collection of articles belonging to a specific
     * category, excluding the head article, ordered by their published date in descending order, and
     * limited to a maximum of 8 articles.
     * 
     * @param Category category The `category` parameter is an instance of the `Category` class. It
     * represents the category for which you want to retrieve the articles.
     * 
     * @return Collection a collection of articles that belong to a specific category.
     */
    private function getCategoryArticles(Category $category): Collection {
        return Article::withArticleRelations()->where("category_id", $category->id)
            ->where("is_head", 0)->orderByDesc("published_at")->limit(8)->get();
    }
}
