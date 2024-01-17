<?php

namespace modules\Article\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use modules\Author\Transformers\AuthorResource;
use modules\Category\Transformers\CategoryResource;
use modules\Country\Transformers\CountryResource;
use modules\Language\Transformers\LanguageResource;
use modules\Provider\Transformers\ProviderResource;
use modules\Source\Transformers\SourceResource;

class ArticleResource extends JsonResource {
    public function toArray($request) {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'reference_url' => $this->reference_url,
            'body' => $this->body,
            'image' => $this->image,
            'published_at' => date('F j, Y g:i a', $this->published_at),
            'language' => new LanguageResource($this->whenLoaded('language')),
            'country' => new CountryResource($this->whenLoaded('country')),
            'source' => new SourceResource($this->whenLoaded('source')),
            'author' => new AuthorResource($this->whenLoaded('author')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'provider' => new ProviderResource($this->whenLoaded('provider')),
        ];
    }
}
