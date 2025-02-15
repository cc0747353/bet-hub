<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\SeoTool;
use Illuminate\Database\Seeder;

class DefaultCurrencySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currency =
            [
                'currency_name' => 'US Dollar',
                'currency_icon' => '$',
                'currency_code' => 'USD',
            ];
        Currency::create($currency);
    }
}
