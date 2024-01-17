<?php

namespace modules\Language\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource {
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
