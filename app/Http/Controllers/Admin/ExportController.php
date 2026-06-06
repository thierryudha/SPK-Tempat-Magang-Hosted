<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Internship;
use App\Models\MooraSession;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function exportUsers()
    {
        $users = User::where('role', 'user')->latest()->get();
        $filename = "mahasiswa_" . date('Ymd_His') . ".csv";

        return $this->generateCsv($filename, ['Nama', 'Email', 'Terdaftar Pada'], $users->map(fn($u) => [
            $u->name,
            $u->email,
            $u->created_at->format('Y-m-d H:i:s')
        ]));
    }

    public function exportInternships()
    {
        $internships = Internship::with('category')->whereNull('user_id')->get();
        $filename = "perusahaan_global_" . date('Ymd_His') . ".csv";

        return $this->generateCsv($filename, ['Nama Perusahaan', 'Bidang', 'Website'], $internships->map(fn($i) => [
            $i->name,
            $i->category->name ?? 'Umum',
            $i->website_link
        ]));
    }

    public function exportSessions()
    {
        $sessions = MooraSession::with('user')->latest()->get();
        $filename = "hasil_perhitungan_" . date('Ymd_His') . ".csv";

        return $this->generateCsv($filename, ['Waktu', 'Mahasiswa', 'Pemenang', 'Skor Akhir'], $sessions->map(fn($s) => [
            $s->created_at->format('Y-m-d H:i:s'),
            $s->user->name,
            $s->winner_name,
            $s->max_optimization_value
        ]));
    }

    private function generateCsv($filename, $headers, $data)
    {
        $response = new StreamedResponse(function () use ($headers, $data) {
            $handle = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($handle, $headers);

            foreach ($data as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
}
