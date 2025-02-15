<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\PaymentGateway
 *
 * @property int $id
 * @property int $payment_gateway_id
 * @property string $payment_gateway
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PaymentGateway newModelQuery()
 * @method static Builder|PaymentGateway newQuery()
 * @method static Builder|PaymentGateway query()
 * @method static Builder|PaymentGateway whereCreatedAt($value)
 * @method static Builder|PaymentGateway whereId($value)
 * @method static Builder|PaymentGateway wherePaymentGateway($value)
 * @method static Builder|PaymentGateway wherePaymentGatewayId($value)
 * @method static Builder|PaymentGateway whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $name
 * @property bool $status
 * @method static Builder|PaymentGateway whereName($value)
 * @method static Builder|PaymentGateway whereStatus($value)
 */
class PaymentGateway extends Model
{
    use HasUuids,HasFactory;
    protected $table = 'payment_gateways';
    
    protected $fillable = [
        'name',
        'status',
        ];

    public  $casts = [
        'name' => 'string',
        'status' => 'boolean',
    ];
    
    const STRIPE = 1;
    const PAYPAL = 2;
    const RAZORPAY = 3;
    const PAYTM = 4;
    const AUTHORIZE = 6;
    const PAYSTACK = 7;
    const MANUALLY = 8;
    const DEPOSIT_COMMISSION = 9;
    const BET_PLACE_COMMISSION = 10;
    const BET_WIN_COMMISSION = 11;
    
    const PAYMENT_METHOD = [
        self::STRIPE => 'Stripe',
        self::PAYPAL => 'PayPal',
        self::RAZORPAY => 'Razorpay',
        self::PAYTM => 'Paytm',
        self::AUTHORIZE => 'Authorize',
        self::PAYSTACK => 'Paystack',
        self::MANUALLY => 'Manually',
    ]; 
    
    const REFERRAL_PAYMENT_METHOD = [
    self::STRIPE => 'Stripe',
    self::PAYPAL => 'PayPal',
    self::RAZORPAY => 'Razorpay',
    self::PAYTM => 'Paytm',
    self::AUTHORIZE => 'Authorize',
    self::PAYSTACK => 'Paystack',
    self::MANUALLY => 'Manually',
    self::DEPOSIT_COMMISSION => 'Deposit Commission',
    self::BET_PLACE_COMMISSION => 'Bet Place Commission',
    self::BET_WIN_COMMISSION => 'Bet Win Commission',
];

    const IMG_URL = [
        self::STRIPE => 'images/logo/stripe.png',
        self::PAYPAL => 'images/logo/paypal.png',
        self::RAZORPAY => 'images/logo/razorpay.png',
        self::PAYTM => 'images/logo/paytm.png',
        self::AUTHORIZE => 'images/logo/authorize.png',
        self::PAYSTACK => 'images/logo/paystack.png',
        self::MANUALLY => 'images/logo/manually.png',
    ];

    const ACTIVE = 1;
    const INACTIVE = 0;
}
