<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubscriberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email:filter|unique:subscribers,email'
        ];
    }
    
    public function messages()
    {
        return[
            'email.unique' => 'This email is already subscribed'
        ];
    }
}
