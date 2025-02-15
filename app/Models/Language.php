<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Language
 *
 * @property string $id
 * @property string $name
 * @property string $iso_code
 * @property string|null $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Language newModelQuery()
 * @method static Builder|Language newQuery()
 * @method static Builder|Language query()
 * @method static Builder|Language whereCreatedAt($value)
 * @method static Builder|Language whereId($value)
 * @method static Builder|Language whereIsDefault($value)
 * @method static Builder|Language whereIsoCode($value)
 * @method static Builder|Language whereName($value)
 * @method static Builder|Language whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Language extends Model
{
    use HasUuids,HasFactory;
    
    protected $table = 'language';
    
    protected $fillable = [
        'name',
        'iso_code'
    ];
    public static $rules = [
        'name'     => 'required|unique:language,name|max:20',
        'iso_code' => 'required|unique:language,iso_code|min:2|max:2',
    ];
}
