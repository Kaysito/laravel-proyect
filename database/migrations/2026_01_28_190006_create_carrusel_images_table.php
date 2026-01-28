<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carrusel_images', function (Blueprint $table) {
            $table->id();
            $table->string('url', 2048);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carrusel_images');
    }
};
