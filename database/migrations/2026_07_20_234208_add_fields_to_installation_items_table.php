<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('installation_items', function (Blueprint $table) {

            $table->string('title')->after('id');

            $table->string('key')->unique()->after('title');

            $table->integer('price')->default(0)->after('key');

            $table->boolean('status')->default(1)->after('price');

        });
    }


    public function down(): void
    {
        Schema::table('installation_items', function (Blueprint $table) {

            $table->dropColumn([
                'title',
                'key',
                'price',
                'status'
            ]);

        });
    }

};