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
        Schema::create('bicycle_time_slots', function (Blueprint $table) {
    $table->id();
    $table->foreignId('bicycle_id')->constrained('bicycles')->onDelete('cascade');
    $table->date('date'); // The day for the booking
    $table->time('start_time');
    $table->time('end_time');
    $table->enum('status', ['available', 'booked'])->default('available');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bicycle_time_slots');
    }
};
