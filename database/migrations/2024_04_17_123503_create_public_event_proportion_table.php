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
        Schema::create('public_event_proportion', function (Blueprint $table) {
            $table->id();
            $table->float('proportion');
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('service_asset')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_event_proportion');
    }
};
