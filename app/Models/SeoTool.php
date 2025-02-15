<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * App\Models\SeoTool
 *
 * @method static Builder|SeoTool newModelQuery()
 * @method static Builder|SeoTool newQuery()
 * @method static Builder|SeoTool query()
 * @mixin Eloquent
 * @property string $id
 * @property string $meta_keyword
 * @property string $meta_description
 * @property string $social_title
 * @property string $social_description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SeoTool whereCreatedAt($value)
 * @method static Builder|SeoTool whereId($value)
 * @method static Builder|SeoTool whereMetaDescription($value)
 * @method static Builder|SeoTool whereMetaKeyword($value)
 * @method static Builder|SeoTool whereSocialDescription($value)
 * @method static Builder|SeoTool whereSocialTitle($value)
 * @method static Builder|SeoTool whereUpdatedAt($value)
 */
class SeoTool extends Model
{
    use HasUuids,HasFactory;

    protected $table = 'seo_tool';
    
    protected $fillable = [
      'meta_keyword',
      'meta_description',
      'social_title',
      'social_description',
    ];
    
    public $casts = [
        'meta_keyword' => 'string',
        'meta_description' => 'string',
        'social_title' => 'string',
        'social_description' => 'string',
    ];
}
