<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaysSeeder extends Seeder
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
                'name'   => 'Manually',
                'status' => 1,
            ],
            [
                'name'   => 'Stripe',
                'status' => 1,
            ],
            [
                'name'   => 'PayPal',
                'status' => 1,
            ],
            [
                'name'   => 'Razorpay',
                'status' => 1,
            ],
            [
                'name'   => 'Paytm',
                'status' => 1,
            ],
            [
                'name'   => 'Authorize',
                'status' => 1,
            ],
            [
                'name'   => 'Paystack',
                'status' => 1,
            ],
        ];

        foreach ($inputs as $input) {
            PaymentGateway::create($input);
        }
    }
}
