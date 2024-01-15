<?php

namespace modules\Provider\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProviderRequest extends FormRequest {
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
            'name' => 'required|max:255',
            'class_name' => 'required|max:255',
            'end_point' => 'required|max:255',
            'api_key' => 'required|max:255',
        ];
    }
}
