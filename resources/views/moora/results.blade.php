<x-app-layout>
    <style>
        /* Typography & Header */
        .page-title { font-size: 26px; font-weight: 800; color: #0F172A; letter-spacing: -0.5px; margin-bottom: 4px; }
        .page-subtitle { font-size: 14px; color: #64748B; font-weight: 500; }

        /* Stepper Style */
        .wizard-stepper { display: flex; justify-content: space-between; items: center; max-width: 700px; margin: 0 auto 48px; position: relative; }
        .wizard-step { display: flex; flex-direction: column; align-items: center; position: relative; z-index: 10; width: 120px; }
        .wizard-circle { 
            width: 44px; height: 44px; border-radius: 50%; background: #fff; border: 2px solid #E2E8F0;
            display: flex; align-items: center; justify-content: center; font-weight: 800; color: #94A3B8;
            transition: all 0.5s;
        }
        .wizard-step.active .wizard-circle, .wizard-step.completed .wizard-circle { background: #2563EB; border-color: #2563EB; color: #fff; box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2); }
        .wizard-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #94A3B8; margin-top: 12px; text-align: center; }
        .wizard-step.active .wizard-label, .wizard-step.completed .wizard-label { color: #2563EB; }
        
        .wizard-line { position: absolute; top: 22px; left: 50%; transform: translateX(-50%); width: 75%; height: 2px; background: #E2E8F0; z-index: 0; }
        .wizard-line-progress { height: 100%; background: #2563EB; width: 100%; }

        /* Results Panel Style */
        .results-panel { background: #fff; border: 0.5px solid #E2E8F0; border-radius: 20px; overflow: hidden; margin-bottom: 24px; padding: 32px; }
        .winner-card { background: linear-gradient(135deg, #1E40AF 0%, #2563EB 100%); border-radius: 20px; padding: 32px; color: #fff; margin-bottom: 32px; position: relative; overflow: hidden; }
        .winner-card::after { content: ''; position: absolute; right: -20px; bottom: -20px; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%; }
        
        .winner-label { display: inline-flex; padding: 4px 12px; border-radius: 8px; background: rgba(255,255,255,0.2); font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px; }
        .winner-name { font-size: 32px; font-weight: 800; letter-spacing: -1px; line-height: 1; margin-bottom: 8px; }
        .winner-score { font-size: 14px; font-weight: 600; opacity: 0.8; }

        /* Step Panels (Collapsible) */
        .details-trigger { color: #2563EB; font-weight: 800; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px; user-select: none; margin: 24px 0; }
        .details-trigger:hover { text-decoration: underline; }
        .step-panel { margin-bottom: 32px; padding-top: 24px; border-top: 1px solid #F1F5F9; }
        .step-title { font-size: 16px; font-weight: 800; color: #0F172A; margin-bottom: 8px; display: flex; align-items: center; gap: 12px; }
        .step-num { width: 24px; height: 24px; background: #0F172A; color: #fff; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; }
        .step-desc { font-size: 12.5px; color: #64748B; margin-bottom: 20px; line-height: 1.6; }
        .formula-box { background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 12px 16px; font-family: 'Courier New', Courier, monospace; font-size: 13px; color: #0F172A; margin-bottom: 16px; }

        /* Calculation Tables */
        .calc-table-container { overflow-x: auto; border: 1px solid #F1F5F9; border-radius: 12px; }
        .calc-table { width: 100%; border-collapse: collapse; background: #fff; }
        .calc-table th { padding: 12px 16px; background: #F8FAFC; border-bottom: 1px solid #F1F5F9; font-size: 10px; font-weight: 800; color: #94A3B8; text-transform: uppercase; text-align: left; }
        .calc-table td { padding: 14px 16px; border-bottom: 1px solid #F8FAFC; font-size: 12.5px; font-weight: 600; color: #334155; }
        .calc-table tr:last-child td { border-bottom: none; }
        .calc-table .val { font-variant-numeric: tabular-nums; }
        .calc-table .alt-name { font-weight: 800; color: #0F172A; }

        /* Ranking Table */
        .ranking-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .ranking-table th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 800; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #F1F5F9; }
        .ranking-table td { padding: 20px 16px; font-size: 14px; color: #334155; border-bottom: 1px solid #F8FAFC; }
        .rank-badge { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px; }
        .rank-1 { background: #FEF9C3; color: #A16207; }
        .rank-2 { background: #F1F5F9; color: #475569; }
        .rank-3 { background: #FEF3C7; color: #B45309; }
        .rank-other { background: #F8FAFC; color: #94A3B8; }
        .score-pill { font-size: 13px; font-weight: 800; color: #2563EB; background: #EFF6FF; padding: 4px 12px; border-radius: 8px; }

        /* Unified Visualization Area */
        .viz-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 40px; }
        .viz-card { background: #fff; border: 1px solid #E2E8F0; border-radius: 20px; padding: 24px; }
        
        /* Analysis Section Detailed */
        .analysis-container { background: #F8FAFC; padding: 24px; border-radius: 16px; border-left: 4px solid #2563EB; }
        .analysis-section { margin-bottom: 20px; }
        .analysis-section:last-child { margin-bottom: 0; }
        .analysis-title { font-size: 13px; font-weight: 800; color: #0F172A; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .analysis-text { font-size: 13.5px; color: #475569; line-height: 1.6; }
        .analysis-text strong { color: #0F172A; }
        .badge-alt { display: inline-block; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 5px; background: #E2E8F0; color: #475569; margin-left: 4px; }

        /* Action Footer */
        .btn-row { display: flex; gap: 12px; margin-top: 32px; border-top: 1px solid #F1F5F9; padding-top: 32px; }
        .btn-action { height: 48px; border-radius: 12px; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em; display: inline-flex; align-items: center; justify-content: center; gap: 10px; cursor: pointer; transition: all 0.2s; border: none; padding: 0 24px; text-decoration: none; }
        .btn-primary { background: #2563EB; color: #fff; }
        .btn-secondary { background: #F1F5F9; color: #475569; }
        .btn-outline { background: #fff; border: 2px solid #F1F5F9; color: #64748B; }

        @media (max-width: 900px) { .viz-grid { grid-template-columns: 1fr; } }
    </style>

    <div x-data="{ showDetails: false }">
        <x-breadcrumbs :links="[
            ['label' => 'Program MOORA', 'url' => route('moora.index')],
            ['label' => 'Hasil Perhitungan']
        ]" />

        <div class="text-center mt-6 mb-8">
            <h1 class="page-title">Hasil Analisis MOORA</h1>
            <p class="page-subtitle">Pusat Rekomendasi Karir & Magang Berdasarkan Kriteria Profesional</p>
        </div>

        <!-- Stepper UI -->
        <div class="wizard-stepper">
            <div class="wizard-line"><div class="wizard-line-progress"></div></div>
            <div class="wizard-step completed">
                <div class="wizard-circle"><i class="ti ti-check"></i></div>
                <span class="wizard-label">Pilih & Prioritas</span>
            </div>
            <div class="wizard-step completed">
                <div class="wizard-circle"><i class="ti ti-check"></i></div>
                <span class="wizard-label">Penilaian</span>
            </div>
            <div class="wizard-step active">
                <div class="wizard-circle">3</div>
                <span class="wizard-label">Hasil</span>
            </div>
        </div>

        <div class="results-panel">
            <!-- Winner Highlight -->
            <div class="winner-card">
                <div class="winner-label">Rekomendasi Utama</div>
                <h2 class="winner-name">{{ $results[0]['name'] }}</h2>
                <p class="winner-score">Indeks Performa Tertinggi (Yi): {{ number_format($results[0]['optimization_value'], 4) }}</p>
            </div>

            <!-- VIZ & ANALYSIS -->
            <div class="viz-grid">
                <!-- Comparative Radar Chart (Top 3) -->
                <div class="viz-card">
                    <h4 class="text-sm font-extrabold text-slate-900 mb-6 uppercase tracking-wider">Visualisasi Perbandingan Profil Top 3</h4>
                    <div style="height: 340px">
                        <canvas id="top3RadarChart"></canvas>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-4 leading-relaxed font-bold text-center italic">
                        *Grafik ini memetakan keseimbangan kriteria. Semakin luas area yang tertutup, semakin unggul profil perusahaan tersebut.
                    </p>
                </div>
                <!-- Text Analysis Detailed -->
                <div class="viz-card">
                    <h4 class="text-sm font-extrabold text-slate-900 mb-6 uppercase tracking-wider">Laporan Analisis Strategis</h4>
                    <div class="analysis-container">
                        <!-- Alasan Menang -->
                        <div class="analysis-section">
                            <div class="analysis-title"><i class="ti ti-trophy text-blue-600"></i> Ringkasan Kemenangan</div>
                            <div class="analysis-text">
                                <strong>{{ $results[0]['name'] }}</strong> unggul dengan skor optimasi <strong>{{ number_format($results[0]['optimization_value'], 4) }}</strong>. 
                                Kemenangan ini didorong oleh efisiensi tinggi pada kriteria yang Anda prioritaskan.
                            </div>
                        </div>

                        <!-- Keunggulan Per Kriteria -->
                        <div class="analysis-section">
                            <div class="analysis-title"><i class="ti ti-chart-dots text-blue-600"></i> Pemimpin Kriteria</div>
                            <div class="analysis-text space-y-2">
                                @foreach($criterias as $c)
                                    @php
                                        $type = strtolower($c->type);
                                        $sorted = collect($results)->sortBy(function($r) use ($c, $type) {
                                            return $type === 'cost' ? $r['scores'][$c->id] : -$r['scores'][$c->id];
                                        })->first();
                                    @endphp
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-slate-500">{{ $c->name }}</span>
                                        <span class="font-bold text-slate-800">{{ $sorted['name'] }} <span class="text-[9px] bg-slate-100 px-1.5 py-0.5 rounded text-slate-400">{{ $sorted['scores'][$c->id] }}</span></span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Komparasi -->
                        <div class="analysis-section">
                            <div class="analysis-title"><i class="ti ti-arrows-left-right text-blue-600"></i> Margin Persaingan</div>
                            <div class="analysis-text">
                                @if(count($results) > 1)
                                    Selisih skor dengan kompetitor terdekat (<strong>{{ $results[1]['name'] }}</strong>) adalah <strong>{{ number_format($results[0]['optimization_value'] - $results[1]['optimization_value'], 4) }}</strong>.
                                @else
                                    Perusahaan ini merupakan satu-satunya alternatif yang dianalisis dalam sesi ini.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE RANKING -->
            <h3 class="text-lg font-extrabold text-slate-900 mb-6">Tabel Peringkat & Performa Relatif</h3>
            <div class="overflow-x-auto mb-10">
                <table class="ranking-table">
                    <thead>
                        <tr>
                            <th style="width: 80px">Rank</th>
                            <th>Nama Perusahaan</th>
                            <th style="width: 200px">Indeks Performa (Relatif)</th>
                            <th style="text-align: right">Skor Yi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $maxYi = $results[0]['optimization_value'] > 0 ? $results[0]['optimization_value'] : 1; @endphp
                        @foreach($results as $index => $res)
                            <tr>
                                <td><div class="rank-badge {{ $index < 3 ? 'rank-'.($index+1) : 'rank-other' }}">{{ $index + 1 }}</div></td>
                                <td class="font-extrabold text-slate-900">{{ $res['name'] }}</td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <!-- Unified Visualization Logic: Performance Index compared to Winner -->
                                        <div style="height: 8px; background: #F1F5F9; border-radius: 4px; width: 140px; overflow: hidden;" title="Persentase performa dibandingkan peringkat 1">
                                            <div style="height: 100%; background: #2563EB; border-radius: 4px; width: {{ max(0, ($res['optimization_value'] / $maxYi) * 100) }}%"></div>
                                        </div>
                                        <span class="text-[10px] font-black text-blue-600 w-8">{{ round(max(0, ($res['optimization_value'] / $maxYi) * 100)) }}%</span>
                                    </div>
                                </td>
                                <td style="text-align: right"><span class="score-pill">{{ number_format($res['optimization_value'], 4) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="text-[10px] text-slate-400 font-bold mt-4 italic">
                    *Garis visual menunjukkan <strong>Relative Performance Index</strong>. Peringkat 1 dijadikan standar 100%, dan baris di bawahnya menunjukkan seberapa jauh tertinggal dibandingkan pemenang.
                </p>
            </div>

            <!-- COLLAPSIBLE DETAILS -->
            <div class="details-trigger" @click="showDetails = !showDetails">
                <i class="ti" :class="showDetails ? 'ti-chevron-up' : 'ti-chevron-down'"></i>
                <span x-text="showDetails ? 'Sembunyikan Detail Perhitungan' : 'Lihat Detail Perhitungan (Langkah-langkah & Rumus)'"></span>
            </div>

            <div x-show="showDetails" x-transition.opacity>
                <div class="step-panel">
                    <div class="step-title"><div class="step-num">1</div> Matriks Keputusan (X)</div>
                    <p class="step-desc">Tabel data awal berdasarkan penilaian Anda.</p>
                    <div class="calc-table-container">
                        <table class="calc-table">
                            <thead><tr><th>Alternatif</th>@foreach($criterias as $c)<th>{{ $c->name }}</th>@endforeach</tr></thead>
                            <tbody>
                                @foreach($results as $res)
                                    <tr><td class="alt-name">{{ $res['name'] }}</td>@foreach($criterias as $c)<td class="val">{{ $res['scores'][$c->id] }}</td>@endforeach</tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="step-panel">
                    <div class="step-title"><div class="step-num">2</div> Normalisasi Matriks (R)</div>
                    <p class="step-desc">Normalisasi rumus MOORA: Xij / sqrt[ Σ(Xij)² ]</p>
                    <div class="formula-box">Rumus: Rij = Xij / sqrt[ Σ(Xij)² ]</div>
                    <div class="calc-table-container">
                        <table class="calc-table">
                            <thead><tr><th>Alternatif</th>@foreach($criterias as $c)<th>{{ $c->name }}</th>@endforeach</tr></thead>
                            <tbody>
                                @foreach($results as $res)
                                    <tr><td class="alt-name">{{ $res['name'] }}</td>@foreach($criterias as $c)<td class="val">{{ number_format($res['normalized_scores'][$c->id]['normalized'], 4) }}</td>@endforeach</tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="step-panel">
                    <div class="step-title"><div class="step-num">3</div> Normalisasi Terbobot (Y)</div>
                    <p class="step-desc">Mengalikan nilai normalisasi dengan bobot kepentingan (W).</p>
                    <div class="formula-box">Rumus: Yij = Rij * Wj</div>
                    <div class="calc-table-container">
                        <table class="calc-table">
                            <thead><tr><th>Alternatif</th>@foreach($criterias as $c)<th>{{ $c->name }} ({{ $c->weight }}%)</th>@endforeach</tr></thead>
                            <tbody>
                                @foreach($results as $res)
                                    <tr><td class="alt-name">{{ $res['name'] }}</td>@foreach($criterias as $c)<td class="val">{{ number_format($res['normalized_scores'][$c->id]['weighted'], 4) }}</td>@endforeach</tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="step-panel">
                    <div class="step-title"><div class="step-num">4</div> Penentuan Nilai Optimasi (Yi)</div>
                    <p class="step-desc">Finalisasi ranking berdasarkan selisih kriteria Benefit dan Cost.</p>
                    <div class="formula-box">Rumus: Yi = Σ(Max Benefit) - Σ(Min Cost)</div>
                    <div class="calc-table-container">
                        <table class="calc-table">
                            <thead><tr><th>Rank</th><th>Alternatif</th><th>Σ Benefit</th><th>Σ Cost</th><th style="text-align: right">Yi (Optimasi)</th></tr></thead>
                            <tbody>
                                @foreach($results as $index => $res)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="alt-name">{{ $res['name'] }}</td>
                                        <td class="val text-emerald-600">+ {{ number_format($res['sum_benefit'], 4) }}</td>
                                        <td class="val text-rose-500">- {{ number_format($res['sum_cost'], 4) }}</td>
                                        <td style="text-align: right" class="font-extrabold text-blue-600">{{ number_format($res['optimization_value'], 4) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="btn-row">
                <a href="{{ route('moora.index') }}" class="btn-action btn-outline"><i class="ti ti-refresh"></i> Ulangi Analisis</a>
                <a href="{{ route('moora.history') }}" class="btn-action btn-secondary"><i class="ti ti-history"></i> Lihat Riwayat</a>
                <a href="{{ route('dashboard') }}" class="btn-action btn-primary ml-auto">Selesai & Ke Dashboard <i class="ti ti-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('top3RadarChart').getContext('2d');
            const results = {!! json_encode(array_slice($results, 0, 3)) !!};
            const criterias = {!! json_encode($criterias) !!};

            const colors = [
                { border: '#2563EB', bg: 'rgba(37, 99, 235, 0.1)' },
                { border: '#10B981', bg: 'rgba(16, 185, 129, 0.1)' },
                { border: '#F59E0B', bg: 'rgba(245, 158, 11, 0.1)' }
            ];

            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: criterias.map(c => c.name),
                    datasets: results.map((res, index) => ({
                        label: res.name,
                        data: criterias.map(c => {
                            const score = res.scores[c.id] || 0;
                            return c.type.toLowerCase() === 'cost' ? (6 - score) : score;
                        }),
                        backgroundColor: colors[index].bg,
                        borderColor: colors[index].border,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#fff',
                        fill: true
                    }))
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: true, position: 'bottom', labels: { font: { family: 'Plus Jakarta Sans', size: 10, weight: 'bold' }, padding: 15, usePointStyle: true } }
                    },
                    scales: {
                        r: {
                            min: 0, max: 5,
                            ticks: { display: false, stepSize: 1 },
                            grid: { color: '#F1F5F9' },
                            angleLines: { color: '#F1F5F9' },
                            pointLabels: { font: { family: 'Plus Jakarta Sans', size: 10, weight: 'bold' }, color: '#64748B' }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
