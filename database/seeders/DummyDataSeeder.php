<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Internship;
use App\Models\Criteria;
use App\Models\UserCriteriaWeight;
use App\Models\Category;
use App\Models\MooraSession;
use App\Models\InternshipEvaluation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Services\MooraService;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories
        $catNames = ['Teknologi Informasi', 'E-Commerce', 'Layanan Keuangan & Perbankan', 'Energi & Sumber Daya Alam', 'Media & Kreatif', 'Kesehatan', 'Pendidikan', 'Telekomunikasi', 'Konsumsi & Ritel', 'Logistik & Transportasi'];
        $categories = [];
        foreach ($catNames as $name) {
            $categories[$name] = Category::updateOrCreate(['name' => $name])->id;
        }

        // 2. Global Internships (20)
        $globalInternshipsData = [
            ['name' => 'PT Tokopedia', 'category' => 'E-Commerce'], ['name' => 'PT Gojek Indonesia', 'category' => 'Teknologi Informasi'],
            ['name' => 'PT Shopee International', 'category' => 'E-Commerce'], ['name' => 'PT Bukalapak.com', 'category' => 'E-Commerce'],
            ['name' => 'PT Traveloka', 'category' => 'Teknologi Informasi'], ['name' => 'PT Bank Mandiri', 'category' => 'Layanan Keuangan & Perbankan'],
            ['name' => 'PT Telkom Indonesia', 'category' => 'Telekomunikasi'], ['name' => 'PT Pertamina', 'category' => 'Energi & Sumber Daya Alam'],
            ['name' => 'PT Astra International', 'category' => 'Logistik & Transportasi'], ['name' => 'PT Grab Indonesia', 'category' => 'Teknologi Informasi'],
            ['name' => 'PT Dana Indonesia', 'category' => 'Layanan Keuangan & Perbankan'], ['name' => 'PT OVO', 'category' => 'Layanan Keuangan & Perbankan'],
            ['name' => 'PT BCA', 'category' => 'Layanan Keuangan & Perbankan'], ['name' => 'PT Indofood', 'category' => 'Konsumsi & Ritel'],
            ['name' => 'PT Unilever', 'category' => 'Konsumsi & Ritel'], ['name' => 'PT Ruangguru', 'category' => 'Pendidikan'],
            ['name' => 'PT Zenius', 'category' => 'Pendidikan'], ['name' => 'PT Halodoc', 'category' => 'Kesehatan'],
            ['name' => 'PT Alodokter', 'category' => 'Kesehatan'], ['name' => 'PT PLN', 'category' => 'Energi & Sumber Daya Alam'],
        ];

        foreach ($globalInternshipsData as $data) {
            Internship::updateOrCreate(['name' => $data['name']], ['category_id' => $categories[$data['category']], 'user_id' => null]);
        }

        // 3. 20 Users
        for ($i = 1; $i <= 20; $i++) {
            $name = "Mahasiswa " . $i;
            $email = str_replace(' ', '', strtolower($name)) . "@example.com";
            $user = User::updateOrCreate(['email' => $email], [
                'name' => $name, 'password' => Hash::make('password123'), 'role' => 'user'
            ]);

            // Manual Contributions (2-3)
            $myInternships = [];
            for ($j = 1; $j <= rand(2, 3); $j++) {
                $myInternships[] = Internship::create([
                    'name' => "PT Kontribusi {$name} {$j}",
                    'category_id' => $categories[array_rand($categories)],
                    'user_id' => $user->id
                ]);
            }
            $allInternships = Internship::whereNull('user_id')->get()->concat($myInternships);
            $criterias = Criteria::all();

            // Set Weights (100% total)
            $weights = [];
            $totalWeight = 0;
            foreach ($criterias as $index => $c) {
                if ($index === count($criterias) - 1) {
                    $w = 100 - $totalWeight;
                } else {
                    $w = rand(5, 15);
                    $totalWeight += $w;
                }
                UserCriteriaWeight::updateOrCreate(['user_id' => $user->id, 'criteria_id' => $c->id], ['weight' => $w]);
                $weights[$c->id] = $w;
            }

            // 5 MOORA Sessions
            for ($s = 0; $s < 5; $s++) {
                $chosenInternships = $allInternships->random(rand(2, 5));
                $chosenCriterias = $criterias->random(rand(3, count($criterias)));
                
                $session = MooraSession::create([
                    'user_id' => $user->id,
                    'winner_name' => $chosenInternships->first()->name,
                    'max_optimization_value' => rand(60, 90) / 100,
                    'criteria_used' => $chosenCriterias->pluck('id')->toArray(),
                    'created_at' => now()->subDays(rand(1, 30))
                ]);

                foreach ($chosenInternships as $int) {
                    foreach ($chosenCriterias as $crit) {
                        $existing = InternshipEvaluation::where('user_id', $user->id)
                            ->where('internship_id', $int->id)
                            ->where('criteria_id', $crit->id)
                            ->first();

                        if (!$existing) {
                            InternshipEvaluation::create([
                                'user_id' => $user->id,
                                'internship_id' => $int->id,
                                'criteria_id' => $crit->id,
                                'moora_session_id' => $session->id,
                                'score' => rand(1, 5)
                            ]);
                        }
                    }
                }
            }
        }
    }
}
