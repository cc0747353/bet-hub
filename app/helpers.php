<?php

use App\Mail\ReferralCommission;
use App\Mail\UserWithdrawRequest;
use App\Models\AllMatch;
use App\Models\Bet;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\DepositTransaction;
use App\Models\EmailTemplate;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewaysFields;
use App\Models\Referral;
use App\Models\ReferralLevel;
use App\Models\Role;
use App\Models\Setting;
use App\Models\State;
use App\Models\User;
use App\Models\UserReferralsLevel;
use App\Models\WithdrawRequests;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use LaravelIdea\Helper\App\Models\_IH_Bet_C;
use LaravelIdea\Helper\App\Models\_IH_User_C;
use LaravelIdea\Helper\App\Models\_IH_User_QB;
use Stripe\Stripe;


function getLogInUser(): User|Authenticatable|null
{
    return Auth::user();
}

function getAppName(): mixed
{
    static $settings;

    if (empty($settings)) {
        $settings = Setting::where('key','app_name')->pluck('value', 'key');
    }

    return (!empty($settings['app_name'])) ? $settings['app_name'] : config('app.name');

}

function getAppLogo(): mixed
{
    static $setting;
    if (empty($setting)) {
        $setting = Setting::all()->keyBy('key');
    }

    return $setting['logo']->value;
}

function getFaviconLogo(): mixed
{
    static $setting;
    if (empty($setting)) {
        $setting = Setting::all()->keyBy('key');
    }

    return $setting['favicon']->value;
}

function getLogInUserId(): mixed
{
    return Auth::user()->id;
}

function getDashboardURL(): string
{
    if (Auth::user()->hasRole('admin')) {
        return 'admin/dashboard';
    }

    if (Auth::user()->hasRole('member')) {
        return 'user/dashboard';
    }

    return RouteServiceProvider::HOME;
}

function setEmailLowerCase($email): string
{
    return strtolower($email);
}

/**
 *
 *
 * @return string|void
 */
function version()
{
    if (config('app.is_version') == 'true') {
        $composerFile = file_get_contents('../composer.json');
        $composerData = json_decode($composerFile, true);
        $currentVersion = $composerData['version'];

        return 'v'.$currentVersion;
    }
}

function checkCurrency($code): bool
{
    $composerFile = file_get_contents(public_path('currencymap.json'));

    $array = (array) json_decode($composerFile);


    if (isset($array[$code])) {
        return true;
    }

    return false;
}

function getCountries(): Collection
{
    return Country::pluck('name', 'id');
}

function getStates(): Collection
{
    return State::pluck('name', 'id');
}

function getCities(): Collection
{
    return City::pluck('name', 'id');
}

function getBadgeColor($index): string
{
    $colors = [
        'primary',
        'danger',
        'success',
        'info',
        'warning',
        'secondary',
    ];

    $index = $index % 6;
    if (Auth::user()->dark_mode) {
        array_splice($colors, 5, 1);
        array_push($colors, 'bg-white');
    }

    return $colors[$index];
}

function checkLanguageSession(): string
{
    if (Session::has('languageName')) {
        return Session::get('languageName');
    }

    $user = getLogInUser();
    if ($user != null) {

        return $user->language;
    }

    return 'en';
}

function getAllPaymentStatus(): array
{
    $paymentGateway = PaymentGateway::PAYMENT_METHOD;

    $selectedPaymentGateway = PaymentGateway::pluck('payment_gateway', 'payment_gateway_id',)->toArray();

    return array_intersect($paymentGateway, $selectedPaymentGateway);

}

function getCurrencyIcon(): string
{
    static $setting;

    if (empty($setting)) {
        $setting = Setting::where('key','currency')->get()->keyBy('key');
    }

    static $currencies;

    if (empty($currencies)) {
        $currencies = Currency::all()->keyBy('id');
    }

    $currencyId = $setting['currency']->value;
    $currency = $currencies[$currencyId];

    return $currency->currency_icon ?? '$';
}

