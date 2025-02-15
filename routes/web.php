<?php

use App\Http\Controllers\AddPaymentController;
use App\Http\Controllers\AdminWithdrawRequestController;
use App\Http\Controllers\AllMatchesController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\BetPlaceController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyPolicyController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomCssController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailConfigureSettingController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\FrontSettingController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PaymentGatewaysController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeoToolController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SmsGatewaysController;
use App\Http\Controllers\SmsTemplateController;
use App\Http\Controllers\SocialIconController;
use App\Http\Controllers\SystemInformationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return (!Auth::check()) ? view('auth.login') : Redirect::to(getDashboardURL());
})->name('login');

//Change Language
Route::post('update-language', [UserController::class, 'updateLanguage'])->name('change-language');
Route::get('language/', [LanguageController::class, 'getAllLanguage'])->name('get.all.language');

Route::get('impersonate-leave',
    [UserController::class, 'impersonateLeave'])->name('impersonate.leave')->middleware('auth');

Route::group([
    'prefix' => 'admin', 'middleware' => ['auth', 'xss', 'valid.user', 'setLanguage', 'role:admin|superAdmin'],
], function () {

    Route::get('/upgrade', function () {
        return view('upgrade.index');
    });

    Route::post('/upgrade-files', function (\Illuminate\Http\Request  $request) {
        backupAndStartUpgrade($request->file('zip'));
        
        return 'Upgrade Successfully';
    })->name('upgrade');

    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    //Categories
    Route::group(['middleware' => ['permission:manage_categories']], function () {
        Route::resource('categories', CategoryController::class);
        Route::put('categories/{category}/status',
            [CategoryController::class, 'changeStatus'])->name('categories.change.status');
    });

    //Seo-tools 
    Route::group(['middleware' => ['permission:manage_seo_tools']], function () {
        Route::get('seo-tools', [SeoToolController::class, 'index'])->name('seo-tools.index');
        Route::Post('seo-tools', [SeoToolController::class, 'update'])->name('seo-tools.update');
    });

    //Settings
    Route::group(['middleware' => ['permission:manage_settings']], function () {
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::Post('settings', [SettingController::class, 'update'])->name('settings.update');

        //Currencies
        Route::resource('currencies', CurrencyController::class,);

        //Cookie
        Route::get('cookie', [CookieController::class, 'index'])->name('cookie-index');
        Route::post('cookie', [CookieController::class, 'update'])->name('cookie-update');
    });

    //Languages
    Route::group(['middleware' => ['permission:manage_languages']], function () {
        Route::resource('languages', LanguageController::class);
        Route::get('languages/translation/{language}',
            [LanguageController::class, 'showTranslation'])->name('languages.translation');
        Route::post('languages/translation/{language}/update',
            [LanguageController::class, 'updateTranslation'])->name('languages.translation.update');
    });

    //Leagues
    Route::group(['middleware' => ['permission:manage_leagues']], function () {
        Route::resource('leagues', LeagueController::class);
        Route::put('leagues/{league}/status',
            [LeagueController::class, 'changeLeagueStatus'])->name('leagues.change.status');
    });

    //Matches
    Route::group(['middleware' => ['permission:manage_matches']], function () {

        //Matches
        Route::resource('all-matches', AllMatchesController::class);
        Route::post('matches-details',
            [AllMatchesController::class, 'matchScoreStore'])->name('all-matches.match-score-store');
        Route::put('matches/{match}/status',
            [AllMatchesController::class, 'changeStatus'])->name('matches.change.status');
        Route::put('matches/{match}/is_locked',
            [AllMatchesController::class, 'changeLockedStatus'])->name('matches-locked-status-change');

        //Questions
        Route::get('questions/{id}', [QuestionController::class, 'index'])->name('matches.questions');
        Route::resource('question', QuestionController::class);
        Route::put('questions/{question}/status',
            [QuestionController::class, 'changeStatus'])->name('question-status-change');
        Route::put('questions/{question}/is_locked',
            [QuestionController::class, 'changeLockedStatus'])->name('question-locked-status-change');

        //Options
        Route::get('options/{id}', [OptionController::class, 'index'])->name('questions.options');
        Route::resource('option', OptionController::class);
        Route::put('options/{option}/status', [OptionController::class, 'changeStatus'])->name('option-status-change');

        //Make Win
        Route::post('/make-win', [OptionController::class, 'makeWin'])->name('make-win');

    });

    //Bets
    Route::group(['middleware' => ['permission:manage_bets']], function () {
        Route::get('bets', [BetController::class, 'index'])->name('bets.index');
    });

    //Roles
    Route::group(['middleware' => ['permission:manage_roles']], function () {
        Route::resource('roles', RoleController::class);
    });

    //User details
    Route::group(['middleware' => ['permission:manage_users']], function () {
        Route::resource('users', UserController::class);
        Route::put('users/{user}/status',
            [UserController::class, 'changeUserStatus'])->name('users.change.status');
        Route::put('users/{user}/emailVerified',
            [UserController::class, 'emailVerified'])->name('users.email.verified');
        Route::get('users/{id}', [UserController::class, 'show'])->name('admin-user-details');
    });

    //Change Profile
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.setting');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('update.profile.setting');

    //Change password
    Route::put('/change-user-password', [UserController::class, 'changePassword'])->name('user.changePassword');

    //Change Theme
    Route::get('update-dark-mode', [UserController::class, 'updateDarkMode'])->name('update-dark-mode');

    //Sms-template
    Route::group(['middleware' => ['permission:manage_sms_template']], function () {

        //Sms-template/global
//        Route::get('sms-template/global-setting',
//            [SmsGlobalSettingController::class, 'index'])->name('sms.global.setting');
//        Route::post('sms-template/global-setting',
//            [SmsGlobalSettingController::class, 'update'])->name('sms.global.setting.store');

        //Sms-template
        Route::resource('sms-template', SmsTemplateController::class)->except('show');
        Route::put('sms-template/{smsTemplate}/status',
            [SmsTemplateController::class, 'smsTemplateStatus'])->name('sms-template.status');

        //Sms-template/sms-gateways
        Route::get('sms-template/sms-gateways', [SmsGatewaysController::class, 'index'])->name('sms.gateways.index');
        Route::post('sms-template/sms-gateways', [SmsGatewaysController::class, 'update'])->name('sms.gateways.update');
        Route::post('sms-template/send-sms', [SmsGatewaysController::class, 'sendSMS'])->name('sms.gateways.sendSMS');
        Route::post('sms-template/send-sms-twilio',
            [SmsGatewaysController::class, 'sendSMSTwilio'])->name('sms.gateways.sendSMSTwilio');
    });

    //Email template route
    Route::group(['middleware' => ['permission:manage_email_template']], function () {

        //Email-template/configure
        Route::get('email-templates/configure',
            [EmailConfigureSettingController::class, 'index'])->name('email.configure.index');
        Route::post('email-templates/configure',
            [EmailConfigureSettingController::class, 'update'])->name('email.configure.update');
        Route::post('email-configure/sendEmail',
            [EmailConfigureSettingController::class, 'sendTestEmail'])->name('email.configure.sendEmail');

        //Email-template
        Route::get('email-template', [EmailTemplateController::class, 'index'])->name('email.template.index');
        Route::get('email-template/{emailTemplate}/edit',
            [EmailTemplateController::class, 'edit'])->name('email.template.edit');
        Route::put('email-template/{emailTemplate}/status',
            [EmailTemplateController::class, 'emailTemplateStatus'])->name('email.template.status');
        Route::put('email-template/{emailTemplate}',
            [EmailTemplateController::class, 'update'])->name('email.template.update')->withoutMiddleware('xss');
        Route::get('email-template/create',
            [EmailTemplateController::class, 'create'])->name('email.template.create');
        Route::post('email-template',
            [EmailTemplateController::class, 'store'])->name('email.template.store');
        Route::put('email-template/{emailTemplate}/status',
            [EmailTemplateController::class, 'emailTemplateStatus'])->name('email.template.status');
        Route::delete('email-template/{emailTemplate}',
            [EmailTemplateController::class, 'destroy'])->name('email.template.destroy');
    });

    //Custom Css
    Route::group(['middleware' => ['permission:manage_custom_css']], function () {
        Route::get('custom-css', [CustomCssController::class, 'index'])->name('custom-css.index');
        Route::post('custom-css/update', [CustomCssController::class, 'update'])->name('custom-css.update');
    });

    //Clear cache
    Route::get('clear-cache', [SettingController::class, 'clearCache'])->name('clear-cache');

    //Impersonate
    Route::group(['middleware' => ['permission:manage_impersonate']], function () {
        Route::get('impersonate/{id}', [UserController::class, 'impersonate'])->name('impersonate');
    });

    //Deposit transactions
    Route::group(['middleware' => ['permission:manage_deposit']], function () {
        Route::get('transaction', [AddPaymentController::class, 'getAllPaymentStatus'])->name('show-all-deposit');
        Route::get('transaction/{id}', [AddPaymentController::class, 'depositDetails'])->name('admin.deposit.details');
    });

    //System-information
    Route::group(['middleware' => ['permission:manage_system_information']], function () {
        Route::get('system-information', [SystemInformationController::class, 'index'])->name('system.info.index');
    });

    //Withdraw-request
    Route::group(['middleware' => ['permission:manage_withdraw_request']], function () {
        Route::get('withdraw-requests',
            [AdminWithdrawRequestController::class, 'getWithdrawRequest'])->name('show-all-withdraw-request');
        Route::get('withdraw-requests/{id}',
            [AdminWithdrawRequestController::class, 'withdrawRequestDetails'])->name('admin.show.withdraw.request');
        Route::post('/withdraw-requests/update',
            [AdminWithdrawRequestController::class, 'updateWithdrawRequest'])->name('admin.withdraw_request_update');
    });

    //CMS
    Route::group(['middleware' => ['permission:manage_cms']], function () {
        Route::resource('blog', BlogController::class)->withoutMiddleware('xss');

        //Faqs
        Route::resource('faqs', FaqsController::class);
        Route::put('faqs/{faq}/status', [FaqsController::class, 'changeStatus'])->name('faqs.change-status');

        //Front-settings
        Route::get('front-settings', [FrontSettingController::class, 'index'])->name('front.settings.index');
        Route::post('front-settings', [FrontSettingController::class, 'update'])->name('front.settings.update');

        //Partner
        Route::resource('partner', PartnerController::class);

        //Social-icon
        Route::resource('social-icon', SocialIconController::class);

        //Company-policy
        Route::get('company-policy', [CompanyPolicyController::class, 'index'])->name('company-policy.index');
        Route::post('company-policy',
            [CompanyPolicyController::class, 'store'])->name('company-policy.update')->withoutMiddleware('xss');
    });

    //Payment-gateways
    Route::group(['middleware' => ['permission:manage_payment_gateways']], function () {
        Route::resource('payment-gateways', PaymentGatewaysController::class);
        Route::put('payment-gateways/{payment}/status',
            [PaymentGatewaysController::class, 'changeStatus'])->name('payment-list.change-status');
    });

    //Referrals
    Route::group(['middleware' => ['permission:manage_referrals']], function () {
        Route::resource('referrals', ReferralController::class);
        Route::put('referrals/{referral}/status',
            [ReferralController::class, 'changeReferralStatus'])->name('referrals.change.status');
    });

    //Transaction
    Route::put('transaction-status',
        [TransactionController::class, 'changeTransactionStatus'])->name('transaction.status');

    //Dashboard Chart
    Route::get('/dashboard-chart',
        [DashboardController::class, 'dashboardChartData'])->name('dashboard.admin.chart');
    Route::get('/dashboard-withdraw-chart',
        [DashboardController::class, 'dashboardWithdrawChartData'])->name('dashboard.admin.withdraw.chart');
    Route::post('/dashboard.browser-chart',
        [DashboardController::class, 'browserChartData'])->name('dashboard.browser-chart');
    Route::post('/dashboard.country-chart',
        [DashboardController::class, 'countryChartData'])->name('dashboard.country-chart');
    Route::post('/dashboard.device-chart',
        [DashboardController::class, 'deviceChartData'])->name('dashboard.device-chart');

    //News-letter
    Route::group(['middleware' => ['permission:manage_news_letter']], function () {
        Route::resource('news-letter', NewsLetterController::class);
    });

    Route::post('/make-win', [OptionController::class, 'makeWin'])->name('make-win');
    Route::post('/make-loser', [OptionController::class, 'makeLoser'])->name('make-loser');
    Route::post('/give-refund', [OptionController::class, 'giveRefund'])->name('give-refund');

    //States-Cities
    Route::get('get-states', [UserController::class, 'getStates'])->name('get-state');
    Route::get('get-cities', [UserController::class, 'getCity'])->name('get-city');
});

