<x-app-layout>
    <style>
        /* Force Global Font */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        :root { --font-main: 'Plus Jakarta Sans', sans-serif; }
        * { font-family: var(--font-main) !important; }

        /* Header styling remains local */
        .page-header { margin-bottom: 28px; }
        .page-title { font-size: 26px; font-weight: 800; color: #0F172A; letter-spacing: -0.5px; margin-bottom: 4px; }
        .page-subtitle { font-size: 14px; color: #64748B; font-weight: 500; }

        /* Welcome banner */
        .welcome-banner {
            background: linear-gradient(135deg, #1E40AF 0%, #2563EB 60%, #3B82F6 100%);
            border-radius: 16px;
            padding: 28px 32px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            overflow: hidden;
            position: relative;
        }
        .welcome-banner::after {
            content: '';
            position: absolute;
            right: -40px; top: -40px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        .welcome-text h2 { font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
        .welcome-text p { font-size: 13px; color: rgba(255,255,255,0.75); font-weight: 500; }
        .welcome-actions { display: flex; gap: 10px; position: relative; z-index: 1; }
        
        .btn-white {
            height: 38px; padding: 0 18px;
            background: #fff; color: #1E40AF;
            border: none; border-radius: 10px;
            font-size: 13px; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; gap: 6px;
            transition: all 0.12s; text-decoration: none;
        }
        .btn-white:hover { background: #EFF6FF; }
        
        .btn-outline-white {
            height: 38px; padding: 0 18px;
            background: rgba(255,255,255,0.12); color: #fff;
            border: 1px solid rgba(255,255,255,0.3); border-radius: 10px;
            font-size: 13px; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; gap: 6px;
            transition: all 0.12s; text-decoration: none;
        }
        .btn-outline-white:hover { background: rgba(255,255,255,0.2); }

        /* Stats row */
        .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
        .stat-card {
            background: #fff;
            border: 0.5px solid #E2E8F0;
            border-radius: 14px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .stat-icon.blue { background: #EFF6FF; color: #2563EB; }
        .stat-icon.green { background: #F0FDF4; color: #16A34A; }
        .stat-icon.amber { background: #FFFBEB; color: #D97706; }
        .stat-icon.purple { background: #F5F3FF; color: #7C3AED; }
        .stat-label { font-size: 11px; color: #94A3B8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; }
        .stat-value { font-size: 22px; font-weight: 800; color: #0F172A; letter-spacing: -0.5px; }

        /* Body grid */
        .body-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; margin-bottom: 24px; }

        /* Panel */
        .panel {
            background: #fff;
            border: 0.5px solid #E2E8F0;
            border-radius: 16px;
            overflow: hidden;
        }
        .panel-header {
            padding: 12px 24px;
            border-bottom: 0.5px solid #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .panel-title { font-size: 15px; font-weight: 700; color: #0F172A; }
        .panel-subtitle { font-size: 12px; color: #94A3B8; margin-top: 2px; }
        .panel-link { font-size: 12px; font-weight: 600; color: #2563EB; text-decoration: none; display: flex; align-items: center; gap: 4px; }
        .panel-link:hover { color: #1D4ED8; }

        /* Session Item (Synced with History Page) */
        .history-list { padding: 0; }
        .history-item {
            padding: 18px 24px;
            border-bottom: 0.5px solid #F8FAFC;
            cursor: pointer;
            transition: background 0.12s;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            text-decoration: none;
            color: inherit;
        }
        .history-item:hover { background: #FAFBFC; }
        .history-item:last-child { border-bottom: none; }

        .item-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: #EFF6FF;
            display: flex; align-items: center; justify-content: center;
            color: #2563EB; font-size: 18px;
            flex-shrink: 0; margin-top: 2px;
        }

        .item-body { flex: 1; min-width: 0; }
        .item-title { font-size: 14px; font-weight: 700; color: #0F172A; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .item-meta { font-size: 12px; color: #94A3B8; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .meta-dot { width: 3px; height: 3px; border-radius: 50%; background: #CBD5E1; }

        .item-right { display: flex; flex-direction: column; align-items: flex-end; gap: 6px; flex-shrink: 0; }
        .score-badge {
            font-size: 13px; font-weight: 800; color: #1D4ED8;
            background: #DBEAFE; border-radius: 8px;
            padding: 3px 10px; letter-spacing: -0.3px;
        }
        .rank-pill {
            font-size: 11px; font-weight: 700;
            padding: 2px 8px; border-radius: 6px;
            display: flex; align-items: center; gap: 4px;
            background: #FEF9C3; color: #A16207;
        }

        .criteria-tags { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 6px; }
        .criteria-tag {
            font-size: 10px; font-weight: 600;
            background: #F1F5F9; color: #64748B;
            padding: 2px 8px; border-radius: 5px;
        }

        /* Sidebar Panels */
        .sidebar { display: flex; flex-direction: column; gap: 16px; }

        /* Quick actions */
        .quick-actions { padding: 16px 20px; display: flex; flex-direction: column; gap: 8px; }
        .qa-btn {
            height: 38px; border-radius: 10px;
            border: none; font-size: 13px; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; gap: 8px;
            padding: 0 16px; width: 100%;
            transition: all 0.12s; text-decoration: none;
            justify-content: center;
        }
        .qa-primary { background: #2563EB; color: #fff; }
        .qa-primary:hover { background: #1D4ED8; }
        .qa-secondary { background: #F1F5F9; color: #334155; border: 1px solid #E2E8F0; }
        .qa-secondary:hover { background: #E2E8F0; }

        /* Kriteria bar chart */
        .criteria-list { padding: 12px 24px 16px; }
        .criteria-bar-row { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .crit-name { font-size: 12px; font-weight: 600; color: #475569; width: 110px; flex-shrink: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .crit-track { flex: 1; height: 6px; background: #F1F5F9; border-radius: 3px; overflow: hidden; }
        .crit-fill { height: 100%; border-radius: 3px; background: #2563EB; transition: width 0.6s ease; }
        .crit-pct { font-size: 11px; font-weight: 700; color: #64748B; width: 30px; text-align: right; }

        /* Tips Section */
        .tips-scroll {
            height: 350px;
            overflow: hidden;
            padding: 20px 24px;
        }
        
        .tip-item { margin-bottom: 20px; display: flex; gap: 12px; }
        .tip-num {
            width: 20px; height: 20px; border-radius: 50%; background: #EFF6FF;
            color: #2563EB; font-size: 11px; font-weight: 800;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .tip-content h4 { font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 4px; }
        .tip-content p { font-size: 12px; color: #64748B; line-height: 1.5; }

        @media (max-width: 900px) {
            .body-grid { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: repeat(2, 1fr); }
            .sidebar { display: flex; flex-direction: column; }
        }
    </style>

    <!-- Breadcrumbs Component Only -->
    <x-breadcrumbs :links="[]" />

    <!-- Header -->
    <div class="page-header mt-6">
        <h1 class="page-title">Selamat datang, {{ Auth::user()->name }}! 👋</h1>
        <p class="page-subtitle">Pantau progres analisis dan pilihan magang kamu di sini</p>
    </div>

    <!-- Welcome banner -->
    <div class="welcome-banner">
        <div class="welcome-text">
            <h2>Mulai analisis MOORA baru</h2>
            <p>Bandingkan tempat magang favoritmu secara objektif berdasarkan kriteria yang kamu tentukan sendiri</p>
        </div>
        <div class="welcome-actions">
            <a href="{{ route('moora.index') }}" class="btn-white">
                <i class="ti ti-chart-bar"></i>
                Mulai Analisis
            </a>
            <a href="{{ route('internships.index') }}" class="btn-outline-white">
                <i class="ti ti-building"></i>
                Lihat Tempat Magang
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="ti ti-chart-bar"></i></div>
            <div>
                <div class="stat-label">Total Sesi MOORA</div>
                <div class="stat-value">{{ $totalSessions }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="ti ti-trophy"></i></div>
            <div>
                <div class="stat-label">Rekomendasi Terakhir</div>
                <div class="stat-value" style="font-size:14px;letter-spacing:-0.2px;">{{ $bestInternshipData->name ?? 'Belum Ada' }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="ti ti-building"></i></div>
            <div>
                <div class="stat-label">Magang Tersedia</div>
                <div class="stat-value">{{ $totalInternships }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple"><i class="ti ti-clock"></i></div>
            <div>
                <div class="stat-label">Sesi Terakhir</div>
                <div class="stat-value" style="font-size:14px;">{{ $latestSessions->first() ? $latestSessions->first()->created_at->diffForHumans() : '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Body grid -->
    <div class="body-grid">
        <!-- Main Content -->
        <div style="display:flex;flex-direction:column;gap:20px;">
            
            <!-- SECTION: Analisis MOORA (Radar Chart with Wide Layout) -->
            <div class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Analisis MOORA Personal</div>
                        <div class="panel-subtitle">Visualisasi performa kriteria untuk rekomendasi terbaikmu</div>
                    </div>
                </div>
                <!-- Content Area: Tightened gap and py-0 -->
                <div class="pt-4 pb-2 px-8 flex flex-col lg:flex-row gap-6 items-center">
                    <!-- Text Info Pane (Narrower) -->
                    <div style="flex: 0 0 320px;">
                        <h3 class="text-2xl font-bold text-slate-900 mb-1">
                            {{ $bestInternshipData->name ?? 'Mulai Analisis' }}
                        </h3>
                        @if($bestInternshipData)
                            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-3">{{ $bestInternshipData->category }}</p>
                        @endif
                        <p class="text-slate-500 text-xs mb-6 leading-relaxed">Profil ini dirangkum berdasarkan preferensi bobot unik Anda terhadap {{ $criterias->count() }} kriteria penilaian profesional.</p>
                        
                        <div class="flex flex-wrap gap-3">
                            <div class="px-5 py-3 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-[8px] text-slate-400 font-bold uppercase tracking-widest mb-1">Evaluasi</p>
                                <div class="flex items-end gap-1.5">
                                    <span class="text-lg font-bold text-slate-800">{{ $evaluationsCount }}</span>
                                    <span class="text-[8px] text-slate-400 font-bold mb-1 uppercase">PT</span>
                                </div>
                            </div>
                            <div class="px-5 py-3 bg-blue-50 rounded-xl border border-blue-100">
                                <p class="text-[8px] text-blue-600 font-bold uppercase tracking-widest mb-1">Yi Skor</p>
                                <div class="flex items-end gap-1.5">
                                    <span class="text-lg font-bold text-blue-600">{{ $bestInternshipData ? number_format($bestInternshipData->optimization_value, 4) : '0.0000' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Chart Pane (Compact) -->
                    <div class="flex-1 w-full h-[280px] bg-white relative">

                        @if($bestInternshipData)
                            <canvas id="personalRadarChart"></canvas>
                        @else
                            <div class="h-full w-full flex items-center justify-center text-center p-6 italic text-slate-300 text-xs bg-slate-50 rounded-2xl border border-slate-100">Jalankan program MOORA <br> untuk melihat grafik radar.</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sesi terbaru -->
            <div class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Sesi MOORA Terbaru</div>
                        <div class="panel-subtitle">Maksimal 5 sesi analisis terakhir kamu</div>
                    </div>
                    <a href="{{ route('moora.history') }}" class="panel-link">Lihat semua <i class="ti ti-chevron-right"></i></a>
                </div>

                <div class="history-list">
                    @forelse($latestSessions as $session)
                        @php
                            $evals = $session->evaluations;
                            $firstEval = $evals->first();
                            $altCount = $evals->isNotEmpty() ? $evals->groupBy('internship_id')->count() : 0;
                            $category = ($firstEval && $firstEval->internship && $firstEval->internship->category) 
                                ? $firstEval->internship->category->name 
                                : 'Umum';
                        @endphp
                        <a href="{{ route('moora.history') }}" class="history-item">
                            <div class="item-icon"><i class="ti ti-chart-bar"></i></div>
                            <div class="item-body">
                                <div class="item-title">{{ $session->winner_name }}</div>
                                <div class="item-meta">
                                    <span><i class="ti ti-calendar" style="font-size:11px;vertical-align:-1px;margin-right:3px"></i>{{ $session->created_at->format('j M Y') }}</span>
                                    <span class="meta-dot"></span>
                                    <span>{{ $session->created_at->format('H:i') }}</span>
                                    <span class="meta-dot"></span>
                                    <span>{{ $altCount }} perusahaan</span>
                                    <span class="meta-dot"></span>
                                    <span>{{ count($session->criteria_used) }} kriteria</span>
                                </div>
                                <div class="criteria-tags">
                                    <span class="criteria-tag">{{ $category }}</span>
                                </div>
                            </div>
                            <div class="item-right">
                                <div class="score-badge">{{ number_format($session->max_optimization_value, 4) }}</div>
                                <div class="rank-pill">🥇 Winner</div>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center text-slate-400">Belum ada sesi MOORA.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Quick Actions -->
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Aksi Cepat</div>
                </div>
                <div class="quick-actions">
                    <a href="{{ route('moora.index') }}" class="qa-btn qa-primary">
                        <i class="ti ti-plus"></i>
                        Analisis MOORA Baru
                    </a>
                    <a href="{{ route('internships.create') }}" class="qa-btn qa-secondary">
                        <i class="ti ti-building-plus"></i>
                        Tambah Tempat Magang
                    </a>
                    <a href="{{ route('moora.history') }}" class="qa-btn qa-secondary">
                        <i class="ti ti-history"></i>
                        Lihat Riwayat Lengkap
                    </a>
                </div>
            </div>

            <!-- Kriteria paling sering digunakan -->
            <div class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Kriteria Populer</div>
                        <div class="panel-subtitle">Sering kamu gunakan</div>
                    </div>
                </div>
                <div class="criteria-list">
                    @forelse($popularCriteria as $crit)
                        <div class="criteria-bar-row">
                            <div class="crit-name">{{ $crit->name }}</div>
                            <div class="crit-track"><div class="crit-fill" style="width:{{ $crit->percentage }}%"></div></div>
                            <div class="crit-pct">{{ $crit->percentage }}%</div>
                        </div>
                    @empty
                        <div class="text-center text-slate-400 py-4 text-xs">Data belum tersedia.</div>
                    @endforelse
                </div>
            </div>

            <!-- Tips & Cara Penggunaan -->
            <div class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Tips & Panduan</div>
                        <div class="panel-subtitle">Cara menggunakan MOORA</div>
                    </div>
                </div>
                <div class="tips-scroll">
                    <div class="tip-item">
                        <div class="tip-num">1</div>
                        <div class="tip-content">
                            <h4>Simpan Perusahaan</h4>
                            <p>Daftarkan tempat magang yang ingin kamu bandingkan di menu <strong>Tempat Magang</strong>.</p>
                        </div>
                    </div>
                    <div class="tip-item">
                        <div class="tip-num">2</div>
                        <div class="tip-content">
                            <h4>Atur Kriteria</h4>
                            <p>Tentukan hal apa yang paling penting buatmu (gaji, jarak, dll) di <strong>Program MOORA</strong>.</p>
                        </div>
                    </div>
                    <div class="tip-item">
                        <div class="tip-num">3</div>
                        <div class="tip-content">
                            <h4>Gunakan Fitur Lock</h4>
                            <p>Kunci bobot kriteria tertentu agar sistem hanya menyeimbangkan sisa kriteria lainnya.</p>
                        </div>
                    </div>
                    <div class="tip-item">
                        <div class="tip-num">4</div>
                        <div class="tip-content">
                            <h4>Beri Penilaian</h4>
                            <p>Isi skor objektif untuk tiap perusahaan. Sistem akan menghitung otomatis untukmu.</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t border-slate-50 bg-slate-50/30">
                    <p class="text-center text-[9px] font-bold text-slate-400 uppercase tracking-widest italic">Pusat Bantuan & Panduan</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            Chart.defaults.color = '#94A3B8';

            @if($bestInternshipData)
            new Chart(document.getElementById('personalRadarChart'), {
                type: 'radar',
                data: {
                    labels: {!! json_encode($personalChartData['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($personalChartData['values']) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: '#3b82f6',
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { 
                        r: { 
                            min: 0, 
                            max: 5, 
                            ticks: { display: false, stepSize: 1 },
                            grid: { color: '#E2E8F0', lineWidth: 1 },
                            angleLines: { color: '#E2E8F0', lineWidth: 1 },
                            pointLabels: { 
                                font: { size: 9, weight: 'bold' }, 
                                color: '#64748B',
                                padding: 5
                            }
                        } 
                    }
                }
            });
            @endif
        });
    </script>
</x-app-layout>
