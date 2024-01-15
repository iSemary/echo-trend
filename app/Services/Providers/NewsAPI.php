<?php

namespace App\Services\Providers;

use App\Services\Abstractors\ProviderAbstractor;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use modules\Provider\Entities\Provider;
use modules\Source\Entities\Source;
use Illuminate\Support\Str;
use modules\Article\Entities\Article;
use modules\Author\Entities\Author;
use modules\Category\Entities\Category;
use modules\Country\Entities\Country;
use modules\Language\Entities\Language;

class NewsAPI extends ProviderAbstractor {
    private Provider $provider;
    private string $endPoint;
    private string $apiKey;

    public function __construct(Provider $provider) {
        $this->provider = $provider;
        $this->setApiKey($provider->api_key);
        $this->setEndPoint($provider->end_point);
    }

    public function fetch() {
        $this->fetchSources();
        $this->fetchArticles();
    }

    protected function fetchSources(): void {
        $response = Http::get($this->endPoint . '/sources', ['apiKey' => $this->apiKey]);
        if ($response->successful()) {
            $data = $response->json();
            $fetchedSources = $data['sources'];
            $this->createOrUpdateSources($fetchedSources);
        } else {
            $errorCode = $response->status();
            $errorMessage = $response->body();
        }
    }

    protected function fetchArticles(): void {
        $separatedSources = Source::select("slug")->inRandomOrder()->limit(3)->pluck('slug')->toArray();
        $separatedSources = implode(', ', $separatedSources);

        $response = Http::get($this->endPoint . '/everything', ['apiKey' => $this->apiKey, 'sources' => $separatedSources]);
        if ($response->successful()) {
            $data = $response->json();
            $fetchedArticles = $data['articles'];
            $this->createOrUpdateArticles($fetchedArticles);
        } else {
            $errorCode = $response->status();
            $errorMessage = $response->body();
        }
    }

    protected function createOrUpdateArticles(array $articles): void {
        if (isset($articles) && is_array($articles) && count($articles)) {
            foreach ($articles as $article) {
                // Create or update existing source category
                if (isset($article['source'])) {
                    $source = Source::updateOrCreate([
                        'title' => $article['source']['name'],
                        'slug' => $article['source']['id'],
                    ]);
                }

                $author = Author::updateOrCreate(['name' => $article['author'], 'slug' => Str::slug($article['author']), 'source_id' => $source->id]);

                Article::updateOrCreate([
                    'title' => $article['title'],
                    'slug' => Str::slug($article['title'])
                ], [
                    'author_id' => $author->id,
                    'source_id' => $source->id,
                    'provider_id' => $this->provider->id,
                    'category_id' => $source->category_id,
                    'language_id' => $source->language_id,
                    'country_id' => $source->country_id,
                    'description' => $article['description'],
                    'body' => $article['content'],
                    'reference_url' => $article['url'],
                    'image' => $article['urlToImage'],
                    'published_at' => strtotime($article['publishedAt']),
                ]);
            }
        }
    }

    protected function createOrUpdateSources(array $sources): void {
        if (isset($sources) && is_array($sources) && count($sources)) {
            foreach ($sources as $source) {
                // Create or update existing source category
                if (isset($source['category'])) {
                    $category = Category::updateOrCreate([
                        'title' => ucfirst($source['category']),
                        'slug' => $source['category']
                    ]);
                }
                // Create or update existing source country
                if (isset($source['category'])) {
                    $country = Country::updateOrCreate([
                        'name' => strtoupper($source['country']),
                        'code' => $source['country']
                    ]);
                }
                // Create or update existing source languages
                if (isset($source['language'])) {
                    $language = Language::updateOrCreate([
                        'name' => strtoupper($source['language']),
                        'code' => $source['language']
                    ]);
                }
                // Create source or update existing one
                Source::updateOrCreate([
                    'title' => $source['name'],
                    'slug' => Str::slug($source['name']),
                ], [
                    'description' => $source['description'],
                    'url' => $source['url'],
                    'category_id' => $category->id,
                    'country_id' => $country->id,
                    'language_id' => $language->id,
                ]);
            }
        }
    }

    protected function setApiKey(string $apiKey): void {
        $this->apiKey = Crypt::decrypt($apiKey);
    }

    protected function getApiKey(): string {
        return $this->apiKey;
    }

    protected function setEndPoint(string $endPoint): void {
        $this->endPoint = $endPoint;
    }

    protected function getEndPoint(): string {
        return $this->endPoint;
    }
}