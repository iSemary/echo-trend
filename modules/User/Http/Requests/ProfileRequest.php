<?php

namespace modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest {
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
        $userId = auth()->guard('api')->user();
        return [
            'full_name' => 'required|max:255',
            'email' => [
                'required',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'phone' => [
                'required',
                'max:14',
                Rule::unique('users', 'phone')->ignore($userId),
            ],
            'password' => 'sometimes|max:255|min:8',
            'categories' => 'sometimes|array',
            'authors' => 'sometimes|array',
            'sources' => 'sometimes|array',
        ];
    }
}
