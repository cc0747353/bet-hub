<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactUsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email:filter|regex:/(.*)@(.*)\.(.*)/',
            'subject'    => 'required',
            'message'    => 'required',
        ];
    }
}
