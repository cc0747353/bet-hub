<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read int|null $league_count
 * @property-read Collection|League[] $league
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereStatus($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $icon
 * @method static Builder|Category whereIcon($value)
 */
class Category extends Model
{
    use HasUuids,HasFactory;
    
    protected $fillable = ['name', 'icon', 'status'];

    public $casts = [
      'name' => 'string',  
      'icon' => 'string',  
      'status' => 'boolean',  
    ];
    
    const ACTIVE = 1;
    const INACTIVE = 0;

   
    public function league(): HasMany
    {
        return $this->hasMany(League::class, 'category_id','id');
    }

    public function getLeagueCountAttribute(): int
    {
        $leagueCount = League::whereCategoryId($this->id)->count();
        
        return $leagueCount;
    }
    
    public function matchDetails()
    {
        return $this->hasOneThrough(AllMatch::class, League::class);
    }
}
