<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return User::$rules;
    }
    
    public function messages(): array
    {
        return [
            'profile.max'          => 'Profile size should be less than 2 MB',
            'user_name.required'   => 'The username field is required.',
            'user_name.unique'     => 'The username has already been taken.',
            'user_name.alpha_dash' => 'The username must only contain letters, numbers, dashes and underscores.',
        ];
    }
}
