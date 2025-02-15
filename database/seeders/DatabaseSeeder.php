<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DefaultCurrencySeeder::class);
        $this->call(DefaultPermissionSeeder::class);
        $this->call(DefaultRoleSeeder::class);
        $this->call(DefaultSeoToolSeeder::class);
        $this->call(DefaultSettingSeeder::class);
        $this->call(DefaultAdminSeeder::class);
        $this->call(LanguageTableSeeder::class);
        $this->call(CreateCountriesSeeder::class);
        $this->call(SmsGatewaysSeeder::class);
        $this->call(EmailTemplateSeeder::class);
        $this->call(SmsTemplateSeeder::class);
        $this->call(PaymentGatewaysSeeder::class);
        $this->call(PaymentFieldsSeeder::class);
        $this->call(ReferralSeeder::class);
        $this->call(DefaultAboutUsSettingSeeder::class);
        $this->call(DefaultHomePageSettingSeeder::class);
        $this->call(DefaultContactUsSettingSeeder::class);
        $this->call(DefaultAffiliateSettingSeeder::class);
        $this->call(DefaultStartSettingSeeder::class);
        $this->call(DefaultFeatureSettingSeeder::class);
    }
}