//Landing-page routes
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/contact-us', [LandingPageController::class, 'contact'])->name('contact-us');
Route::post('/contact-us', [LandingPageController::class, 'contactUsStore'])->name('contact-us.store');
Route::get('/about-us', [LandingPageController::class, 'about'])->name('about-us');
Route::get('/affiliate', [LandingPageController::class, 'affiliate'])->name('affiliate');
Route::get('/blogs', [LandingPageController::class, 'blogs'])->name('blogs');
Route::get('/blog-details/{slug}', [LandingPageController::class, 'blogDetails'])->name('blog-details');
Route::get('/licences-info', [LandingPageController::class, 'licencesInfoDetails'])->name('licences-info');
Route::get('/rules-for-bet', [LandingPageController::class, 'rulesForBetDetails'])->name('rules-for-bet');
Route::get('/terms-of-service', [LandingPageController::class, 'termsOfServiceDetails'])->name('terms-of-service');
Route::get('/privacy-policy', [LandingPageController::class, 'privacyPolicyDetails'])->name('privacy-policy');
Route::get('/match-details/{id}', [LandingPageController::class, 'matchDetails'])->name('match-details');
Route::get('/category/{category}', [LandingPageController::class, 'matchListByCategory'])->name('match-list-category');
Route::get('/league/{league}', [LandingPageController::class, 'matchListByLeague'])->name('match-list-league');

Route::group(['middleware' => ['auth', 'xss', 'valid.user']], function () {
    Route::post('/bet-place', [BetPlaceController::class, 'index'])->name('bet.store');
});
Route::post('subscribe', [LandingPageController::class, 'saveSubscribeUser'])->name('subscribe.store');

require __DIR__.'/auth.php';
require __DIR__.'/user.php';
require __DIR__.'/upgrade.php';
