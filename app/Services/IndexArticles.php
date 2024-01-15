<?php

namespace App\Services;

use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Collection;
use modules\Article\Entities\Article;

class IndexArticles {
    public function run() {
        $articles = $this->articles();
        $client = ClientBuilder::create()->build();
        foreach ($articles as $article) {
            $params = $this->prepareParameters($article);
            // Index the article
            $result = $client->index($params);
            // Check for errors
            if ($result['result'] == 'created') {
                return true;
            } else {
                print_r($result);
                return false;
            }
        }
    }

    public function prepareParameters(Article $article): array {
        return [
            'index' => Article::$elasticIndex,
            'type'  => Article::$elasticType,
            'id'  => $article->id,
            'body'  => [
                'title'       => $article->title,
                'description' => $article->description,
                'body'        => $article->body,
            ],
        ];
    }

    public function articles(): Collection {
        return Article::select(['id', 'title', 'description', 'body'])->get();
    }
}
