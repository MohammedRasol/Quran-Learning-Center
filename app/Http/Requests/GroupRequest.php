<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    private const MAX_TEXT_LENGTH = 255;
    private const MAX_IMAGE_SIZE = 2048; // in KB
    private const IMAGE_MIMES = 'png,jpg,jpeg,gif';

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
            'name' => ['required', 'string', 'max:' . self::MAX_TEXT_LENGTH],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'image' => [
                'nullable',
                'image',
                'mimes:' . self::IMAGE_MIMES,
                'max:' . self::MAX_IMAGE_SIZE
            ],
        ];
    }
}
