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
        Schema::create('proportion', function (Blueprint $table) {
            $table->id();
            $table->integer('proportion');
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('service_asset');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proportion');
    }
};
