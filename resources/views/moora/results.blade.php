<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Perhitungan MOORA') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Ranking Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Rekomendasi Tempat Magang Terbaik
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        @foreach(collect($results)->take(3) as $index => $res)
                        <div class="relative p-6 border-2 {{ $index == 0 ? 'border-yellow-400 bg-yellow-50' : 'border-gray-200 bg-white' }} rounded-xl shadow-sm text-center">
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-white px-4 py-1 border rounded-full font-bold text-sm">
                                Rank #{{ $res['rank'] }}
                            </div>
                            <div class="text-3xl mb-2">{{ $index == 0 ? '🥇' : ($index == 1 ? '🥈' : '🥉') }}</div>
                            <div class="text-lg font-bold text-gray-800">{{ $res['name'] }}</div>
                            <div class="text-xs text-gray-500 mt-1">Nilai Optimasi: {{ number_format($res['optimization_value'], 4) }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rank</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Tempat Magang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai Akhir (Yi)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($results as $res)
                                <tr class="{{ $res['rank'] == 1 ? 'bg-yellow-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap font-bold">#{{ $res['rank'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $res['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-blue-600 font-mono">{{ number_format($res['optimization_value'], 4) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Detailed Steps (Optional for transparency) -->
            <div x-data="{ open: false }" class="mt-8">
                <button @click="open = !open" class="text-blue-600 hover:underline text-sm font-semibold">
                    <span x-show="!open">Tampilkan Detail Perhitungan</span>
                    <span x-show="open">Sembunyikan Detail Perhitungan</span>
                </button>

                <div x-show="open" x-transition class="mt-4 space-y-8">
                    <!-- Normalization Matrix -->
                    <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
                        <h4 class="font-bold mb-4">1. Matriks Normalisasi (r<sub>ij</sub>)</h4>
                        <table class="min-w-full text-xs border">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border p-2">Alternatif</th>
                                    @foreach($criterias as $c)
                                        <th class="border p-2">{{ $c->code }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $res)
                                <tr>
                                    <td class="border p-2 font-bold">{{ $res['name'] }}</td>
                                    @foreach($criterias as $c)
                                        <td class="border p-2 font-mono">{{ number_format($res['normalized_scores'][$c->id]['normalized'], 4) }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Weighted Matrix -->
                    <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
                        <h4 class="font-bold mb-4">2. Matriks Terbobot (y<sub>ij</sub>)</h4>
                        <table class="min-w-full text-xs border">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border p-2">Alternatif</th>
                                    @foreach($criterias as $c)
                                        <th class="border p-2">{{ $c->code }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $res)
                                <tr>
                                    <td class="border p-2 font-bold">{{ $res['name'] }}</td>
                                    @foreach($criterias as $c)
                                        <td class="border p-2 font-mono text-green-600">{{ number_format($res['normalized_scores'][$c->id]['weighted'], 4) }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-12 flex justify-center gap-4">
                <a href="{{ route('moora.index') }}" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Hitung Ulang</a>
                <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</x-app-layout>
