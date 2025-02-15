<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BetLost
 *
 * @property string $id
 * @property string $bet_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BetLost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BetLost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BetLost query()
 * @method static \Illuminate\Database\Eloquent\Builder|BetLost whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetLost whereBetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetLost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetLost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetLost whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BetLost extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'bet_losts';

    protected $fillable = [
        'bet_id',
        'amount',
    ];
}
