<?php

namespace Database\Seeders;

use App\Models\SmsGateways;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SmsGatewaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $smsGatewaysData = [
            'sms_send_method' => '1',
            'nexmo_api_key' => '',
            'nexmo_api_secret' => '',
            'account_sid' => '',
            'auth_token' => '',
            'from_number' => '',
        ];
        
        foreach ($smsGatewaysData as $key => $value) {
            $smsGatewaysDataExist = SmsGateways::where('key', $key)->exists();
            if (!$smsGatewaysDataExist) {
                SmsGateways::create(['key' => $key, 'value' => $value]);
            }
        }

    }
}
