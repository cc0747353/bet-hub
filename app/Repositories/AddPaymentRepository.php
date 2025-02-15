<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;


/**
 * Class CategoryRepository
 */
class AddPaymentRepository extends BaseRepository
{
    public $fieldSearchable = [
        'name',
    ];

    public function getFieldsSearchable(): mixed
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Category::class;
    }


    public function manageStripeData($userId, $data): array
    {

        $amountToPay = $data['amountToPay'] * 100;

        setStripeApiKey();
        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email'       => Auth::user()->email,
            'line_items'           => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => getLogInUser()->full_name,
                        ],
                        'unit_amount'  => (int) $amountToPay,
                        'currency'     => getCurrencyCode(),
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode'                 => 'payment',
            'success_url'          => url('user/payment-success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => url('user/failed-payment?error=payment_cancelled'),
        ]);

        $result = [
            'sessionId' => $session['id'],
        ];

        return $result;
    }
}
