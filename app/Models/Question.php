<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Question
 *
 * @property string $id
 * @property string $match_id
 * @property string $question
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read int $options_count
 * @method static Builder|Question newModelQuery()
 * @method static Builder|Question newQuery()
 * @method static Builder|Question query()
 * @method static Builder|Question whereCreatedAt($value)
 * @method static Builder|Question whereId($value)
 * @method static Builder|Question whereMatchId($value)
 * @method static Builder|Question whereQuestion($value)
 * @method static Builder|Question whereStatus($value)
 * @method static Builder|Question whereUpdatedAt($value)
 * @mixin Eloquent
 * @property bool $is_locked
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Option[] $options
 * @method static Builder|Question whereIsLocked($value)
 */
class Question extends Model
{
    use HasUuids,HasFactory;
    
    protected $fillable = [
        'match_id',
        'question',
        'status',
        'is_locked',
        'result_declared',
    ];

    public $casts = [
      'match_id' => 'string',
      'question' => 'string',
      'status' => 'boolean',
      'is_locked' => 'boolean',
      'result_declared' => 'boolean',
    ];

    const ACTIVE = 1;
    const INACTIVE = 0;
    
    public function getOptionsCountAttribute(): int
    {
        return Option::whereQuestionId($this->id)->count();
    }

    public function match()
    {
        return $this->belongsTo(AllMatch::class, 'match_id','id');
    }
    
    public function options(): HasMany
    {
        return $this->hasMany(Option::class, 'question_id','id');
    }

    public function bets(): HasMany
    {
        return $this->hasMany(Bet::class, 'question_id', 'id');
    }
}
