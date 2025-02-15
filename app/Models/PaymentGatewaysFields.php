<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\PaymentGatewaysFields
 *
 * @property string $id
 * @property string $payment_id
 * @property string $key
 * @property string|null $value
 * @property string|null $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PaymentGatewaysFields newModelQuery()
 * @method static Builder|PaymentGatewaysFields newQuery()
 * @method static Builder|PaymentGatewaysFields query()
 * @method static Builder|PaymentGatewaysFields whereCreatedAt($value)
 * @method static Builder|PaymentGatewaysFields whereId($value)
 * @method static Builder|PaymentGatewaysFields whereKey($value)
 * @method static Builder|PaymentGatewaysFields wherePaymentId($value)
 * @method static Builder|PaymentGatewaysFields whereType($value)
 * @method static Builder|PaymentGatewaysFields whereUpdatedAt($value)
 * @method static Builder|PaymentGatewaysFields whereValue($value)
 * @mixin Eloquent
 */
class PaymentGatewaysFields extends Model
{
    use HasUuids,HasFactory;
    
    protected $table = 'payment_fields';
    
    protected $fillable = [
      'payment_id',  
      'key',  
      'value',  
    ];
    
    public $casts = [
      'payment_id' => 'string',
    ];
    const CREDENTIALS = 1;
    const RANGE = 2;
    const CHARGE = 3;
    
}
