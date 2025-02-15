<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use App\Models\PaymentGatewaysFields;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stripe_payment_id = PaymentGateway::whereName('Stripe')->value('id');
        $payPal_payment_id = PaymentGateway::whereName('PayPal')->value('id');
        $razorpay_payment_id = PaymentGateway::whereName('Razorpay')->value('id');
        $paytm_payment_id = PaymentGateway::whereName('Paytm')->value('id');
        $authorize_payment_id = PaymentGateway::whereName('Authorize')->value('id');
        $paystack_payment_id = PaymentGateway::whereName('Paystack')->value('id');
        $manually_payment_id = PaymentGateway::whereName('Manually')->value('id');

        $inputs = [
            [
                'payment_id' => $stripe_payment_id,
                'key'        => 'stripe_key',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $stripe_payment_id,
                'key'        => 'stripe_secret',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $stripe_payment_id,
                'key'        => 'stripe_range_min_amount',
                'value'      => 10,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $stripe_payment_id,
                'key'        => 'stripe_range_max_amount',
                'value'      => 10000,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $stripe_payment_id,
                'key'        => 'stripe_fixed_charge',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $stripe_payment_id,
                'key'        => 'stripe_percent_charge',
                'value'      => 18,
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $payPal_payment_id,
                'key'        => 'paypal_client_id',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $payPal_payment_id,
                'key'        => 'paypal_secret',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $payPal_payment_id,
                'key'        => 'paypal_range_min_amount',
                'value'      => 10,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $payPal_payment_id,
                'key'        => 'paypal_range_max_amount',
                'value'      => 10000,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $payPal_payment_id,
                'key'        => 'paypal_fixed_charge',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $payPal_payment_id,
                'key'        => 'paypal_percent_charge',
                'value'      => 18,
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $payPal_payment_id,
                'key'        => 'paypal_mode',
                'value'      => 'sandbox',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $razorpay_payment_id,
                'key'        => 'razorpay_key',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $razorpay_payment_id,
                'key'        => 'razorpay_secret',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $razorpay_payment_id,
                'key'        => 'razorpay_range_min_amount',
                'value'      => 10,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $razorpay_payment_id,
                'key'        => 'razorpay_range_max_amount',
                'value'      => 10000,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $razorpay_payment_id,
                'key'        => 'razorpay_fixed_charge',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $razorpay_payment_id,
                'key'        => 'razorpay_percent_charge',
                'value'      => 18,
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $paytm_payment_id,
                'key'        => 'paytm_merchant_id',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $paytm_payment_id,
                'key'        => 'paytm_merchant_key',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $paytm_payment_id,
                'key'        => 'paytm_range_min_amount',
                'value'      => 10,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $paytm_payment_id,
                'key'        => 'paytm_range_max_amount',
                'value'      => 10000,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $paytm_payment_id,
                'key'        => 'paytm_fixed_charge',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $paytm_payment_id,
                'key'        => 'paytm_percent_charge',
                'value'      => 18,
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $authorize_payment_id,
                'key'        => 'authorize_key',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $authorize_payment_id,
                'key'        => 'authorize_secret',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $authorize_payment_id,
                'key'        => 'authorize_range_min_amount',
                'value'      => 10,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $authorize_payment_id,
                'key'        => 'authorize_range_max_amount',
                'value'      => 10000,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $authorize_payment_id,
                'key'        => 'authorize_fixed_charge',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $authorize_payment_id,
                'key'        => 'authorize_percent_charge',
                'value'      => 18,
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $paystack_payment_id,
                'key'        => 'paystack_key',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $paystack_payment_id,
                'key'        => 'paystack_secret',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CREDENTIALS,
            ],
            [
                'payment_id' => $paystack_payment_id,
                'key'        => 'paystack_range_min_amount',
                'value'      => 10,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $paystack_payment_id,
                'key'        => 'paystack_range_max_amount',
                'value'      => 10000,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $paystack_payment_id,
                'key'        => 'paystack_fixed_charge',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $paystack_payment_id,
                'key'        => 'paystack_percent_charge',
                'value'      => 18,
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $manually_payment_id,
                'key'        => 'manually_range_min_amount',
                'value'      => 10,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $manually_payment_id,
                'key'        => 'manually_range_max_amount',
                'value'      => 10000,
                'type'       => PaymentGatewaysFields::RANGE,
            ],
            [
                'payment_id' => $manually_payment_id,
                'key'        => 'manually_fixed_charge',
                'value'      => '',
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
            [
                'payment_id' => $manually_payment_id,
                'key'        => 'manually_percent_charge',
                'value'      => 18,
                'type'       => PaymentGatewaysFields::CHARGE,
            ],
        ];

        foreach ($inputs as $input) {
            PaymentGatewaysFields::create($input);
        }
    }
}
