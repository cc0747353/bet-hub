<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserMailVerification;
use App\Models\EmailTemplate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Laracasts\Flash\Flash;

class PasswordResetLinkController extends Controller
{
    /**
     *
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * @param Request $request
     *
     *
     * @return Application|Factory|View
     */
    public function store(Request $request)
    {
        $request->validate([
            'email'      => 'required|email|regex:/(.*)@(.*)\.(.*)/',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $input = [];
        $input['emails'] = EmailTemplate::whereName('Password Reset')->first()->toArray();
        $subject = $input['emails']['subject'];
        $input['url'] = URL::temporarySignedRoute(
            'password.reset',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'token' => base64_encode($request['email']),
                'email' => $request->email,
            ]
        );
        Mail::to($request['email'])
            ->send(new UserMailVerification('emails.user_password_reset_mail',
                $subject,
                $input));
        
        Flash::success(__('We have emailed your password reset link!'));
        return redirect(route('password.request'));
    }
}
