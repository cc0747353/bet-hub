<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\EmailTemplate
 *
 * @property string $id
 * @property string $name
 * @property string $subject
 * @property string $message
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|EmailTemplate newModelQuery()
 * @method static Builder|EmailTemplate newQuery()
 * @method static Builder|EmailTemplate query()
 * @method static Builder|EmailTemplate whereCreatedAt($value)
 * @method static Builder|EmailTemplate whereId($value)
 * @method static Builder|EmailTemplate whereMessage($value)
 * @method static Builder|EmailTemplate whereName($value)
 * @method static Builder|EmailTemplate whereStatus($value)
 * @method static Builder|EmailTemplate whereSubject($value)
 * @method static Builder|EmailTemplate whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $variables
 * @method static Builder|EmailTemplate whereVariables($value)
 */
class EmailTemplate extends Model
{
    use HasUuids,HasFactory;

    /**
     * @var string
     */
    public $table = 'email_templates';

    /**
     * @var array
     */
    public $fillable = [
        'name',
        'subject',
        'message',
        'status',
    ];
    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $casts = [
        'name' => 'string',
        'subject' => 'string',
        'message' => 'string',
        'status' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'subject' => 'required|max:150',
        'message'    => 'required',
    ];
}
