<?php

namespace Database\Seeders;

use App\Models\FrontSetting;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultStartSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $affiliateSettingData = [
            'start_title' => 'How To Start',
            'start_description' =>'Amet accusantium sunt, aut totam reiciendis, earum deleniti minus reprehenderit ad aperiam possimus cum. earum deleniti minus reprehenderit.',
            'step_1_title' => 'Create An Account',
            'step_1_description' =>'Distinctio minus consectetur repellat quod minima ad earum rem autem.',
            'step_2_title' => 'Predict Result',
            'step_2_description' =>'Distinctio minus consectetur repellat quod minima ad earum rem autem.',
            'step_3_title' => 'Win And Enjoy',
            'step_3_description' =>'Distinctio minus consectetur repellat quod minima ad earum rem autem.',
        ];

        foreach ($affiliateSettingData as $key => $value) {
            $affiliateUsDataExist = FrontSetting::where('key', $key)->exists();
            if (!$affiliateUsDataExist) {
                FrontSetting::create(['key' => $key, 'value' => $value]);
            }
        }
        
    }
}
