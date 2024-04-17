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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('attendees_number');
            $table->date('start_date');
            $table->date('end_date');
            $table->float('duration');
            $table->boolean('payment')->default(false);
            $table->float('total_price');
            $table->text('notes')->nullable();
            $table->foreignId('confirmed_guest_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
