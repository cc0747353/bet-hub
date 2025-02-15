<?php

namespace Database\Seeders;

use App\Models\FrontSetting;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultFeatureSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $affiliateSettingData = [
            'feature_title'         => 'Our Special Feature',
            'feature_description'   => 'Amet accusantium sunt, aut totam reiciendis, earum deleniti minus reprehenderit ad aperiam possimus cum. earum deleniti minus reprehenderit.',
            'feature_1_title'       => 'We Are Trusted',
            'feature_1_description' => 'We Are Trusted.',
            'feature_2_title'       => 'We Are Best',
            'feature_2_description' => 'We Are Best.',
            'feature_3_title'       => 'Reward Granted',
            'feature_3_description' => 'Reward Granted.',
        ];

        foreach ($affiliateSettingData as $key => $value) {
            $affiliateUsDataExist = FrontSetting::where('key', $key)->exists();
            if (!$affiliateUsDataExist) {
                FrontSetting::create(['key' => $key, 'value' => $value]);
            }
        }

    }
}
