<?php

namespace App\Models;

use App\Models\Contracts\JsonResourceful;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Blog
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $tag
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $blog_image
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @method static Builder|Blog newModelQuery()
 * @method static Builder|Blog newQuery()
 * @method static Builder|Blog query()
 * @method static Builder|Blog whereCreatedAt($value)
 * @method static Builder|Blog whereDescription($value)
 * @method static Builder|Blog whereId($value)
 * @method static Builder|Blog whereSlug($value)
 * @method static Builder|Blog whereTag($value)
 * @method static Builder|Blog whereTitle($value)
 * @method static Builder|Blog whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Blog extends Model implements HasMedia
{
    use HasUuids,HasFactory, InteractsWithMedia;

    protected $with = ['media'];

    protected $fillable = [
        'slug',
        'tag',
        'title',
        'description',
    ];

    public $casts = [
        'slug' => 'string',
        'tag' => 'string',
        'title' => 'string',
        'description' => 'string',
    ];
    const IMAGE = 'blog_images';
    protected $appends = ['blog_image'];

    public function getBlogImageAttribute(): string
    {
        $media = $this->getMedia(self::IMAGE)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return asset('images/avatar.png');
    }
}
