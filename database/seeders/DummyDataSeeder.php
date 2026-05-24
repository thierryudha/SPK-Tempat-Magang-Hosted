<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Internship;
use App\Models\InternshipEvaluation;
use App\Models\Criteria;
use App\Models\UserCriteriaWeight;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $criterias = Criteria::all(); // C1 - C10
        
        $categories = [
            'Software House', 'Fintech Startup', 'E-commerce', 'Edutech', 'Healthtech', 
            'Banking & Finance', 'Oil & Gas', 'Telecommunications', 'FMCG', 'Manufacturing', 
            'Automotive', 'Lembaga Negara', 'BUMN', 'Media & Broadcasting', 'Game Development', 
            'Creative Agency', 'Logistics', 'Agriculture Tech', 'Cyber Security', 'Cloud Service', 
            'Venture Capital', 'Retail', 'Hospitality', 'Aviation'
        ];

        $realCompanies = [
            ['name' => 'Gojek', 'city' => 'Jakarta Selatan', 'cat' => 'Fintech Startup'],
            ['name' => 'Tokopedia', 'city' => 'Jakarta Barat', 'cat' => 'E-commerce'],
            ['name' => 'Traveloka', 'city' => 'Tangerang', 'cat' => 'Fintech Startup'],
            ['name' => 'Bukalapak', 'city' => 'Jakarta Selatan', 'cat' => 'E-commerce'],
            ['name' => 'Dana', 'city' => 'Jakarta Pusat', 'cat' => 'Fintech Startup'],
            ['name' => 'Shopee', 'city' => 'Jakarta Selatan', 'cat' => 'E-commerce'],
            ['name' => 'Lazada', 'city' => 'Jakarta Selatan', 'cat' => 'E-commerce'],
            ['name' => 'Blibli', 'city' => 'Jakarta Pusat', 'cat' => 'E-commerce'],
            ['name' => 'eFishery', 'city' => 'Bandung', 'cat' => 'Agriculture Tech'],
            ['name' => 'Ruangguru', 'city' => 'Jakarta Selatan', 'cat' => 'Edutech'],
            ['name' => 'Halodoc', 'city' => 'Jakarta Selatan', 'cat' => 'Healthtech'],
            ['name' => 'Ajaib', 'city' => 'Jakarta Selatan', 'cat' => 'Fintech Startup'],
            ['name' => 'Xendit', 'city' => 'Jakarta Selatan', 'cat' => 'Fintech Startup'],
            ['name' => 'Bibit', 'city' => 'Jakarta Selatan', 'cat' => 'Fintech Startup'],
            ['name' => 'Kopi Kenangan', 'city' => 'Jakarta Selatan', 'cat' => 'Retail'],
            ['name' => 'J&T Express', 'city' => 'Jakarta Barat', 'cat' => 'Logistics'],
            ['name' => 'SiCepat', 'city' => 'Jakarta Utara', 'cat' => 'Logistics'],
            ['name' => 'GITS Indonesia', 'city' => 'Bandung', 'cat' => 'Software House'],
            ['name' => 'Agate International', 'city' => 'Bandung', 'cat' => 'Game Development'],
            ['name' => 'TIX ID', 'city' => 'Jakarta Pusat', 'cat' => 'Fintech Startup'],
            ['name' => 'Payfazz', 'city' => 'Jakarta Selatan', 'cat' => 'Fintech Startup'],
            ['name' => 'Moka POS', 'city' => 'Jakarta Selatan', 'cat' => 'Software House'],
            ['name' => 'Flip', 'city' => 'Depok', 'cat' => 'Fintech Startup'],
            ['name' => 'Pahamify', 'city' => 'Bogor', 'cat' => 'Edutech'],
            ['name' => 'Kredivo', 'city' => 'Jakarta Selatan', 'cat' => 'Fintech Startup'],
            ['name' => 'BCA', 'city' => 'Jakarta Pusat', 'cat' => 'Banking & Finance'],
            ['name' => 'Bank Mandiri', 'city' => 'Jakarta Pusat', 'cat' => 'Banking & Finance'],
            ['name' => 'Bank BRI', 'city' => 'Jakarta Pusat', 'cat' => 'Banking & Finance'],
            ['name' => 'Bank BNI', 'city' => 'Jakarta Pusat', 'cat' => 'Banking & Finance'],
            ['name' => 'Telkom Indonesia', 'city' => 'Bandung', 'cat' => 'Telecommunications'],
            ['name' => 'Pertamina', 'city' => 'Jakarta Pusat', 'cat' => 'Oil & Gas'],
            ['name' => 'Astra International', 'city' => 'Jakarta Utara', 'cat' => 'Automotive'],
            ['name' => 'Unilever Indonesia', 'city' => 'Tangerang', 'cat' => 'FMCG'],
            ['name' => 'Indofood', 'city' => 'Jakarta Selatan', 'cat' => 'FMCG'],
            ['name' => 'Mayora', 'city' => 'Tangerang', 'cat' => 'FMCG'],
            ['name' => 'Adaro Energy', 'city' => 'Jakarta Selatan', 'cat' => 'Oil & Gas'],
            ['name' => 'Garuda Indonesia', 'city' => 'Tangerang', 'cat' => 'Aviation'],
            ['name' => 'Gudang Garam', 'city' => 'Kediri', 'cat' => 'Manufacturing'],
            ['name' => 'HMSP (Sampoerna)', 'city' => 'Surabaya', 'cat' => 'Manufacturing'],
            ['name' => 'PLN', 'city' => 'Jakarta Selatan', 'cat' => 'BUMN'],
            ['name' => 'Bank Indonesia', 'city' => 'Jakarta Pusat', 'cat' => 'Lembaga Negara'],
            ['name' => 'OJK', 'city' => 'Jakarta Pusat', 'cat' => 'Lembaga Negara'],
            ['name' => 'Kemenkeu RI', 'city' => 'Jakarta Pusat', 'cat' => 'Lembaga Negara'],
            ['name' => 'Narasi', 'city' => 'Jakarta Selatan', 'cat' => 'Media & Broadcasting'],
            ['name' => 'IDN Media', 'city' => 'Jakarta Selatan', 'cat' => 'Media & Broadcasting'],
            ['name' => 'Kumparan', 'city' => 'Jakarta Selatan', 'cat' => 'Media & Broadcasting'],
            ['name' => 'Metro TV', 'city' => 'Jakarta Barat', 'cat' => 'Media & Broadcasting'],
            ['name' => 'Kompas Gramedia', 'city' => 'Jakarta Pusat', 'cat' => 'Media & Broadcasting'],
            ['name' => 'BPJS Kesehatan', 'city' => 'Jakarta Pusat', 'cat' => 'BUMN'],
            ['name' => 'Telkomsel', 'city' => 'Jakarta Selatan', 'cat' => 'Telecommunications'],
        ];

        // Define Sector Personalities with SOFTER contrast
        // Values are centered more around 2-4 with occasional 1s or 5s
        $sectorProfiles = [
            'Fintech Startup' => [4, 2, 2, 4, 5, 4, 3, 4, 4, 2], 
            'Banking & Finance' => [4, 4, 4, 3, 2, 5, 5, 5, 2, 4], 
            'Media & Broadcasting' => [2, 3, 3, 4, 5, 2, 2, 4, 5, 2], 
            'BUMN' => [3, 4, 4, 5, 2, 4, 5, 4, 3, 4], 
            'Software House' => [3, 3, 3, 4, 5, 2, 3, 3, 4, 3], 
            'Telecommunications' => [4, 4, 3, 4, 4, 5, 4, 5, 3, 4],
        ];

        // List of 20 Manual Personas (Unique Individuals)
        $personas = [
            ['name' => 'Rizky Ramadhan', 'email' => 'rizky.ramadhan@example.com'],
            ['name' => 'Siti Aminah', 'email' => 'siti.aminah@example.com'],
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@example.com'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi.lestari@example.com'],
            ['name' => 'Ahmad Hidayat', 'email' => 'ahmad.hidayat@example.com'],
            ['name' => 'Putri Indah Sari', 'email' => 'putri.indah@example.com'],
            ['name' => 'Fajar Nugraha', 'email' => 'fajar.nugraha@example.com'],
            ['name' => 'Lestari Wahyuni', 'email' => 'lestari.wahyuni@example.com'],
            ['name' => 'Eko Prasetyo', 'email' => 'eko.prasetyo@example.com'],
            ['name' => 'Sari Kartika', 'email' => 'sari.kartika@example.com'],
            ['name' => 'Aditya Wijaya', 'email' => 'aditya.wijaya@example.com'],
            ['name' => 'Neni Mulyani', 'email' => 'neni.mulyani@example.com'],
            ['name' => 'Hendra Kusuma', 'email' => 'hendra.kusuma@example.com'],
            ['name' => 'Rina Permata', 'email' => 'rina.permata@example.com'],
            ['name' => 'Agus Setiawan', 'email' => 'agus.setiawan@example.com'],
            ['name' => 'Maya Puspita', 'email' => 'maya.puspita@example.com'],
            ['name' => 'Dedi Kurniawan', 'email' => 'dedi.kurniawan@example.com'],
            ['name' => 'Indah Permatasari', 'email' => 'indah.permata@example.com'],
            ['name' => 'Taufik Hidayat', 'email' => 'taufik.hidayat@example.com'],
            ['name' => 'Wulan Dari', 'email' => 'wulan.dari@example.com'],
        ];

        foreach ($personas as $p) {
            $user = User::create([
                'name' => $p['name'],
                'email' => $p['email'],
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now()->subDays(rand(0, 30))
            ]);

            // Randomize user's interest (different users care about different things)
            $selectedCriteria = $criterias->random(rand(4, 8));
            $totalWeight = 100;
            $count = $selectedCriteria->count();
            
            // Assign weights with more randomness
            foreach ($selectedCriteria as $index => $c) {
                if ($index === $count - 1) { 
                    $weight = $totalWeight; 
                } else { 
                    $max = max(5, floor($totalWeight - (($count - $index - 1) * 5)));
                    $weight = rand(5, min(40, $max)); 
                    $totalWeight -= $weight; 
                }
                UserCriteriaWeight::create(['user_id' => $user->id, 'criteria_id' => $c->id, 'weight' => $weight]);
            }

            // Each user has a unique set of companies they are interested in
            $userCompanies = array_rand($realCompanies, rand(4, 7));
            foreach ((array)$userCompanies as $key) {
                $company = $realCompanies[$key];
                $internship = Internship::create([
                    'user_id' => $user->id,
                    'name' => $company['name'],
                    'city' => $company['city'],
                    'category' => $company['cat'],
                    'description' => "Pengalaman magang profesional " . $p['name'] . " di " . $company['name'],
                ]);

                // Give each user a unique evaluation style
                $userStrictness = rand(-100, 100) / 100;
                $profile = $sectorProfiles[$company['cat']] ?? null;

                foreach ($criterias as $index => $c) {
                    if ($profile && isset($profile[$index])) {
                        $baseScore = $profile[$index];
                        $score = $baseScore + $userStrictness + (rand(-50, 50) / 100);
                    } else {
                        $score = rand(200, 450) / 100;
                    }
                    
                    $score = max(1, min(5, round($score, 2)));

                    InternshipEvaluation::create([
                        'internship_id' => $internship->id, 
                        'criteria_id' => $c->id, 
                        'score' => $score
                    ]);
                }
            }
        }

        // Test User
        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser) {
            $testSelection = array_slice($realCompanies, 0, 8);
            foreach ($testSelection as $company) {
                $internship = Internship::create([
                    'user_id' => $testUser->id,
                    'name' => $company['name'],
                    'city' => $company['city'],
                    'category' => $company['cat'],
                    'description' => "My chosen internship at " . $company['name'],
                ]);
                foreach ($criterias as $c) {
                    InternshipEvaluation::create(['internship_id' => $internship->id, 'criteria_id' => $c->id, 'score' => rand(3, 5)]);
                }
            }
        }
    }
}
