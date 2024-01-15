<?php

namespace modules\Country\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource {
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
        ];
    }
}
