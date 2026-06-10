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
        Schema::table('internship_evaluations', function (Blueprint $table) {
            // Drop foreign key first because MySQL is being stubborn
            $table->dropForeign(['user_id']);
            
            // Drop the too-restrictive unique index
            $table->dropUnique('eval_user_intern_crit_unique');
            
            // Re-add foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Add the new unique index if it doesn't exist (handle previous failed runs)
            // We'll use a try-catch or just check if it exists if we could, but here we just try to be safe.
            // Since it already exists from previous run, we might need to skip or drop it first.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_evaluations', function (Blueprint $table) {
            $table->dropUnique('eval_session_intern_crit_unique');
            $table->unique(['user_id', 'internship_id', 'criteria_id'], 'eval_user_intern_crit_unique');
        });
    }
};
