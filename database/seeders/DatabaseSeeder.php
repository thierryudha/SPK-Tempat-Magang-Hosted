<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Internship;
use App\Models\InternshipEvaluation;
use App\Models\Criteria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CriteriaSeeder::class,
            DummyDataSeeder::class,
        ]);

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );
        
        // Ensure Test User has NO evaluations at all
        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser) {
            \App\Models\InternshipEvaluation::where('user_id', $testUser->id)->delete();
            \App\Models\UserCriteriaWeight::where('user_id', $testUser->id)->delete();
        }
    }
}
