<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CarpetCode extends Model
{

    protected $fillable = [

        'carpet_model_id',
        'code',

    ];



    public function carpetModel()
    {
        return $this->belongsTo(
            CarpetModel::class
        );
    }

}