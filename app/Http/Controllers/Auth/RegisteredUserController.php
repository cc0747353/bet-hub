<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserMailVerification;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $rule = ['nullable'];
        $setting = getSettingValue()['show_captcha'];
        if ($setting == 1){
            $rule = ['required'];
        }

        $request->validate([
            'first_name'           => ['required', 'string', 'max:255'],
            'last_name'            => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'unique:users,email', 'regex:/(.*)@(.*)\.(.*)/'],
            'user_name'            => ['required', 'alpha_dash', 'unique:users,user_name'],
            'password'             => ['required', 'confirmed', Rules\Password::defaults()],
            'toc'                  => ['required'],
            'g-recaptcha-response' => $rule,
        ], [
            'toc.required'                  => 'You must agree with the terms and conditions',
            'g-recaptcha-response.required' => 'reCAPTCHA required!',
        ]);

        try {
            DB::beginTransaction();
        
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'user_name'  => $request->user_name,
                'password' => Hash::make($request->password),
                'referral_by' => $request->referral_by,
            ]);
    
            $memberRole = Role::where('name','member')->first();
            $user->assignRole($memberRole);
            $input = [];
            $input['emails'] =EmailTemplate::whereName('Email Verification')->first()->toArray();
            $input['url'] =  URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $user->id,
                    'hash' => sha1($user->email),
                ]
            );
            Mail::to($user->email)
                ->send(new UserMailVerification('emails.user_verification_mail',
                    'Email Verification',
                    $input));
    
            event(new Registered($user));
            
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($exception->getMessage());
        }
        
        return redirect(route('login'));
    }
}
