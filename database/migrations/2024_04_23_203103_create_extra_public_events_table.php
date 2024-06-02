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
        Schema::create('extra_public_events', function (Blueprint $table) {
            $table->id();
            $table->json('category');
            $table->text('description');
            $table->string('photo')->nullable();
            $table->string('name');
            $table->string('address');
            $table->float('ticket_price');
            $table->integer('reserved_tickets')->default(0);
            $table->foreignId('reservation_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_public_events');
    }
};
