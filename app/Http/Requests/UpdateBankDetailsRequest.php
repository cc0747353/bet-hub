<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBankDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'               => 'required|email|regex:/(.*)@(.*)\.(.*)/',
            'account_number'      => 'required|numeric|min:0',
            'account_holder_name' => 'required',
            'ifsc_number'         => 'required',
            'branch_name'         => 'required',
        ];
    }
    
    public function messages()
    {
        return [
          'account_number.min' => 'Please enter valida account number',
        ];
    }
}
