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
        // 1. Categories (Industrial Sectors only)
        $catNames = [
            'Teknologi Informasi', 'E-Commerce', 'Layanan Keuangan & Perbankan', 
            'Energi & Sumber Daya Alam', 'Media & Kreatif', 'Kesehatan', 
            'Pendidikan', 'Telekomunikasi', 'Konsumsi & Ritel', 'Logistik & Transportasi'
        ];
        $categories = [];
        foreach ($catNames as $name) {
            $categories[$name] = Category::updateOrCreate(['name' => $name])->id;
        }

        // 2. Real Personas (20 Users)
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

        // 3. Internships (25 Actual Companies)
        $internshipsData = [
            ['name' => 'PT Tokopedia', 'category' => 'E-Commerce', 'link' => 'https://www.tokopedia.com/careers'],
            ['name' => 'PT Gojek Indonesia', 'category' => 'Teknologi Informasi', 'link' => 'https://www.gojek.io/careers'],
            ['name' => 'PT Shopee International', 'category' => 'E-Commerce', 'link' => 'https://careers.shopee.co.id'],
            ['name' => 'PT Bukalapak.com', 'category' => 'E-Commerce', 'link' => 'https://careers.bukalapak.com'],
            ['name' => 'PT Traveloka Indonesia', 'category' => 'Teknologi Informasi', 'link' => 'https://www.traveloka.com/en-id/careers'],
            ['name' => 'PT Bank Mandiri (Persero) Tbk', 'category' => 'Layanan Keuangan & Perbankan', 'link' => 'https://www.bankmandiri.co.id/en/karir'],
            ['name' => 'PT Telkom Indonesia Tbk', 'category' => 'Telekomunikasi', 'link' => 'https://itdr.telkom.co.id/careers'],
            ['name' => 'PT Pertamina (Persero)', 'category' => 'Energi & Sumber Daya Alam', 'link' => 'https://recruitment.pertamina.com'],
            ['name' => 'PT Astra International Tbk', 'category' => 'Logistik & Transportasi', 'link' => 'https://career.astra.co.id'],
            ['name' => 'PT Grab Teknologi Indonesia', 'category' => 'Teknologi Informasi', 'link' => 'https://www.grab.com/id/careers'],
            ['name' => 'PT Dana Indonesia', 'category' => 'Layanan Keuangan & Perbankan', 'link' => 'https://www.dana.id/careers'],
            ['name' => 'PT Visionet Internasional (OVO)', 'category' => 'Layanan Keuangan & Perbankan', 'link' => 'https://www.ovo.id/career'],
            ['name' => 'PT Bank Central Asia Tbk', 'category' => 'Layanan Keuangan & Perbankan', 'link' => 'https://karir.bca.co.id'],
            ['name' => 'PT Indofood CBP Sukses Makmur', 'category' => 'Konsumsi & Ritel', 'link' => 'https://www.indofood.com/career'],
            ['name' => 'PT Unilever Indonesia Tbk', 'category' => 'Konsumsi & Ritel', 'link' => 'https://www.unilever.co.id/careers'],
            ['name' => 'PT Ruang Raya Indonesia', 'category' => 'Pendidikan', 'link' => 'https://career.ruangguru.com'],
            ['name' => 'PT Zenius Education', 'category' => 'Pendidikan', 'link' => 'https://www.zenius.net/career'],
            ['name' => 'PT Media Dokter Investama', 'category' => 'Kesehatan', 'link' => 'https://www.halodoc.com/career'],
            ['name' => 'PT Alodokter', 'category' => 'Kesehatan', 'link' => 'https://www.alodokter.com/career'],
            ['name' => 'PT PLN (Persero)', 'category' => 'Energi & Sumber Daya Alam', 'link' => 'https://rekrutmen.pln.co.id'],
            ['name' => 'PT Bukit Asam Tbk', 'category' => 'Energi & Sumber Daya Alam', 'link' => 'https://www.ptba.co.id/sdm/karir'],
            ['name' => 'PT Adaro Energy Tbk', 'category' => 'Energi & Sumber Daya Alam', 'link' => 'https://adaro.com/pages/read/11/careers'],
            ['name' => 'PT Kumparan (Media)', 'category' => 'Media & Kreatif', 'link' => 'https://kumparan.com/career'],
            ['name' => 'PT IDN Media', 'category' => 'Media & Kreatif', 'link' => 'https://www.idntimes.com/career'],
            ['name' => 'PT Trans Digital Media', 'category' => 'Media & Kreatif', 'link' => 'https://www.detik.com/karir'],
        ];

        foreach ($internshipsData as $data) {
            Internship::updateOrCreate(
                ['name' => $data['name']],
                [
                    'category_id' => $categories[$data['category']],
                    'website_link' => $data['link']
                ]
            );
        }

        // 4. Randomized Activity ... (unchanged)
        $users = User::where('role', 'user')->get();
        $internships = Internship::all();
        $criterias = Criteria::all();

        foreach ($users as $user) {
            foreach ($criterias as $c) {
                UserCriteriaWeight::updateOrCreate(
                    ['user_id' => $user->id, 'criteria_id' => $c->id],
                    ['weight' => rand(1, 5)]
                );
            }

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

                $internshipSample = $internships->random(rand(4, 6));
                foreach ($internshipSample as $intern) {
                    foreach ($criterias as $crit) {
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
