<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserReferralsLevel
 *
 * @property string $id
 * @property string $user_id
 * @property string $level
 * @property string $type
 * @property string $commission
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $userName
 * @method static Builder|UserReferralsLevel newModelQuery()
 * @method static Builder|UserReferralsLevel newQuery()
 * @method static Builder|UserReferralsLevel query()
 * @method static Builder|UserReferralsLevel whereCommission($value)
 * @method static Builder|UserReferralsLevel whereCreatedAt($value)
 * @method static Builder|UserReferralsLevel whereId($value)
 * @method static Builder|UserReferralsLevel whereLevel($value)
 * @method static Builder|UserReferralsLevel whereType($value)
 * @method static Builder|UserReferralsLevel whereUpdatedAt($value)
 * @method static Builder|UserReferralsLevel whereUserId($value)
 * @mixin Eloquent
 */
class UserReferralsLevel extends Model
{
    use HasUuids,HasFactory;
    
    protected $table = 'user_referrals_level';
    
    protected $fillable = [
        'user_id',
        'referral_to_id',
        'level',
        'type',
        'commission',
    ];

    public $casts = [
        'user_id'        => 'string',
        'referral_to_id' => 'string',
        'level'          => 'string',
        'type'           => 'string',
        'commission'     => 'string',
    ];

    const DEPOSIT_COMMISSION = 1;
    const BET_PLACE_COMMISSION = 2;
    const BET_WIN_COMMISSION = 3;
    
    const REFERRAL_PAYMENT_METHOD = [
        self::DEPOSIT_COMMISSION   => 'Deposit Commission',
        self::BET_PLACE_COMMISSION => 'Bet Place Commission',
        self::BET_WIN_COMMISSION   => 'Bet Win Commission',
    ];

    public function userName()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
