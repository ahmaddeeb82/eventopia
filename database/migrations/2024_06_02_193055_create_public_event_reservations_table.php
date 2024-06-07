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
        Schema::create('public_event_reservations', function (Blueprint $table) {
            $table->id();
            $table->boolean('payment')->default(false);
            $table->float('tickets_price')->default(0);
            $table->integer('tickets_number');
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('extra_public_events')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_event_reservations');
    }
};
