<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Program MOORA (SPK Tempat Magang)') }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12" x-data="mooraWizard()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Progress Stepper -->
            <div class="mb-8 md:mb-12 relative">
                <div class="flex justify-between items-center max-w-2xl mx-auto relative z-10 px-2">
                    <template x-for="i in 3">
                        <div class="flex flex-col items-center">
                            <div :class="step >= i ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-white text-gray-400 border border-gray-200'"
                                 class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center font-bold transition duration-500 text-sm md:text-base">
                                <span x-text="i"></span>
                            </div>
                            <span :class="step >= i ? 'text-blue-600 font-bold' : 'text-gray-400 font-medium'"
                                  class="text-[8px] md:text-[10px] uppercase mt-2 tracking-widest transition duration-500 text-center"
                                  x-text="['Kriteria', 'Alternatif', 'Penilaian'][i-1]"></span>
                        </div>
                    </template>
                </div>
                <!-- Connector Line -->
                <div class="absolute top-5 md:top-6 left-1/2 -translate-x-1/2 w-[80%] max-w-[400px] h-[2px] bg-gray-200 z-0">
                    <div class="h-full bg-blue-600 transition-all duration-500" :style="'width: ' + ((step-1)/2)*100 + '%'"></div>
                </div>
            </div>

            <form action="{{ route('moora.calculate') }}" method="POST">
                @csrf
                
                <!-- Step 1: Smart Weight Balancer -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-10">
                    <div class="bg-white p-6 md:p-10 rounded-3xl shadow-xl border border-gray-100">
                        <div class="mb-8 md:mb-10">
                            <h3 class="text-xl md:text-2xl font-extrabold text-gray-900 mb-2">Langkah 1: Tentukan Prioritas Anda</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">Pilih kriteria yang Anda anggap penting. Gunakan <strong>Smart Balancer</strong> untuk membagi bobot secara otomatis agar total selalu 100%.</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            @foreach($criterias as $criteria)
                            <div :class="selectedCriterias['{{ $criteria->id }}'] ? 'border-blue-500 ring-4 ring-blue-50 bg-blue-50/30' : 'border-gray-100 hover:border-blue-200 bg-white'"
                                 class="p-4 md:p-6 border-2 rounded-2xl transition duration-300 group">
                                <div class="flex items-center justify-between mb-4 md:mb-6">
                                    <div class="flex items-center gap-3 md:gap-4">
                                        <div class="relative inline-flex items-center cursor-pointer scale-90 md:scale-100">
                                            <input type="checkbox" 
                                                   name="criteria[{{ $criteria->id }}]" 
                                                   id="c-{{ $criteria->id }}"
                                                   x-model="selectedCriterias['{{ $criteria->id }}']"
                                                   @change="balanceWeights()"
                                                   class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </div>
                                        <div class="min-w-0">
                                            <label for="c-{{ $criteria->id }}" class="font-bold text-gray-900 group-hover:text-blue-700 transition text-sm md:text-base block truncate">{{ $criteria->name }}</label>
                                            <p class="text-[9px] md:text-[10px] text-gray-400 uppercase tracking-tighter">{{ strtoupper($criteria->type) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 md:gap-3">
                                        <!-- Lock Feature -->
                                        <button type="button" 
                                                x-show="selectedCriterias['{{ $criteria->id }}']"
                                                @click="toggleLock('{{ $criteria->id }}')"
                                                :class="lockedWeights['{{ $criteria->id }}'] ? 'text-blue-600' : 'text-gray-300 hover:text-gray-400'"
                                                class="transition transform active:scale-90 p-1"
                                                title="Kunci bobot ini">
                                            <svg x-show="!lockedWeights['{{ $criteria->id }}']" class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                            <svg x-show="lockedWeights['{{ $criteria->id }}']" x-cloak class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                        </button>
                                        <div class="text-lg md:text-xl font-black text-blue-600" x-show="selectedCriterias['{{ $criteria->id }}']">
                                            <span x-text="weights['{{ $criteria->id }}']"></span><span class="text-xs md:text-sm ml-0.5 md:ml-1">%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div x-show="selectedCriterias['{{ $criteria->id }}']" x-transition>
                                    <input type="range" 
                                           name="weights[{{ $criteria->id }}]" 
                                           x-model.number="weights['{{ $criteria->id }}']"
                                           @input="manualAdjust('{{ $criteria->id }}')"
                                           min="5" max="80" step="1"
                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-8 md:mt-12 flex flex-col sm:flex-row justify-between items-center p-6 md:p-8 bg-gray-900 rounded-2xl text-white gap-6">
                            <div class="text-center sm:text-left">
                                <p class="text-gray-400 text-[10px] md:text-xs uppercase font-bold tracking-widest mb-1">Status Bobot</p>
                                <div class="flex items-center justify-center sm:justify-start gap-3">
                                    <div :class="totalWeight === 100 ? 'bg-green-500' : 'bg-yellow-500'" class="w-3 h-3 rounded-full animate-pulse"></div>
                                    <span class="text-2xl md:text-3xl font-black"><span x-text="totalWeight"></span>%</span>
                                    <span x-show="totalWeight === 100" class="text-green-400 font-bold text-xs md:text-sm">✓ Sempurna</span>
                                </div>
                            </div>
                            <button type="button" 
                                    @click="nextStep()" 
                                    :disabled="totalWeight !== 100 || selectedCount < 3"
                                    class="w-full sm:w-auto px-10 py-4 bg-blue-600 text-white font-extrabold rounded-xl disabled:opacity-50 disabled:cursor-not-allowed hover:bg-blue-700 transition transform active:scale-95 shadow-xl shadow-blue-900/20 text-sm md:text-base">
                                Langkah Selanjutnya
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Pilih Tempat Magang -->
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-10">
                    <div class="bg-white p-6 md:p-10 rounded-3xl shadow-xl border border-gray-100">
                        <h3 class="text-xl md:text-2xl font-extrabold text-gray-900 mb-2">Langkah 2: Pilih Alternatif</h3>
                        <p class="text-sm text-gray-500 mb-6 md:mb-8">Pilih perusahaan yang ingin Anda bandingkan dalam perhitungan ini.</p>
                        
                        @if($internships->isEmpty())
                            <div class="text-center py-12 md:py-16 bg-gray-50 rounded-3xl border-2 border-dashed">
                                <p class="text-gray-500 font-medium mb-6">Belum ada daftar tempat magang.</p>
                                <a href="{{ route('internships.create') }}" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg">Tambah Sekarang</a>
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4">
                                @foreach($internships as $internship)
                                <label :class="selectedInternships.includes('{{ $internship->id }}') ? 'border-blue-500 ring-2 ring-blue-100 bg-blue-50' : 'border-gray-100 hover:border-blue-200'"
                                       class="p-4 md:p-6 border-2 rounded-2xl cursor-pointer transition relative group">
                                    <input type="checkbox" 
                                           name="internships[]" 
                                           value="{{ $internship->id }}" 
                                           x-model="selectedInternships"
                                           class="absolute top-4 right-4 rounded-full border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <div class="font-bold text-gray-900 text-base md:text-lg leading-tight mb-1 group-hover:text-blue-700 transition truncate pr-8">{{ $internship->name }}</div>
                                    <div class="text-[10px] md:text-xs text-gray-400 font-bold uppercase tracking-widest truncate">{{ $internship->city }} • {{ $internship->category }}</div>
                                </label>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-8 md:mt-12 flex flex-col sm:flex-row justify-between gap-4">
                            <button type="button" @click="step = 1" class="w-full sm:w-auto order-2 sm:order-1 px-8 py-4 text-gray-500 font-bold hover:text-gray-700 transition text-sm md:text-base">Kembali</button>
                            <button type="button" 
                                    @click="nextStep()" 
                                    :disabled="selectedInternships.length < 2"
                                    class="w-full sm:w-auto order-1 sm:order-2 px-10 py-4 bg-blue-600 text-white font-extrabold rounded-xl disabled:opacity-50 disabled:cursor-not-allowed hover:bg-blue-700 shadow-xl transition transform active:scale-95 text-sm md:text-base">
                                Lanjut ke Penilaian
                            </button>
                        </div>
                        <p x-show="selectedInternships.length < 2" class="text-center text-xs text-red-500 mt-4 font-bold">Pilih minimal 2 tempat untuk dibandingkan.</p>
                    </div>
                </div>

                <!-- Step 3: Input Nilai -->
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-10">
                    <div class="bg-white p-6 md:p-10 rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                        <h3 class="text-xl md:text-2xl font-extrabold text-gray-900 mb-2">Langkah 3: Skoring</h3>
                        <p class="text-sm text-gray-500 mb-8 md:mb-10">Berikan penilaian objektif untuk setiap alternatif berdasarkan kriteria terpilih.</p>
                        
                        <div class="overflow-x-auto -mx-6 px-6 pb-4">
                            <table class="w-full border-separate border-spacing-y-4">
                                <thead>
                                    <tr class="text-gray-400 text-[10px] md:text-xs font-bold uppercase tracking-widest text-left">
                                        <th class="px-4">Perusahaan</th>
                                        @foreach($criterias as $criteria)
                                            <template x-if="selectedCriterias['{{ $criteria->id }}']">
                                                <th class="px-4 text-center min-w-[140px] md:min-w-[180px]">{{ $criteria->name }}</th>
                                            </template>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($internships as $internship)
                                        <template x-if="selectedInternships.includes('{{ $internship->id }}')">
                                            <tr class="bg-gray-50/50 rounded-2xl">
                                                <td class="px-4 py-6 font-extrabold text-gray-900 whitespace-nowrap border-y border-l rounded-l-2xl border-gray-100 text-sm md:text-base">
                                                    {{ $internship->name }}
                                                </td>
                                                @foreach($criterias as $criteria)
                                                    <template x-if="selectedCriterias['{{ $criteria->id }}']">
                                                        <td class="px-4 py-6 border-y border-gray-100 last:rounded-r-2xl last:border-r">
                                                            <select name="scores[{{ $internship->id }}][{{ $criteria->id }}]" 
                                                                    class="w-full text-[10px] md:text-xs font-bold border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition shadow-sm bg-white"
                                                                    required>
                                                                <option value="">Skor</option>
                                                                @foreach($criteria->scales as $scale)
                                                                    <option value="{{ $scale->score }}">{{ $scale->score }} - {{ $scale->description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </template>
                                                @endforeach
                                            </tr>
                                        </template>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 md:mt-12 flex flex-col sm:flex-row justify-between items-center gap-4">
                            <button type="button" @click="step = 2" class="w-full sm:w-auto order-2 sm:order-1 px-8 py-4 text-gray-500 font-bold hover:text-gray-700 transition text-sm md:text-base">Kembali</button>
                            <button type="submit" class="w-full sm:w-auto order-1 sm:order-2 px-10 md:px-12 py-4 md:py-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black rounded-2xl hover:from-blue-700 hover:to-indigo-700 shadow-2xl shadow-blue-200 transition transform hover:-translate-y-1 active:translate-y-0 text-sm md:text-base">
                                DAPATKAN RANKING MOORA
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function mooraWizard() {
            return {
                step: 1,
                selectedCriterias: {},
                weights: {
                    @foreach($criterias as $criteria)
                        '{{ $criteria->id }}': 0,
                    @endforeach
                },
                lockedWeights: {},
                selectedInternships: [],
                
                get totalWeight() {
                    let total = 0;
                    for (let id in this.selectedCriterias) {
                        if (this.selectedCriterias[id]) {
                            total += parseInt(this.weights[id] || 0);
                        }
                    }
                    return total;
                },

                get selectedCount() {
                    return Object.values(this.selectedCriterias).filter(val => val).length;
                },

                toggleLock(id) {
                    this.lockedWeights[id] = !this.lockedWeights[id];
                },

                balanceWeights() {
                    const selectedIds = Object.keys(this.selectedCriterias).filter(id => this.selectedCriterias[id]);
                    const unlockedIds = selectedIds.filter(id => !this.lockedWeights[id]);
                    
                    if (unlockedIds.length === 0) return;

                    let lockedTotal = 0;
                    selectedIds.filter(id => this.lockedWeights[id]).forEach(id => {
                        lockedTotal += parseInt(this.weights[id]);
                    });

                    let remaining = 100 - lockedTotal;
                    if (remaining < 0) {
                        // If locked total > 100, we must unlock something or adjust
                        remaining = 0;
                    }

                    const portion = Math.floor(remaining / unlockedIds.length);
                    let sum = 0;
                    unlockedIds.forEach((id, index) => {
                        if (index === unlockedIds.length - 1) {
                            this.weights[id] = remaining - sum;
                        } else {
                            this.weights[id] = portion;
                            sum += portion;
                        }
                    });
                },

                manualAdjust(changedId) {
                    const selectedIds = Object.keys(this.selectedCriterias).filter(id => this.selectedCriterias[id]);
                    const otherUnlockedIds = selectedIds.filter(id => !this.lockedWeights[id] && id !== changedId);
                    
                    if (otherUnlockedIds.length === 0) {
                        // If no other unlocked, the change is reverted or forces remaining
                        let lockedTotal = 0;
                        selectedIds.filter(id => this.lockedWeights[id]).forEach(id => {
                            lockedTotal += parseInt(this.weights[id]);
                        });
                        this.weights[changedId] = 100 - lockedTotal;
                        return;
                    }

                    let lockedTotal = 0;
                    selectedIds.filter(id => this.lockedWeights[id]).forEach(id => {
                        lockedTotal += parseInt(this.weights[id]);
                    });

                    let remaining = 100 - lockedTotal - this.weights[changedId];
                    
                    // Enforce minimum 5% for other unlocked if possible
                    if (remaining < otherUnlockedIds.length * 5) {
                        this.weights[changedId] = 100 - lockedTotal - (otherUnlockedIds.length * 5);
                        remaining = 100 - lockedTotal - this.weights[changedId];
                    }

                    const portion = Math.floor(remaining / otherUnlockedIds.length);
                    let sum = 0;
                    otherUnlockedIds.forEach((id, index) => {
                        if (index === otherUnlockedIds.length - 1) {
                            this.weights[id] = remaining - sum;
                        } else {
                            this.weights[id] = portion;
                            sum += portion;
                        }
                    });
                },

                nextStep() {
                    if (this.step < 3) this.step++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                init() {
                    @foreach($userWeights as $id => $w)
                        this.selectedCriterias['{{ $id }}'] = true;
                        this.weights['{{ $id }}'] = {{ (int)$w }};
                    @endforeach
                    
                    if (this.selectedCount === 0) {
                        // Default select first 3
                        [1, 2, 3].forEach(id => {
                            this.selectedCriterias[id] = true;
                        });
                        this.balanceWeights();
                    }
                }
            }
        }
    </script>
</x-app-layout>
