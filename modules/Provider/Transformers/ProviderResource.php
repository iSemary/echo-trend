<?php

namespace modules\Provider\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource {
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
