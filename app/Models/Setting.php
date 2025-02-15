<?php

namespace App\Models;

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
 * App\Models\Setting
 *
 * @property string $id
 * @property string $key
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $favicon
 * @property-read string $logo
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @method static Builder|Setting newModelQuery()
 * @method static Builder|Setting newQuery()
 * @method static Builder|Setting query()
 * @method static Builder|Setting whereCreatedAt($value)
 * @method static Builder|Setting whereId($value)
 * @method static Builder|Setting whereKey($value)
 * @method static Builder|Setting whereUpdatedAt($value)
 * @method static Builder|Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends Model implements HasMedia
{
    use HasUuids,HasFactory, InteractsWithMedia;

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
    ];
    
    protected $appends = ['logo', 'favicon'];
    const LOGO = 'logo';
    const FAVICON = 'favicon';

    /**
     * @return string
     */
    public function getLogoAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(self::LOGO)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return asset('assets/image/infyom-logo.png');
    }

    /**
     *
     *
     * @return string
     */
    public function getFaviconAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(self::FAVICON)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return asset('assets/image/favicon-infyom.png');
    }
}
