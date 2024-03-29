<?php

namespace modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
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
            'full_name' => 'required|max:164',
            'email' => 'required|max:255|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'dial_code' => 'required|numeric',
            'country_code' => 'required|max:4',
            'password' => 'required|confirmed|max:255|min:8',
            'categories' => 'sometimes|array'
        ];
    }
}
