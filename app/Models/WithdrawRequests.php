<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\WithdrawRequests
 *
 * @property string $id
 * @property string $user_id
 * @property float $amount
 * @property int $method
 * @property string $currency_id
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder|WithdrawRequests newModelQuery()
 * @method static Builder|WithdrawRequests newQuery()
 * @method static Builder|WithdrawRequests query()
 * @method static Builder|WithdrawRequests whereAmount($value)
 * @method static Builder|WithdrawRequests whereCreatedAt($value)
 * @method static Builder|WithdrawRequests whereCurrencyId($value)
 * @method static Builder|WithdrawRequests whereId($value)
 * @method static Builder|WithdrawRequests whereMethod($value)
 * @method static Builder|WithdrawRequests whereStatus($value)
 * @method static Builder|WithdrawRequests whereUpdatedAt($value)
 * @method static Builder|WithdrawRequests whereUserId($value)
 * @mixin Eloquent
 * @property string|null $notes
 * @property string|null $user_notes
 * @property-read \App\Models\Currency $currency
 * @property-read string $attachment
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @method static Builder|WithdrawRequests whereNotes($value)
 * @method static Builder|WithdrawRequests whereUserNotes($value)
 */
class WithdrawRequests extends Model implements HasMedia
{
    use HasUuids, HasFactory, InteractsWithMedia,Impersonate;

    protected $fillable = [
        'user_id', 
        'amount', 
        'method', 
        'currency_id', 
        'status',
        'notes',
        'user_notes',
    ];

    const BANK = 1;
    const PAYPAL = 2;
    const PAYMENT_METHOD = [
        self::BANK   => 'Bank',
        self::PAYPAL => 'PayPal',
    ];

    const APPROVED = 1;
    const PENDING = 2;
    const REJECTED = 0;

    const PAYMENT_STATUS = [
        self::APPROVED => 'Approved',
        self::PENDING  => 'Pending',
        self::REJECTED => 'Rejected',
    ];
    
    const STATUS_COLOR = [
        self::APPROVED =>'success',
        self::PENDING => 'warning',
        self::REJECTED => 'danger',
    ];
    
    const IMG_URL = [
        self::BANK   => 'images/logo/manually.png',
        self::PAYPAL => 'images/logo/paypal.png',
    ];

    const ATTACHMENT = 'withdraw_attachment';

    /**
     * @return string
     */
    public function getAttachmentAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::ATTACHMENT)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}
