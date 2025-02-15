<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ReferralLevel
 *
 * @property int $id
 * @property int|null $referral_id
 * @property string $level
 * @property string $commission
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Referral|null $referral
 * @method static Builder|ReferralLevel newModelQuery()
 * @method static Builder|ReferralLevel newQuery()
 * @method static Builder|ReferralLevel query()
 * @method static Builder|ReferralLevel whereCommission($value)
 * @method static Builder|ReferralLevel whereCreatedAt($value)
 * @method static Builder|ReferralLevel whereId($value)
 * @method static Builder|ReferralLevel whereLevel($value)
 * @method static Builder|ReferralLevel whereReferralId($value)
 * @method static Builder|ReferralLevel whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ReferralLevel extends Model
{
    use HasUuids,HasFactory;
    
    protected $table = 'referrals_level';
    
    protected $fillable = ['referral_id', 'level', 'commission'];

    public $casts = [
      'referral_id' => 'string',  
      'level' => 'string',  
      'commission' => 'string',  
    ];
    public function referral(): BelongsTo
    {
        return $this->belongsTo(Referral::class, 'referral_id','id');
    }
}
