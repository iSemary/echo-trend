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

class NewsDataIO extends ProviderAbstractor {
    private Provider $provider;
    private string $endPoint;
    private string $apiKey;
    private array $countries = ['de', 'us', 'nl'];

    private const SOURCES_PATH = '/sources';
    private const NEWS_PATH = '/news';


    public function __construct(Provider $provider) {
        $this->provider = $provider;
        $this->setApiKey($provider->api_key);
        $this->setEndPoint($provider->end_point);
    }

    public function fetch() {
        $this->fetchSources();
        $this->fetchArticles();
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

    protected function fetchSources(): void {
        foreach ($this->countries as $country) {
            $response = Http::timeout(30)->get($this->endPoint . self::SOURCES_PATH, ['apikey' => $this->apiKey, 'country' => $country]);
            if ($response->successful()) {
                $data = $response->json();
                $fetchedSources = $data['results'];
                $this->createOrUpdateSources($fetchedSources);
            } else {
                $errorCode = $response->status();
                $errorMessage = $response->body();
            }
        }
    }

    protected function fetchArticles(): void {
        $sources = Source::select("slug")->where("provider_id", $this->provider->id)->get();
        foreach ($sources as $source) {
            $response = Http::timeout(30)->get($this->endPoint . self::NEWS_PATH, ['apikey' => $this->apiKey, 'domain' => $source->slug]);
            if ($response->successful()) {
                $data = $response->json();
                $fetchedArticles = $data['results'];
                $this->createOrUpdateArticles($fetchedArticles, false);
            } else {
                $errorCode = $response->status();
                $errorMessage = $response->body();
            }
        }
    }

    protected function createOrUpdateArticles(array $articles, bool $heading): void {
        if (isset($articles) && is_array($articles) && count($articles)) {
            foreach ($articles as $article) {
                $source = Source::where("slug", $article['source_id'])->where("provider_id", $this->provider->id)->first();
                if ($source) {
                    $defaultAuthorName = $source->title . " Author";
                    $author = Author::updateOrCreate(
                        [
                            'name' =>  $defaultAuthorName,
                            'slug' => Str::slug($defaultAuthorName),
                        ],
                        [
                            'source_id' => $source->id
                        ]
                    );

                    Article::updateOrCreate([
                        'slug' => Str::slug($article['title'])
                    ], [
                        'title' => $article['title'],
                        'author_id' => $author->id,
                        'source_id' => $source->id,
                        'provider_id' => $this->provider->id,
                        'category_id' => $source->category_id,
                        'language_id' => $source->language_id,
                        'country_id' => $source->country_id,
                        'description' => mb_convert_encoding($article['description'], "UTF-8"),
                        'body' => mb_convert_encoding($article['content'] ?? '-', "UTF-8"),
                        'is_head' => in_array($article['category'], ['top']),
                        'reference_url' => $article['link'],
                        'image' => $article['image_url'],
                        'published_at' => strtotime($article['pubDate']),
                    ]);
                }
            }
        }
    }

    protected function createOrUpdateSources(array $sources): void {
        if (isset($sources) && is_array($sources) && count($sources)) {
            foreach ($sources as $source) {
                // Create or update existing source category
                if (isset($source['category'])) {
                    $category = Category::updateOrCreate([
                        'title' => ucfirst($source['category'][0]),
                        'slug' => $source['category'][0]
                    ]);
                }
                // Create or update existing source country
                if (isset($source['country'])) {
                    $country = Country::updateOrCreate([
                        'name' => strtoupper($source['country'][0]),
                        'code' => $this->getCountryCode($source['country'][0])
                    ]);
                }
                // Create or update existing source languages
                if (isset($source['language'])) {
                    $language = Language::updateOrCreate([
                        'name' => strtoupper($source['language'][0]),
                        'code' => $source['language'][0]
                    ]);
                }
                // Create source or update existing one
                Source::updateOrCreate([
                    'slug' => $source['id'],
                ], [
                    'title' => $source['name'],
                    'url' => $source['url'] ?? '/',
                    'provider_id' => $this->provider->id,
                    'description' => $source['description'],
                    'category_id' => $category->id,
                    'country_id' => $country->id,
                    'language_id' => $language->id,
                ]);
            }
        }
    }

    private function getCountryCode(string $string): string {
        $words = explode(' ', $string);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return $initials;
    }

    /** Not available for this service */
    protected function fetchTopHeadingsSources(): void {
    }
    /** Not available for this service */
    protected function fetchTopHeadingsArticles(): void {
    }
}
