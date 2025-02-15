<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'first_name'  => 'required',
            'last_name'   => 'required',
            'email'       => 'required|email|regex:/(.*)@(.*)\.(.*)/|unique:users,email,'.$this->route('user')->id,
            'user_name'   => 'required|alpha_dash|unique:users,user_name,'.$this->route('user')->id,
            'contact'     => 'required|unique:users,contact,'.$this->route('user')->id,
            'password'    => 'nullable|same:password_confirmation|min:8',
            'status'      => 'nullable',
            'zip'         => 'nullable|max:10',
            'profile'     => 'mimes:jpeg,jpg,png|max:2000',
        ];
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
