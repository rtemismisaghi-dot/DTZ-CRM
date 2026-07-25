<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Measurement extends Model
{
    protected $fillable = [

        'customer_id',

        'tracking_code',

        'measurement_type',

        'title',

        'description',

        'measurement_date',

        'status',

        'payment_status',

        'measurement_by',

        'terms_type',

        'address',

        'latitude',

        'longitude',

        'image',

        'base_price',

        'distance_km',

        'distance_price',

        'total_price',

    ];

    protected $casts = [

        'measurement_date' => 'date',

    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {

            'created' => 'ایجاد شده',

            'waiting_schedule' => 'ارسال برای تعیین وقت',

            'ready_invoice' => 'آماده فاکتور',

            'archived' => 'بایگانی',

            default => 'نامشخص',

        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {

            'created' => 'primary',

            'waiting_schedule' => 'warning',

            'ready_invoice' => 'success',

            'archived' => 'secondary',

            default => 'dark',

        };
    }
}