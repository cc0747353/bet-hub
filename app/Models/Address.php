<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property int $user_id
 * @property int $country_id
 * @property string $address_1
 * @property string $address_2
 * @property string $state
 * @property string $city
 * @property string $zip
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|Eloquent $owner
 * @method static Builder|Address newModelQuery()
 * @method static Builder|Address newQuery()
 * @method static Builder|Address query()
 * @method static Builder|Address whereAddress1($value)
 * @method static Builder|Address whereAddress2($value)
 * @method static Builder|Address whereCity($value)
 * @method static Builder|Address whereCountryId($value)
 * @method static Builder|Address whereCreatedAt($value)
 * @method static Builder|Address whereId($value)
 * @method static Builder|Address whereState($value)
 * @method static Builder|Address whereUpdatedAt($value)
 * @method static Builder|Address whereUserId($value)
 * @method static Builder|Address whereZip($value)
 * @mixin Eloquent
 * @property-read Country|null $country
 * @property-read User|null $user
 */
class Address extends Model
{
    use HasUuids,HasFactory;

    protected $table = 'address';

    protected $fillable = [
        'user_id',
        'address_1',
        'address_2',
        'country_id',
        'state',
        'city',
        'zip',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function country(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Country::class, 'id' ,  'country_id');
    }
}
