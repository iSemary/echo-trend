<?php

namespace modules\Source\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SourceResource extends JsonResource {
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
        ];
    }
}
