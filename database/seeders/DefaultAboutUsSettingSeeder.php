<?php

namespace Database\Seeders;

use App\Models\FrontSetting;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultAboutUsSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aboutUsSettingData = [
            'about_us_image' => ('/images/about.png'),   
            'about_us_title' => 'Know About Us',
            'about_us_description' => 'Amet accusantium sunt, aut totam reiciendis, earum deleniti minus reprehenderit ad aperiam possimus cum. Non tenetur dolorem molestiae voluptate sit, modi qui, beatae libero excepturi a odio corporis soluta minima. Laudantium impedit ab ut id nisi. Non tenetur dolorem molestiae voluptate sit, modi qui, beatae libero excepturi a odio corporis soluta minima. Laudantium impedit ab ut id nisi. Non tenetur dolorem molestiae voluptate modi qui, beatae libero excepturi a odio Laudantium impedit ab ut id nisi.'
        ];

        foreach ($aboutUsSettingData as $key => $value) {
            $aboutUsDataExist = FrontSetting::where('key', $key)->exists();
            if (!$aboutUsDataExist) {
                FrontSetting::create(['key' => $key, 'value' => $value]);
            }
        }
        
    }
}
