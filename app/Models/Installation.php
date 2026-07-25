<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installation extends Model
{

    protected $fillable = [

        'customer_id',

        'tracking_code',

        'installation_type',

        'title',

        'description',

        'installation_date',

        'status',

        'payment_status',

        'installation_by',

        'terms_type',

        'address',

        'latitude',

        'longitude',

        'image',

    ];


    protected $casts = [

        'installation_date' => 'date',

    ];



    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }



    public function getStatusLabelAttribute()
    {
        return match ($this->status) {

            'created' => 'ایجاد شده',

            'scheduled' => 'تعیین وقت',

            'ready_install' => 'آماده نصب',

            'installing' => 'در حال نصب',

            'review' => 'نیاز به بررسی',

            'ready_payment' => 'آماده تسویه شدن',

            'remaining' => 'مانده نصب',

            'completed' => 'تمام شده',

            default => 'نامشخص',

        };
    }



    public function getStatusColorAttribute()
    {
        return match ($this->status) {

            'created' => 'primary',

            'scheduled' => 'warning',

            'ready_install' => 'info',

            'installing' => 'dark',

            'review' => 'danger',

            'ready_payment' => 'success',

            'remaining' => 'secondary',

            'completed' => 'success',

            default => 'light',

        };
    }

}