<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Internship;
use App\Models\Criteria;
use App\Models\UserCriteriaWeight;
use App\Models\Category;
use App\Models\MooraSession;
use App\Models\InternshipEvaluation;
use App\Services\MooraService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $mooraService = new MooraService();
        $allCriteria = Criteria::all()->keyBy('id');

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
                'created_at' => '2026-04-01 08:30:00',
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
                    [ // S1: 2 Perusahaan, 4 Kriteria
                        'created_at' => '2026-06-05 10:00:00', 
                        'weights' => [1 => 30, 2 => 20, 3 => 30, 5 => 20], 
                        'evaluations' => [
                            ['name' => 'PT Excelitas Technologies Batam', 'scores' => [1 => 5, 2 => 3, 3 => 1, 5 => 4]], 
                            ['name' => 'PT Maju Terus Budi', 'scores' => [1 => 2, 2 => 5, 3 => 4, 5 => 3]]
                        ]
                    ],
                    [ // S2: 4 Perusahaan, 6 Kriteria
                        'created_at' => '2026-06-05 14:30:00', 
                        'weights' => [1 => 20, 3 => 20, 5 => 20, 8 => 15, 9 => 15, 10 => 10], 
                        'evaluations' => [
                            ['name' => 'PT. Global Tiket Network (Tiket.com)', 'scores' => [1 => 4, 3 => 4, 5 => 3, 8 => 4, 9 => 4, 10 => 3]], 
                            ['name' => 'PT. Packet Systems Indonesia', 'scores' => [1 => 3, 3 => 3, 5 => 4, 8 => 5, 9 => 4, 10 => 4]], 
                            ['name' => 'OpenWay', 'scores' => [1 => 5, 3 => 2, 5 => 5, 8 => 5, 9 => 3, 10 => 2]],
                            ['name' => 'CV Karya Bersama Budi', 'scores' => [1 => 1, 3 => 5, 5 => 2, 8 => 2, 9 => 5, 10 => 5]]
                        ]
                    ],
                    [ // S3: 3 Perusahaan, 3 Kriteria
                        'created_at' => '2026-06-05 09:00:00', 
                        'weights' => [1 => 40, 5 => 40, 6 => 20], 
                        'evaluations' => [
                            ['name' => 'Qwiik', 'scores' => [1 => 4, 5 => 4, 6 => 3]], 
                            ['name' => 'PT Properti Solusi Manajemen (Pinhome)', 'scores' => [1 => 3, 5 => 3, 6 => 5]],
                            ['name' => 'PT. Akasha Wira International, Tbk.', 'scores' => [1 => 5, 5 => 4, 6 => 4]]
                        ]
                    ],
                    [ // S4: 5 Perusahaan, 5 Kriteria
                        'created_at' => '2026-06-06 11:00:00', 
                        'weights' => [1 => 20, 2 => 20, 3 => 20, 4 => 20, 5 => 20], 
                        'evaluations' => [
                            ['name' => 'PT Excelitas Technologies Batam', 'scores' => [1 => 5, 2 => 2, 3 => 1, 4 => 4, 5 => 4]], 
                            ['name' => 'OpenWay', 'scores' => [1 => 4, 2 => 3, 3 => 3, 4 => 5, 5 => 5]],
                            ['name' => 'Qwiik', 'scores' => [1 => 3, 2 => 4, 3 => 4, 4 => 3, 5 => 3]],
                            ['name' => 'PT Maju Terus Budi', 'scores' => [1 => 2, 2 => 5, 3 => 5, 4 => 2, 5 => 2]],
                            ['name' => 'CV Karya Bersama Budi', 'scores' => [1 => 1, 2 => 1, 3 => 5, 4 => 5, 5 => 5]]
                        ]
                    ],
                    [ // S5: 2 Perusahaan, 3 Kriteria
                        'created_at' => '2026-06-06 16:20:00', 
                        'weights' => [8 => 40, 9 => 30, 10 => 30], 
                        'evaluations' => [
                            ['name' => 'PT. Akasha Wira International, Tbk.', 'scores' => [8 => 5, 9 => 5, 10 => 2]], 
                            ['name' => 'PT. Global Tiket Network (Tiket.com)', 'scores' => [8 => 4, 9 => 4, 10 => 3]]
                        ]
                    ]
                ]
            ],
            // ================== USER 2: SITI ==================
            [
                'name' => 'Siti',
                'email' => 'siti@example.com',
                'created_at' => '2026-04-02 09:15:00',
                'personal_internships' => [
                    'PT Excelitas Technologies Batam',
                    'PT Properti Solusi Manajemen (Pinhome)',
                    'PT. Global Tiket Network (Tiket.com)',
                    'UD Sejahtera Siti',
                    'PT Teknologi Siti'
                ],
                'active_criteria' => [2 => 25, 4 => 25, 6 => 30, 8 => 20], 
                'sessions' => [
                    [ // S1: 2 Perusahaan, 4 Kriteria
                        'created_at' => '2026-06-04 11:45:00', 
                        'weights' => [1 => 25, 3 => 25, 5 => 25, 7 => 25], 
                        'evaluations' => [
                            ['name' => 'PT Excelitas Technologies Batam', 'scores' => [1 => 4, 3 => 3, 5 => 5, 7 => 4]], 
                            ['name' => 'UD Sejahtera Siti', 'scores' => [1 => 5, 3 => 4, 5 => 4, 7 => 3]]
                        ]
                    ],
                    [ // S2: 3 Perusahaan, 5 Kriteria
                        'created_at' => '2026-06-04 14:00:00', 
                        'weights' => [2 => 20, 4 => 20, 6 => 20, 8 => 20, 10 => 20], 
                        'evaluations' => [
                            ['name' => 'PT Properti Solusi Manajemen (Pinhome)', 'scores' => [2 => 2, 4 => 5, 6 => 4, 8 => 4, 10 => 3]], 
                            ['name' => 'PT Teknologi Siti', 'scores' => [2 => 4, 4 => 3, 6 => 5, 8 => 3, 10 => 4]],
                            ['name' => 'PT. Global Tiket Network (Tiket.com)', 'scores' => [2 => 3, 4 => 4, 6 => 3, 8 => 5, 10 => 2]]
                        ]
                    ],
                    [ // S3: 4 Perusahaan, 3 Kriteria
                        'created_at' => '2026-06-05 10:30:00', 
                        'weights' => [1 => 40, 5 => 30, 9 => 30], 
                        'evaluations' => [
                            ['name' => 'PT Excelitas Technologies Batam', 'scores' => [1 => 4, 5 => 5, 9 => 4]], 
                            ['name' => 'PT Properti Solusi Manajemen (Pinhome)', 'scores' => [1 => 3, 5 => 4, 9 => 5]],
                            ['name' => 'UD Sejahtera Siti', 'scores' => [1 => 5, 5 => 4, 9 => 5]],
                            ['name' => 'PT Teknologi Siti', 'scores' => [1 => 2, 5 => 3, 9 => 3]]
                        ]
                    ],
                    [ // S4: 2 Perusahaan, 6 Kriteria
                        'created_at' => '2026-06-06 09:15:00', 
                        'weights' => [2 => 15, 3 => 15, 4 => 20, 6 => 20, 8 => 15, 10 => 15], 
                        'evaluations' => [
                            ['name' => 'PT. Global Tiket Network (Tiket.com)', 'scores' => [2 => 3, 3 => 2, 4 => 5, 6 => 4, 8 => 5, 10 => 3]], 
                            ['name' => 'PT Teknologi Siti', 'scores' => [2 => 4, 3 => 5, 4 => 4, 6 => 5, 8 => 3, 10 => 4]]
                        ]
                    ],
                    [ // S5: 5 Perusahaan, 4 Kriteria
                        'created_at' => '2026-06-07 13:45:00', 
                        'weights' => [1 => 25, 5 => 25, 7 => 25, 9 => 25], 
                        'evaluations' => [
                            ['name' => 'PT Excelitas Technologies Batam', 'scores' => [1 => 4, 5 => 5, 7 => 4, 9 => 4]], 
                            ['name' => 'PT Properti Solusi Manajemen (Pinhome)', 'scores' => [1 => 3, 5 => 4, 7 => 5, 9 => 5]],
                            ['name' => 'PT. Global Tiket Network (Tiket.com)', 'scores' => [1 => 5, 5 => 5, 7 => 3, 9 => 3]],
                            ['name' => 'UD Sejahtera Siti', 'scores' => [1 => 5, 5 => 4, 7 => 2, 9 => 4]],
                            ['name' => 'PT Teknologi Siti', 'scores' => [1 => 2, 5 => 3, 7 => 5, 9 => 3]]
                        ]
                    ]
                ]
            ],
            // ================== USER 3: ANDI ==================
            [
                'name' => 'Andi',
                'email' => 'andi@example.com',
                'created_at' => '2026-05-03 10:00:00',
                'personal_internships' => [
                    'PT. Packet Systems Indonesia',
                    'OpenWay',
                    'Qwiik',
                    'PT Andi Inovasi',
                    'Startup Andi Maju'
                ],
                'active_criteria' => [1 => 50, 5 => 30, 10 => 20], 
                'sessions' => [
                    [ // S1: 3 Perusahaan, 3 Kriteria
                        'created_at' => '2026-06-04 09:00:00', 
                        'weights' => [1 => 40, 5 => 40, 10 => 20], 
                        'evaluations' => [
                            ['name' => 'PT. Packet Systems Indonesia', 'scores' => [1 => 4, 5 => 5, 10 => 3]], 
                            ['name' => 'PT Andi Inovasi', 'scores' => [1 => 5, 5 => 4, 10 => 4]],
                            ['name' => 'Startup Andi Maju', 'scores' => [1 => 3, 5 => 5, 10 => 2]]
                        ]
                    ],
                    [ // S2: 2 Perusahaan, 5 Kriteria
                        'created_at' => '2026-06-05 11:30:00', 
                        'weights' => [2 => 20, 3 => 30, 4 => 20, 6 => 15, 8 => 15], 
                        'evaluations' => [
                            ['name' => 'OpenWay', 'scores' => [2 => 2, 3 => 4, 4 => 5, 6 => 4, 8 => 5]], 
                            ['name' => 'Qwiik', 'scores' => [2 => 4, 3 => 3, 4 => 4, 6 => 3, 8 => 4]]
                        ]
                    ],
                    [ // S3: 4 Perusahaan, 4 Kriteria
                        'created_at' => '2026-06-06 14:00:00', 
                        'weights' => [1 => 25, 5 => 25, 7 => 25, 9 => 25], 
                        'evaluations' => [
                            ['name' => 'PT. Packet Systems Indonesia', 'scores' => [1 => 5, 5 => 5, 7 => 4, 9 => 4]], 
                            ['name' => 'OpenWay', 'scores' => [1 => 4, 5 => 5, 7 => 5, 9 => 3]],
                            ['name' => 'PT Andi Inovasi', 'scores' => [1 => 5, 5 => 4, 7 => 5, 9 => 5]],
                            ['name' => 'Startup Andi Maju', 'scores' => [1 => 3, 5 => 5, 7 => 2, 9 => 4]]
                        ]
                    ],
                    [ // S4: 3 Perusahaan, 6 Kriteria
                        'created_at' => '2026-06-07 10:45:00', 
                        'weights' => [1 => 15, 2 => 15, 3 => 20, 5 => 20, 10 => 15, 9 => 15], 
                        'evaluations' => [
                            ['name' => 'PT Andi Inovasi', 'scores' => [1 => 5, 2 => 3, 3 => 4, 5 => 4, 10 => 4, 9 => 5]], 
                            ['name' => 'Qwiik', 'scores' => [1 => 4, 2 => 4, 3 => 3, 5 => 4, 10 => 5, 9 => 5]],
                            ['name' => 'Startup Andi Maju', 'scores' => [1 => 2, 2 => 2, 3 => 5, 5 => 5, 10 => 2, 9 => 3]]
                        ]
                    ],
                    [ // S5: 5 Perusahaan, 3 Kriteria
                        'created_at' => '2026-06-08 15:30:00', 
                        'weights' => [1 => 33, 5 => 33, 9 => 34], 
                        'evaluations' => [
                            ['name' => 'PT. Packet Systems Indonesia', 'scores' => [1 => 5, 5 => 5, 9 => 4]], 
                            ['name' => 'OpenWay', 'scores' => [1 => 4, 5 => 5, 9 => 3]],
                            ['name' => 'Qwiik', 'scores' => [1 => 4, 5 => 4, 9 => 5]],
                            ['name' => 'PT Andi Inovasi', 'scores' => [1 => 5, 5 => 4, 9 => 5]],
                            ['name' => 'Startup Andi Maju', 'scores' => [1 => 3, 5 => 5, 9 => 4]]
                        ]
                    ]
                ]
            ],
            // ================== USER 4: DEWI ==================
            [
                'name' => 'Dewi',
                'email' => 'dewi@example.com',
                'created_at' => '2026-05-04 11:30:00',
                'personal_internships' => [
                    'PT. Akasha Wira International, Tbk.',
                    'Carousell Group',
                    'PT.Grahaprima SuksesMandiri',
                    'Butik Dewi Sejahtera',
                    'Dewi IT Consultant'
                ],
                'active_criteria' => [3 => 40, 6 => 30, 7 => 30], 
                'sessions' => [
                    [ // S1: 3 Perusahaan, 3 Kriteria
                        'created_at' => '2026-06-06 13:15:00', 
                        'weights' => [3 => 30, 6 => 40, 7 => 30], 
                        'evaluations' => [
                            ['name' => 'PT. Akasha Wira International, Tbk.', 'scores' => [3 => 2, 6 => 4, 7 => 5]], 
                            ['name' => 'Carousell Group', 'scores' => [3 => 4, 6 => 5, 7 => 4]],
                            ['name' => 'Butik Dewi Sejahtera', 'scores' => [3 => 5, 6 => 2, 7 => 2]]
                        ]
                    ],
                    [ // S2: 2 Perusahaan, 5 Kriteria
                        'created_at' => '2026-06-08 09:30:00', 
                        'weights' => [1 => 20, 2 => 20, 3 => 20, 4 => 20, 5 => 20], 
                        'evaluations' => [
                            ['name' => 'PT.Grahaprima SuksesMandiri', 'scores' => [1 => 3, 2 => 5, 3 => 4, 4 => 4, 5 => 3]], 
                            ['name' => 'Dewi IT Consultant', 'scores' => [1 => 5, 2 => 2, 3 => 1, 4 => 5, 5 => 5]]
                        ]
                    ],
                    [ // S3: 5 Perusahaan, 4 Kriteria
                        'created_at' => '2026-06-09 15:00:00', 
                        'weights' => [3 => 25, 6 => 25, 8 => 25, 9 => 25], 
                        'evaluations' => [
                            ['name' => 'PT. Akasha Wira International, Tbk.', 'scores' => [3 => 2, 6 => 4, 8 => 5, 9 => 4]], 
                            ['name' => 'Carousell Group', 'scores' => [3 => 4, 6 => 5, 8 => 4, 9 => 5]],
                            ['name' => 'PT.Grahaprima SuksesMandiri', 'scores' => [3 => 4, 6 => 3, 8 => 4, 9 => 5]],
                            ['name' => 'Butik Dewi Sejahtera', 'scores' => [3 => 5, 6 => 2, 8 => 2, 9 => 5]],
                            ['name' => 'Dewi IT Consultant', 'scores' => [3 => 1, 6 => 5, 8 => 3, 9 => 4]]
                        ]
                    ],
                    [ // S4: 4 Perusahaan, 6 Kriteria
                        'created_at' => '2026-06-09 11:20:00', 
                        'weights' => [1 => 10, 3 => 20, 5 => 20, 7 => 20, 8 => 15, 10 => 15], 
                        'evaluations' => [
                            ['name' => 'PT. Akasha Wira International, Tbk.', 'scores' => [1 => 5, 3 => 2, 5 => 4, 7 => 5, 8 => 5, 10 => 3]], 
                            ['name' => 'Carousell Group', 'scores' => [1 => 4, 3 => 4, 5 => 4, 7 => 4, 8 => 4, 10 => 3]],
                            ['name' => 'Butik Dewi Sejahtera', 'scores' => [1 => 3, 3 => 5, 5 => 5, 7 => 2, 8 => 2, 10 => 4]],
                            ['name' => 'Dewi IT Consultant', 'scores' => [1 => 5, 3 => 1, 5 => 5, 7 => 2, 8 => 3, 10 => 2]]
                        ]
                    ],
                    [ // S5: 2 Perusahaan, 3 Kriteria
                        'created_at' => '2026-06-10 14:45:00', 
                        'weights' => [6 => 40, 7 => 30, 9 => 30], 
                        'evaluations' => [
                            ['name' => 'Carousell Group', 'scores' => [6 => 5, 7 => 4, 9 => 5]], 
                            ['name' => 'Butik Dewi Sejahtera', 'scores' => [6 => 2, 7 => 2, 9 => 5]]
                        ]
                    ]
                ]
            ],
            // ================== USER 5: FAJAR ==================
            [
                'name' => 'Fajar',
                'email' => 'fajar@example.com',
                'created_at' => '2026-05-05 14:00:00',
                'personal_internships' => [
                    'Gate.io',
                    'Grow Grid',
                    'PT. Global Tiket Network (Tiket.com)',
                    'Fajar Crypto Lab',
                    'Bengkel Fajar'
                ],
                'active_criteria' => [2 => 30, 8 => 40, 9 => 30], 
                'sessions' => [
                    [ // S1: 3 Perusahaan, 3 Kriteria
                        'created_at' => '2026-06-07 15:45:00', 
                        'weights' => [2 => 20, 8 => 50, 9 => 30], 
                        'evaluations' => [
                            ['name' => 'Gate.io', 'scores' => [2 => 4, 8 => 5, 9 => 4]], 
                            ['name' => 'Grow Grid', 'scores' => [2 => 3, 8 => 4, 9 => 5]],
                            ['name' => 'Fajar Crypto Lab', 'scores' => [2 => 1, 8 => 3, 9 => 5]]
                        ]
                    ],
                    [ // S2: 2 Perusahaan, 4 Kriteria
                        'created_at' => '2026-06-08 10:00:00', 
                        'weights' => [1 => 30, 5 => 30, 8 => 20, 10 => 20], 
                        'evaluations' => [
                            ['name' => 'PT. Global Tiket Network (Tiket.com)', 'scores' => [1 => 5, 5 => 4, 8 => 5, 10 => 2]], 
                            ['name' => 'Bengkel Fajar', 'scores' => [1 => 2, 5 => 3, 8 => 2, 10 => 4]]
                        ]
                    ],
                    [ // S3: 4 Perusahaan, 5 Kriteria
                        'created_at' => '2026-06-08 13:30:00', 
                        'weights' => [2 => 20, 3 => 20, 4 => 20, 8 => 20, 9 => 20], 
                        'evaluations' => [
                            ['name' => 'Gate.io', 'scores' => [2 => 4, 3 => 4, 4 => 5, 8 => 5, 9 => 4]], 
                            ['name' => 'Grow Grid', 'scores' => [2 => 3, 3 => 3, 4 => 4, 8 => 4, 9 => 5]],
                            ['name' => 'PT. Global Tiket Network (Tiket.com)', 'scores' => [2 => 3, 3 => 2, 4 => 4, 8 => 5, 9 => 3]],
                            ['name' => 'Fajar Crypto Lab', 'scores' => [2 => 1, 3 => 5, 4 => 3, 8 => 3, 9 => 5]]
                        ]
                    ],
                    [ // S4: 2 Perusahaan, 6 Kriteria
                        'created_at' => '2026-06-10 09:15:00', 
                        'weights' => [1 => 15, 2 => 15, 5 => 20, 7 => 20, 8 => 15, 9 => 15], 
                        'evaluations' => [
                            ['name' => 'Fajar Crypto Lab', 'scores' => [1 => 4, 2 => 1, 5 => 5, 7 => 5, 8 => 3, 9 => 5]], 
                            ['name' => 'PT. Global Tiket Network (Tiket.com)', 'scores' => [1 => 5, 2 => 3, 5 => 4, 7 => 4, 8 => 5, 9 => 3]]
                        ]
                    ],
                    [ // S5: 5 Perusahaan, 3 Kriteria
                        'created_at' => '2026-06-10 11:00:00', 
                        'weights' => [2 => 30, 8 => 40, 10 => 30], 
                        'evaluations' => [
                            ['name' => 'Gate.io', 'scores' => [2 => 4, 8 => 5, 10 => 2]], 
                            ['name' => 'Grow Grid', 'scores' => [2 => 3, 8 => 4, 10 => 3]],
                            ['name' => 'PT. Global Tiket Network (Tiket.com)', 'scores' => [2 => 3, 8 => 5, 10 => 2]],
                            ['name' => 'Fajar Crypto Lab', 'scores' => [2 => 1, 8 => 3, 10 => 3]],
                            ['name' => 'Bengkel Fajar', 'scores' => [2 => 5, 8 => 2, 10 => 4]]
                        ]
                    ]
                ]
            ]
        ];

        // 4. Eksekusi Pembuatan Data secara Sekuensial
        foreach ($usersConfig as $config) {
            $userTimestamp = Carbon::parse($config['created_at']);
            $user = User::updateOrCreate(
                ['email' => $config['email']],
                [
                    'name' => $config['name'], 
                    'password' => Hash::make('password123'), 
                    'role' => 'user',
                    'created_at' => $userTimestamp,
                    'updated_at' => $userTimestamp
                ]
            );

            // Hapus sesi lama agar sinkron dengan seeder
            MooraSession::where('user_id', $user->id)->delete(); 

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
                // Prepare data for MOORA calculation
                $alternatives = [];
                foreach ($sessionData['evaluations'] as $index => $eval) {
                    $alternatives[] = [
                        'id' => $index,
                        'name' => $eval['name'],
                        'scores' => $eval['scores']
                    ];
                }

                $criteriaForMoora = [];
                foreach ($sessionData['weights'] as $critId => $weight) {
                    $criteriaForMoora[] = [
                        'id' => $critId,
                        'weight' => $weight,
                        'type' => $allCriteria[$critId]->type
                    ];
                }

                $results = $mooraService->calculate($alternatives, $criteriaForMoora);
                $winner = $results[0];

                $sessionTimestamp = Carbon::parse($sessionData['created_at']);
                $session = MooraSession::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'created_at' => $sessionTimestamp
                    ],
                    [
                        'winner_name' => $winner['name'],
                        'max_optimization_value' => round($winner['optimization_value'], 2),
                        'criteria_used' => $sessionData['weights'],
                        'updated_at' => $sessionTimestamp
                    ]
                );

                foreach ($sessionData['evaluations'] as $evaluation) {
                    $internship = Internship::where('name', $evaluation['name'])
                        ->where('user_id', $user->id)
                        ->first();

                    if ($internship) {
                        foreach ($evaluation['scores'] as $critId => $score) {
                            InternshipEvaluation::updateOrCreate(
                                [
                                    'user_id' => $user->id,
                                    'internship_id' => $internship->id,
                                    'criteria_id' => $critId,
                                ],
                                [
                                    'moora_session_id' => $session->id,
                                    'score' => $score,
                                ]
                            );
                        }
                    }
                }
            }
        }
    }
}
