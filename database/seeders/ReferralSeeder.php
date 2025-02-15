<?php

namespace Database\Seeders;

use App\Models\Referral;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReferralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inputs = [
          [
              'name' => 'Deposit Commission',
              'status' => 1
          ],
          [
              'name' => 'Bet Place Commission',
              'status' => 0
          ],
          [
              'name' => 'Bet Win Commission',
              'status' => 1
          ],
        ];
        
        foreach ($inputs as $input){
            Referral::create($input);
        }
    }
}