function getCurrencyCode(): string
{

    static $setting;
    if (empty($setting)) {
        $setting = Setting::all()->keyBy('key');
    }

    static $currencies;

    if (empty($currencies)) {
        $currencies = Currency::all()->keyBy('id');
    }

    $currencyId = $setting['currency']->value;
    $currency = $currencies[$currencyId];

    return $currency->currency_code ?? 'USD';
}

function setStripeApiKey(): void
{
    Stripe::setApiKey(config('services.stripe.secret_key'));
}

function zeroDecimalCurrencies(): array
{
    return [
        'BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF',
    ];
}

function getCurrencyId(): mixed
{

    static $setting;
    if (empty($setting)) {
        $setting = Setting::all()->keyBy('key');
    }

    static $currencies;

    if (empty($currencies)) {
        $currencies = Currency::all()->keyBy('id');
    }

    return $setting['currency']->value;
}

function getMonth(): array
{
    return array(
        1  => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep',
        10 => 'Oct', 11 => 'Nov', 12 => 'Dec',
    );
}

function getSettingValue(): array
{
    static $settingValues = [];

    if (empty($settingValues)) {
        $settingValues = Setting::pluck('value', 'key')->toArray();
    }

    return $settingValues;
}

function getCurrentLanguageName(): mixed
{
    return Auth::user()->language;
}

function getAllLanguage(): array
{
    return User::LANGUAGES;
}

function getAllRole(): array
{
    return Role::whereNot('name', 'superAdmin')->pluck('display_name', 'id')->toArray();

}

function numberFormatShort($n, int $precision = 2): string
{
    if ($n < 1000) {
        // 0 - 900
        $numberFormat = number_format($n, $precision);
        $suffix = '';
    } elseif ($n < 900000) {
        // 0.9k-850k
        $numberFormat = number_format($n / 1000, $precision);
        $suffix = 'K';
    } elseif ($n < 900000000) {
        // 0.9m-850m
        $numberFormat = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } elseif ($n < 900000000000) {
        // 0.9b-850b
        $numberFormat = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $numberFormat = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }

    if ($precision > 0) {
        $dotZero = '.'.str_repeat('0', $precision);
        $numberFormat = str_replace($dotZero, '', $numberFormat);
    }

    return $numberFormat.$suffix;
}

function getBGColors($index): string
{
    $colors = [
        'rgb(245, 158, 11)',
        'rgb(77, 124, 15)',
        'rgb(254, 199, 2)',
        'rgb(80, 205, 137)',
        'rgb(16, 158, 247)',
        'rgb(241, 65, 108)',
        'rgb(80, 205, 137)',
        'rgb(245, 152, 28)',
        'rgb(13, 148, 136)',
        'rgb(59, 130, 246)',
        'rgb(162, 28, 175)',
        'rgb(190, 18, 60)',
        'rgb(244, 63, 94)',
        'rgb(30, 30, 45)',
    ];

    return $colors[$index % count($colors)];
}

function removeCommaFromNumbers($number): mixed
{
    return (gettype($number) == 'string' && !empty($number)) ? str_replace(',', '', $number) : $number;
}

