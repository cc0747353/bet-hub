<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBankDetailsRequest;
use App\Models\UserPaymentSettings;
use Illuminate\Http\RedirectResponse;
use Laracasts\Flash\Flash;

class UserSettingController extends Controller
{
    public function update(UpdateBankDetailsRequest $request): RedirectResponse
    {
        $input = $request->all();
        
        $userSetting = UserPaymentSettings::where('user_id', getLogInUserId())->first();
        if($userSetting !== null)
        {
            $userSetting->update($input);
        }else{
            $input['user_id'] = getLogInUserId();
            UserPaymentSettings::create($input);
        }
       
        Flash::success(__('messages.flash.withdraw_details_updated'));
        return redirect()->route('user.withdraw-request.index');
    }
}
