<?php

namespace modules\Article\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array {
        return [
            'keyword' => 'required|max:1000|string',
            'date_order' => 'sometimes|in:DESC,ASC',
            'category_id' => 'nullable|numeric',
            'source_id' => 'nullable|numeric',
        ];
    }
}