function userReferralsLevel($type): void
{
    $referralByUseId = User::whereUserName(getLoginUserData(getLogInUserId())->referral_by)->value('id');
    if ($type == UserReferralsLevel::DEPOSIT_COMMISSION) {
        $referralData = Referral::whereName('Deposit Commission')->whereStatus(1)->value('id');
        $userLevelDataExists = UserReferralsLevel::whereUserId($referralByUseId)->whereType(UserReferralsLevel::DEPOSIT_COMMISSION)->exists();
        if ($userLevelDataExists) {
            $level = UserReferralsLevel::whereUserId($referralByUseId)->whereType(UserReferralsLevel::DEPOSIT_COMMISSION)->value('level') + 1;
            $levelData = ReferralLevel::whereReferralId($referralData)->whereLevel($level)->first();
        } else {
            $levelData = ReferralLevel::whereReferralId($referralData)->latest('created_at')->first();
        }
    } elseif ($type == UserReferralsLevel::BET_PLACE_COMMISSION) {
        $referralData = Referral::whereName('Bet Place Commission')->whereStatus(1)->value('id');
        $userLevelDataExists = UserReferralsLevel::whereUserId($referralByUseId)->whereType(UserReferralsLevel::BET_PLACE_COMMISSION)->exists();
        if ($userLevelDataExists) {
            $level = UserReferralsLevel::whereUserId($referralByUseId)->whereType(UserReferralsLevel::BET_PLACE_COMMISSION)->value('level') + 1;
            $levelData = ReferralLevel::whereReferralId($referralData)->whereLevel($level)->first();
        } else {
            $levelData = ReferralLevel::whereReferralId($referralData)->latest('created_at')->first();
        }
    } elseif ($type == UserReferralsLevel::BET_WIN_COMMISSION) {
        $referralData = Referral::whereName('Bet Win Commission')->whereStatus(1)->value('id');
        $userLevelDataExists = UserReferralsLevel::whereUserId($referralByUseId)->whereType(UserReferralsLevel::BET_WIN_COMMISSION)->exists();
        if ($userLevelDataExists) {
            $level = UserReferralsLevel::whereUserId($referralByUseId)->whereType(UserReferralsLevel::BET_WIN_COMMISSION)->value('level') + 1;
            $levelData = ReferralLevel::whereReferralId($referralData)->whereLevel($level)->first();
        } else {
            $levelData = ReferralLevel::whereReferralId($referralData)->latest('created_at')->first();
        }
    }
    $userId = User::whereUserName(getLogInUser()->referral_by)->value('id');
    $userLevelData = UserReferralsLevel::whereUserId($userId)->whereType($type)->first();

    if (!empty(getLogInUser()->referral_by) && !empty($referralData) && !empty($levelData)) {
        if (!empty($userLevelData)) {
            UserReferralsLevel::whereUserId($userId)->whereType($userLevelData['type'])->update([
                'referral_to_id' => getLogInUserId(),
                'level'          => $userLevelData['level'] + 1,
                'commission'     => $levelData['commission'],
            ]);
        } else {
            UserReferralsLevel::create([
                'user_id'        => $userId,
                'referral_to_id' => getLogInUserId(),
                'level'          => $levelData['level'],
                'type'           => $type,
                'commission'     => $levelData['commission'],
            ]);
        }
    }
}

function isDisabledRejectBtn($row): bool
{
    return $row->status == WithdrawRequests::REJECTED;
}

function getLoginUserData($id): array|User|_IH_User_C
{
    return User::findOrFail($id);
}

function getPaymentCredentials($type): array
{
    $payPal_payment_id = PaymentGateway::whereName($type)->value('id');

    return PaymentGatewaysFields::where('payment_id', $payPal_payment_id)->where('type', '1')->pluck('value',
        'key')->toArray();
}

function getDataByUserName($userName): Model|_IH_User_QB|Builder|User|null
{
    return User::whereReferralBy($userName)->latest('created_at')->first();
}

function getCurrentVersion(): mixed
{
    $composerFile = file_get_contents('../composer.json');
    $composerData = json_decode($composerFile, true);

    return $composerData['version'];
}

function getTotalBalance(): mixed
{
    if (getLogInUser()) {
        $deposit = DepositTransaction::whereUserId(getLogInUserId())->where('status',
            DepositTransaction::SUCCESS)->sum('deposit_amount');
        $withdraw = WithdrawRequests::whereUserId(getLogInUserId())->where('status',
            WithdrawRequests::APPROVED)->sum('amount');
        $bet_win = Bet::whereUserId(getLogInUserId())->whereStatus(Bet::WINNER)->sum('win_amount');
        $bet_lose = Bet::whereUserId(getLogInUserId())->whereStatus(Bet::LOSER)->sum('amount');
        $bet_place = Bet::whereUserId(getLogInUserId())->whereStatus(Bet::PENDING)->sum('amount');
        $bet_place_after_win = Bet::whereUserId(getLogInUserId())->whereStatus(Bet::WINNER)->sum('amount');
//        $refund = Bet::whereUserId(getLogInUserId())->whereStatus(Bet::REFUND)->sum('amount');
        return $bet_win + $deposit - $bet_lose - $bet_place - $bet_place_after_win - $withdraw;
    }

    return 0;
}

