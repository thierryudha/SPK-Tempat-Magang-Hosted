<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Program MOORA (SPK Tempat Magang)') }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12" x-data="mooraWizard()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs :links="[['label' => 'Program MOORA']]" />
            
            <!-- Unified Progress Stepper -->
            <div class="mb-12 relative">
                <div class="flex justify-between items-center max-w-2xl mx-auto relative z-10 px-2">
                    <template x-for="i in 2">
                        <div class="flex flex-col items-center">
                            <div :class="step >= i ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-white text-gray-400 border border-gray-200'"
                                 class="w-10 h-10 md:w-16 md:h-16 rounded-full flex items-center justify-center font-bold transition duration-500 text-sm md:text-xl">
                                <span x-text="i"></span>
                            </div>
                            <span :class="step >= i ? 'text-blue-600 font-bold' : 'text-gray-400 font-medium'"
                                  class="text-[8px] md:text-xs uppercase mt-3 tracking-widest transition duration-500 text-center font-black"
                                  x-text="['Pilih Opsi & Prioritas', 'Berikan Penilaian'][i-1]"></span>
                        </div>
                    </template>
                </div>
                <!-- Connector Line -->
                <div class="absolute top-5 md:top-8 left-1/2 -translate-x-1/2 w-[50%] h-[2px] bg-gray-200 z-0">
                    <div class="h-full bg-blue-600 transition-all duration-500" :style="'width: ' + ((step-1)/1)*100 + '%'"></div>
                </div>
            </div>

            <form action="{{ route('moora.calculate') }}" method="POST">
                @csrf
                
                <!-- Step 1: Combined Selection & Weights -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-10">
                    <!-- Section: Select Internships -->
                    <div class="bg-white p-6 md:p-10 rounded-[2.5rem] shadow-xl border border-gray-100 mb-8">
                        <div class="mb-8">
                            <div class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg mb-4">Bagian 01</div>
                            <h3 class="text-2xl font-black text-gray-900 mb-2 tracking-tight">Pilih Tempat Magang</h3>
                            <p class="text-sm text-gray-500">Pilih minimal 2 perusahaan yang ingin dibandingkan.</p>
                        </div>

                        @if($internships->isEmpty())
                            <div class="text-center py-12 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                                <p class="text-slate-500 font-bold mb-4 uppercase text-xs">Belum ada daftar perusahaan.</p>
                                <a href="{{ route('internships.create') }}" class="px-6 py-3 bg-blue-600 text-white font-black rounded-xl text-xs hover:bg-blue-700 transition inline-block">Tambah Baru</a>
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($internships as $internship)
                                <label :class="selectedInternships.includes('{{ $internship->id }}') ? 'border-emerald-500 ring-4 ring-emerald-50 bg-emerald-50/20' : 'border-gray-100 hover:border-emerald-200 bg-white'"
                                       class="p-4 border-2 rounded-3xl cursor-pointer transition relative group flex items-start gap-4">
                                    <input type="checkbox" name="internships[]" value="{{ $internship->id }}" x-model="selectedInternships" class="sr-only">
                                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors" :class="selectedInternships.includes('{{ $internship->id }}') ? 'bg-emerald-500 border-emerald-500' : 'bg-white border-gray-200'">
                                        <svg x-show="selectedInternships.includes('{{ $internship->id }}')" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <div class="font-black text-gray-900 text-sm leading-tight truncate tracking-tight capitalize">{{ $internship->name }}</div>
                                        <div class="text-[9px] text-gray-400 font-bold uppercase tracking-widest truncate mt-1">{{ $internship->category->name ?? 'Umum' }}</div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Section: Smart Weight Balancer -->
                    <div class="bg-white p-6 md:p-10 rounded-[2.5rem] shadow-xl border border-gray-100">
                        <div class="mb-8">
                            <div class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg mb-4">Bagian 02</div>
                            <h3 class="text-2xl font-black text-gray-900 mb-2 tracking-tight">Atur Prioritas Kriteria</h3>
                            <p class="text-sm text-gray-500">Pilih kriteria penilaian dan tentukan seberapa penting bagi Anda.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($criterias as $criteria)
                            <div :class="selectedCriterias['{{ $criteria->id }}'] ? 'border-blue-500 ring-4 ring-blue-50 bg-blue-50/30' : 'border-gray-100 hover:border-blue-200 bg-white'"
                                 class="p-6 border-2 rounded-3xl transition duration-300">
                                <div class="flex items-center justify-between gap-4 mb-4">
                                    <div class="flex items-center gap-4">
                                        <input type="checkbox" name="criteria[{{ $criteria->id }}]" id="c-{{ $criteria->id }}" x-model="selectedCriterias['{{ $criteria->id }}']" @change="balanceWeights()" class="sr-only peer">
                                        <label for="c-{{ $criteria->id }}" class="relative w-11 h-6 bg-gray-200 rounded-full cursor-pointer transition-colors peer-checked:bg-blue-600">
                                            <div class="absolute top-[2px] left-[2px] bg-white border border-gray-300 rounded-full h-5 w-5 transition-transform" :class="selectedCriterias['{{ $criteria->id }}'] ? 'translate-x-5' : ''"></div>
                                        </label>
                                        <div>
                                            <span class="font-black text-gray-900 text-sm leading-tight tracking-tight">{{ $criteria->name }}</span>
                                            <span class="block text-[8px] font-black uppercase tracking-widest {{ strtolower($criteria->type) === 'benefit' ? 'text-emerald-500' : 'text-rose-500' }}">{{ $criteria->type }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2" x-show="selectedCriterias['{{ $criteria->id }}']">
                                        <button type="button" @click="toggleLock('{{ $criteria->id }}')" :class="lockedWeights['{{ $criteria->id }}'] ? 'text-blue-600' : 'text-gray-300'">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path x-show="lockedWeights['{{ $criteria->id }}']" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" /><path x-show="!lockedWeights['{{ $criteria->id }}']" fill-rule="evenodd" d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path x-show="!lockedWeights['{{ $criteria->id }}']" fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" /></svg>
                                        </button>
                                        <div class="text-lg font-black text-blue-600"><span x-text="weights['{{ $criteria->id }}']"></span>%</div>
                                    </div>
                                </div>
                                <div x-show="selectedCriterias['{{ $criteria->id }}']">
                                    <input type="range" name="weights[{{ $criteria->id }}]" x-model.number="weights['{{ $criteria->id }}']" @input="manualAdjust('{{ $criteria->id }}')" min="5" max="80" class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-10 flex flex-col sm:flex-row justify-between items-center p-8 bg-slate-900 rounded-[2rem] gap-6 text-white shadow-2xl shadow-slate-900/20">
                            <div>
                                <p class="text-slate-400 text-[9px] uppercase font-black tracking-[0.2em] mb-1">Total Bobot Akumulasi</p>
                                <div class="flex items-center gap-3">
                                    <span class="text-3xl font-black"><span x-text="totalWeight"></span>%</span>
                                    <span x-show="totalWeight === 100" class="text-emerald-400 text-[10px] font-black uppercase tracking-widest">✓ Valid</span>
                                </div>
                            </div>
                            <button type="button" @click="nextStep()" :disabled="totalWeight !== 100 || selectedInternships.length < 2 || selectedCount < 3" class="w-full sm:w-auto px-10 py-4 bg-blue-600 text-white font-black rounded-2xl disabled:opacity-50 hover:bg-blue-700 transition transform active:scale-95 shadow-xl shadow-blue-500/20 uppercase tracking-widest text-xs">
                                Lanjut ke Penilaian
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Smart Scoring Guide -->
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-10">
                    <div class="bg-white p-6 md:p-10 rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                        <div class="mb-10">
                            <div class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg mb-4">Langkah 02</div>
                            <h3 class="text-2xl font-black text-gray-900 mb-2 tracking-tight">Skoring & Evaluasi Objektif</h3>
                            <p class="text-sm text-gray-500">Berikan penilaian angka 1-5 berdasarkan panduan kriteria.</p>
                        </div>
                        
                        <div class="space-y-12">
                            @foreach($internships as $internship)
                                <template x-if="selectedInternships.includes('{{ $internship->id }}')">
                                    <div class="p-8 border-2 border-slate-100 rounded-[2.5rem] group hover:border-blue-500 transition-all bg-white relative">
                                        <div class="mb-10 pb-6 border-b border-slate-50 flex justify-between items-end">
                                            <div>
                                                <h4 class="text-2xl font-black text-slate-900 capitalize">{{ $internship->name }}</h4>
                                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $internship->category->name ?? 'Umum' }}</p>
                                            </div>
                                            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 font-black">
                                                {{ substr($internship->name, 0, 1) }}
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                                            @foreach($criterias as $criteria)
                                                <template x-if="selectedCriterias['{{ $criteria->id }}']">
                                                    <div class="space-y-4" x-data="{ score: '' }">
                                                        <label class="font-black text-gray-700 text-xs uppercase tracking-widest block">{{ $criteria->name }}</label>
                                                        
                                                        <div class="relative">
                                                            <select name="scores[{{ $internship->id }}][{{ $criteria->id }}]" 
                                                                    x-model="score"
                                                                    class="w-full text-sm font-black border-2 border-slate-50 rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition-all bg-slate-50 py-4 px-6 cursor-pointer text-slate-800"
                                                                    required>
                                                                <option value="" disabled selected>Pilih Skor...</option>
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

                        <div class="mt-12 flex flex-col sm:flex-row justify-between items-center gap-6 pt-10 border-t border-slate-50">
                            <button type="button" @click="step = 1" class="w-full sm:w-auto px-10 py-4 text-slate-400 font-black hover:text-slate-600 transition text-xs uppercase tracking-widest">Kembali ke Opsi</button>
                            <button type="submit" class="w-full sm:w-auto px-12 py-5 bg-slate-900 text-white font-black rounded-2xl hover:bg-black transition transform active:scale-95 shadow-2xl shadow-slate-900/20 text-xs uppercase tracking-[0.2em]">
                                Kalkulasi Ranking MOORA
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
                    if (remaining < 0) remaining = 0;

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
                            if (id !== changedId) lockedTotal += parseInt(this.weights[id]);
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
                    if (this.step < 2) this.step++;
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
