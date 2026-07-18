<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurements', function (Blueprint $table) {

            $table->id();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnDelete();

            // اطلاعات اصلی
            $table->string('tracking_code')->unique();
            $table->string('measurement_type');
            $table->string('title');
            $table->text('description')->nullable();

            // تاریخ
            $table->date('measurement_date')->nullable();

            // وضعیت‌ها
            $table->string('status')->default('created');
            $table->string('payment_status')->default('pending');

            // اندازه‌گیر
            $table->string('measurement_by')->nullable();

            // قوانین
            $table->enum('terms_type', [
                'online',
                'offline'
            ])->nullable();

            // آدرس
            $table->text('address')->nullable();

            $table->decimal('latitude',10,7)->nullable();
            $table->decimal('longitude',10,7)->nullable();

            // تصویر
            $table->string('image')->nullable();

            // هزینه‌ها
            $table->decimal('base_price',12,0)->default(0);

            $table->decimal('distance_km',8,2)->default(0);

            $table->decimal('distance_price',12,0)->default(0);

            $table->decimal('total_price',12,0)->default(0);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};