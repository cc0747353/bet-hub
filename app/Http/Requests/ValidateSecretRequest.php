<?php

namespace App\Http\Requests;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Factory as ValidationFactory;
use PragmaRX\Google2FA\Google2FA;

class ValidateSecretRequest extends FormRequest
{

    /**
     * @var \App\User
     */
    private $user;

    /**
     * Create a new FormRequest instance.
     *
     * @param ValidationFactory $factory
     * @return void
     */
    public function __construct(ValidationFactory $factory)
    {
      
        $factory->extend(
            'valid_token',
            function ($attribute, $value, $parameters, $validator) {
                
                $secret = Crypt::decrypt($this->user->google2fa_secret);
               
                $google2fa = new Google2FA();
                $valid = $google2fa->verifyKey($secret, $value);
                
                return $valid;

            },
            'Not a valid token'
        );

        $factory->extend(
            'used_token',
            function ($attribute, $value, $parameters, $validator) {
                $key = $this->user->id . ':' . $value;

                return !Cache::has($key);
            },
            'Cannot reuse token'
        );
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        try {
            $this->user = User::findOrFail(
                session('2fa:user:id')
            );
        } catch (Exception $exc) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'totp' => 'bail|required|digits:6|valid_token|used_token',
        ];
    }

    public function messages()
    {
        $messages['totp.required'] = 'The One-Time Password field is required.';
        $messages['totp.digits'] = 'The One-Time Password must be 6 digits.';
        $messages['totp.valid_token'] = 'The entered One-Time Password is not valid.';
        $messages['totp.used_token'] = 'The entered One-Time Password is already used.';
        $messages['totp.bail'] = 'The One-Time Password validation not matched.';

        return $messages;
    }
}
