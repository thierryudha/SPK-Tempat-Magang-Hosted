<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internship_evaluations', function (Blueprint $table) {
            $table->foreignId('moora_session_id')->nullable()->after('user_id')->constrained('moora_sessions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('internship_evaluations', function (Blueprint $table) {
            $table->dropForeign(['moora_session_id']);
            $table->dropColumn('moora_session_id');
        });
    }
};
