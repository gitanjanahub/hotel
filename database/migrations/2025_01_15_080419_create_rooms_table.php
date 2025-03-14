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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade'); // Reference to room types
            $table->string('name');
            $table->decimal('price_per_night', 10, 2);
            $table->integer('size');
            $table->integer('capacity');
            $table->integer('adults');
            $table->integer('children');
            $table->string('bed');
            $table->json('services')->nullable(); // JSON for room services
            $table->integer('available_rooms')->default(0);
            $table->string('image')->nullable(); // Main image
            $table->json('images')->nullable(); // JSON for multiple images
            $table->timestamps();
            $table->softDeletes(); // Adds deleted_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
