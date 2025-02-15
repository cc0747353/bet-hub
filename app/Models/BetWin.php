<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BetWin
 *
 * @property string $id
 * @property string $bet_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BetWin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BetWin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BetWin query()
 * @method static \Illuminate\Database\Eloquent\Builder|BetWin whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetWin whereBetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetWin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetWin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetWin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BetWin extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'bet_wins';

    protected $fillable = [
        'bet_id',
        'amount',
    ];
}