function getCategoriesFront(): array
{
    $liveMatches = AllMatch::whereDate('match_start', Carbon::today())->pluck('league_id')->toArray();
    $categories['live'] = Category::with(['league'])->whereStatus(1)->whereHas('league',
        function ($query) use ($liveMatches) {
            $query->whereIn('id', $liveMatches);
        })->get();

    $upcomingMatches = AllMatch::whereDate('match_start', '>=' ,Carbon::tomorrow())->pluck('league_id')->toArray();
    $categories['upcoming'] = Category::with(['league'])->whereStatus(1)->whereHas('league',
        function ($query) use ($upcomingMatches) {
            $query->whereIn('id', $upcomingMatches);
        })->get();

    return $categories;
}

function getRecentWinnerDataFront(): \Illuminate\Database\Eloquent\Collection|array
{
    return Bet::whereStatus(Bet::WINNER)->latest('created_at')->limit(3)->get();
}

function getAdminEmail()
{
    return User::role('superAdmin')->value('email');
}

function userReferralCommissionMail($referralUsersId, $totalUserCommission, $transaction, $userLevelData, $type): void
{
    $input['email'] = EmailTemplate::where('name', 'Referral Commission')->first();
    $input['name'] = getLoginUserData($referralUsersId)->full_name;
    $input['referral_to'] = getLogInUser()->full_name;
    $input['amount'] = $totalUserCommission;
    $input['currency'] = getCurrencyIcon();
    $input['transaction_number'] = $transaction->transaction_id;
    $input['method_name'] = $type;
    $input['level'] = $userLevelData;

    Mail::to(getLoginUserData($referralUsersId)->email)
        ->send(new ReferralCommission('emails.referral_commission_mail',
            __($input['email']->subject),
            $input));
}

function backupAndStartUpgrade($zipFile)
{
    // Backup existing code to folder backup
    backupFiles();

    // Extract zip to upgrade folder
    $upgradeFiles = base_path('upgrade');
    File::makeDirectory('upgrade');

    $zip = new ZipArchive;
    if ($zip->open($zipFile->getRealPath()) === TRUE) {
        $zip->extractTo($upgradeFiles);
        $zip->close();
    } else {
        return 'failed';
    }

    // copy directories to existing code from upgrade folder
    $directories = [
        'app', 'bootstrap', 'config', 'database', 'lang', 'public', 'vendor', 'storage'
    ];

    foreach ($directories as $directory) {
        File::copyDirectory($upgradeFiles.DIRECTORY_SEPARATOR.$directory, base_path($directory));
    }

    // delete upgrade folder
    File::deleteDirectory($upgradeFiles);
}

function backupFiles()
{
    // Backup existing code to folder backup
    $backupPath = base_path('backup');
    File::makeDirectory($backupPath);

    File::copy(base_path('.env'), $backupPath.'/.env');

    // copy directories to existing code from upgrade folder
    $directories = [
        'app', 'bootstrap', 'config', 'database', 'lang', 'public', 'storage'
    ];

    foreach ($directories as $directory) {
        File::copyDirectory(base_path($directory), $backupPath);
    }
}

function getDepositCommissionLevel()
{
    $countLevel = UserReferralsLevel::whereUserId(getLogInUserId())->whereType(UserReferralsLevel::DEPOSIT_COMMISSION)->latest()->first();
    if (!empty($countLevel)){
        $count = $countLevel['level'];
    }
    else{
        $count = 0;
    }

    return $count;
}

function getBetPlaceCommissionLevel()
{
    $countLevel = UserReferralsLevel::whereUserId(getLogInUserId())->whereType(UserReferralsLevel::BET_PLACE_COMMISSION)->latest()->first();
    if (!empty($countLevel)){
        $count = $countLevel['level'];
    }
    else{
        $count = 0;
    }

    return $count;
}

function getBetWinCommissionLevel()
{
    $countLevel = UserReferralsLevel::whereUserId(getLogInUserId())->whereType(UserReferralsLevel::BET_WIN_COMMISSION)->latest()->first();
    if (!empty($countLevel)){
        $count = $countLevel['level'];
    }
    else{
        $count = 0;
    }

    return $count;
}
