<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Analytic
 *
 * @property string $id
 * @property string $user_id
 * @property string|null $uri
 * @property string|null $source
 * @property string|null $country
 * @property string|null $browser
 * @property string|null $device
 * @property string|null $operating_system
 * @property string|null $ip
 * @property string|null $language
 * @property string|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic query()
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereOperatingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Analytic whereUserId($value)
 * @mixin \Eloquent
 */
class Analytic extends Model
{
    use HasUuids,HasFactory;
    
    protected $fillable = [
        'user_id',
        'uri',
        'source',
        'country',
        'state',
        'browser',
        'device',
        'operating_system',
        'ip',
        'language',
        'meta' 
    ];
    
    protected $casts = [
        'user_id' => 'string',
        'uri' => 'string',
        'source' => 'string',
        'country' => 'string',
        'state' => 'string',
        'browser' => 'string',
        'device' => 'string',
        'operating_system' => 'string',
        'ip' => 'string',
        'language' => 'string',
    ];
}
