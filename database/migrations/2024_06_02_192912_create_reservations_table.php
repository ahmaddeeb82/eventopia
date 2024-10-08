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
            $table->integer('attendees_number')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->float('duration')->default(0);
            $table->boolean('payment')->default(false);
            $table->decimal('total_price', 20)->default(0);
            $table->text('notes')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('confirmed_guest_id');
            $table->foreign('confirmed_guest_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('service_asset')->onDelete('cascade');
            $table->foreignId('time_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
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
