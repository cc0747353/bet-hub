<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\SocialIcon
 *
 * @property string $id
 * @property string $title
 * @property string $icon
 * @property string $url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SocialIcon newModelQuery()
 * @method static Builder|SocialIcon newQuery()
 * @method static Builder|SocialIcon query()
 * @method static Builder|SocialIcon whereCreatedAt($value)
 * @method static Builder|SocialIcon whereIcon($value)
 * @method static Builder|SocialIcon whereId($value)
 * @method static Builder|SocialIcon whereTitle($value)
 * @method static Builder|SocialIcon whereUpdatedAt($value)
 * @method static Builder|SocialIcon whereUrl($value)
 * @mixin Eloquent
 */
class SocialIcon extends Model
{
    use HasUuids,HasFactory;
    
    protected $fillable = [
      'title',  
      'icon',  
      'url',  
    ];
    
    public $casts = [
        'title' => 'string',
        'icon' => 'string',
        'url' => 'string',
    ];
}
