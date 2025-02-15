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
 * App\Models\League
 *
 * @property int $id
 * @property int|null $category_id
 * @property string $name
 * @property string $icon
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category|null $category
 * @method static Builder|League newModelQuery()
 * @method static Builder|League newQuery()
 * @method static Builder|League query()
 * @method static Builder|League whereCategoryId($value)
 * @method static Builder|League whereCreatedAt($value)
 * @method static Builder|League whereIcon($value)
 * @method static Builder|League whereId($value)
 * @method static Builder|League whereName($value)
 * @method static Builder|League whereStatus($value)
 * @method static Builder|League whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read int|null $match_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AllMatch[] $match
 */
class League extends Model
{
    use HasUuids,HasFactory;

    protected $fillable = ['name', 'category_id','status', 'icon'];

    public $casts = [
      'name' => 'string',  
      'category_id' => 'string',  
      'status' => 'boolean',  
      'icon' => 'string',  
    ];
    const ACTIVE = 1;
    const INACTIVE = 0;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }

    public function match(): HasMany
    {
        return $this->hasMany(AllMatch::class, 'league_id','id');
    }

    /**
     * @return int
     */
    public function getMatchCountAttribute(){
        $matchCount = AllMatch::whereLeagueId($this->id)->count();

        return $matchCount;
    }
}
