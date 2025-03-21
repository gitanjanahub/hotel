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
        Schema::table('aboutuses', function (Blueprint $table) {
            $table->text('home_content')->nullable()->after('description');
            $table->string('home_title')->nullable()->after('home_content');
            $table->json('home_images')->nullable()->after('home_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aboutuses', function (Blueprint $table) {
            $table->dropColumn(['home_content', 'home_title', 'home_images']);
        });
    }
};
