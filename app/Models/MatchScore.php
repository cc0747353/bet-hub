<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MatchScore
 *
 * @property string $id
 * @property string $match_id
 * @property string|null $team_a_score
 * @property string|null $team_b_score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MatchScore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MatchScore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MatchScore query()
 * @method static \Illuminate\Database\Eloquent\Builder|MatchScore whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MatchScore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MatchScore whereMatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MatchScore whereTeamAScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MatchScore whereTeamBScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MatchScore whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MatchScore extends Model
{
    use HasUuids,HasFactory;
    
    protected $fillable = [
        'match_id',
        'team_a_score',
        'team_b_score',
    ];
    
    protected $table = 'match_score';
}
