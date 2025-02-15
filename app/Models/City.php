<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasUuids,HasFactory;

    public $table = 'cities';

    public $fillable = [
        'name',
        'state_id',
    ];

    protected $casts = [
        'name' => 'string',
        'state_id' => 'string',
    ];

    public static $rules = [
        'name' => 'required|unique:cities,name',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
