<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserReferralsCommission
 *
 * @property string $id
 * @property string $referral_by_id
 * @property string $referral_to_id
 * @property int $type
 * @property string $deposit_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DepositTransaction|null $deposit
 * @property-read User|null $referral_by
 * @property-read User|null $referral_to
 * @method static Builder|UserReferralsCommission newModelQuery()
 * @method static Builder|UserReferralsCommission newQuery()
 * @method static Builder|UserReferralsCommission query()
 * @method static Builder|UserReferralsCommission whereCreatedAt($value)
 * @method static Builder|UserReferralsCommission whereDepositId($value)
 * @method static Builder|UserReferralsCommission whereId($value)
 * @method static Builder|UserReferralsCommission whereReferralById($value)
 * @method static Builder|UserReferralsCommission whereReferralToId($value)
 * @method static Builder|UserReferralsCommission whereType($value)
 * @method static Builder|UserReferralsCommission whereUpdatedAt($value)
 * @mixin Eloquent
 */
class UserReferralsCommission extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'user_referrals_commission';

    protected $fillable = [
        'referral_by_id',
        'referral_to_id',
        'type',
        'deposit_id',
    ];

    protected $casts = [
        'referral_by_id' => 'string',
        'referral_to_id' => 'string',
        'type' => 'integer',
        'deposit_id' => 'string',
    ];
    
    const DEPOSIT_COMMISSION = 1;
    const BET_PLACE_COMMISSION = 2;
    const BET_WIN_COMMISSION = 3;

    const REFERRAL_PAYMENT_METHOD = [
        self::DEPOSIT_COMMISSION   => 'Deposit Commission',
        self::BET_PLACE_COMMISSION => 'Bet Place Commission',
        self::BET_WIN_COMMISSION   => 'Bet Win Commission',
    ];

    public function referral_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'referral_by_id');
    }

    public function referral_to(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'referral_to_id');
    }
    
    public function deposit(): HasOne
    {
        return $this->hasOne(DepositTransaction::class, 'id', 'deposit_id');
    }
}
