# 📊 Analisis Project SPK Tempat Magang

> **Sistem Pendukung Keputusan (SPK) Pemilihan Tempat Magang** — Dibangun menggunakan metode **MOORA** (Multi-Objective Optimization on the Basis of Ratio Analysis), melayani dua klien: **Web Browser** dan **Flutter Android App**.

---

## 1. 🛠️ Tech Stack yang Digunakan

### Backend (Server-side)

| Teknologi | Versi | Peran |
|---|---|---|
| **PHP** | ^8.2 | Bahasa pemrograman utama |
| **Laravel** | ^12.0 | Framework backend (MVC + Routing + ORM) |
| **Laravel Sanctum** | ^4.0 | Autentikasi API berbasis token (untuk Flutter) |
| **Laravel Socialite** | ^5.27 | Autentikasi via Google OAuth (login dengan Google) |
| **Laravel Breeze** | ^2.4 | Scaffolding awal auth (login, register, reset password - web) |
| **Laravel Tinker** | ^2.10.1 | REPL untuk eksplorasi database di terminal |

### Frontend (Client-side Web)

| Teknologi | Versi | Peran |
|---|---|---|
| **Blade** | Bawaan Laravel | Templating engine untuk HTML dinamis |
| **Tailwind CSS** | ^3.1.0 | Utility-first CSS framework untuk styling |
| **Alpine.js** | ^3.4.2 | Framework JS ringan untuk interaktivitas UI (toggle, modal, dll.) |
| **Vite** | ^6.0.11 | Build tool modern (bundling CSS/JS untuk production) |
| **Axios** | ^1.7.4 | HTTP client JS (untuk request AJAX dari browser) |

### Database

| Teknologi | Peran |
|---|---|
| **MySQL / SQLite** | Database utama (dikonfigurasi di `.env`) |
| **Laravel Eloquent ORM** | Abstraksi database — query menggunakan sintaks PHP, bukan SQL mentah |
| **Laravel Migrations** | Version control untuk skema database |

### Dev Tools

| Teknologi | Peran |
|---|---|
| **Laravel Pail** | Real-time log viewer di terminal |
| **Laravel Sail** | Docker environment (opsional) |
| **PHPUnit** | Testing framework |
| **Concurrently** | Menjalankan beberapa proses sekaligus (server + queue + vite) |

### Klien Mobile

| Teknologi | Peran |
|---|---|
| **Flutter (Android)** | Mengonsumsi REST API Laravel via HTTP |

---

## 2. 🗂️ Skema Database (Antar Tabel)

```
users
 ├── id, name, email, password, role (user/admin)
 ├── photo, phone, bio
 └── google_id, google_token (untuk login Google)

criterias                          ← Dikelola admin
 ├── id, code, name, type (benefit/cost)
 └── ──► criteria_scales (id, criteria_id, scale 1-5, description)

internships
 ├── id, name, category_id, website_link
 ├── user_id (NULL = global/admin, ada nilai = milik user)
 └── deleted_at (soft delete)

categories                         ← Dikelola admin
 └── id, name

user_criteria_weights              ← Preferensi bobot per user
 └── user_id, criteria_id, weight

internship_evaluations             ← Nilai/skor per perusahaan per kriteria
 └── user_id, internship_id, criteria_id, score, moora_session_id

moora_sessions                     ← Riwayat setiap kali user menghitung MOORA
 └── user_id, winner_name, max_optimization_value, criteria_used (JSON)

activity_logs                      ← Audit trail semua aksi penting
 └── user_id, action, module, description, ip_address

personal_access_tokens             ← Token Sanctum untuk Flutter
 └── tokenable_id, tokenable_type, name, token, abilities
```

---

## 3. 🔄 Workflow Lengkap Aplikasi

### 3A. Alur Perhitungan MOORA — Dari Web Browser

> **Skenario:** User membuka halaman MOORA, mengisi form, dan mengklik tombol "Hitung".

