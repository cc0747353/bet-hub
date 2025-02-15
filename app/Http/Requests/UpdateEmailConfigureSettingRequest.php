<?php

namespace App\Http\Requests;

use App\Models\EmailConfigureSetting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateEmailConfigureSettingRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $emailMethod = $request->email_send_method;
        
        if ($emailMethod == EmailConfigureSetting::SMTP){
            return [
                'smtp_host' => 'required',
                'smtp_port' => 'required|numeric',
                'smtp_username' => 'required',
                'smtp_password' => 'required',
            ];
        }
        if ($emailMethod == EmailConfigureSetting::SENDGRID_API){
            return [
                'sendgrid_key' => 'required',
            ];
        }
        if ($emailMethod == EmailConfigureSetting::MAILJET_API){
            return [
                'mailjet_public_key' => 'required',
                'mailjet_secret_key' => 'required',
            ];
        }
        return true;
    }
}
