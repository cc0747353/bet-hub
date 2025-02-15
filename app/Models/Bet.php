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
 * App\Models\Bet
 *
 * @property string $id
 * @property float $amount
 * @property string $currency_id
 * @property string $user_id
 * @property string $match_id
 * @property string $question_id
 * @property string $option_id
 * @property float $win_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Currency $currency
 * @property-read AllMatch $match
 * @property-read Option $option
 * @property-read Question $question
 * @property-read User $user
 * @method static Builder|Bet newModelQuery()
 * @method static Builder|Bet newQuery()
 * @method static Builder|Bet query()
 * @method static Builder|Bet whereAmount($value)
 * @method static Builder|Bet whereCreatedAt($value)
 * @method static Builder|Bet whereCurrencyId($value)
 * @method static Builder|Bet whereId($value)
 * @method static Builder|Bet whereMatchId($value)
 * @method static Builder|Bet whereOptionId($value)
 * @method static Builder|Bet whereQuestionId($value)
 * @method static Builder|Bet whereUpdatedAt($value)
 * @method static Builder|Bet whereUserId($value)
 * @method static Builder|Bet whereWinAmount($value)
 * @mixin Eloquent
 * @property bool $status
 * @method static Builder|Bet whereStatus($value)
 */
class Bet extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'bets';
    
    protected $fillable = [
        'amount',
        'user_id',
        'currency_id',
        'match_id',
        'question_id',
        'option_id',
        'status',
        'win_amount',
    ];

    protected $casts = [
        'user_id' => 'string',
        'currency_id' => 'string',
        'match_id' => 'string',
        'question_id' => 'string',
        'option_id' => 'string',
        'status' => 'integer',
    ];

    const PENDING = 0;
    const WINNER = 1;
    const LOSER = 2;
    const REFUND = 3;

    const STATUS = [
        self::PENDING => 'Pending',
        self::WINNER   => 'Winner',
        self::LOSER    => 'Lose',
        self::REFUND   => 'Refund',
    ];
    
    /**
     *
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function currency() : BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function match() : BelongsTo
    {
        return $this->belongsTo(AllMatch::class, 'match_id', 'id');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function option() : BelongsTo
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
}
