<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShaikhRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "string|required|max:255",
            "last_name" => "nullable|string|max:255",
            "family_name" => "nullable|string|max:255",
            "image" => "nullable|mimes:png,jpg,jpeg,gif|max:2048",
            "password" => "string|required|max:255|confirmed",
        ];
    }
}
