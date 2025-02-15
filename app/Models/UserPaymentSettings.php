<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserSettings
 *
 * @property string $id
 * @property string|null $email
 * @property string|null $account_number
 * @property string|null $ifsc_number
 * @property string|null $branch_name
 * @property string|null $account_holder_name
 * @property string $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|UserPaymentSettings newModelQuery()
 * @method static Builder|UserPaymentSettings newQuery()
 * @method static Builder|UserPaymentSettings query()
 * @method static Builder|UserPaymentSettings whereAccountHolderName($value)
 * @method static Builder|UserPaymentSettings whereAccountNumber($value)
 * @method static Builder|UserPaymentSettings whereBranchName($value)
 * @method static Builder|UserPaymentSettings whereCreatedAt($value)
 * @method static Builder|UserPaymentSettings whereEmail($value)
 * @method static Builder|UserPaymentSettings whereId($value)
 * @method static Builder|UserPaymentSettings whereIfscNumber($value)
 * @method static Builder|UserPaymentSettings whereUpdatedAt($value)
 * @method static Builder|UserPaymentSettings whereUserId($value)
 * @mixin Eloquent
 */
class UserPaymentSettings extends Model
{
    use HasUuids,HasFactory;
    
    protected $table = 'user_payment_settings';

    protected $fillable = ['email','account_number','account_holder_name','ifsc_number','branch_name','user_id'];
}
