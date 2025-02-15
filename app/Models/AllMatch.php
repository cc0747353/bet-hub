<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\AllMatch
 *
 * @property int $id
 * @property string $match_title
 * @property int $league_id
 * @property string|null $start_from
 * @property string|null $end_at
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read League $league
 * @method static Builder|AllMatch newModelQuery()
 * @method static Builder|AllMatch newQuery()
 * @method static Builder|AllMatch query()
 * @method static Builder|AllMatch whereCreatedAt($value)
 * @method static Builder|AllMatch whereEndAt($value)
 * @method static Builder|AllMatch whereId($value)
 * @method static Builder|AllMatch whereLeagueId($value)
 * @method static Builder|AllMatch whereMatchTitle($value)
 * @method static Builder|AllMatch whereStartFrom($value)
 * @method static Builder|AllMatch whereStatus($value)
 * @method static Builder|AllMatch whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $team_a
 * @property string $team_b
 * @property string|null $match_start
 * @property-read int $questions_count
 * @property-read string $team_a_image
 * @property-read string $team_b_image
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @method static Builder|AllMatch whereMatchStart($value)
 * @method static Builder|AllMatch whereTeamA($value)
 * @method static Builder|AllMatch whereTeamB($value)
 * @property int $is_locked
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @method static Builder|AllMatch whereIsLocked($value)
 */
class AllMatch extends Model implements HasMedia
{
    use HasUuids,HasFactory,InteractsWithMedia;

    protected $fillable = [
        'match_title',
        'league_id',
        'team_a',
        'team_b',
        'match_start',
        'start_from',
        'end_at',
        'status',
        'is_locked'
    ];

    public  $casts = [
        'match_title' => 'string',
        'league_id' => 'string',
        'start_from' => 'datetime',
        'end_at' => 'datetime',
        'status' => 'boolean',
    ];
    
    const ACTIVE = 1;
    const INACTIVE = 0;

    const TEAM_A_IMAGE = 'team_a_image';
    const TEAM_B_IMAGE = 'team_b_image';
    protected $appends = ['team_a_image', 'team_b_image'];

    public function getTeamAImageAttribute(): string
    {
        $media = $this->getMedia(self::TEAM_A_IMAGE)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return asset('images/avatar.png');
    }
    
    public function getTeamBImageAttribute(): string
    {
        $media = $this->getMedia(self::TEAM_B_IMAGE)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return asset('images/avatar.png');
    }
    

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class, 'league_id','id');
    }

    public function getQuestionsCountAttribute(): int
    {
        return $this->questions()->count();
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'match_id','id');
    }

    public function bets(): HasMany
    {
        return $this->hasMany(Bet::class, 'match_id', 'id');
    }
}
