<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationItem extends Model
{

    protected $fillable = [

        'title',
        'key',
        'price',
        'status'

    ];

}