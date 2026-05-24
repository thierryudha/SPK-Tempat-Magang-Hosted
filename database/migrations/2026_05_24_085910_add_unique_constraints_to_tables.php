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
        // 1. Constraint: One user cannot have duplicate internships with same name + city
        Schema::table('internships', function (Blueprint $table) {
            $table->unique(['user_id', 'name', 'city'], 'user_internship_name_city_unique');
        });

        // 2. Constraint: One internship cannot have duplicate scores for the same criteria
        Schema::table('internship_evaluations', function (Blueprint $table) {
            $table->unique(['internship_id', 'criteria_id'], 'internship_criteria_score_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->dropUnique('user_internship_name_city_unique');
        });

        Schema::table('internship_evaluations', function (Blueprint $table) {
            $table->dropUnique('internship_criteria_score_unique');
        });
    }
};
