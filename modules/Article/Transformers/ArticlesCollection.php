<?php

namespace modules\Article\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticlesCollection extends ResourceCollection {
    /**
     * Transform the resource collection into an array.
     */
    public function toArray($request): array {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
