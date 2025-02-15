<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\SeoTool;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DefaultSettingSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logo = ('/images/logo-red-black.png');
        $favicon = ('/images/favicon.png');
        $currency = Currency::first();
        $settingData = [
            'app_name'           => 'InfyBetting',
            'contact_no'         => '7096336561',
            'region_code'        => '+91',
            'email'              => 'admin@betting.com',
            'address'            => 'C-303, Atlanta Shopping Mall, Nr. Sudama Chowk, Mota Varachha, Surat, Gujarat, India.',
            'copy_right_text'    => 'All Rights Reserved (C)',
            'logo'               => $logo,
            'favicon'            => $favicon,
            'max_bet'            => 10000,
            'min_bet'            => 10,
            'cookie_description' => 'Your experience on this site will be improved by allowing cookies.',
            'cookie_is'          => 1,
            'policy_link'        => '',
            'global_template'    => 'hi {{name}}, {{message}}',
            'currency'           => $currency->id,
            'show_captcha'       => 0,
            'site_key'           => '',
            'secret_key'         => '',
        ];

        foreach ($settingData as $key => $value) {
            $settingDataExist = Setting::where('key', $key)->exists();
            if (!$settingDataExist) {
                Setting::create(['key' => $key, 'value' => $value]);
            }
        }
    }
}
