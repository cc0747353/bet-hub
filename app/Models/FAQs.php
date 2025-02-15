<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\FAQs
 *
 * @property string $id
 * @property string $question
 * @property string $answer
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|FAQs newModelQuery()
 * @method static Builder|FAQs newQuery()
 * @method static Builder|FAQs query()
 * @method static Builder|FAQs whereAnswer($value)
 * @method static Builder|FAQs whereCreatedAt($value)
 * @method static Builder|FAQs whereId($value)
 * @method static Builder|FAQs whereQuestion($value)
 * @method static Builder|FAQs whereStatus($value)
 * @method static Builder|FAQs whereUpdatedAt($value)
 * @mixin Eloquent
 */
class FAQs extends Model
{
    use HasUuids,HasFactory;
    
    protected $table = 'faqs';
    
    protected $fillable = [
        'question',
        'answer',
        'status',
    ];

    public $casts = [
        'question' => 'string',
        'answer' => 'string',
        'status' => 'boolean',
    ];
    const ACTIVE = 1;
    const INACTIVE = 0;
}
