<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Criteria;
use App\Models\InternshipEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function index()
    {
        $internships = Internship::latest()->get();
        return view('internships.index', compact('internships'));
    }

    public function create()
    {
        $categories = [
            'Software House', 'Fintech Startup', 'E-commerce', 'Edutech', 'Healthtech', 
            'Banking & Finance', 'Oil & Gas', 'Telecommunications', 'FMCG', 'Manufacturing', 
            'Automotive', 'Lembaga Negara', 'BUMN', 'Media & Broadcasting', 'Game Development', 
            'Creative Agency', 'Logistics', 'Agriculture Tech', 'Cyber Security', 'Cloud Service', 
            'Venture Capital', 'Retail', 'Hospitality', 'Aviation'
        ];
        sort($categories);

        $indonesianCities = [
        'Aceh Barat', 'Aceh Barat Daya', 'Aceh Besar', 'Aceh Jaya', 'Aceh Selatan', 'Aceh Singkil', 'Aceh Tamiang', 'Aceh Tengah', 'Aceh Tenggara', 'Aceh Timur', 'Aceh Utara', 'Agam', 'Alor', 'Ambon', 'Asahan', 'Asmat', 'Badung', 'Balangan', 'Balikpapan', 'Banda Aceh', 'Bandar Lampung', 'Bandung', 'Bandung Barat', 'Banggai', 'Banggai Kepulauan', 'Banggai Laut', 'Bangka', 'Bangka Barat', 'Bangka Selatan', 'Bangka Tengah', 'Bangkalan', 'Bangli', 'Banjar', 'Banjarbaru', 'Banjarmasin', 'Banjarnegara', 'Bantaeng', 'Bantul', 'Banyuasin', 'Banyumas', 'Banyuwangi', 'Barito Kuala', 'Barito Selatan', 'Barito Timur', 'Barito Utara', 'Barru', 'Batam', 'Batang', 'Batanghari', 'Batu', 'Batubara', 'Bau-Bau', 'Bekasi', 'Belitung', 'Belitung Timur', 'Belu', 'Bener Meriah', 'Bengkalis', 'Bengkayang', 'Bengkulu', 'Bengkulu Selatan', 'Bengkulu Tengah', 'Bengkulu Utara', 'Berau', 'Biak Numfor', 'Bima', 'Binjai', 'Bintan', 'Bireuen', 'Bitung', 'Blitar', 'Blora', 'Boalemo', 'Bogor', 'Bojonegoro', 'Bolaang Mongondow', 'Bolaang Mongondow Selatan', 'Bolaang Mongondow Timur', 'Bolaang Mongondow Utara', 'Bombana', 'Bondowoso', 'Bone', 'Bone Bolango', 'Bontang', 'Boven Digoel', 'Boyolali', 'Brebes', 'Bukittinggi', 'Buleleng', 'Bulukumba', 'Bulungan', 'Bungo', 'Buol', 'Buru', 'Buru Selatan', 'Buton', 'Buton Selatan', 'Buton Tengah', 'Buton Utara', 'Ciamis', 'Cianjur', 'Cilacap', 'Cilegon', 'Cimahi', 'Cirebon', 'Dairi', 'Deiyai', 'Deli Serdang', 'Demak', 'Denpasar', 'Depok', 'Dharmasraya', 'Dogiyai', 'Dompu', 'Donggala', 'Dumai', 'Empat Lawang', 'Ende', 'Enrekang', 'Fakfak', 'Flores Timur', 'Garut', 'Gayo Lues', 'Gianyar', 'Gorontalo', 'Gorontalo Utara', 'Gowa', 'Gresik', 'Grobogan', 'Gunung Mas', 'Gunungkidul', 'Gunungsitoli', 'Halmahera Barat', 'Halmahera Selatan', 'Halmahera Tengah', 'Halmahera Timur', 'Halmahera Utara', 'Hulu Sungai Selatan', 'Hulu Sungai Tengah', 'Hulu Sungai Utara', 'Humbang Hasundutan', 'Indragiri Hilir', 'Indragiri Hulu', 'Indramayu', 'Intan Jaya', 'Jakarta Barat', 'Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Timur', 'Jakarta Utara', 'Jambi', 'Jayapura', 'Jayawijaya', 'Jember', 'Jembrana', 'Jeneponto', 'Jepara', 'Jombang', 'Kaimana', 'Kampar', 'Kapuas', 'Kapuas Hulu', 'Karanganyar', 'Karangasem', 'Karawang', 'Karimun', 'Karo', 'Katingan', 'Kaur', 'Kayong Utara', 'Kebumen', 'Kediri', 'Keerom', 'Kendal', 'Kendari', 'Kepahiang', 'Kepulauan Anambas', 'Kepulauan Aru', 'Kepulauan Mentawai', 'Kepulauan Meranti', 'Kepulauan Sangihe', 'Kepulauan Selayar', 'Kepulauan Seribu', 'Kepulauan Siau Tagulandang Biaro', 'Kepulauan Sula', 'Kepulauan Talaud', 'Kepulauan Yapen', 'Kerinci', 'Ketapang', 'Klaten', 'Klungkung', 'Kolaka', 'Kolaka Timur', 'Kolaka Utara', 'Konawe', 'Konawe Kepulauan', 'Konawe Selatan', 'Konawe Utara', 'Kotabaru', 'Kotamobagu', 'Kotawaringin Barat', 'Kotawaringin Timur', 'Kuantan Singingi', 'Kubu Raya', 'Kudus', 'Kulon Progo', 'Kuningan', 'Kupang', 'Kutai Barat', 'Kutai Kartanegara', 'Kutai Timur', 'Labuhanbatu', 'Labuhanbatu Selatan', 'Labuhanbatu Utara', 'Lahat', 'Lamandau', 'Lamongan', 'Lampung Barat', 'Lampung Selatan', 'Lampung Tengah', 'Lampung Timur', 'Lampung Utara', 'Landak', 'Langkat', 'Langsa', 'Lanny Jaya', 'Lebak', 'Lebong', 'Lembata', 'Lhokseumawe', 'Lima Puluh Kota', 'Lingga', 'Lombok Barat', 'Lombok Tengah', 'Lombok Timur', 'Lombok Utara', 'Lubuklinggau', 'Lumajang', 'Luwu', 'Luwu Timur', 'Luwu Utara', 'Madiun', 'Magelang', 'Magetan', 'Mahakam Ulu', 'Majalengka', 'Majene', 'Makassar', 'Malaka', 'Malang', 'Malinau', 'Maluku Barat Daya', 'Maluku Tengah', 'Maluku Tenggara', 'Maluku Tenggara Barat', 'Mamasa', 'Mamberamo Raya', 'Mamberamo Tengah', 'Mamuju', 'Mamuju Tengah', 'Mamuju Utara', 'Manado', 'Mandailing Natal', 'Manggarai', 'Manggarai Barat', 'Manggarai Timur', 'Manokwari', 'Manokwari Selatan', 'Mappi', 'Maros', 'Mataram', 'Maybrat', 'Medan', 'Melawi', 'Mempawah', 'Merangin', 'Merauke', 'Mesuji', 'Metro', 'Mimika', 'Minahasa', 'Minahasa Selatan', 'Minahasa Tenggara', 'Minahasa Utara', 'Mojokerto', 'Morowali', 'Morowali Utara', 'Muara Enim', 'Muaro Jambi', 'Mukomuko', 'Muna', 'Muna Barat', 'Murung Raya', 'Musi Banyuasin', 'Musi Rawas', 'Musi Rawas Utara', 'Nabire', 'Nagan Raya', 'Nagekeo', 'Natuna', 'Nduga', 'Ngada', 'Nganjuk', 'Ngawi', 'Nias', 'Nias Barat', 'Nias Selatan', 'Nias Utara', 'Nunukan', 'Ogan Ilir', 'Ogan Komering Ilir', 'Ogan Komering Ulu', 'Ogan Komering Ulu Selatan', 'Ogan Komering Ulu Timur', 'Pacitan', 'Padang', 'Padang Lawas', 'Padang Lawas Utara', 'Padang Pariaman', 'Padangpanjang', 'Padangsidempuan', 'Pagar Alam', 'Pakpak Bharat', 'Palangka Raya', 'Palembang', 'Palopo', 'Palu', 'Pamekasan', 'Pandeglang', 'Pangandaran', 'Pangkajene dan Kepulauan', 'Pangkal Pinang', 'Paniai', 'Parepare', 'Pariaman', 'Parigi Moutong', 'Pasaman', 'Pasaman Barat', 'Paser', 'Pasuruan', 'Pati', 'Payakumbuh', 'Pegunungan Arfak', 'Pegunungan Bintang', 'Pekalongan', 'Pekanbalongan', 'Pekanbaru', 'Pelalawan', 'Pemalang', 'Pematangsiantar', 'Penajam Paser Utara', 'Penukal Abab Lematang Ilir', 'Pesawaran', 'Pesisir Barat', 'Pesisir Selatan', 'Pidie', 'Pidie Jaya', 'Pinrang', 'Pohuwato', 'Polewali Mandar', 'Ponorogo', 'Pontianak', 'Poso', 'Prabumulih', 'Pringsewu', 'Probolinggo', 'Pulang Pisau', 'Pulau Morotai', 'Pulau Taliabu', 'Puncak', 'Puncak Jaya', 'Purbalingga', 'Purwakarta', 'Purworejo', 'Raja Ampat', 'Rejang Lebong', 'Rembang', 'Rokan Hilir', 'Rokan Hulu', 'Rote Ndao', 'Sabang', 'Sabu Raijua', 'Salatiga', 'Samarinda', 'Sambas', 'Samosir', 'Sampang', 'Sanggau', 'Sarmi', 'Sarolangun', 'Sawahlunto', 'Sekadau', 'Seluma', 'Semarang', 'Seram Bagian Barat', 'Seram Bagian Timur', 'Serang', 'Serdang Bedagai', 'Seruyan', 'Siak', 'Sibolga', 'Sidenreng Rappang', 'Sidoarjo', 'Sigi', 'Sijunjung', 'Sikka', 'Simalungun', 'Simeulue', 'Singkawang', 'Sinjai', 'Sintang', 'Situbondo', 'Sleman', 'Solok', 'Solok Selatan', 'Soppeng', 'Sorong', 'Sorong Selatan', 'Sragen', 'Subang', 'Subulussalam', 'Sukabumi', 'Sukamara', 'Sukoharjo', 'Sumba Barat', 'Sumba Barat Daya', 'Sumba Tengah', 'Sumba Timur', 'Sumbawa', 'Sumbawa Barat', 'Sumedang', 'Sumenep', 'Sungai Penuh', 'Supiori', 'Surabaya', 'Surakarta', 'Tabalong', 'Tabanan', 'Takalar', 'Tambrauw', 'Tana Tidung', 'Tana Toraja', 'Tanah Bumbu', 'Tanah Datar', 'Tanah Laut', 'Tangerang', 'Tangerang Selatan', 'Tanggamus', 'Tanjung Jabung Barat', 'Tanjung Jabung Timur', 'Tanjung Pinang', 'Tanjungbalai', 'Tapanuli Selatan', 'Tapanuli Tengah', 'Tapanuli Utara', 'Tapin', 'Tarakan', 'Tasikmalaya', 'Tebing Tinggi', 'Tebo', 'Tegal', 'Teluk Bintuni', 'Teluk Wondama', 'Temanggung', 'Ternate', 'Tidore Kepulauan', 'Timor Tengah Selatan', 'Timor Tengah Utara', 'Toba Samosir', 'Tojo Una-Una', 'Toli-Toli', 'Tolikara', 'Tomohon', 'Toraja Utara', 'Trenggalek', 'Tual', 'Tuban', 'Tulang Bawang', 'Tulang Bawang Barat', 'Tulungagung', 'Wajo', 'Wakatobi', 'Waropen', 'Way Kanan', 'Wonogiri', 'Wonosobo', 'Yahukimo', 'Yalimo', 'Yogyakarta',
        ];

        // Fetch all existing internships to show in the UI list if needed
        $globalInternships = Internship::latest()->get();

        return view('internships.create', compact('categories', 'indonesianCities', 'globalInternships'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Constraint: Check if this internship already exists (name only as requested)
        $exists = Internship::where('name', $validated['name'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Tempat magang dengan nama ini sudah ada dalam daftar.'])
                        ->withInput();
        }

        Internship::create($validated);

        return redirect()->route('internships.index')->with('success', 'Tempat magang berhasil ditambahkan.');
    }

    public function edit(Internship $internship)
    {
        $categories = [
            'Software House', 'Fintech Startup', 'E-commerce', 'Edutech', 'Healthtech', 
            'Banking & Finance', 'Oil & Gas', 'Telecommunications', 'FMCG', 'Manufacturing', 
            'Automotive', 'Lembaga Negara', 'BUMN', 'Media & Broadcasting', 'Game Development', 
            'Creative Agency', 'Logistics', 'Agriculture Tech', 'Cyber Security', 'Cloud Service', 
            'Venture Capital', 'Retail', 'Hospitality', 'Aviation'
        ];
        sort($categories);
        return view('internships.edit', compact('internship', 'categories'));
    }


    public function update(Request $request, Internship $internship)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Constraint: Check if another internship with same name exists
        $exists = Internship::where('name', $validated['name'])
            ->where('id', '!=', $internship->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Nama tempat magang ini sudah ada dalam daftar.'])
                        ->withInput();
        }

        $internship->update($validated);

        return redirect()->route('internships.index')->with('success', 'Tempat magang berhasil diperbarui.');
    }

    public function destroy(Internship $internship)
    {
        $internship->delete();

        return redirect()->route('internships.index')->with('success', 'Tempat magang berhasil dihapus.');
    }
}
