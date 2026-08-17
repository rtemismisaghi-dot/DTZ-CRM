<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('carpet_codes', function (Blueprint $table) {

            $table->id();


            $table->foreignId('carpet_model_id')
                  ->constrained('carpet_models')
                  ->cascadeOnDelete();


            $table->string('code')
                  ->unique();


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('carpet_codes');
    }

};