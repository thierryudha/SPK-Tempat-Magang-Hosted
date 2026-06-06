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
            // Drop existing global unique constraint on 'name'
            // Depending on the database driver, the index name might vary. 
            // In Laravel, it's typically 'table_column_unique'.
            $table->dropUnique(['name']);
            
            // Add new composite unique constraint: name + user_id
            // This allows different users to have an internship with the same name,
            // but the same user cannot have two internships with the same name.
            $table->unique(['name', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->dropUnique(['name', 'user_id']);
            $table->unique('name');
        });
    }
};
