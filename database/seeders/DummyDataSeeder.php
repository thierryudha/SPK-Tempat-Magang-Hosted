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
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori Perusahaan (Manual)
        $categoriesData = [
            'Manufaktur & Elektronik', 'Proptech', 'E-Commerce', 'IT & Networking', 
            'Fintech & Payment', 'Logistik', 'FMCG', 'Web3 & Crypto', 'Agrotech'
        ];
        
        $categories = [];
        foreach ($categoriesData as $name) {
            $categories[$name] = Category::firstOrCreate(['name' => $name])->id;
        }

        // 2. Perusahaan Global (Template untuk ditambahkan ke user)
        $globalTemplates = [
            'PT Excelitas Technologies Batam' => ['category' => 'Manufaktur & Elektronik', 'link' => 'https://id.jobstreet.com/job/92606011'],
            'PT Properti Solusi Manajemen (Pinhome)' => ['category' => 'Proptech', 'link' => 'https://www.linkedin.com/jobs/view/4410496548'],
            'PT. Global Tiket Network (Tiket.com)' => ['category' => 'E-Commerce', 'link' => 'https://www.linkedin.com/jobs/view/4412735989'],
            'PT. Packet Systems Indonesia' => ['category' => 'IT & Networking', 'link' => 'https://www.linkedin.com/jobs/view/4415017769'],
            'OpenWay' => ['category' => 'Fintech & Payment', 'link' => 'https://www.linkedin.com/jobs/view/4415110636'],
            'Qwiik' => ['category' => 'Logistik', 'link' => 'https://www.linkedin.com/jobs/view/4380296806'],
            'PT. Akasha Wira International, Tbk.' => ['category' => 'FMCG', 'link' => 'https://www.linkedin.com/jobs/view/4415113543'],
            'PT.Grahaprima SuksesMandiri' => ['category' => 'Logistik', 'link' => 'https://www.linkedin.com/jobs/view/4416144789'],
            'Carousell Group' => ['category' => 'E-Commerce', 'link' => 'https://www.linkedin.com/jobs/view/4409924033'],
            'Gate.io' => ['category' => 'Web3 & Crypto', 'link' => 'https://www.linkedin.com/jobs/view/4413905954'],
            'Grow Grid' => ['category' => 'Agrotech', 'link' => 'https://www.linkedin.com/jobs/view/4425577622/'],
        ];

        // Buat data global asli (tetap ada di sistem sebagai template umum)
        foreach ($globalTemplates as $name => $data) {
            Internship::firstOrCreate(
                ['name' => $name, 'user_id' => null],
                [
                    'category_id' => $categories[$data['category']],
                    'website_link' => $data['link'],
                ]
            );
        }

        // 3. Konfigurasi Riwayat Sesi Per User
        $usersConfig = [
            // ================== USER 1: BUDI ==================
            [
                'name' => 'Budi',
                'email' => 'budi@example.com',
                'personal_internships' => [
                    'PT Excelitas Technologies Batam',
                    'PT Properti Solusi Manajemen (Pinhome)',
                    'PT. Global Tiket Network (Tiket.com)',
                    'PT. Packet Systems Indonesia',
                    'OpenWay',
                    'Qwiik',
                    'PT. Akasha Wira International, Tbk.',
                    'PT Maju Terus Budi',
                    'CV Karya Bersama Budi'
                ],
                'active_criteria' => [1 => 40, 5 => 40, 9 => 20], 
                'sessions' => [
                    [
                        'winner' => 'PT Excelitas Technologies Batam', 
                        'max_val' => 0.15, 
                        'days_ago' => 25, 
                        'weights' => [1 => 40, 2 => 30, 3 => 30], 
                        'evaluations' => [
                            ['name' => 'PT Excelitas Technologies Batam', 'scores' => [1 => 5, 2 => 1, 3 => 1]], // Win: Ben high, Cost low
                            ['name' => 'PT Properti Solusi Manajemen (Pinhome)', 'scores' => [1 => 3, 2 => 3, 3 => 3]], 
                            ['name' => 'PT Maju Terus Budi', 'scores' => [1 => 2, 2 => 5, 3 => 4]]
                        ]
                    ],
                    [
                        'winner' => 'CV Karya Bersama Budi', 
                        'max_val' => 0.18, 
                        'days_ago' => 20, 
                        'weights' => [2 => 25, 3 => 25, 4 => 25, 5 => 25], 
                        'evaluations' => [
                            ['name' => 'PT. Global Tiket Network (Tiket.com)', 'scores' => [2 => 4, 3 => 4, 4 => 3, 5 => 3]], 
                            ['name' => 'PT. Packet Systems Indonesia', 'scores' => [2 => 3, 3 => 3, 4 => 4, 5 => 4]], 
                            ['name' => 'CV Karya Bersama Budi', 'scores' => [2 => 1, 3 => 1, 4 => 5, 5 => 5]] // Win: Cost very low, Ben very high
                        ]
                    ]
                ]
            ],
            // ================== USER 2: SITI ==================
            [
                'name' => 'Siti',
                'email' => 'siti@example.com',
                'personal_internships' => [
                    'PT Excelitas Technologies Batam',
                    'PT Properti Solusi Manajemen (Pinhome)',
                    'PT. Global Tiket Network (Tiket.com)',
                    'UD Sejahtera Siti',
                    'PT Teknologi Siti'
                ],
                'active_criteria' => [2 => 25, 4 => 25, 6 => 30, 8 => 20], 
                'sessions' => [
                    [
                        'winner' => 'UD Sejahtera Siti', 
                        'max_val' => 0.81, 
                        'days_ago' => 30, 
                        'weights' => [1 => 30, 3 => 40, 5 => 30], 
                        'evaluations' => [
                            ['name' => 'PT Excelitas Technologies Batam', 'scores' => [1 => 4, 3 => 3, 5 => 5]], 
                            ['name' => 'UD Sejahtera Siti', 'scores' => [1 => 5, 3 => 4, 5 => 4]]
                        ]
                    ]
                ]
            ]
        ];

        // 4. Eksekusi Pembuatan Data secara Sekuensial
        foreach ($usersConfig as $config) {
            $user = User::firstOrCreate(
                ['email' => $config['email']],
                ['name' => $config['name'], 'password' => Hash::make('password123'), 'role' => 'user']
            );

            // Buat Perusahaan Pribadi (Termasuk salinan dari global)
            foreach ($config['personal_internships'] as $internName) {
                $template = $globalTemplates[$internName] ?? null;
                Internship::firstOrCreate(
                    ['name' => $internName, 'user_id' => $user->id],
                    [
                        'category_id' => $template ? $categories[$template['category']] : $categories['Umum'] ?? 1,
                        'website_link' => $template['link'] ?? null,
                        'user_id' => $user->id
                    ]
                );
            }

            // Set Preferensi Aktif
            foreach ($config['active_criteria'] as $critId => $weight) {
                UserCriteriaWeight::updateOrCreate(
                    ['user_id' => $user->id, 'criteria_id' => $critId],
                    ['weight' => $weight]
                );
            }

            // Buat Sesi MOORA
            foreach ($config['sessions'] as $sessionData) {
                $session = MooraSession::create([
                    'user_id' => $user->id,
                    'winner_name' => $sessionData['winner'],
                    'max_optimization_value' => $sessionData['max_val'],
                    'criteria_used' => $sessionData['weights'], 
                    'created_at' => Carbon::now()->subDays($sessionData['days_ago'])
                ]);

                foreach ($sessionData['evaluations'] as $evaluation) {
                    $internship = Internship::where('name', $evaluation['name'])
                        ->where('user_id', $user->id)
                        ->first();

                    if ($internship) {
                        foreach ($evaluation['scores'] as $critId => $score) {
                            InternshipEvaluation::create([
                                'user_id' => $user->id,
                                'internship_id' => $internship->id,
                                'criteria_id' => $critId,
                                'moora_session_id' => $session->id,
                                'score' => $score,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
