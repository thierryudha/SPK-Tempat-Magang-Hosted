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
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $criterias = Criteria::all(); // C1 - C10
        
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

        // Create Global Internships
        $internshipModels = [];
        foreach ($realCompanies as $company) {
            $internshipModels[] = Internship::updateOrCreate(
                ['name' => $company['name']],
                [
                    'city' => $company['city'],
                    'category' => $company['cat'],
                    'description' => "Program magang profesional di " . $company['name'],
                ]
            );
        }

        // Personas with Varying Dates for Trend
        $personas = [
            ['name' => 'Rizky', 'email' => 'rizky@example.com', 'days' => 360],
            ['name' => 'Siti', 'email' => 'siti@example.com', 'days' => 350],
            ['name' => 'Budi', 'email' => 'budi@example.com', 'days' => 270],
            ['name' => 'Dewi', 'email' => 'dewi@example.com', 'days' => 260],
            ['name' => 'Ahmad', 'email' => 'ahmad@example.com', 'days' => 250],
            ['name' => 'Putri', 'email' => 'putri@example.com', 'days' => 180],
            ['name' => 'Fajar', 'email' => 'fajar@example.com', 'days' => 170],
            ['name' => 'Lestari', 'email' => 'lestari@example.com', 'days' => 160],
            ['name' => 'Eko', 'email' => 'eko@example.com', 'days' => 90],
            ['name' => 'Sari', 'email' => 'sari@example.com', 'days' => 80],
            ['name' => 'Aditya', 'email' => 'aditya@example.com', 'days' => 70],
            ['name' => 'Neni', 'email' => 'neni@example.com', 'days' => 30],
            ['name' => 'Hendra', 'email' => 'hendra@example.com', 'days' => 20],
            ['name' => 'Rina', 'email' => 'rina@example.com', 'days' => 10],
            ['name' => 'Agus', 'email' => 'agus@example.com', 'days' => 5],
            ['name' => 'Maya', 'email' => 'maya@example.com', 'days' => 2],
        ];

        foreach ($personas as $p) {
            $user = User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['name'],
                    'password' => Hash::make('password123'),
                    'created_at' => Carbon::now()->subDays($p['days'])
                ]
            );

            // Randomize criteria weights
            $selectedCriteria = $criterias->random(rand(4, 8));
            $totalWeight = 100;
            $count = $selectedCriteria->count();
            foreach ($selectedCriteria as $index => $c) {
                if ($index === $count - 1) { $weight = $totalWeight; } 
                else { 
                    $max = max(5, floor($totalWeight - (($count - $index - 1) * 5)));
                    $weight = rand(5, min(40, $max)); 
                    $totalWeight -= $weight; 
                }
                UserCriteriaWeight::updateOrCreate(
                    ['user_id' => $user->id, 'criteria_id' => $c->id],
                    ['weight' => $weight]
                );
            }

            // Each user evaluates 3-5 random companies
            $userCompanies = collect($internshipModels)->random(rand(3, 5));
            foreach ($userCompanies as $internship) {
                foreach ($criterias as $c) {
                    InternshipEvaluation::updateOrCreate(
                        ['user_id' => $user->id, 'internship_id' => $internship->id, 'criteria_id' => $c->id],
                        ['score' => rand(1, 5)]
                    );
                }
            }
        }
    }
}
