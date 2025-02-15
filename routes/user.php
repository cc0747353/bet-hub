<?php

use App\Http\Controllers\AddPaymentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthorizePaymentController;
use App\Http\Controllers\ManuallyPaymentController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\PayTMController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserReferralsController;
use App\Http\Controllers\UserSettingController;
use App\Http\Controllers\WithdrawRequestController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth', 'xss', 'valid.user', 'setLanguage', 'role:member'],
], function () {

    //User Dashboard
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    //User Deposit
    Route::resource('deposit-transaction', AddPaymentController::class);
    Route::get('deposit-amount/{id}', [AddPaymentController::class, 'show'])->name('get-deposit-amount');
    Route::post('add-payment',
        [StripePaymentController::class, 'addPayment'])->name('add-payment');

    //User Users
    Route::resource('users', UserController::class);

    //User Profile
    Route::get('/user-profile/edit', [UserController::class, 'editUserProfile'])->name('profile.setting');
    Route::put('/user-profile/update',
        [UserController::class, 'updateUserProfile'])->name('update.profile.setting');

    //User Withdraw
    Route::resource('withdraw-transaction', WithdrawRequestController::class);

    Route::resource('withdraw-request', WithdrawRequestController::class);
    Route::post('payout-setting/update', [UserSettingController::class, 'update'])->name('settings-update');

    //User Manually-Payment
    Route::post('manually-add-payment',
        [ManuallyPaymentController::class, 'store'])->name('manually-add-payment');

    //User Referrals
//    Route::get('/users-referrals-level', [UserReferralsController::class, 'index'])->name('users_referrals_level');
    Route::get('/referrals-deposit-commission',
        [UserReferralsController::class, 'referralsDepositCommission'])->name('referrals_deposit_commission');
    Route::get('/referrals-bet-place-commission',
        [UserReferralsController::class, 'referralsBetPlaceCommission'])->name('referrals_bet_place_commission');
    Route::get('/referrals-bet-win-commission',
        [UserReferralsController::class, 'referralsBetWinCommission'])->name('referrals_bet_win_commission');

    //User Stripe-Payment
    Route::get('payment-success', [StripePaymentController::class, 'paymentSuccess'])->name('payment-success');
    Route::get('failed-payment', [StripePaymentController::class, 'handleFailedPayment'])->name('failed-payment');

    //User Paypal-Payment
    Route::get('/paypal-payment', function () {
        return view('payments.paypal.index');
    })->name('paypal.index');

    Route::get('paypal-onboard', [\App\Http\Controllers\PaypalController::class, 'onBoard'])->name('paypal.init');
    Route::get('paypal-payment-success',
        [\App\Http\Controllers\PaypalController::class, 'success'])->name('paypal.success');
    Route::get('paypal-payment-failed',
        [\App\Http\Controllers\PaypalController::class, 'failed'])->name('paypal.failed');

    //User Razorpay-payment
    Route::post('razorpay-onboard', [RazorpayController::class, 'onBoard'])->name('razorpay.init');
    Route::post('razorpay-payment-success', [RazorpayController::class, 'paymentSuccess'])
        ->name('razorpay.success');
    Route::post('razorpay-payment-failed', [RazorpayController::class, 'paymentFailed'])
        ->name('razorpay.failed');
    Route::get('razorpay-payment-webhook', [RazorpayController::class, 'paymentSuccessWebHook'])
        ->name('razorpay.webhook');

    //User Paytm-payment
    Route::get('twofactor-auth', [UserController::class, 'twoFactorAuth'])->name('twofactor.auth');
    Route::get('twofactor-auth-enable',
        [UserController::class, 'twoFactorAuthEnable'])->name('twofactor.auth.enable');
    Route::post('twofactor-auth-disable',
        [UserController::class, 'twoFactorAuthDisable'])->name('twofactor.auth.disable');

    //User Authorize-Payment
    Route::get('authorize-onboard', [AuthorizePaymentController::class, 'onboard'])->name('authorize.init');
    Route::post('authorize-do-payment', [AuthorizePaymentController::class, 'pay'])->name('authorize.onboard');
    Route::get('authorize-payment-failed', [AuthorizePaymentController::class, 'failed'])->name('authorize.failed');

    //User paystack-Payment
    Route::get('paystack-onboard', [PaystackController::class, 'redirectToGateway'])->name('paystack.init');


    //User Impersonate
    Route::get('impersonate-leave', [UserController::class, 'impersonateLeave'])->name('impersonate.leave');

    //User Bet
    Route::get('bets-details', [UserController::class, 'betsDetails'])->name('bets-details');
});
Route::get('2fa-validate', [AuthenticatedSessionController::class, 'twoAuthValidate'])->name('user.2fa.validate.otp');
Route::post('/2fa/validate', [
    AuthenticatedSessionController::class, 'postValidateToken',
])->middleware('throttle')->name('user.token.validation');
Route::get('/paytm-init', [PayTMController::class, 'initiate'])->name('paytm.init');
Route::post('/paytm-payment', [PayTMController::class, 'payment'])->name('make.payment');
Route::post('/paytm-callback', [PayTMController::class, 'paymentCallback'])->name('paytm.callback');
Route::get('paytm-payment-cancel', [PayTMController::class, 'failed'])->name('paytm.failed');
Route::get('update-dark-mode', [UserController::class, 'updateDarkMode'])->name('update-dark-mode');

Route::get('referral/{user_name}', [UserController::class, 'create_referral_user'])->name('referral_url');
Route::get('paystack-payment-success',
    [PaystackController::class, 'handleGatewayCallback'])->name('paystack.success');
?>
