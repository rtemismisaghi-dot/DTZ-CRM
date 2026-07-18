<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
         'name',
    'mobile',
    'national_code',
    'address',
    'lat',
    'lng',
    ];

    public function measurements(): HasMany
    {
        return $this->hasMany(Measurement::class);
    }
}