<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Country
 *
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country query()
 * @mixin Eloquent
 * @property string $id
 * @property string $name
 * @property string|null $short_code
 * @property string|null $phone_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereName($value)
 * @method static Builder|Country wherePhoneCode($value)
 * @method static Builder|Country whereShortCode($value)
 * @method static Builder|Country whereUpdatedAt($value)
 */
class Country extends Model
{
    use HasUuids,HasFactory;

    protected $table = 'countries';

    public $fillable = [
        'name',
        'short_code',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'       => 'string',
        'short_code' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:countries,name',
    ];

}
