<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\SmsTemplate
 *
 * @property string $id
 * @property string $name
 * @property string $message
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SmsTemplate newModelQuery()
 * @method static Builder|SmsTemplate newQuery()
 * @method static Builder|SmsTemplate query()
 * @method static Builder|SmsTemplate whereCreatedAt($value)
 * @method static Builder|SmsTemplate whereId($value)
 * @method static Builder|SmsTemplate whereMessage($value)
 * @method static Builder|SmsTemplate whereName($value)
 * @method static Builder|SmsTemplate whereStatus($value)
 * @method static Builder|SmsTemplate whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SmsTemplate extends Model
{
    use HasUuids,HasFactory;

    public $table = 'sms_templates';
    
    protected $fillable = [
        'name',
        'message',
        'variables',
        'status',
    ];
    
    public $casts = [
        'name' => 'string',
        'message' => 'string',
        'variables' => 'string',
        'status' => 'boolean',
    ];
    const ACTIVE = 1;
    const INACTIVE = 0;
}
