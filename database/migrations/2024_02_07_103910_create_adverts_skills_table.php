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
        Schema::create('adverts_skills', function (Blueprint $table) {
            $table->unsignedBigInteger('advert_id');
            $table->unsignedBigInteger('skill_id');
            $table->timestamps();
            $table->foreign('advert_id')->references('id')->on('adverts')->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adverts_skills');
    }
};