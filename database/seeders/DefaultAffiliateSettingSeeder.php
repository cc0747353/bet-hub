<?php

namespace Database\Seeders;

use App\Models\FrontSetting;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultAffiliateSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $affiliateSettingData = [
            'affiliate_image' => ('/images/affiliate.png'),
            'affiliate_title' => 'Refer And Earn',
            'affiliate_description' =>'Amet accusantium sunt, aut totam reiciendis, earum deleniti minus reprehenderit ad aperiam possimus cum. earum deleniti minus reprehenderit.'
        ];

        foreach ($affiliateSettingData as $key => $value) {
            $affiliateUsDataExist = FrontSetting::where('key', $key)->exists();
            if (!$affiliateUsDataExist) {
                FrontSetting::create(['key' => $key, 'value' => $value]);
            }
        }

    }
}
