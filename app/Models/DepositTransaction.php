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
 * App\Models\DepositTransaction
 *
 * @property string $id
 * @property string $user_id
 * @property string $currency_id
 * @property string $transaction_id
 * @property float|null $amount
 * @property float $deposit_amount
 * @property float|null $tax
 * @property int $type
 * @property int $status
 * @property mixed|null $meta
 * @property string|null $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder|DepositTransaction newModelQuery()
 * @method static Builder|DepositTransaction newQuery()
 * @method static Builder|DepositTransaction query()
 * @method static Builder|DepositTransaction whereAmount($value)
 * @method static Builder|DepositTransaction whereCreatedAt($value)
 * @method static Builder|DepositTransaction whereCurrencyId($value)
 * @method static Builder|DepositTransaction whereDepositAmount($value)
 * @method static Builder|DepositTransaction whereId($value)
 * @method static Builder|DepositTransaction whereMessage($value)
 * @method static Builder|DepositTransaction whereMeta($value)
 * @method static Builder|DepositTransaction whereStatus($value)
 * @method static Builder|DepositTransaction whereTax($value)
 * @method static Builder|DepositTransaction whereTransactionId($value)
 * @method static Builder|DepositTransaction whereType($value)
 * @method static Builder|DepositTransaction whereUpdatedAt($value)
 * @method static Builder|DepositTransaction whereUserId($value)
 * @mixin Eloquent
 * @property string|null $notes
 * @property-read \App\Models\Currency $currency
 * @property-read string $attachment
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @method static Builder|DepositTransaction whereNotes($value)
 */
class DepositTransaction extends Model implements HasMedia
{
    use HasUuids,HasFactory ,InteractsWithMedia, Impersonate;

    protected $table = 'deposit_payment_transactions';
    
    protected $fillable = [
        'transaction_id',
        'user_id',
        'amount',
        'deposit_amount',
        'tax',
        'type',
        'currency_id',
        'meta',
        'message',
        'status',
        'notes',
    ];
    const SUCCESS = 1;
    const PENDING = 2;
    const FAILED = 0;
    
    
    const PAYMENT_STATUS = [
        self::SUCCESS =>'Success',
        self::PENDING => 'Pending',
        self::FAILED => 'Failed',
    ];

    const STATUS_COLOR = [
        self::SUCCESS =>'success',
        self::PENDING => 'warning',
        self::FAILED => 'danger',
    ];
    
    const ATTACHMENT = 'deposit_attachment';
    
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
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}
