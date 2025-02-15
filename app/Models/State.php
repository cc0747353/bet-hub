<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends Model
{
    use HasUuids,HasFactory;

    protected $table = 'states';

    public $fillable = [
        'name',
        'country_id',
    ];

    protected $casts = [
        'name' => 'string',
        'country_id' => 'integer',
    ];

    public static $rules = [
        'name' => 'required|unique:states,name',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
