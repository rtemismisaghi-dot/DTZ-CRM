<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarpetModel extends Model
{
    protected $fillable = [
        'model_name',
        'code',
        'status',
    ];


    public function codes()
    {
        return $this->hasMany(CarpetCode::class);
    }
}