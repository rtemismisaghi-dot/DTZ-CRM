<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('measurement_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->bigInteger('amount');

            $table->enum('method', [
                'online',
                'cash',
                'card_to_card',
                'pos',
                'bank_transfer'
            ]);

            $table->enum('status', [
                'pending',
                'processing',
                'paid',
                'refunded'
            ])->default('pending');

            $table->string('transaction_id')->nullable();

            $table->string('gateway')->nullable();

            $table->string('ip_address')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};