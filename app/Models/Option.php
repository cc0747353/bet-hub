<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Option
 *
 * @property string $id
 * @property string $question_id
 * @property string $name
 * @property string $dividend
 * @property string $divisor
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Option newModelQuery()
 * @method static Builder|Option newQuery()
 * @method static Builder|Option query()
 * @method static Builder|Option whereCreatedAt($value)
 * @method static Builder|Option whereDividend($value)
 * @method static Builder|Option whereDivisor($value)
 * @method static Builder|Option whereId($value)
 * @method static Builder|Option whereName($value)
 * @method static Builder|Option whereQuestionId($value)
 * @method static Builder|Option whereStatus($value)
 * @method static Builder|Option whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Option extends Model
{
    use HasUuids,HasFactory;
    
    protected $fillable = [
        'question_id',
        'name',
        'dividend',
        'divisor',
        'status',
    ];

    public $casts = [
      'question_id' => 'string',  
      'name' => 'string',
      'dividend' => 'string',
      'divisor' => 'string',
      'status' => 'boolean',
    ];
    const ACTIVE = 1;
    const INACTIVE = 0;


    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function bets(): HasMany
    {
        return $this->hasMany(Bet::class, 'option_id', 'id');
    }
}
