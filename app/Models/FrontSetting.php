<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\FrontSetting
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $image_url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting whereValue($value)
 * @mixin \Eloquent
 */
class FrontSetting extends Model implements HasMedia
{
    use HasUuids, HasFactory , InteractsWithMedia;

    public $table = 'front_settings';

    const ABOUT_US_IMAGE_PATH = 'about-us-image';
    const HOME_BG_IMAGE = 'home-bg-image';
    const AFFILIATE_IAMGE = 'affiliate-image';
    const CONTACT_US_IAMGE = 'contact-us-image';

    public $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'id' => 'integer',
        'key' => 'string',
        'value' => 'string',
    ];

    public function getImageUrlAttribute(): mixed
    {
        /** @var Media $media */
        $medias = $this->getMedia(self::HOME_BG_IMAGE);
        $mediaUrl = [];
        foreach ($medias as $media) {
            if (! empty($media)) {
                $mediaUrl[] = $media->getFullUrl();
            }
        }

        return $mediaUrl;
    }
}
