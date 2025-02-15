<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\SmsGateways
 *
 * @property string $id
 * @property string $key
 * @property string|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SmsGateways newModelQuery()
 * @method static Builder|SmsGateways newQuery()
 * @method static Builder|SmsGateways query()
 * @method static Builder|SmsGateways whereCreatedAt($value)
 * @method static Builder|SmsGateways whereId($value)
 * @method static Builder|SmsGateways whereKey($value)
 * @method static Builder|SmsGateways whereUpdatedAt($value)
 * @method static Builder|SmsGateways whereValue($value)
 * @mixin Eloquent
 */
class SmsGateways extends Model
{
    use HasUuids,HasFactory;

    protected $fillable = ['key', 'value'];

    const nexmo = 1;
    const twilio = 2;

    const SEND_SMS_METHOD = [
        self::nexmo => 'Nexmo',
        self::twilio => 'Twilio',
    ];
    
}
