// const mix = require('laravel-mix');
//
// /*
//  |--------------------------------------------------------------------------
//  | Mix Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Mix provides a clean, fluent API for defining some Webpack build steps
//  | for your Laravel applications. By default, we are compiling the CSS
//  | file for the application as well as bundling up all the JS files.
//  |
//  */
//
// mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
//     require('tailwindcss'),
//     require('autoprefixer'),
// ]);

const mix = require('laravel-mix')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// copy folder
mix.copyDirectory('resources/images', 'public/images')
mix.copyDirectory('resources/theme/images', 'public/images')
mix.copyDirectory('node_modules/intl-tel-input/build/img', 'public/assets/img');

// mix.copyDirectory('resources/assets/front/vendor/font-awesome/webfonts',
//     'public/assets/webfonts');
// mix.copyDirectory('public/web/plugins/global/fonts', 'public/assets/css/fonts');
// mix.copyDirectory('node_modules/intl-tel-input/build/img', 'public/assets/img');
mix.copyDirectory('resources/assets/fonts', 'public/assets/css/fonts');
mix.copyDirectory('resources/assets/fonts', 'public/css/fonts');

// mix.copy(
//     'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
//     'public/assets/css/bootstrap-datepicker/bootstrap-datepicker.css');
// mix.copy('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
//     'public/assets/js/bootstrap-datepicker/bootstrap-datepicker.js');

// third-party css
mix.styles([
    'resources/theme/css/third-party.css',
     'node_modules/intl-tel-input/build/css/intlTelInput.css',
     'node_modules/quill/dist/quill.snow.css',
     'node_modules/quill/dist/quill.bubble.css',
    'public/vendor/iconpicker/bootstrapicons-iconpicker.min.css'
], 'public/assets/css/third-party.css')

// light theme css
mix.styles('resources/theme/css/style.css', 'public/assets/css/style.css')
mix.styles('resources/theme/css/plugins.css', 'public/css/plugins.css')
mix.sass('resources/assets/scss/custom-pages-dark.scss', 'public/assets/css/custom-pages-dark.css').version()

// dark theme css
mix.styles('resources/theme/css/style.dark.css',
    'public/assets/css/style-dark.css')
mix.styles('resources/theme/css/plugins.dark.css',
    'public/css/plugins.dark.css')
// mix.sass('resources/assets/scss/custom-pages-dark.scss', 'public/assets/css/custom-pages-dark.css').version()

// page css
mix.sass('resources/assets/scss/main.scss', 'public/assets/css/pages.css').
    version()


// mix.copy('node_modules/datatables/media/images', 'public/assets/images');

// mix.copyDirectory('resources/assets/front', 'public/assets/front');

//backend third-party js
mix.scripts([
    'resources/theme/js/vendor.js',
    'resources/theme/js/plugins.js',
    'public/messages.js',
    'node_modules/chart.js/dist/chart.js',
//     'node_modules/apexcharts/dist/apexcharts.js',
    'node_modules/intl-tel-input/build/js/utils.js',
    'node_modules/intl-tel-input/build/js/intlTelInput.js',
    'node_modules/quill/dist/quill.js',
    'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
    // 'node_modules/bootstrap-iconpicker/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js',
    'public/vendor/iconpicker/bootstrapicon-iconpicker.min.js'
], 'public/js/third-party.js')

mix.js('resources/assets/js/custom/helper.js',
    'public/assets/js/custom/helper.js')

mix.js([
    'resources/assets/js/turbo.js',
    'resources/assets/js/custom/helper.js',
    'resources/assets/js/languages/languages.js',
    'resources/assets/js/add_payment/add_payment.js',
    'resources/assets/js/roles/create-edit.js',
    'resources/assets/js/users/users.js',
    'resources/assets/js/custom/phone-number-country-code.js',
    'resources/assets/js/roles/roles.js',
    'resources/assets/js/languages/language_translate.js',
    'resources/assets/js/custom/custom.js',
    'resources/assets/js/custom/delete.js',
    'resources/assets/js/categories/category.js',
    'resources/assets/js/all_matches/all_matches.js',
    'resources/assets/js/questions/questions.js',
    'resources/assets/js/options/options.js',
    'resources/assets/js/users/user-profile.js',
    'resources/assets/js/leagues/league.js',
    'resources/assets/js/currencies/currencies.js',
    'resources/assets/js/withdraw_request/withdraw_request.js',
    'resources/assets/js/admin_withdraw_request/admin_withdraw_request.js',
    'resources/assets/js/sms_template/sms_gateways.js',
    'resources/assets/js/sms_template/sms_template.js',
    'resources/assets/js/cms/blog/blog.js',
    'resources/assets/js/faqs/faqs.js',
    'resources/assets/js/dashboard/dashboard.js',
    'resources/assets/js/partner/partner.js',
    'resources/assets/js/social_icon/social_icon.js',
    'resources/assets/js/company_policy/company_policy.js',
    'resources/assets/js/transaction/transaction.js',
    'resources/assets/js/payment_gateways/payment_gateways.js',
    'resources/assets/js/settings/settings.js',
    'resources/assets/js/email_templates/email_templates_global.js',
    'resources/assets/js/email_templates/email_configure_setting.js',
    'resources/assets/js/email_templates/email_template.js',
    'resources/assets/js/referrals/referral.js',
    'resources/assets/js/news_letter/news_letter.js',
    'resources/assets/js/front_settings/cms.js',
    'resources/assets/js/custom/sidebar_menu.js',
], 'public/js/pages.js').version()

mix.scripts([
    'resources/front_theme/js/third-party/jquery.min.js',
    'resources/front_theme/js/third-party/bootstrap.bundle.min.js',
    'resources/front_theme/js/third-party/owl.carousel.min.js',
    'resources/front_theme/js/third-party/slick.min.js',
],'public/js/front-third-party.js');

mix.js([
    'resources/assets/js/turbo.js',
    'resources/front_theme/js/custom.js',
    'resources/assets/js/custom/custom.js',
    'resources/assets/js/front/contact_us.js',
    'resources/assets/js/front/add_bet.js',
    'resources/assets/js/front/about_us.js',
    'resources/assets/js/front/home.js',
],'public/assets/js/front-pages.js')

mix.styles([
    'resources/front_theme/css/all.min.css',
    'resources/front_theme/css/bootstrap.css',
    'resources/theme/css/plugins.css',
    'resources/front_theme/css/owl.carousel.min.css',
    'resources/front_theme/css/owl.theme.default.min.css',
    'resources/front_theme/css/slick.css',
    'resources/front_theme/css/slick-theme.css',
],'public/css/front-third-party.css');

mix.sass('resources/front_theme/scss/main.scss' ,'public/css/front-pages.css');

mix.copyDirectory('resources/front_theme/images' ,'public/images');
