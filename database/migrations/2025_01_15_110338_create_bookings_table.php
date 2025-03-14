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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Nullable user ID for registered users
            $table->string('customer_name');
            $table->string('customer_email');
            $table->datetime('check_in_datetime'); // Combined check-in date and time
            $table->datetime('check_out_datetime'); // Combined checkout date and time
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['Pending', 'Confirmed', 'Cancelled'])->default('Pending');
            $table->enum('check_in_status', ['Not Checked In', 'Checked In', 'Checked Out'])->default('Not Checked In'); // Added field
            $table->integer('no_of_rooms'); // Number of rooms booked
            $table->integer('adults'); // Number of adults
            $table->integer('children'); // Number of children
            $table->timestamps();
            $table->softDeletes(); // Adds deleted_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
