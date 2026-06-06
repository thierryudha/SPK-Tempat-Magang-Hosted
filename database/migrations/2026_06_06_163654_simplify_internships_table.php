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
        Schema::table('internships', function (Blueprint $table) {
            // Remove redundant fields
            $table->dropColumn(['city', 'description', 'latitude', 'longitude', 'address']);
            
            // Add website_link if it doesn't exist
            if (!Schema::hasColumn('internships', 'website_link')) {
                $table->string('website_link')->nullable()->after('category_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->string('city')->nullable();
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('address')->nullable();
            $table->dropColumn('website_link');
        });
    }
};
