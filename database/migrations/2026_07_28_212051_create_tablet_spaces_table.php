<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tablet_spaces', function (Blueprint $table) {

            $table->id();

            $table->string('project_token');

            $table->string('name');

            $table->decimal('area', 8, 2)->nullable();

            $table->string('roll')->nullable();

            $table->integer('roll_count')->default(1);

            $table->longText('drawing')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tablet_spaces');
    }
};