<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('tracking_code')->unique();

            $table->string('installation_type');

            $table->string('title')->nullable();

            $table->text('description')->nullable();

            $table->date('installation_date')->nullable();

            $table->string('status')->default('created');

            $table->string('payment_status')->default('pending');

            $table->string('installation_by')->nullable();

            $table->enum('terms_type', ['online', 'offline'])->nullable();

            $table->string('address')->nullable();

            $table->decimal('latitude',10,7)->nullable();

            $table->decimal('longitude',10,7)->nullable();

            $table->string('image')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installations');
    }
};