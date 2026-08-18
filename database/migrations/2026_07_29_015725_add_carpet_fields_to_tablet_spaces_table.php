<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tablet_spaces', function (Blueprint $table) {

            $table->foreignId('carpet_model_id')
                ->nullable()
                ->after('name');

            $table->foreignId('carpet_code_id')
                ->nullable()
                ->after('carpet_model_id');

        });
    }


    public function down(): void
    {
        Schema::table('tablet_spaces', function (Blueprint $table) {

            $table->dropColumn([
                'carpet_model_id',
                'carpet_code_id'
            ]);

        });
    }
};