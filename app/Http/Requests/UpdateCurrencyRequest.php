<?php

namespace App\Http\Requests;

use App\Models\Currency;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
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
        $rules = Currency::$rules;
        $rules['currency_name'] = $rules['currency_name'].','.$this->route('currency');
        $rules['currency_code'] = $rules['currency_code'].','.$this->route('currency');
        return $rules;
    }
}
