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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->float('percentage');
            $table->decimal('disconted_price', 20);
            $table->date('start_date');
            $table->date('end_date');
            $table->float('duration');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('discounts');
    }
};

