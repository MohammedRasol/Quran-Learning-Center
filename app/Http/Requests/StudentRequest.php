<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    // Constants for repeated values
    private const MAX_TEXT_LENGTH = 255;
    private const MAX_IMAGE_SIZE = 2048; // in KB
    private const IMAGE_MIMES = 'png,jpg,jpeg,gif';

    /*
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
        // Common rule set
        $nullableString = ['nullable', 'string', 'max:' . self::MAX_TEXT_LENGTH];

        return [
            'name' => ['required', 'string', 'max:' . self::MAX_TEXT_LENGTH],
            'last_name' => $nullableString,
            'family_name' => $nullableString,
            'phone' => array_merge($nullableString, ['regex:/^\+962(7|8|9)[0-9]{8}$/']),
            'birth_day' => ['required', 'string', 'between:1,31'],
            'birth_month' => ['required', 'string', 'between:1,12'],
            'birth_year' => ['required', 'integer', 'between:1990,' . date('Y')],
            'join_day' => ['required', 'string', 'between:1,31'],
            'join_month' => ['required', 'string', 'between:1,12'],
            'join_year' => ['required', 'integer', 'between:1990,' . date('Y')],
            'email' => [
                'nullable',
                'email',
                'max:' . self::MAX_TEXT_LENGTH,
                'unique:users,email,' . $this->user?->id // Ignores current user's email if updating
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:' . self::IMAGE_MIMES,
                'max:' . self::MAX_IMAGE_SIZE
            ],
        ];
    }
}
