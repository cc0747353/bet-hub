<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Referral
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|ReferralLevel[] $referralLevel
 * @property-read int|null $referral_level_count
 * @method static Builder|Referral newModelQuery()
 * @method static Builder|Referral newQuery()
 * @method static Builder|Referral query()
 * @method static Builder|Referral whereCreatedAt($value)
 * @method static Builder|Referral whereId($value)
 * @method static Builder|Referral whereName($value)
 * @method static Builder|Referral whereStatus($value)
 * @method static Builder|Referral whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Referral extends Model
{
    use HasUuids,HasFactory;
    
    protected $fillable = ['name','status'];

    public $casts = [
      'name' => 'string',  
      'status' => 'boolean',  
    ];
    public function referralLevel(): HasMany
    {
        return $this->hasMany(ReferralLevel::class, 'referral_id','id');
    }
}