```
[Browser: /moora]
      │
      ▼
routes/web.php
  GET  /moora          → MooraController@index
  POST /moora/calculate → MooraController@calculate
      │
      ▼
[1] MooraController@index()
      ├── Criteria::with('scales')->get()         ← Model Criteria
      ├── Internship::where('user_id', Auth::id())← Model Internship
      ├── Auth::user()->weights->pluck(...)        ← Model UserCriteriaWeight
      └── return view('moora.index', ...)
              └── resources/views/moora/index.blade.php
                        (Form: pilih kriteria, bobot, perusahaan, nilai)

[2] User Submit Form → POST /moora/calculate
      │
      ▼
[3] MooraController@calculate()
      │
      ├── Validasi Input (total bobot harus = 100%)
      │
      ├── UserCriteriaWeight::updateOrCreate(...)  ← Simpan preferensi bobot user
      │
      ├── Siapkan array $mooraAlternatives & $mooraCriteria
      │
      ├── MooraService::calculate($alternatives, $criteria)
      │         └── app/Services/MooraService.php
      │               [a] Buat Decision Matrix
      │               [b] Normalisasi: x / sqrt(Σx²)
      │               [c] Pembobotan: normalized × (weight/100)
      │               [d] Yi = Σ(Benefit) - Σ(Cost)
      │               [e] Ranking (sort descending by Yi)
      │               [f] Return array hasil ranking
      │
      ├── MooraSession::create(...)                ← Simpan sesi ke DB
      │         (winner_name, max_optimization_value, criteria_used sebagai JSON)
      │
      ├── InternshipEvaluation::create(...)        ← Simpan setiap skor per kriteria
      │         (loop: setiap internship × setiap kriteria)
      │
      └── return view('moora.results', compact('results', 'criterias'))
                └── resources/views/moora/results.blade.php
                          (Tampilkan tabel ranking, skor, normalisasi)
```

### 3B. Alur Perhitungan MOORA — Dari Flutter Android App

> **Skenario:** User Flutter mengirim POST `/api/calculate` dengan Bearer Token.

```
[Flutter App]
      │  POST /api/calculate
      │  Header: Authorization: Bearer {token}
      │  Body: { criteria, weights, internships, scores }
      │
      ▼
routes/api.php
  Middleware: auth:sanctum  ← Verifikasi token di tabel personal_access_tokens
      │
      ▼
[1] MooraApiController@calculate()
      │
      ├── Validasi Input (lebih ketat dari versi web)
      │     - criteria.*  → exists di tabel criterias
      │     - internships.* → harus milik user yang login
      │     - scores.*.*  → integer 1-5
      │
      ├── Validasi total bobot = 100%
      │
      ├── UserCriteriaWeight::updateOrCreate(...)   ← Simpan bobot
      │
      ├── Siapkan $mooraAlternatives & $mooraCriteria
      │
      ├── MooraService::calculate(...)              ← SAMA persis dengan versi web!
      │         └── app/Services/MooraService.php   (satu service, dua consumer)
      │
      ├── MooraSession::create(...)                 ← Simpan sesi
      │
      └── return response()->json([
                'success' => true,
                'data' => $results,        ← Array ranking MOORA
                'criterias' => $criteriaModels  ← Untuk label radar chart di Flutter
            ])
```

