<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\EmailConfigureSetting
 *
 * @property string $id
 * @property string $key
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|EmailConfigureSetting newModelQuery()
 * @method static Builder|EmailConfigureSetting newQuery()
 * @method static Builder|EmailConfigureSetting query()
 * @method static Builder|EmailConfigureSetting whereCreatedAt($value)
 * @method static Builder|EmailConfigureSetting whereId($value)
 * @method static Builder|EmailConfigureSetting whereKey($value)
 * @method static Builder|EmailConfigureSetting whereUpdatedAt($value)
 * @method static Builder|EmailConfigureSetting whereValue($value)
 * @mixin Eloquent
 */
class EmailConfigureSetting extends Model
{
    use HasUuids,HasFactory;
    
    protected $fillable = ['key', 'value'];

    const PHP_MAIL = 1;
    const SMTP = 2;
    const SENDGRID_API = 3;
    const MAILJET_API = 4;

    const SEND_MAIL_METHOD = [
        self::PHP_MAIL => 'PHP Mail',
        self::SMTP => 'SMTP',
        self::SENDGRID_API => 'SendGrid API',
        self::MAILJET_API => 'Mailjet API',
    ];

    const SSL = 1;
    const TLS = 2;

    const ENCRYPTION = [
        self::SSL => 'SSL',
        self::TLS => 'TLS',
    ];
}
