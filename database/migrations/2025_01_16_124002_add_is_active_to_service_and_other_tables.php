<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToServiceAndOtherTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('is_active')->after('name'); // Adjust column position as needed
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->boolean('is_active')->after('images'); // Adjust column position as needed
        });

        Schema::table('room_types', function (Blueprint $table) {
            $table->boolean('is_active')->after('description'); // Adjust column position as needed
        });

        Schema::table('room_services', function (Blueprint $table) {
            $table->boolean('is_active')->after('service_id'); // Adjust column position as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('room_types', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('room_services', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
}
