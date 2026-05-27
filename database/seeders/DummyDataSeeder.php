<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Internship;
use App\Models\InternshipEvaluation;
use App\Models\Criteria;
use App\Models\UserCriteriaWeight;
use App\Models\Category;
use App\Models\MooraSession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories (10 Categories)
        $catNames = [
            'Fintech Startup', 'E-Commerce', 'BUMN / Government', 'Software House', 
            'Creative Agency', 'Healthtech', 'Edutech', 'Energy & Mining', 
            'Telecommunication', 'Retail & FMCG'
        ];
        $categories = [];
        foreach ($catNames as $name) {
            $categories[$name] = Category::updateOrCreate(['name' => $name])->id;
        }

        // 2. Real Personas (20 Users) with wave-like registration dates
        $personas = [
            ['name' => 'Rizky Amalia', 'email' => 'rizky@example.com', 'days' => 170],
            ['name' => 'Siti Aminah', 'email' => 'siti@example.com', 'days' => 165],
            ['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'days' => 162],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@example.com', 'days' => 140],
            ['name' => 'Eko Prasetyo', 'email' => 'eko@example.com', 'days' => 135],
            ['name' => 'Fitriani', 'email' => 'fitri@example.com', 'days' => 110],
            ['name' => 'Guntur Ginting', 'email' => 'guntur@example.com', 'days' => 105],
            ['name' => 'Hani Handayani', 'email' => 'hani@example.com', 'days' => 90],
            ['name' => 'Irfan Bachdim', 'email' => 'irfan@example.com', 'days' => 88],
            ['name' => 'Joko Widodo', 'email' => 'joko@example.com', 'days' => 85],
            ['name' => 'Kiki Fatmala', 'email' => 'kiki@example.com', 'days' => 70],
            ['name' => 'Lutfi Agizal', 'email' => 'lutfi@example.com', 'days' => 65],
            ['name' => 'Mamat Alkatiri', 'email' => 'mamat@example.com', 'days' => 50],
            ['name' => 'Neni', 'email' => 'neni@example.com', 'days' => 45],
            ['name' => 'Agus', 'email' => 'agus@example.com', 'days' => 42],
            ['name' => 'Maya', 'email' => 'maya@example.com', 'days' => 30],
            ['name' => 'Andi Saputra', 'email' => 'andi.saputra@example.com', 'days' => 25],
            ['name' => 'Bambang Hermawan', 'email' => 'bams.hermawan@example.com', 'days' => 20],
            ['name' => 'Citra Lestari', 'email' => 'citra.lestari@example.com', 'days' => 10],
            ['name' => 'Dedi Kusnadi', 'email' => 'dedi.kusnadi@example.com', 'days' => 5],
        ];

        foreach ($personas as $p) {
            User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'created_at' => Carbon::now()->subDays($p['days']),
                ]
            );
        }

        // 3. Internships (25 Internships)
        $internshipsData = [
            ['name' => 'Tokopedia', 'city' => 'Jakarta', 'category' => 'E-Commerce'],
            ['name' => 'Gojek', 'city' => 'Jakarta', 'category' => 'Fintech Startup'],
            ['name' => 'Shopee', 'city' => 'Jakarta', 'category' => 'E-Commerce'],
            ['name' => 'Bukalapak', 'city' => 'Jakarta', 'category' => 'E-Commerce'],
            ['name' => 'Traveloka', 'city' => 'Jakarta', 'category' => 'Fintech Startup'],
            ['name' => 'Bank Mandiri', 'city' => 'Jakarta', 'category' => 'BUMN / Government'],
            ['name' => 'Telkom Indonesia', 'city' => 'Bandung', 'category' => 'Telecommunication'],
            ['name' => 'Pertamina', 'city' => 'Jakarta', 'category' => 'Energy & Mining'],
            ['name' => 'Astra International', 'city' => 'Jakarta', 'category' => 'BUMN / Government'],
            ['name' => 'Traveloka Paylaters', 'city' => 'Jakarta', 'category' => 'Fintech Startup'],
            ['name' => 'Dana', 'city' => 'Jakarta', 'category' => 'Fintech Startup'],
            ['name' => 'OVO', 'city' => 'Jakarta', 'category' => 'Fintech Startup'],
            ['name' => 'BCA', 'city' => 'Jakarta', 'category' => 'BUMN / Government'],
            ['name' => 'Indomie (ICBP)', 'city' => 'Jakarta', 'category' => 'Retail & FMCG'],
            ['name' => 'Unilever', 'city' => 'Tangerang', 'category' => 'Retail & FMCG'],
            ['name' => 'Ruangguru', 'city' => 'Jakarta', 'category' => 'Edutech'],
            ['name' => 'Zenius', 'city' => 'Jakarta', 'category' => 'Edutech'],
            ['name' => 'Halodoc', 'city' => 'Jakarta', 'category' => 'Healthtech'],
            ['name' => 'Alodokter', 'city' => 'Jakarta', 'category' => 'Healthtech'],
            ['name' => 'PLN', 'city' => 'Jakarta', 'category' => 'BUMN / Government'],
            ['name' => 'Bukit Asam', 'city' => 'Palembang', 'category' => 'Energy & Mining'],
            ['name' => 'Adaro Energy', 'city' => 'Jakarta', 'category' => 'Energy & Mining'],
            ['name' => 'Kumparan', 'city' => 'Jakarta', 'category' => 'Creative Agency'],
            ['name' => 'IDN Times', 'city' => 'Jakarta', 'category' => 'Creative Agency'],
            ['name' => 'Detikcom', 'city' => 'Jakarta', 'category' => 'Creative Agency'],
        ];

        foreach ($internshipsData as $data) {
            Internship::updateOrCreate(
                ['name' => $data['name']],
                [
                    'city' => $data['city'],
                    'category_id' => $categories[$data['category']],
                    'description' => 'Dummy description for ' . $data['name']
                ]
            );
        }

        // 4. Randomized Activity for Dotted Line Charts (5-8 sessions per user)
        $users = User::where('role', 'user')->get();
        $internships = Internship::all();
        $criterias = Criteria::all();

        foreach ($users as $user) {
            // Set user weights
            foreach ($criterias as $c) {
                UserCriteriaWeight::updateOrCreate(
                    ['user_id' => $user->id, 'criteria_id' => $c->id],
                    ['weight' => rand(1, 5)]
                );
            }

            // Perform 5-8 MOORA sessions per user spread across last 30 days
            $sessionCount = rand(5, 8);
            for ($s = 0; $s < $sessionCount; $s++) {
                $sessionDate = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
                
                $session = MooraSession::create([
                    'user_id' => $user->id,
                    'winner_name' => $internships->random()->name,
                    'max_optimization_value' => rand(50, 95) / 100,
                    'criteria_used' => $criterias->pluck('id')->toArray(),
                    'created_at' => $sessionDate,
                    'updated_at' => $sessionDate
                ]);

                // Evaluations for this session
                $internshipSample = $internships->random(rand(4, 6));
                foreach ($internshipSample as $intern) {
                    foreach ($criterias as $crit) {
                        // Use raw insert to bypass model event or just unique check if needed
                        // But since session_id is new for every session, it should be fine 
                        // as long as user-intern-crit is unique per session if that was the constraint.
                        // Wait, the unique index is eval_user_intern_crit_unique.
                        // I must DELETE old evaluations for this user-intern-crit combo to simulate the 
                        // "most recent state" or just avoid the duplicate key error.
                        
                        DB::table('internship_evaluations')
                            ->where('user_id', $user->id)
                            ->where('internship_id', $intern->id)
                            ->where('criteria_id', $crit->id)
                            ->delete();

                        DB::table('internship_evaluations')->insert([
                            'user_id' => $user->id,
                            'moora_session_id' => $session->id,
                            'internship_id' => $intern->id,
                            'criteria_id' => $crit->id,
                            'score' => rand(1, 5),
                            'created_at' => $sessionDate,
                            'updated_at' => $sessionDate
                        ]);
                    }
                }
            }
        }
    }
}
