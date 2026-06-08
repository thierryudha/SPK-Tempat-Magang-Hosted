<x-app-layout>
    <style>
        /* Header */
        .page-header { margin-bottom: 28px; display: flex; justify-content: space-between; align-items: flex-end; }
        .page-title { font-size: 26px; font-weight: 800; color: #0F172A; letter-spacing: -0.5px; margin-bottom: 4px; }
        .page-subtitle { font-size: 14px; color: #64748B; font-weight: 500; }

        /* Panel */
        .panel {
            background: #fff;
            border: 0.5px solid #E2E8F0;
            border-radius: 16px;
            overflow: hidden;
        }
        .panel-header {
            padding: 20px 24px;
            border-bottom: 0.5px solid #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .panel-title { font-size: 15px; font-weight: 700; color: #0F172A; }
        
        /* Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { 
            padding: 12px 24px; text-align: left; 
            font-size: 11px; font-weight: 700; color: #94A3B8; 
            text-transform: uppercase; letter-spacing: 0.05em;
            border-bottom: 1px solid #F1F5F9;
            background: #FAFBFC;
        }
        .data-table td { 
            padding: 16px 24px; 
            font-size: 14px; color: #334155; 
            border-bottom: 1px solid #F8FAFC;
        }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover td { background: #FAFBFC; }

        /* Badges */
        .badge {
            display: inline-flex; align-items: center;
            font-size: 11px; font-weight: 700;
            padding: 2px 10px; border-radius: 6px;
        }
        .badge-blue { background: #EFF6FF; color: #2563EB; }

        /* Buttons */
        .action-btn {
            height: 34px; padding: 0 14px;
            border-radius: 8px; border: none;
            font-size: 12px; font-weight: 700;
            cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
            transition: all 0.12s; text-decoration: none;
        }
        .btn-primary { background: #2563EB; color: #fff; height: 38px; border-radius: 10px; font-size: 13px; }
        .btn-primary:hover { background: #1D4ED8; }
        .btn-secondary { background: #F1F5F9; color: #334155; border: 1px solid #E2E8F0; }
        .btn-secondary:hover { background: #E2E8F0; }
        .btn-danger { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .btn-danger:hover { background: #FEE2E2; }

        /* Mobile Cards */
        .mobile-cards { display: none; flex-direction: column; gap: 12px; padding: 16px; }
        .mobile-card {
            background: #fff; border: 0.5px solid #E2E8F0; border-radius: 14px; padding: 16px;
        }

        @media (max-width: 768px) {
            .desktop-table { display: none; }
            .mobile-cards { display: flex; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
        }
    </style>

    <!-- Breadcrumbs Fixed -->
    <x-breadcrumbs :links="[['label' => 'Daftar Tempat Magang']]" />

    <div class="page-header mt-6">
        <div>
            <div class="page-title">Daftar Tempat Magang</div>
            <div class="page-subtitle">Kelola daftar perusahaan yang ingin kamu bandingkan</div>
        </div>
        <a href="{{ route('internships.create') }}" class="action-btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Perusahaan
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 text-sm font-bold rounded-xl flex items-center gap-3">
            <i class="ti ti-circle-check text-lg"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">Perusahaan Tersimpan</div>
        </div>

        @if($internships->isEmpty())
            <div class="py-20 text-center">
                <i class="ti ti-building-community text-5xl text-slate-200 mb-4"></i>
                <p class="text-slate-400 font-bold">Belum ada data perusahaan.</p>
                <p class="text-xs text-slate-300 mt-1">Tambahkan perusahaan untuk mulai menggunakan MOORA.</p>
            </div>
        @else
            <!-- Desktop Table -->
            <div class="desktop-table">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Perusahaan</th>
                            <th>Bidang / Kategori</th>
                            <th>Link Website</th>
                            <th style="text-align:right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($internships as $internship)
                            <tr>
                                <td class="font-bold text-slate-900">{{ $internship->name }}</td>
                                <td>
                                    <span class="badge badge-blue">{{ $internship->category->name ?? 'Umum' }}</span>
                                </td>
                                <td>
                                    @if($internship->website_link)
                                        <a href="{{ $internship->website_link }}" target="_blank" class="text-blue-600 font-bold hover:underline flex items-center gap-1">
                                            <i class="ti ti-external-link"></i>
                                            Kunjungi
                                        </a>
                                    @else
                                        <span class="text-slate-300 italic text-xs">Tidak ada link</span>
                                    @endif
                                </td>
                                <td style="text-align:right">
                                    <div style="display:inline-flex; gap:8px;">
                                        <a href="{{ route('internships.edit', $internship) }}" class="action-btn btn-secondary">
                                            <i class="ti ti-edit"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('internships.destroy', $internship) }}" method="POST" onsubmit="return confirm('Hapus perusahaan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-danger">
                                                <i class="ti ti-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="mobile-cards">
                @foreach($internships as $internship)
                    <div class="mobile-card">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                            <div>
                                <div class="font-bold text-slate-900">{{ $internship->name }}</div>
                                <div class="mt-1"><span class="badge badge-blue">{{ $internship->category->name ?? 'Umum' }}</span></div>
                            </div>
                            @if($internship->website_link)
                                <a href="{{ $internship->website_link }}" target="_blank" class="text-blue-600 font-bold"><i class="ti ti-external-link"></i></a>
                            @endif
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; border-top:1px solid #F8FAFC; padding-top:12px; margin-top:12px;">
                            <a href="{{ route('internships.edit', $internship) }}" class="action-btn btn-secondary" style="width:100%">Edit</a>
                            <form action="{{ route('internships.destroy', $internship) }}" method="POST" style="width:100%">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-danger" style="width:100%">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
