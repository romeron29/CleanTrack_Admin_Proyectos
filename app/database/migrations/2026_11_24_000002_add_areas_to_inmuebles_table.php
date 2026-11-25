<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inmuebles', function (Blueprint $table) {
            $table->unsignedSmallInteger('habitaciones')->default(0);
            $table->unsignedSmallInteger('banos')->default(0);
            $table->unsignedSmallInteger('cocinas')->default(0);
            $table->unsignedSmallInteger('oficinas')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('inmuebles', function (Blueprint $table) {
            $table->dropColumn(['habitaciones', 'banos', 'cocinas', 'oficinas']);
        });
    }
};
