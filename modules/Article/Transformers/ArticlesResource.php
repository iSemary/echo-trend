<?php

namespace modules\Article\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use modules\Author\Transformers\AuthorResource;
use modules\Category\Transformers\CategoryResource;
use modules\Country\Transformers\CountryResource;
use modules\Language\Transformers\LanguageResource;
use modules\Source\Transformers\SourceResource;

class ArticlesResource extends JsonResource {
    public function toArray($request) {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'is_head' => $this->is_head,
            'published_at' => date('F j, Y g:i a', $this->published_at),
            'language' => new LanguageResource($this->whenLoaded('language')),
            'country' => new CountryResource($this->whenLoaded('country')),
            'source' => new SourceResource($this->whenLoaded('source')),
            'author' => new AuthorResource($this->whenLoaded('author')),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }

}
