<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pusat Analitik Intelligence') }}
        </h2>
    </x-slot>

    <!-- Visualisation Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-6 lg:py-10 bg-[#F1F5F9]/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- SECTION 1: Personal Profile -->
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-8">
                <!-- User Welcome & Stats -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 lg:p-12 flex flex-col md:flex-row gap-10 items-center overflow-hidden relative">
                    <div class="flex-1 z-10">
                        <div class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg mb-6">Analisis Personal</div>
                        <h3 class="text-3xl lg:text-4xl font-black text-slate-900 mb-1 tracking-tight leading-tight uppercase">
                            {{ $bestInternshipData->name ?? 'Mulai Pilih Tempat Magang Mu' }}
                        </h3>
                        @if($bestInternshipData)
                            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-3">{{ $bestInternshipData->category }}</p>
                        @endif
                        <p class="text-slate-500 text-sm mb-10 max-w-md leading-relaxed">Profil ini dirangkum berdasarkan preferensi bobot unik Anda terhadap {{ $criterias->count() }} kriteria penilaian profesional.</p>
                        
                        <div class="flex flex-wrap gap-4">
                            <div class="px-6 py-4 bg-slate-50 rounded-3xl border border-slate-100">
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Evaluasi</p>
                                <div class="flex items-end gap-2">
                                    <span class="text-2xl font-black text-slate-800">{{ $evaluationsCount }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold mb-1.5 uppercase">Perusahaan</span>
                                </div>
                                <p class="text-[9px] text-slate-400 mt-1 italic lowercase">Internship yang baru Anda bandingkan</p>
                            </div>
                            <div class="px-6 py-4 bg-blue-50 rounded-3xl border border-blue-100">
                                <p class="text-[10px] text-blue-600 font-bold uppercase tracking-widest mb-1">Skor Rata-Rata</p>
                                <div class="flex items-end gap-2">
                                    <span class="text-2xl font-black text-blue-600">{{ $bestInternshipData ? number_format($bestInternshipData->avg_score, 1) : '0.0' }}</span>
                                    <span class="text-[10px] text-blue-400 font-bold mb-1.5 uppercase">/ 5.0</span>
                                </div>
                                <p class="text-[9px] text-blue-400 mt-1 italic lowercase">Rerata kriteria terbaik Anda</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-80 h-80 flex-shrink-0 z-10 bg-white/50 backdrop-blur-sm rounded-[2rem] p-4 border border-slate-50 shadow-inner relative overflow-hidden">
                        @if($bestInternshipData)
                            <canvas id="personalRadarChart" class="relative z-10"></canvas>
                        @else
                            <div class="h-full w-full flex items-center justify-center text-center p-6 italic text-slate-300 text-xs">Tambah & nilai tempat magang <br> untuk melihat grafik radar profil.</div>
                        @endif
                    </div>

                    <!-- Decorative background icons (Triangle Ornaments) -->
                    <div class="absolute -right-16 -bottom-16 text-slate-100 rotate-12 pointer-events-none z-0">
                        <svg class="w-96 h-96" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Global Stats & Action -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- TOP 5 ELITE -->
                <div class="bg-white rounded-[2.5rem] shadow-sm p-8 border border-gray-100 relative overflow-hidden">
                    <h3 class="font-black text-slate-900 text-sm mb-8 flex items-center gap-2 relative z-10">
                        <span class="w-1.5 h-4 bg-yellow-400 rounded-full"></span>
                        Top 5 Elite Companies
                    </h3>
                    <div class="space-y-4">
                        @foreach($globalTopInternships as $index => $global)
                        <div class="group flex items-center gap-4 p-3 hover:bg-slate-50 rounded-2xl transition duration-300">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-black text-xs {{ $index == 0 ? 'text-yellow-500 ring-2 ring-yellow-100' : 'text-slate-400' }}">{{ $index + 1 }}</div>
                            <div class="flex-1 overflow-hidden">
                                <p class="text-sm font-black text-slate-900 group-hover:text-blue-600 transition truncate uppercase">{{ $global->name }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $global->category }}</p>
                            </div>
                            <div class="text-[10px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">⭐ {{ number_format($global->avg_score, 1) }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Market Insight & Action -->
                <div class="lg:col-span-2 bg-indigo-600 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-indigo-900/20 relative overflow-hidden flex flex-col md:flex-row gap-10">
                    <div class="flex-1 z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-indigo-200 mb-4">Strategic Insight</p>
                        <h4 class="text-3xl font-black mb-6 leading-tight">Siap Untuk Menentukan Pilihan Terbaikmu?</h4>
                        <p class="text-indigo-100 text-sm leading-relaxed mb-10 opacity-80 italic">"Gunakan metode MOORA untuk melihat apakah perusahaan saat ini sesuai dengan kriteria pribadi Anda."</p>
                        <a href="{{ route('moora.index') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-indigo-600 font-black rounded-2xl shadow-xl hover:scale-105 transition transform active:scale-95">
                            Jalankan Program MOORA
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                    <!-- Stats abstract -->
                    <div class="w-full md:w-64 bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/10 z-10">
                        <p class="text-[10px] font-black uppercase tracking-widest text-indigo-200 mb-6">Database Scan</p>
                        <div class="space-y-6">
                            <div>
                                <p class="text-2xl font-black">{{ $totalInternships }}</p>
                                <p class="text-[9px] font-bold text-indigo-200 uppercase">Opportunities Found</p>
                            </div>
                            <div>
                                <p class="text-2xl font-black">{{ $totalUsers * 10 }}+</p>
                                <p class="text-[9px] font-bold text-indigo-200 uppercase">Evaluations Run</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            Chart.defaults.color = '#94A3B8';

            // 1. PERSONAL RADAR CHART
            @if($bestInternshipData)
            new Chart(document.getElementById('personalRadarChart'), {
                type: 'radar',
                data: {
                    labels: {!! json_encode($personalChartData['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($personalChartData['values']) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: '#3b82f6',
                        borderWidth: 3,
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
                            ticks: { 
                                display: false, 
                                stepSize: 1
                            },
                            grid: { color: '#E2E8F0', lineWidth: 1 },
                            angleLines: { color: '#E2E8F0', lineWidth: 1 },
                            pointLabels: { 
                                font: { size: 10, weight: 'bold' }, 
                                color: '#64748B',
                                padding: 10
                            }
                        } 
                    },
                    elements: {
                        line: {
                            borderWidth: 4,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.15)',
                        },
                        point: {
                            radius: 5,
                            hoverRadius: 8,
                            backgroundColor: '#fff',
                            borderWidth: 3,
                            borderColor: '#3b82f6',
                        }
                    }
                }
            });
            @endif
        });
    </script>
</x-app-layout>
