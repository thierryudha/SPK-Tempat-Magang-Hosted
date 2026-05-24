<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\CriteriaScale;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criterias = [
            [
                'code' => 'C1',
                'name' => 'Uang Saku',
                'type' => 'benefit',
                'scales' => [
                    ['score' => 1, 'description' => 'Tidak ada uang saku'],
                    ['score' => 2, 'description' => '< Rp 500.000 / bulan'],
                    ['score' => 3, 'description' => 'Rp 500.000 - Rp 1.500.000 / bulan'],
                    ['score' => 4, 'description' => 'Rp 1.500.000 - Rp 3.000.000 / bulan'],
                    ['score' => 5, 'description' => '> Rp 3.000.000 / bulan'],
                ]
            ],
            [
                'code' => 'C2',
                'name' => 'Jam Kerja',
                'type' => 'cost',
                'scales' => [
                    ['score' => 1, 'description' => 'Sangat Fleksibel (< 5 jam/hari)'],
                    ['score' => 2, 'description' => 'Fleksibel (5-7 jam/hari)'],
                    ['score' => 3, 'description' => 'Normal (7-8 jam/hari)'],
                    ['score' => 4, 'description' => 'Padat (8-9 jam/hari)'],
                    ['score' => 5, 'description' => 'Sangat Padat (> 9 jam/hari)'],
                ]
            ],
            [
                'code' => 'C3',
                'name' => 'Jarak dari Kampus',
                'type' => 'cost',
                'scales' => [
                    ['score' => 1, 'description' => 'Sangat Dekat (< 2 km)'],
                    ['score' => 2, 'description' => 'Dekat (2 - 5 km)'],
                    ['score' => 3, 'description' => 'Sedang (5 - 10 km)'],
                    ['score' => 4, 'description' => 'Jauh (10 - 20 km)'],
                    ['score' => 5, 'description' => 'Sangat Jauh (> 20 km)'],
                ]
            ],
            [
                'code' => 'C4',
                'name' => 'Keamanan Lingkungan',
                'type' => 'benefit',
                'scales' => [
                    ['score' => 1, 'description' => 'Sangat Tidak Aman'],
                    ['score' => 2, 'description' => 'Kurang Aman'],
                    ['score' => 3, 'description' => 'Cukup Aman'],
                    ['score' => 4, 'description' => 'Aman'],
                    ['score' => 5, 'description' => 'Sangat Aman'],
                ]
            ],
            [
                'code' => 'C5',
                'name' => 'Relevansi Techstack',
                'type' => 'benefit',
                'scales' => [
                    ['score' => 1, 'description' => 'Tidak Relevan'],
                    ['score' => 2, 'description' => 'Kurang Relevan'],
                    ['score' => 3, 'description' => 'Cukup Relevan'],
                    ['score' => 4, 'description' => 'Relevan'],
                    ['score' => 5, 'description' => 'Sangat Relevan'],
                ]
            ],
            [
                'code' => 'C6',
                'name' => 'Fasilitas Kantor',
                'type' => 'benefit',
                'scales' => [
                    ['score' => 1, 'description' => 'Sangat Terbatas'],
                    ['score' => 2, 'description' => 'Minimalis'],
                    ['score' => 3, 'description' => 'Cukup Memadai'],
                    ['score' => 4, 'description' => 'Lengkap'],
                    ['score' => 5, 'description' => 'Sangat Mewah & Lengkap'],
                ]
            ],
            [
                'code' => 'C7',
                'name' => 'Kesempatan Kerja Tetap',
                'type' => 'benefit',
                'scales' => [
                    ['score' => 1, 'description' => 'Sangat Kecil / Tidak Ada'],
                    ['score' => 2, 'description' => 'Kecil'],
                    ['score' => 3, 'description' => 'Mungkin'],
                    ['score' => 4, 'description' => 'Besar'],
                    ['score' => 5, 'description' => 'Sangat Terbuka Lebar'],
                ]
            ],
            [
                'code' => 'C8',
                'name' => 'Reputasi Perusahaan',
                'type' => 'benefit',
                'scales' => [
                    ['score' => 1, 'description' => 'Baru / Tidak Dikenal'],
                    ['score' => 2, 'description' => 'Lokal / Skala Kecil'],
                    ['score' => 3, 'description' => 'Nasional / Menengah'],
                    ['score' => 4, 'description' => 'Multinasional / Populer'],
                    ['score' => 5, 'description' => 'Top Tier / Global Fortune 500'],
                ]
            ],
            [
                'code' => 'C9',
                'name' => 'Lingkungan Kerja (Culture)',
                'type' => 'benefit',
                'scales' => [
                    ['score' => 1, 'description' => 'Sangat Kompetitif / Kaku'],
                    ['score' => 2, 'description' => 'Konvensional'],
                    ['score' => 3, 'description' => 'Cukup Nyaman'],
                    ['score' => 4, 'description' => 'Suportif & Terbuka'],
                    ['score' => 5, 'description' => 'Sangat Nyaman (Fun & Supportive)'],
                ]
            ],
            [
                'code' => 'C10',
                'name' => 'Beban Tugas',
                'type' => 'cost',
                'scales' => [
                    ['score' => 1, 'description' => 'Sangat Ringan'],
                    ['score' => 2, 'description' => 'Ringan'],
                    ['score' => 3, 'description' => 'Normal / Sesuai'],
                    ['score' => 4, 'description' => 'Berat'],
                    ['score' => 5, 'description' => 'Sangat Berat (Overload)'],
                ]
            ],
        ];

        foreach ($criterias as $c) {
            $criteria = Criteria::create([
                'code' => $c['code'],
                'name' => $c['name'],
                'type' => $c['type'],
            ]);

            foreach ($c['scales'] as $s) {
                CriteriaScale::create([
                    'criteria_id' => $criteria->id,
                    'score' => $s['score'],
                    'description' => $s['description'],
                ]);
            }
        }
    }
}
