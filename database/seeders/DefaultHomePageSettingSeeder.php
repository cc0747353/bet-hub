<?php

namespace Database\Seeders;

use App\Models\FrontSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultHomePageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $homePageSettingData = [
            'home_bg_image' => ('/images/banner.png'),
            'home_title' => 'Invest Bid A Little & Get More Profit',
            'home_description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever.'
        ];

        foreach ($homePageSettingData as $key => $value) {
            $homePageDataExist = FrontSetting::where('key', $key)->exists();
            if (!$homePageDataExist) {
                FrontSetting::create(['key' => $key, 'value' => $value]);
            }
        }
    }
}
