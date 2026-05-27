<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moora_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('winner_name')->nullable();
            $table->float('max_optimization_value')->nullable();
            $table->json('criteria_used'); // Store list of criteria IDs used
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moora_sessions');
    }
};
