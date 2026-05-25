<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Program MOORA (SPK Tempat Magang)') }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12" x-data="mooraWizard()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs :links="[['label' => 'Program MOORA']]" />
            
            <!-- Progress Stepper -->
            <div class="mb-8 md:mb-12 relative">
                <div class="flex justify-between items-center max-w-2xl mx-auto relative z-10 px-2">
                    <template x-for="i in 3">
                        <div class="flex flex-col items-center">
                            <div :class="step >= i ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-white text-gray-400 border border-gray-200'"
                                 class="w-10 h-10 md:w-16 md:h-16 rounded-full flex items-center justify-center font-bold transition duration-500 text-sm md:text-xl">
                                <span x-text="i"></span>
                            </div>
                            <span :class="step >= i ? 'text-blue-600 font-bold' : 'text-gray-400 font-medium'"
                                  class="text-[8px] md:text-xs uppercase mt-3 tracking-widest transition duration-500 text-center font-black"
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
                    <div class="bg-white p-5 sm:p-6 md:p-10 rounded-3xl md:rounded-[2.5rem] shadow-xl border border-gray-100">
                        <div class="mb-8 md:mb-10">
                            <div class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg mb-4">Langkah 01</div>
                            <h3 class="text-2xl md:text-3xl font-black text-gray-900 mb-2 tracking-tight">Tentukan Prioritas Kriteria</h3>
                            <p class="text-sm text-gray-500 leading-relaxed max-w-2xl">Pilih kriteria yang relevan bagi Anda dan atur bobot kepentingannya. Gunakan <strong>Smart Balancer</strong> untuk memastikan total bobot selalu 100%.</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            @foreach($criterias as $criteria)
                            <div :class="selectedCriterias['{{ $criteria->id }}'] ? 'border-blue-500 ring-4 ring-blue-50 bg-blue-50/30' : 'border-gray-100 hover:border-blue-200 bg-white'"
                                 class="p-4 sm:p-5 md:p-6 border-2 rounded-3xl transition duration-300 group">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4 md:mb-6">
                                    <div class="flex items-center gap-3 md:gap-4 overflow-hidden w-full sm:w-auto">
                                        <div class="relative inline-flex items-center cursor-pointer scale-90 md:scale-100 flex-shrink-0">
                                            <input type="checkbox" 
                                                   name="criteria[{{ $criteria->id }}]" 
                                                   id="c-{{ $criteria->id }}"
                                                   x-model="selectedCriterias['{{ $criteria->id }}']"
                                                   @change="balanceWeights()"
                                                   class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <label for="c-{{ $criteria->id }}" class="font-black text-gray-900 text-sm md:text-base leading-tight truncate tracking-tight block cursor-pointer">{{ $criteria->name }}</label>
                                            <p class="text-[9px] md:text-[10px] text-gray-400 font-bold uppercase tracking-widest truncate mt-1">
                                                <span class="{{ strtolower($criteria->type) === 'benefit' ? 'text-emerald-500' : 'text-rose-500' }}">{{ $criteria->type }}</span>
                                            </p>
                                        </div>

                                    </div>
                                    <div class="flex items-center gap-2 md:gap-3 flex-shrink-0 self-end sm:self-auto">
                                        <button type="button" 
                                                x-show="selectedCriterias['{{ $criteria->id }}']"
                                                @click="toggleLock('{{ $criteria->id }}')"
                                                :class="lockedWeights['{{ $criteria->id }}'] ? 'text-blue-600' : 'text-gray-300 hover:text-gray-400'"
                                                class="transition transform active:scale-90 p-1">
                                            <svg x-show="!lockedWeights['{{ $criteria->id }}']" class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                            <svg x-show="lockedWeights['{{ $criteria->id }}']" x-cloak class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                        </button>
                                        <div class="text-base md:text-xl font-black text-blue-600 whitespace-nowrap" x-show="selectedCriterias['{{ $criteria->id }}']">
                                            <span x-text="weights['{{ $criteria->id }}']"></span><span class="text-[10px] md:text-sm ml-0.5">%</span>
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

                        <div class="mt-8 md:mt-12 flex flex-col sm:flex-row justify-start items-center p-6 md:p-8 bg-white border-2 border-slate-100 rounded-[2rem] gap-8">
                            <div class="text-center sm:text-left">
                                <p class="text-slate-400 text-[9px] md:text-[10px] uppercase font-black tracking-[0.2em] mb-2">Total Akumulasi Bobot</p>
                                <div class="flex items-center justify-center sm:justify-start gap-3">
                                    <div :class="totalWeight === 100 ? 'bg-emerald-500' : 'bg-amber-500'" class="w-3 h-3 rounded-full animate-pulse"></div>
                                    <span class="text-3xl md:text-4xl font-black text-slate-800"><span x-text="totalWeight"></span>%</span>
                                    <span x-show="totalWeight === 100" class="text-emerald-500 font-bold text-xs md:text-sm uppercase tracking-widest ml-2">✓ Ready</span>
                                </div>
                            </div>
                            <button type="button" 
                                    @click="nextStep()" 
                                    :disabled="totalWeight !== 100 || selectedCount < 3"
                                    class="w-full sm:w-auto px-10 py-4 bg-blue-600 text-white font-black rounded-2xl disabled:opacity-50 disabled:cursor-not-allowed hover:bg-blue-700 transition transform active:scale-95 shadow-xl shadow-blue-100 text-sm md:text-base">
                                Langkah Selanjutnya
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Pilih Tempat Magang -->
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-10">
                    <div class="bg-white p-5 sm:p-6 md:p-10 rounded-3xl md:rounded-[2.5rem] shadow-xl border border-gray-100">
                        <div class="mb-8 md:mb-10">
                            <div class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg mb-4">Langkah 02</div>
                            <h3 class="text-2xl md:text-3xl font-black text-gray-900 mb-2 tracking-tight">Pilih Alternatif Tempat Magang</h3>
                            <p class="text-sm text-gray-500 leading-relaxed max-w-2xl">Pilih minimal 2 perusahaan yang ingin Anda bandingkan dalam perhitungan MOORA ini.</p>
                        </div>
                        
                        @if($internships->isEmpty())
                            <div class="text-center py-12 md:py-16 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                                <p class="text-slate-500 font-bold mb-6">Belum ada daftar tempat magang di database.</p>
                                <a href="{{ route('internships.create') }}" class="px-8 py-4 bg-blue-600 text-white font-black rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition inline-block">Tambah Sekarang</a>
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
                                @foreach($internships as $internship)
                                <label :class="selectedInternships.includes('{{ $internship->id }}') ? 'border-emerald-500 ring-4 ring-emerald-50 bg-emerald-50/20' : 'border-gray-100 hover:border-emerald-200 bg-white'"
                                       class="p-4 sm:p-5 md:p-6 border-2 rounded-3xl cursor-pointer transition relative group flex items-start gap-4">
                                    <div class="pt-1 flex-shrink-0">
                                        <input type="checkbox" 
                                               name="internships[]" 
                                               value="{{ $internship->id }}" 
                                               x-model="selectedInternships"
                                               class="w-5 h-5 rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <div class="font-black text-gray-900 text-base md:text-lg leading-tight mb-2 group-hover:text-blue-600 transition truncate tracking-tight">{{ $internship->name }}</div>
                                        <div class="text-[10px] md:text-xs text-gray-400 font-bold uppercase tracking-widest truncate">{{ $internship->city }} • {{ $internship->category }}</div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-10 md:mt-12 flex flex-col sm:flex-row justify-start gap-4">
                            <button type="button" @click="step = 1" class="px-8 py-4 text-slate-500 font-black hover:text-slate-700 transition text-sm md:text-base">Kembali</button>
                            <button type="button" 
                                    @click="nextStep()" 
                                    :disabled="selectedInternships.length < 2"
                                    class="px-10 py-4 bg-blue-600 text-white font-black rounded-2xl disabled:opacity-50 disabled:cursor-not-allowed hover:bg-blue-700 shadow-xl shadow-blue-100 transition transform active:scale-95 text-sm md:text-base">
                                Lanjut ke Penilaian
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Input Nilai -->
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-10">
                    <div class="bg-white p-5 sm:p-6 md:p-10 rounded-3xl md:rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                        <div class="mb-8 md:mb-10">
                            <div class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg mb-4">Langkah 03</div>
                            <h3 class="text-2xl md:text-3xl font-black text-gray-900 mb-2 tracking-tight">Skoring & Evaluasi Objektif</h3>
                            <p class="text-sm text-gray-500 leading-relaxed max-w-2xl">Berikan penilaian untuk setiap perusahaan berdasarkan kriteria yang telah Anda pilih sebelumnya.</p>
                        </div>
                        
                        <div class="space-y-8 md:space-y-10">
                            @foreach($internships as $internship)
                                <template x-if="selectedInternships.includes('{{ $internship->id }}')">
                                    <div class="bg-white rounded-[2.5rem] border-2 border-slate-100 p-6 md:p-10 transition-all hover:border-blue-200 hover:shadow-xl hover:shadow-blue-50/50 group">
                                        <div class="mb-8 pb-6 border-b border-slate-100">
                                            <h4 class="text-xl md:text-2xl font-black text-slate-900 leading-tight tracking-tight group-hover:text-blue-600 transition">{{ $internship->name }}</h4>
                                            <p class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-widest mt-2 flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                                                {{ $internship->city }} • {{ $internship->category }}
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-6 md:gap-8">
                                            @foreach($criterias as $criteria)
                                                <template x-if="selectedCriterias['{{ $criteria->id }}']">
                                                    <div class="space-y-2">
                                                        <div class="ml-1 mb-2">
                                                            <label class="font-black text-gray-900 text-sm md:text-base leading-tight truncate tracking-tight block">
                                                                {{ $criteria->name }}
                                                            </label>
                                                        </div>
                                                        <div class="relative">
                                                            <select name="scores[{{ $internship->id }}][{{ $criteria->id }}]" 
                                                                    class="w-full text-xs md:text-sm font-black border-slate-200 rounded-[1.2rem] focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition-all shadow-sm bg-slate-50 py-4 px-6 appearance-none cursor-pointer text-slate-800"
                                                                    style="-webkit-appearance: none; -moz-appearance: none; appearance: none;"
                                                                    required>
                                                                <option value="" disabled selected>Pilih Skor Nilai...</option>
                                                                @foreach($criteria->scales as $scale)
                                                                    <option value="{{ $scale->score }}">{{ $scale->description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </template>
                                            @endforeach
                                        </div>
                                    </div>
                                </template>
                            @endforeach
                        </div>

                        <div class="mt-12 flex flex-col sm:flex-row justify-start items-center gap-6">
                            <button type="button" @click="step = 2" class="w-full sm:w-auto px-8 py-4 text-slate-500 font-black hover:text-slate-700 transition text-sm md:text-base">Kembali</button>
                            <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-blue-600 text-white font-black rounded-2xl hover:bg-blue-700 transition transform active:scale-95 shadow-xl shadow-blue-100 text-sm md:text-base">
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
