<?php

namespace Database\Seeders;

use App\Models\FrontSetting;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultContactUsSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contactUsSettingData = [
            'contact_us_image' => ('/images/contact.png'),   
            'contact_us_title' => 'Get In Touch With Us',
            'contact_us_description' =>'Amet accusantium sunt, aut totam reiciendis, earum deleniti minus reprehenderit ad aperiam possimus cum. earum deleniti minus reprehenderit.'
        ];

        foreach ($contactUsSettingData as $key => $value) {
            $contactUsDataExist = FrontSetting::where('key', $key)->exists();
            if (!$contactUsDataExist) {
                FrontSetting::create(['key' => $key, 'value' => $value]);
            }
        }
        
    }
}
