<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('beranda', function (Blueprint $table) {
            $table->id();
            $table->text('profil')->nullable();
            $table->text('tentang_kami')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('about_image')->nullable();
            $table->string('gallery_1')->nullable();
            $table->string('gallery_2')->nullable();
            $table->string('gallery_3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beranda');
    }
};
