<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('installations', function (Blueprint $table) {
            $table->decimal('quote_amount', 15, 2)->nullable()->after('payment_status');
            $table->json('quote_payload')->nullable()->after('quote_amount');
        });
    }

    public function down(): void
    {
        Schema::table('installations', function (Blueprint $table) {
            $table->dropColumn(['quote_amount', 'quote_payload']);
        });
    }
};
