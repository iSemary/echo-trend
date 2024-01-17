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
    private array $countries = ['de', 'us', 'nl'];

    public function __construct(Provider $provider) {
        $this->provider = $provider;
        $this->setApiKey($provider->api_key);
        $this->setEndPoint($provider->end_point);
    }

    /**
     * The function sets the API key by decrypting the provided encrypted key.
     * 
     * @param string apiKey The `apiKey` parameter is a string that represents the API key that needs to be
     * set.
     */
    protected function setApiKey(string $apiKey): void {
        $this->apiKey = Crypt::decrypt($apiKey);
    }

    /**
     * The function "getApiKey" returns the value of the apiKey property as a string.
     * 
     * @return string a string value, which is the API key.
     */
    protected function getApiKey(): string {
        return $this->apiKey;
    }

    /**
     * The function sets the endpoint for a PHP class.
     * 
     * @param string endPoint The `endPoint` parameter is a string that represents the endpoint of a
     * network connection.
     */
    protected function setEndPoint(string $endPoint): void {
        $this->endPoint = $endPoint;
    }

    /**
     * The function "getEndPoint" returns the endpoint value as a string.
     * 
     * @return string The method is returning a string value, which is the value of the variable
     * `->endPoint`.
     */
    protected function getEndPoint(): string {
        return $this->endPoint;
    }

    public function fetch() {
        $this->fetchSources();
        $this->fetchTopHeadingsSources();
        $this->fetchArticles();
        $this->fetchTopHeadings();
    }

    protected function fetchSources(): void {
        foreach ($this->countries as $country) {
            $response = Http::timeout(30)->get($this->endPoint . '/sources', ['apiKey' => $this->apiKey, 'country' => $country]);
            if ($response->successful()) {
                $data = $response->json();
                $fetchedSources = $data['sources'];
                $this->createOrUpdateSources($fetchedSources);
            } else {
                $errorCode = $response->status();
                $errorMessage = $response->body();
            }
        }
    }

    protected function fetchArticles(): void {
        $separatedSources = Source::select("slug")->inRandomOrder()->limit(3)->pluck('slug')->toArray();
        $separatedSources = implode(', ', $separatedSources);

        $response = Http::timeout(30)->get($this->endPoint . '/everything', ['apiKey' => $this->apiKey, 'sources' => $separatedSources]);
        if ($response->successful()) {
            $data = $response->json();
            $fetchedArticles = $data['articles'];
            $this->createOrUpdateArticles($fetchedArticles, false);
        } else {
            $errorCode = $response->status();
            $errorMessage = $response->body();
        }
    }


    protected function fetchTopHeadingsSources(): void {
        $response = Http::timeout(30)->get($this->endPoint . '/top-headlines/sources', ['apiKey' => $this->apiKey]);
        if ($response->successful()) {
            $data = $response->json();
            $fetchedSources = $data['sources'];
            $this->createOrUpdateSources($fetchedSources, true);
        } else {
            $errorCode = $response->status();
            $errorMessage = $response->body();
        }
    }


    protected function fetchTopHeadings(): void {
        foreach ($this->countries as $country) {
            $response = Http::timeout(30)->get($this->endPoint . '/top-headlines', ['apiKey' => $this->apiKey, 'country' => $country]);
            if ($response->successful()) {
                $data = $response->json();
                $fetchedArticles = $data['articles'];
                $this->createOrUpdateArticles($fetchedArticles, true);
            } else {
                $errorCode = $response->status();
                $errorMessage = $response->body();
            }
        }
    }

    protected function createOrUpdateArticles(array $articles, bool $heading): void {
        if (isset($articles) && is_array($articles) && count($articles)) {
            foreach ($articles as $article) {
                // Create or update existing source category
                if (isset($article['source'])) {
                    $source = Source::where('slug', $article['source']['id'])
                        ->orWhere('title', $article['source']['name'])
                        ->first();
                    if (!$source) {
                        // If the source doesn't exist, create a new one
                        $source = Source::create([
                            'title' => $article['source']['name'],
                            'slug' => !empty($article['source']['id']) ? $article['source']['id'] : Str::slug($article['source']['name']),
                            'url' => '/',
                        ]);
                    }
                }

                $defaultAuthorName = $source->title . " Author";
                $author = Author::updateOrCreate(
                    [
                        'name' => $article['author'] && !empty($article['author']) ? $article['author'] : $defaultAuthorName,
                        'slug' => $article['author'] && !empty($article['author']) ? Str::slug($article['author']) : Str::slug($defaultAuthorName),
                    ],
                    [
                        'source_id' => $source->id
                    ]
                );

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
                    'body' => $article['content'] ?? '-',
                    'is_head' => $heading,
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
                if (isset($source['country'])) {
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
                    'url' => $source['url'] ?? '/',
                    'description' => $source['description'],
                    'category_id' => $category->id,
                    'country_id' => $country->id,
                    'language_id' => $language->id,
                ]);
            }
        }
    }
}
