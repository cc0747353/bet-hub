<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'logo'         => 'image|mimes:jpeg,png,jpg',
            'favicon'      => 'image|mimes:jpeg,png,jpg',
        ];
    }

    public function messages(): array
    {
        return [
            //
        ];
    }
}
