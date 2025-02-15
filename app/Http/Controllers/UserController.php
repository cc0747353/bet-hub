<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateChangePasswordRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\DepositTransaction;
use App\Models\State;
use App\Models\User;
use App\Models\UserPaymentSettings;
use App\Models\WithdrawRequests;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UserController extends AppBaseController
{

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function index(): Application|Factory|View
    {
        $status = User::STATUS;
        return view('users.index',compact('status'));
    }

    public function create(): Application|Factory|View
    {
//        $country = $this->userRepo->getCountries();

        return view('users.create');
    }

    public function store(CreateUserRequest $request): Application|RedirectResponse|Redirector
    {
        $input = $request->all();
        $user = $this->userRepo->store($input);

        Flash::success(__('messages.flash.user_create'));

        return redirect(route('users.index'));
    }

    public function edit($id): Factory|View|Application
    {
        $user = User::findOrFail($id);
        $address = Address::whereUserId($id)->first();

        return view('users.edit', compact('user', 'address'));
    }

    public function update(UpdateUserRequest $request, User $user): Application|RedirectResponse|Redirector
    {
        $input = $request->all();
        $this->userRepo->update($input, $user);

        Flash::success(__('messages.flash.user_update'));

        return redirect(route('users.index'));
    }

    public function destroy(User $user): JsonResponse
    {
        $userId = $user['id'];

        $user = User::whereId($userId)->first();
        $user->delete();

        return $this->sendSuccess(__('messages.flash.user_deleted'));
    }

    public function editProfile(): Factory|View|Application
    {

        $user = getLogInUser();

        return view('profile.index', compact('user'));
    }

    public function editUserProfile()
    {

        $user = getLogInUser();

        return view('profile.user_index', compact('user'));
    }

    public function updateProfile(UpdateUserProfileRequest $request)
    {
        /** @var User $user */
        $user = getLogInUser();
        $input = $request->all();
        $user->update($request->all());

        if (isset($input['image']) && !empty('image')) {
            $user->clearMediaCollection(User::PROFILE);
            $user->addMedia($input['image'])->toMediaCollection(User::PROFILE,
                config('app.media_disc'));
        }

        Flash::success(__('messages.flash.admin_profile_update'));

        return redirect(route('profile.setting'));
    }

    public function updateUserProfile(UpdateUserProfileRequest $request)
    {
        /** @var User $user */
        $user = getLogInUser();
        $input = $request->all();
        $user->update($request->all());

        if (isset($input['image']) && !empty('image')) {
            $user->clearMediaCollection(User::PROFILE);
            $user->addMedia($input['image'])->toMediaCollection(User::PROFILE,
                config('app.media_disc'));
        }

        Flash::success(__('messages.flash.user_profile_update'));

        return redirect(route('user.profile.setting'));
    }

    public function changePassword(UpdateChangePasswordRequest $request): JsonResponse
    {
        $input = $request->all();

        try {
            /** @var User $user */
            $user = getLogInUser();
            if (!Hash::check($input['current_password'], $user->password)) {
                return $this->sendError(__('messages.flash.current_invalid'));
            }
            $input['password'] = Hash::make($input['new_password']);
            $user->update($input);

            return $this->sendSuccess(__('messages.flash.password_update'));
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function updateLanguage(Request $request): JsonResponse
    {
        $language = $request->get('language');

        $user = getLogInUser();
        $user->update(['language' => $language]);

        return $this->sendSuccess(__('messages.flash.language_update'));
    }

    /**
     *
     * @return JsonResponse
     */
    public function updateDarkMode(): JsonResponse
    {
        $user = getLogInUser();

        $darkEnabled = $user->theme_mode == true;

        $user->update([
            'theme_mode' => !$darkEnabled,
        ]);

        return $this->sendSuccess(__('messages.flash.theme_change'));
    }

    public function impersonate($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        getLogInUser()->impersonate($user);

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('member')) {
            return redirect()->route('user.dashboard');
        }

        return redirect()->route('admin.dashboard');
    }

    public function impersonateLeave(): RedirectResponse
    {
        getLogInUser()->leaveImpersonation();

        return redirect()->route('admin.dashboard');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function twoFactorAuth(Request $request)
    {
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
        $user = getLogInUser();
        $imageRender = null;
        $secret = null;
        if ($user->google2fa_secret) {
            $secret = Crypt::decrypt($user->google2fa_secret);
            $image = $google2fa->getQRCodeUrl(
                $request->getHttpHost(),
                $user->email,
                $user->google2fa_secret
            );
            $imageRender = ((new \chillerlan\QRCode\QRCode())->render($image));
        }

        return view('2fa_security.index', compact('imageRender', 'user', 'secret'));
    }

    /**
     * @param Request $request
     *
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     * @return JsonResponse
     */
    public function twoFactorAuthEnable(Request $request)
    {
        $image = null;
        $secret = null;
        $data = [];
        $google2fa = new Google2FA();
        $data['secret'] = $google2fa->generateSecretKey();

        $user = $request->user();
        $user->google2fa_secret = Crypt::encrypt($data['secret']);
        $data['user'] = $user->save();

        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        $image = $google2fa->getQRCodeUrl(
            $request->getHttpHost(),
            $user->email,
            $secret
        );

        $data['imageRender'] = ((new \chillerlan\QRCode\QRCode())->render($image));

        return $this->sendResponse($data, 'Two Factor Authentication Enabled successfully');
    }

    /**
     * @param Request $request
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     * @return JsonResponse
     */
    public function twoFactorAuthDisable(Request $request)
    {
        $user = getLogInUser();
        $secret = Crypt::decrypt($user->google2fa_secret);

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secret, $request->twoStep_otp);
        if (!$valid) {
            return $this->sendError('The entered One-Time Password is not valid.');
        }
        $user->google2fa_secret = null;
        $user->save();

        return $this->sendResponse($user, 'Two Factor Authentication Disabled successfully');
    }

    public function changeUserStatus(User $user): JsonResponse
    {
        $user->update(['status' => $user->status == 0 ? 1 : 0]);

        return $this->sendResponse($user, __('messages.flash.user_status_update'));

    }

    public function emailVerified(User $user): JsonResponse
    {
        DB::table('users')->where('id', $user->id)->update(['email_verified_at' => Carbon::now()]);

        return $this->sendSuccess(__('messages.flash.verified_email'));
    }

    /**
     * @param Request $request
     *
     *
     * @return Application|Factory|View
     */
    public function create_referral_user(Request $request)
    {

        $userName = $request->user_name ?? '';

        $user = getLogInUser();
        if (isset($user)) {
            return redirect(getDashboardURL());
        }

        return view('auth.register', compact('userName'));
    }

    public function show($id): Application|View|Factory
    {
        $userDetails = User::find($id);
        $userAddress = Address::whereUserId($id)->first();
        $userBankDetails = UserPaymentSettings::whereUserId($id)->first();
        $userDeposit = DepositTransaction::whereUserId($id)->where('status',
            DepositTransaction::SUCCESS)->sum('deposit_amount');
        $userWithdraw = WithdrawRequests::whereUserId($id)->where('status', WithdrawRequests::APPROVED)->sum('amount');
        $userAvailableBalance = $userDeposit - $userWithdraw;

        return view('users.details', compact('userDetails', 'userAddress', 'userBankDetails', 'userAvailableBalance'));
    }

    public function betsDetails()
    {
        return view('user_bets_details.index');
    }

    public function getStates(Request $request): JsonResponse
    {
        $countryId = $request->country_id;
        $states = State::where('country_id', $countryId)->toBase()->pluck('name', 'id')->toArray();

        return $this->sendResponse($states, __('messages.flash.data_retrieve'));
    }

    public function getCity(Request $request): JsonResponse
    {
        $stateId = $request->state_id;
        $cities = City::where('state_id', $stateId)->pluck('name', 'id')->toArray();

        return $this->sendResponse($cities, __('messages.flash.data_retrieve'));
    }
}
