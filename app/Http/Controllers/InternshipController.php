<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Criteria;
use App\Models\Category;
use App\Models\InternshipEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function index()
    {
        $internships = Internship::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->get();
        return view('internships.index', compact('internships'));
    }

    public function create()
    {
        $categories = Category::all();

        $indonesianCities = [
        'Aceh Barat', 'Aceh Barat Daya', 'Aceh Besar', 'Aceh Jaya', 'Aceh Selatan', 'Aceh Singkil', 'Aceh Tamiang', 'Aceh Tengah', 'Aceh Tenggara', 'Aceh Timur', 'Aceh Utara', 'Agam', 'Alor', 'Ambon', 'Asahan', 'Asmat', 'Badung', 'Balangan', 'Balikpapan', 'Banda Aceh', 'Bandar Lampung', 'Bandung', 'Bandung Barat', 'Banggai', 'Banggai Kepulauan', 'Banggai Laut', 'Bangka', 'Bangka Barat', 'Bangka Selatan', 'Bangka Tengah', 'Bangkalan', 'Bangli', 'Banjar', 'Banjarbaru', 'Banjarmasin', 'Banjarnegara', 'Bantaeng', 'Bantul', 'Banyuasin', 'Banyumas', 'Banyuwangi', 'Barito Kuala', 'Barito Selatan', 'Barito Timur', 'Barito Utara', 'Barru', 'Batam', 'Batang', 'Batanghari', 'Batu', 'Batubara', 'Bau-Bau', 'Bekasi', 'Belitung', 'Belitung Timur', 'Belu', 'Bener Meriah', 'Bengkalis', 'Bengkayang', 'Bengkulu', 'Bengkulu Selatan', 'Bengkulu Tengah', 'Bengkulu Utara', 'Berau', 'Biak Numfor', 'Bima', 'Binjai', 'Bintan', 'Bireuen', 'Bitung', 'Blitar', 'Blora', 'Boalemo', 'Bogor', 'Bojonegoro', 'Bolaang Mongondow', 'Bolaang Mongondow Selatan', 'Bolaang Mongondow Timur', 'Bolaang Mongondow Utara', 'Bombana', 'Bondowoso', 'Bone', 'Bone Bolango', 'Bontang', 'Boven Digoel', 'Boyolali', 'Brebes', 'Bukittinggi', 'Buleleng', 'Bulukumba', 'Bulungan', 'Bungo', 'Buol', 'Buru', 'Buru Selatan', 'Buton', 'Buton Selatan', 'Buton Tengah', 'Buton Utara', 'Ciamis', 'Cianjur', 'Cilacap', 'Cilegon', 'Cimahi', 'Cirebon', 'Dairi', 'Deiyai', 'Deli Serdang', 'Demak', 'Denpasar', 'Depok', 'Dharmasraya', 'Dogiyai', 'Dompu', 'Donggala', 'Dumai', 'Empat Lawang', 'Ende', 'Enrekang', 'Fakfak', 'Flores Timur', 'Garut', 'Gayo Lues', 'Gianyar', 'Gorontalo', 'Gorontalo Utara', 'Gowa', 'Gresik', 'Grobogan', 'Gunung Mas', 'Gunungkidul', 'Gunungsitoli', 'Halmahera Barat', 'Halmahera Selatan', 'Halmahera Tengah', 'Halmahera Timur', 'Halmahera Utara', 'Hulu Sungai Selatan', 'Hulu Sungai Tengah', 'Hulu Sungai Utara', 'Humbang Hasundutan', 'Indragiri Hilir', 'Indragiri Hulu', 'Indramayu', 'Intan Jaya', 'Jakarta Barat', 'Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Timur', 'Jakarta Utara', 'Jambi', 'Jayapura', 'Jayawijaya', 'Jember', 'Jembrana', 'Jeneponto', 'Jepara', 'Jombang', 'Kaimana', 'Kampar', 'Kapuas', 'Kapuas Hulu', 'Karanganyar', 'Karangasem', 'Karawang', 'Karimun', 'Karo', 'Katingan', 'Kaur', 'Kayong Utara', 'Kebumen', 'Kediri', 'Keerom', 'Kendal', 'Kendari', 'Kepahiang', 'Kepulauan Anambas', 'Kepulauan Aru', 'Kepulauan Mentawai', 'Kepulauan Meranti', 'Kepulauan Sangihe', 'Kepulauan Selayar', 'Kepulauan Seribu', 'Kepulauan Siau Tagulandang Biaro', 'Kepulauan Sula', 'Kepulauan Talaud', 'Kepulauan Yapen', 'Kerinci', 'Ketapang', 'Klaten', 'Klungkung', 'Kolaka', 'Kolaka Utara', 'Konawe', 'Konawe Selatan', 'Konawe Utara', 'Kotabaru', 'Kotamobagu', 'Kotawaringin Barat', 'Kotawaringin Timur', 'Kuantan Singingi', 'Kupang', 'Kutai Barat', 'Kutai Kartanegara', 'Kutai Timur', 'Labuhanbatu', 'Labuhanbatu Selatan', 'Labuhanbatu Utara', 'Lahat', 'Lamandau', 'Lamongan', 'Lampung Barat', 'Lampung Selatan', 'Lampung Tengah', 'Lampung Timur', 'Lampung Utara', 'Landak', 'Langkat', 'Langsa', 'Lhokseumawe', 'Limboto', 'Lingga', 'Lombok Barat', 'Lombok Tengah', 'Lombok Timur', 'Lombok Utara', 'Lubuklinggau', 'Lumajang', 'Luwu', 'Luwu Timur', 'Luwu Utara', 'Madiun', 'Magelang', 'Magetan', 'Majalengka', 'Majene', 'Makassar', 'Malang', 'Malinau', 'Maluku Barat Daya', 'Maluku Tenggara', 'Maluku Tenggara Barat', 'Mamasa', 'Mamberamo Raya', 'Mamberamo Tengah', 'Mamuju', 'Mamuju Utara', 'Manado', 'Mandailing Natal', 'Manggarai', 'Manggarai Barat', 'Manggarai Timur', 'Manokwari', 'Manokwari Selatan', 'Mapupt', 'Maros', 'Mataram', 'Maybrat', 'Medan', 'Melawi', 'Merangin', 'Merauke', 'Mesuji', 'Metro', 'Mimika', 'Minahasa', 'Minahasa Selatan', 'Minahasa Tenggara', 'Minahasa Utara', 'Mojokerto', 'Morowali', 'Muara Enim', 'Muaro Jambi', 'Muko Muko', 'Muna', 'Murung Raya', 'Musi Banyuasin', 'Musi Rawas', 'Nabire', 'Nagan Raya', 'Nagekeo', 'Natuna', 'Nduga', 'Nganjuk', 'Ngawi', 'Nias', 'Nias Barat', 'Nias Selatan', 'Nias Utara', 'Nunukan', 'Ogan Ilir', 'Ogan Komering Ilir', 'Ogan Komering Ulu', 'Ogan Komering Ulu Selatan', 'Ogan Komering Ulu Timur', 'Pacitan', 'Padang', 'Padang Lawas', 'Padang Lawas Utara', 'Padang Panjang', 'Padang Pariaman', 'Padangsidempuan', 'Pagar Alam', 'Pakpak Bharat', 'Palangkaraya', 'Palembang', 'Palopo', 'Palu', 'Pamekasan', 'Pandeglang', 'Pangkal Pinang', 'Pangkajene Dan Kepulauan', 'Parigi Moutong', 'Pariaman', 'Parit Malintang', 'Pasaman', 'Pasaman Barat', 'Paser', 'Pasuruan', 'Pati', 'Payakumbuh', 'Pegunungan Arfak', 'Pegunungan Bintang', 'Pekalongan', 'Pekanbaru', 'Pelalawan', 'Pemalang', 'Pematangsiantar', 'Penajam Paser Utara', 'Pesawaran', 'Pesisir Barat', 'Pesisir Selatan', 'Pidie', 'Pidie Jaya', 'Pinrang', 'Pohon Kanari', 'Polewali Mandar', 'Ponorogo', 'Pontianak', 'Poso', 'Prabumulih', 'Pringsewu', 'Probolinggo', 'Pulang Pisau', 'Pulau Morotai', 'Puncak', 'Puncak Jaya', 'Purwakarta', 'Purworejo', 'Raja Ampat', 'Rejang Lebong', 'Rembang', 'Riau', 'Rokan Hilir', 'Rokan Hulu', 'Rote Ndao', 'Sabang', 'Salatiga', 'Samarinda', 'Sambas', 'Samosir', 'Sampit', 'Sanggau', 'Sarolangun', 'Sawah Lunto', 'Sekadau', 'Seluma', 'Semarang', 'Seram Bagian Barat', 'Seram Bagian Timur', 'Serang', 'Serdang Bedagai', 'Sibolga', 'Sidoarjo', 'Sigi', 'Sijunjung', 'Sikka', 'Simalungun', 'Simeulue', 'Singkawang', 'Sinjai', 'Sintang', 'Situbondo', 'Sleman', 'Solok', 'Solok Selatan', 'Soppeng', 'Sorong', 'Sorong Selatan', 'Sragen', 'Subang', 'Subulussalam', 'Sukabumi', 'Sukamara', 'Sukoharjo', 'Sumba Barat', 'Sumba Barat Daya', 'Sumba Tengah', 'Sumba Timur', 'Sumbawa', 'Sumbawa Barat', 'Sumedang', 'Sumenep', 'Sungai Penuh', 'Supiori', 'Surabaya', 'Surakarta', 'Tabalong', 'Tabanan', 'Takalar', 'Talaut', 'Tambrauw', 'Tana Tidung', 'Tana Toraja', 'Tanah Bumbu', 'Tanah Datar', 'Tanah Laut', 'Tangerang', 'Tangerang Selatan', 'Tanggamus', 'Tanjung Balai', 'Tanjung Jabung Barat', 'Tanjung Jabung Timur', 'Tanjung Pinang', 'Tapanuli Selatan', 'Tapanuli Tengah', 'Tapanuli Utara', 'Tapin', 'Tarakan', 'Tasikmalaya', 'Tebing Tinggi', 'Tebo', 'Tegal', 'Teluk Bintuni', 'Teluk Wondama', 'Temanggung', 'Ternate', 'Tidore Kepulauan', 'Timor Tengah Selatan', 'Timor Tengah Utara', 'Toba Samosir', 'Tojo Una-Una', 'Toli-Toli', 'Tolikara', 'Tomohon', 'Toraja Utara', 'Trenggalek', 'Tual', 'Tuban', 'Tulungagung', 'Tulung Bawang', 'Tulung Bawang Barat', 'Tumijajar', 'Wajo', 'Wakatobi', 'Waropen', 'Way Kanan', 'Wonogiri', 'Wonosobo', 'Yogyakarta'
        ];

        // Fetch all existing internships to show in the UI list if needed
        $globalInternships = Internship::whereNull('user_id')->with('category')->latest()->get();

        return view('internships.create', compact('categories', 'indonesianCities', 'globalInternships'));
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:internships,id',
        ]);

        $count = 0;
        foreach ($request->ids as $id) {
            $global = Internship::find($id);
            
            // Check if user already has it (by name)
            $exists = Internship::where('user_id', Auth::id())
                ->where('name', $global->name)
                ->exists();
                
            if (!$exists) {
                Internship::create([
                    'name' => $global->name,
                    'city' => $global->city,
                    'category_id' => $global->category_id,
                    'description' => $global->description,
                    'user_id' => Auth::id(),
                ]);
                $count++;
            }
        }

        return redirect()->route('internships.index')->with('success', $count . ' tempat magang berhasil ditambahkan ke daftar Anda.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('internships')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                }),
            ],
            'city' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Internship::create($validated);

        return redirect()->route('internships.index')->with('success', 'Tempat magang berhasil ditambahkan.');
    }

    public function edit(Internship $internship)
    {
        $this->authorize('update', $internship);

        $categories = Category::all();
        return view('internships.edit', compact('internship', 'categories'));
    }


    public function update(Request $request, Internship $internship)
    {
        $this->authorize('update', $internship);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('internships')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })->ignore($internship->id),
            ],
            'city' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $internship->update($validated);

        return redirect()->route('internships.index')->with('success', 'Tempat magang berhasil diperbarui.');
    }

    public function destroy(Internship $internship)
    {
        $this->authorize('delete', $internship);

        $internship->delete();

        return redirect()->route('internships.index')->with('success', 'Tempat magang berhasil dihapus.');
    }
}
