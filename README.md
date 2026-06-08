# MooraProject - SPK Penentuan Tempat Magang

[![Laravel](https://img.shields.io/badge/Laravel-12.6-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)

**MooraProject** adalah aplikasi Sistem Pendukung Keputusan (SPK) berbasis web yang dirancang untuk membantu mahasiswa menentukan tempat magang terbaik secara objektif menggunakan metode **MOORA (Multi-Objective Optimization on the basis of Ratio Analysis)**.

## 🚀 Fitur Utama

- **Analisis MOORA:** Perhitungan ranking otomatis berdasarkan 10 kriteria profesional (Uang Saku, Budaya Perusahaan, Fasilitas, dll).
- **Dashboard Interaktif:** Visualisasi tren pertumbuhan pengguna, distribusi industri, dan benchmark sektor unggulan menggunakan Chart.js.
- **Mobile Optimized:** Navigasi bawah (Bottom Navigation) yang intuitif untuk pengalaman layaknya aplikasi mobile asli.
- **Smart Weight Balancer:** Fitur untuk mengatur bobot kriteria secara otomatis agar total selalu 100%.
- **Manajemen Tempat Magang:** Fitur CRUD lengkap untuk mengelola daftar tempat magang pribadi.

## 🛠️ Teknologi yang Digunakan

- **Backend:** Laravel 12.x (PHP 8.2+)
- **Frontend:** Tailwind CSS, Alpine.js, Blade Templating
- **Database:** SQLite (Default) / MySQL
- **Charts:** Chart.js
- **Icons:** Heroicons

## 📦 Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di komputer lokal Anda:

1. **Clone Repository**
   ```bash
   git clone https://github.com/Soel-c/SPK-Tempat-Magang-Web-APP.git
   cd SPK-Tempat-Magang-Web-APP
   ```

2. **Instal Dependensi (Composer & NPM)**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Lingkungan**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```

4. **Generate App Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi dan Seeding**
   Jalankan migrasi database beserta data dummy (20 user profesional siap pakai):
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Build Aset Frontend**
   ```bash
   npm run build
   ```

7. **Jalankan Server**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di `http://127.0.0.1:8000`

## 👤 Akun Demo
Setelah menjalankan seeder, Anda dapat mencoba login dengan salah satu akun berikut:
- **Email:** `siti.aminah@example.com`
- **Password:** `password123`

---

Dibuat dengan ❤️ untuk membantu mahasiswa menentukan masa depan karir yang lebih baik.
