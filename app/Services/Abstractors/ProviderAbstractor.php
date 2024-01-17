<?php

namespace App\Services\Abstractors;

abstract class ProviderAbstractor {
    abstract public function fetch();
    abstract protected function setApiKey(string $apiKey): void;
    abstract protected function getApiKey(): string;
    abstract protected function setEndPoint(string $endPoint): void;
    abstract protected function getEndPoint(): string;
    abstract protected function fetchSources(): void;
    abstract protected function createOrUpdateSources(array $fetchedSources): void;
    abstract protected function fetchArticles(): void;
    abstract protected function createOrUpdateArticles(array $fetchedArticles, bool $heading): void;
    abstract protected function fetchTopHeadingsSources(): void;
    abstract protected function fetchTopHeadingsArticles(): void;
}
