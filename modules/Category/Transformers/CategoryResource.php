<?php

namespace modules\Category\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource {
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
        ];
    }
}
