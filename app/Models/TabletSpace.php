<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TabletSpace extends Model
{
    protected $fillable = [

        'project_token',

        'name',

        'area',

        'roll',

        'roll_count',

        'drawing',

        'carpet_model_id',

        'carpet_code_id',

    ];


    public function carpetModel()
    {
        return $this->belongsTo(CarpetModel::class);
    }


    public function carpetCode()
    {
        return $this->belongsTo(CarpetCode::class);
    }
}