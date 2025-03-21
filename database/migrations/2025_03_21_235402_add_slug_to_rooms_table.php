<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // ✅ Import DB

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Add 'slug' column without unique constraint first
            $table->string('slug')->nullable()->after('name');
        });

        // ✅ Generate slugs for existing records
        DB::statement('UPDATE rooms SET slug = CONCAT("room-", id)');

        // ✅ Now make the column NOT NULL
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });

        // ✅ Finally, add UNIQUE constraint
        Schema::table('rooms', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropUnique(['slug']); // ✅ Remove UNIQUE constraint
            $table->dropColumn('slug');   // ✅ Drop the column
        });
    }
};