> [!IMPORTANT]
> **Key Insight:** `MooraService.php` adalah satu-satunya file yang berisi algoritma MOORA murni. Baik web browser maupun Flutter menggunakan **service yang sama persis** — ini adalah prinsip **DRY (Don't Repeat Yourself)**.

---

## 4. 🗺️ Peta Komunikasi Antar File (Per Fitur)

### Autentikasi (Web)
```
routes/auth.php → Auth\AuthenticatedSessionController → resources/views/auth/
```

### Autentikasi (Flutter/API)
```
routes/api.php → Api\AuthApiController → Models\User → personal_access_tokens
```

### Manajemen Perusahaan (User Web)
```
routes/web.php → InternshipController → Models\Internship, Category
              → resources/views/internships/
```

### Manajemen Perusahaan (Flutter API)
```
routes/api.php → Api\InternshipApiController → Models\Internship → JSON Response
```

### Admin Panel
```
routes/web.php [prefix: /admin, middleware: admin]
  → Admin\AdminDashboardController  → resources/views/admin/dashboard.blade.php
  → Admin\CriteriaController        → resources/views/admin/criterias/
  → Admin\CategoryController        → resources/views/admin/categories/
  → Admin\UserController            → resources/views/admin/users/
  → Admin\ExportController          → StreamedResponse (CSV download)
  → ActivityLogController           → resources/views/admin/logs/
```

### Activity Logging (Audit Trail)
```
(Dipanggil secara manual dari Controller)
  ActivityLogServiceProvider::log($action, $module, $description)
    → Models\ActivityLog::create(...)
```

---

## 5. 💡 Insight untuk Standar Industri

### 5.1 Service Layer Pattern ⭐

**Apa itu?** Logika bisnis yang kompleks dipisahkan ke folder `app/Services/`.

```
❌ Anti-pattern (semua di Controller):
   MooraController::calculate() { /* 300 baris algoritma */ }

✅ Pattern yang dipakai di project ini:
   MooraController::calculate() { $this->mooraService->calculate(...) }
   MooraService::calculate() { /* algoritma MOORA */ }
```

**Kenapa penting?** Karena `MooraApiController` (untuk Flutter) juga bisa memakai `MooraService` yang sama tanpa copy-paste kode. Di industri, ini mengurangi bug secara drastis.

---

### 5.2 Dual Interface: Web + REST API

Project ini melayani **dua jenis klien** dari satu codebase Laravel:

```
                    ┌─────────────────┐
                    │   Laravel App   │
                    └────────┬────────┘
                             │
               ┌─────────────┴────────────┐
               ▼                          ▼
     routes/web.php                 routes/api.php
   (Blade Template)               (JSON Response)
          │                              │
          ▼                              ▼
   Web Browser                    Flutter Android
```

- **Web:** Controller → `return view('...')` — mengembalikan HTML
- **API:** Controller → `return response()->json(...)` — mengembalikan JSON

Ini adalah arsitektur yang sangat umum di industri untuk startup yang punya web app dan mobile app sekaligus.

---

### 5.3 Role-Based Access Control (RBAC)

Project menggunakan sistem role sederhana dengan **2 peran**:

| Role | Akses |
|---|---|
| `user` | Dashboard, MOORA, Internship milik sendiri, Profile |
| `admin` | Semua akses user + Admin panel (kelola criteria, categories, users, export) |

Implementasinya via:
- **Middleware** `AdminMiddleware` — dicek di `app/Http/Middleware/AdminMiddleware.php`
- **Route Group** — `Route::middleware(['auth', 'admin'])->prefix('admin')`
- **Model method** `User::isAdmin()` — helper untuk cek role di Blade/Controller

---

### 5.4 API Token Authentication (Laravel Sanctum)

Untuk Flutter, setiap request harus membawa **Bearer Token**:

```
Flutter Login → POST /api/login
  ← Response: { "token": "1|abcxyz..." }

Flutter Request lain → GET /api/internships
  Header: Authorization: Bearer 1|abcxyz...
  ← Laravel verifikasi token di tabel personal_access_tokens
```

Token disimpan di device Flutter (SharedPreferences/SecureStorage) dan dikirim setiap request. Ini adalah standar industry untuk **Stateless API Authentication**.

---

### 5.5 Soft Deletes

Tabel `internships` menggunakan **Soft Delete** (`deleted_at`):

```php
// Model pakai trait SoftDeletes
class Internship extends Model {
    use SoftDeletes;
}
```

Artinya saat data dihapus, tidak langsung hilang dari database — hanya kolom `deleted_at` yang diisi. Query normal otomatis mengecualikan data terhapus. Ini penting untuk **audit trail** dan kemampuan restore data di industri.

---

### 5.6 JSON Cast di Model (criteria_used)

```php
// MooraSession.php
protected $casts = [
    'criteria_used' => 'array',  // Simpan sebagai JSON di DB, baca sebagai array PHP
];
```

Kolom `criteria_used` menyimpan kriteria yang dipilih dalam format JSON di database. Laravel otomatis serialize/deserialize. Ini adalah teknik umum untuk menyimpan **data semi-terstruktur** tanpa harus membuat tabel relasi baru.

---

### 5.7 Eager Loading (N+1 Problem Prevention)

```php
// ❌ N+1 Problem (1 query untuk session + N query untuk setiap evaluations)
$sessions = MooraSession::all();
foreach ($sessions as $s) {
    echo $s->evaluations; // Query baru setiap iterasi!
}

// ✅ Eager Loading yang dipakai di project ini (hanya 2 query total)
MooraSession::with(['evaluations.internship.category', 'evaluations.criteria'])
```

Di industri, N+1 problem adalah penyebab aplikasi jadi lambat. Selalu gunakan `with()` untuk relasi.

---

### 5.8 Form Request Validation

Project menggunakan `$request->validate([...])` langsung di controller. Di industri level menengah-atas, ini biasanya dipisah ke **Form Request class** (`app/Http/Requests/`):

```php
// app/Http/Requests/StoreMooraRequest.php
class StoreMooraRequest extends FormRequest {
    public function rules() {
        return [
            'criteria' => 'required|array|min:3',
            // ...
        ];
    }
}
```

Project ini belum menggunakan ini sepenuhnya — tapi strukturnya sudah ada di folder `app/Http/Requests/`. Ini adalah area yang bisa kamu tingkatkan.

---

### 5.9 Activity Log / Audit Trail

```php
// Dipanggil di berbagai controller setelah aksi penting
ActivityLogServiceProvider::log('Deleted', 'MOORA', "Menghapus riwayat: {$name}.");
```

Di industri, audit trail sangat penting terutama untuk aplikasi yang menyimpan data sensitif. Setiap aksi user tersimpan di tabel `activity_logs` beserta IP address-nya.

---

### 5.10 CSV Export tanpa Library Eksternal

```php
// ExportController.php menggunakan StreamedResponse bawaan PHP
$response = new StreamedResponse(function () use ($headers, $data) {
    $handle = fopen('php://output', 'w');
    fputcsv($handle, $headers);
    // ...
});
```

Banyak project menggunakan library seperti `maatwebsite/excel` untuk export. Project ini membuktikan bahwa untuk kebutuhan sederhana, **native PHP sudah cukup** dan tidak perlu dependensi tambahan.

---

## 6. 🚨 Hal yang Perlu Diperhatikan / Potensi Improvement

> [!WARNING]
> **Inkonsistensi `criteria_used`:** Di `MooraController` (web), kolom `criteria_used` disimpan sebagai `{ id: weight }` (associative array). Di `MooraApiController` (Flutter), disimpan sebagai `[id1, id2, ...]` (indexed array). Ini sudah dihandle dengan pengecekan `isAssociative` di history, tapi bisa jadi sumber bug jika tidak hati-hati.

> [!NOTE]
> **Tidak ada Rate Limiting di API:** Route API tidak menggunakan middleware `throttle:`. Di industri, ini wajib ada untuk mencegah abuse/spam request dari client.

> [!TIP]
> **Area untuk Upgrade:**
> - Pisahkan validasi ke `FormRequest` classes di `app/Http/Requests/`
> - Tambahkan API Resources (`app/Http/Resources/`) untuk format JSON response yang konsisten
> - Tambahkan middleware `throttle:60,1` di `routes/api.php`
> - Pertimbangkan menambahkan `app/Repositories/` jika query DB makin kompleks

---

## 7. 📁 Struktur Folder Ringkas

```
SPK-Tempat-Magang-Web-APP/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/          ← Controller khusus Flutter (return JSON)
│   │   │   ├── Admin/        ← Controller khusus admin panel
│   │   │   ├── Auth/         ← Controller autentikasi web (Breeze)
│   │   │   ├── MooraController.php       ← MOORA untuk web
│   │   │   ├── InternshipController.php  ← CRUD internship user
│   │   │   └── DashboardController.php   ← Dashboard user
│   │   └── Middleware/
│   │       └── AdminMiddleware.php       ← Guard admin route
│   ├── Models/               ← Representasi tabel database (Eloquent)
│   ├── Providers/
│   │   └── ActivityLogServiceProvider.php ← Logging system
│   └── Services/
│       └── MooraService.php  ← ⭐ Inti algoritma MOORA (murni logika)
│
├── database/
│   ├── migrations/           ← Riwayat perubahan skema database (25 file!)
│   └── seeders/              ← Data awal (criteria, categories, dll.)
│
├── resources/
│   └── views/                ← Template HTML (Blade)
│       ├── admin/            ← Tampilan panel admin
│       ├── moora/            ← Form & hasil perhitungan MOORA
│       ├── internships/      ← Manajemen perusahaan
│       └── layouts/          ← Template dasar (header, sidebar)
│
├── routes/
│   ├── api.php               ← Endpoint untuk Flutter (/api/...)
│   ├── web.php               ← Endpoint untuk browser
│   └── auth.php              ← Endpoint autentikasi web
│
└── .env                      ← Konfigurasi sensitif (DB, mail, Google OAuth)
```

---

*Dokumen ini dibuat otomatis berdasarkan analisis kode sumber project. Diperiksa pada: 29 Juni 2026.*
