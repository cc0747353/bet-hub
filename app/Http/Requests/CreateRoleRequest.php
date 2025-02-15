<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Role;

class CreateRoleRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return Role::$rules;
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'display_name.required'  => 'Name field is required',
            'display_name.unique'    => 'The name has already been taken.',
            'permission_id.required' => 'Please select any one permission',
        ];
    }
}
