<x-app-layout>
    <style>
        /* Stepper Style (Fixed & Synced) */
        .wizard-stepper { display: flex; justify-content: space-between; items: center; max-width: 700px; margin: 0 auto 48px; position: relative; }
        .wizard-step { display: flex; flex-direction: column; align-items: center; position: relative; z-index: 10; width: 120px; }
        .wizard-circle { 
            width: 44px; height: 44px; border-radius: 50%; background: #fff; border: 2px solid #E2E8F0;
            display: flex; align-items: center; justify-content: center; font-weight: 800; color: #94A3B8;
            transition: all 0.5s;
        }
        .wizard-step.active .wizard-circle { background: #2563EB; border-color: #2563EB; color: #fff; box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2); }
        .wizard-step.completed .wizard-circle { background: #2563EB; border-color: #2563EB; color: #fff; }
        .wizard-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #94A3B8; margin-top: 12px; text-align: center; }
        .wizard-step.active .wizard-label { color: #2563EB; }
        
        .wizard-line { position: absolute; top: 22px; left: 50%; transform: translateX(-50%); width: 75%; height: 2px; background: #E2E8F0; z-index: 0; }
        .wizard-line-progress { height: 100%; background: #2563EB; transition: width 0.5s ease; width: 0%; }

        /* Component Styles */
        .panel { background: #fff; border: 0.5px solid #E2E8F0; border-radius: 20px; overflow: hidden; margin-bottom: 24px; padding: 32px; }
        .section-tag { display: inline-flex; padding: 4px 12px; border-radius: 8px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 16px; }
        .tag-blue { background: #EFF6FF; color: #2563EB; }
        .tag-emerald { background: #ECFDF5; color: #059669; }

        /* Full Width Grid for Internships */
        .internship-card { border: 2px solid #F1F5F9; border-radius: 16px; padding: 16px; cursor: pointer; transition: all 0.2s; display: flex; align-items: flex-start; gap: 12px; }
        .internship-card.selected { border-color: #10B981; background: #F0FDF4; box-shadow: 0 0 0 4px #DCFCE7; }
        
        /* Weights Section */
        .weight-card { border: 2px solid #F1F5F9; border-radius: 16px; padding: 20px; transition: all 0.3s; }
        .weight-card.active { border-color: #2563EB; background: rgba(37, 99, 235, 0.02); box-shadow: 0 0 0 4px #EFF6FF; }

        .weight-slider { width: 100%; height: 6px; background: #F1F5F9; border-radius: 3px; appearance: none; outline: none; margin: 16px 0; }
        .weight-slider::-webkit-slider-thumb { appearance: none; width: 18px; height: 18px; border-radius: 50%; background: #2563EB; border: 3px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); cursor: pointer; }

        .scoring-group { border: 2px solid #F1F5F9; border-radius: 20px; padding: 24px; margin-bottom: 24px; }
        .score-select { width: 100%; height: 44px; border-radius: 12px; border: 2px solid #F1F5F9; background: #F8FAFC; padding: 0 16px; font-size: 13px; font-weight: 700; color: #0F172A; cursor: pointer; }

        .btn-action { height: 48px; border-radius: 12px; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em; display: inline-flex; align-items: center; justify-content: center; gap: 10px; cursor: pointer; transition: all 0.2s; border: none; padding: 0 32px; }
        .btn-primary { background: #2563EB; color: #fff; box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3); }
        .btn-secondary { background: transparent; color: #64748B; }

        .footer-total { background: #0F172A; border-radius: 20px; padding: 32px; color: #fff; display: flex; justify-content: space-between; align-items: center; }

        .page-title { font-size: 26px; font-weight: 800; color: #0F172A; letter-spacing: -0.5px; margin-bottom: 4px; }
        .page-subtitle { font-size: 14px; color: #64748B; font-weight: 500; }
    </style>

    <div x-data="mooraWizard()">
        <x-breadcrumbs :links="[['label' => 'Program MOORA']]" />

        <div class="text-center mt-6 mb-8">
            <h1 class="page-title">Program Analisis MOORA</h1>
            <p class="page-subtitle">Tentukan tempat magang terbaikmu secara objektif dalam 3 langkah mudah</p>
        </div>

        <!-- Stepper UI (3 Steps) -->
        <div class="wizard-stepper">
            <div class="wizard-line"><div class="wizard-line-progress" :style="'width: ' + ((step-1)/2)*100 + '%'"></div></div>
            <div class="wizard-step" :class="step >= 1 ? 'active' : ''">
                <div class="wizard-circle">1</div>
                <span class="wizard-label">Pilih Tempat Magang & Kriteria</span>
            </div>
            <div class="wizard-step" :class="step >= 2 ? 'active' : ''">
                <div class="wizard-circle">2</div>
                <span class="wizard-label">Penilaian Kriteria</span>
            </div>
            <div class="wizard-step" :class="step >= 3 ? 'active' : ''">
                <div class="wizard-circle">3</div>
                <span class="wizard-label">Hasil Perhitungan</span>
            </div>
        </div>

        <form action="{{ route('moora.calculate') }}" method="POST">
            @csrf
            
            <!-- STEP 1: Full-Width Sections -->
            <div x-show="step === 1" x-transition>
                <!-- Bagian 1: Pilih Tempat Magang -->
                <div class="panel">
                    <div class="section-tag tag-emerald">Bagian 01</div>
                    <h3 class="text-xl font-extrabold text-slate-900 mb-2">Pilih Tempat Magang</h3>
                    <p class="text-sm text-slate-500 mb-8">Pilih setidaknya 2 perusahaan untuk dibandingkan.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($internships as $internship)
                            <div class="internship-card" :class="selectedInternships.includes('{{ $internship->id }}') ? 'selected' : ''" @click="toggleIntern('{{ $internship->id }}')">
                                <input type="checkbox" name="internships[]" value="{{ $internship->id }}" x-model="selectedInternships" class="hidden">
                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors" :class="selectedInternships.includes('{{ $internship->id }}') ? 'bg-emerald-500 border-emerald-500' : 'border-slate-200'">
                                    <i class="ti ti-check text-white text-[10px]" x-show="selectedInternships.includes('{{ $internship->id }}')"></i>
                                </div>
                                <div class="flex-1 overflow-hidden">
                                    <div class="font-bold text-slate-900 text-sm truncate">{{ $internship->name }}</div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase mt-1">{{ $internship->category->name ?? 'Umum' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Bagian 2: Atur Prioritas Kriteria -->
                <div class="panel">
                    <div class="section-tag tag-blue">Bagian 02</div>
                    <h3 class="text-xl font-extrabold text-slate-900 mb-2">Atur Prioritas Kriteria</h3>
                    <p class="text-sm text-slate-500 mb-8">Kunci (lock) bobot tertentu dan sistem akan menyeimbangkan sisanya secara otomatis.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($criterias as $criteria)
                            <div class="weight-card" :class="selectedCriterias['{{ $criteria->id }}'] ? 'active' : ''">
                                <div class="flex items-center justify-between gap-4 mb-4">
                                    <div class="flex items-center gap-4">
                                        <input type="checkbox" name="criteria[{{ $criteria->id }}]" id="c-{{ $criteria->id }}" x-model="selectedCriterias['{{ $criteria->id }}']" @change="balanceWeights()" class="hidden peer">
                                        <label for="c-{{ $criteria->id }}" class="relative w-11 h-6 bg-slate-200 rounded-full cursor-pointer transition-colors peer-checked:bg-blue-600">
                                            <div class="absolute top-[2px] left-[2px] bg-white rounded-full h-5 w-5 transition-transform" :class="selectedCriterias['{{ $criteria->id }}'] ? 'translate-x-5' : ''"></div>
                                        </label>
                                        <div>
                                            <span class="font-bold text-slate-900 text-sm block leading-none">{{ $criteria->name }}</span>
                                            <span class="text-[9px] font-extrabold uppercase mt-1 inline-block {{ strtolower($criteria->type) === 'benefit' ? 'text-emerald-500' : 'text-rose-500' }}">{{ $criteria->type }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3" x-show="selectedCriterias['{{ $criteria->id }}']">
                                        <button type="button" @click="toggleLock('{{ $criteria->id }}')" 
                                            :class="lockedWeights['{{ $criteria->id }}'] ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-400'"
                                            class="w-8 h-8 rounded-lg border-none transition-all flex items-center justify-center cursor-pointer hover:scale-110 shadow-sm">
                                            <i class="ti text-base" :class="lockedWeights['{{ $criteria->id }}'] ? 'ti-lock' : 'ti-lock-open'"></i>
                                        </button>
                                        <div class="text-xl font-extrabold text-blue-600"><span x-text="weights['{{ $criteria->id }}']"></span>%</div>
                                    </div>
                                </div>
                                <div x-show="selectedCriterias['{{ $criteria->id }}']">
                                    <input type="range" name="weights[{{ $criteria->id }}]" x-model.number="weights['{{ $criteria->id }}']" @input="manualAdjust('{{ $criteria->id }}')" min="5" max="90" class="weight-slider">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="footer-total mt-10">
                        <div class="flex items-center gap-8">
                            <div>
                                <p class="text-slate-400 text-[10px] font-extrabold uppercase tracking-widest mb-1">Akumulasi Bobot</p>
                                <div class="flex items-center gap-3">
                                    <span class="text-4xl font-extrabold" :class="totalWeight === 100 ? 'text-white' : 'text-blue-400'"><span x-text="totalWeight"></span>%</span>
                                    <span x-show="totalWeight === 100" class="text-emerald-400 text-xs font-bold"><i class="ti ti-circle-check"></i> Valid</span>
                                </div>
                            </div>
                            <div class="hidden md:flex flex-col gap-1">
                                <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wide">
                                    <i class="ti" :class="selectedInternships.length >= 2 ? 'ti-check text-emerald-400' : 'ti-x text-rose-400'"></i>
                                    <span :class="selectedInternships.length >= 2 ? 'text-slate-400' : 'text-rose-300'">Min. 2 Perusahaan</span>
                                </div>
                                <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wide">
                                    <i class="ti" :class="selectedCount >= 3 ? 'ti-check text-emerald-400' : 'ti-x text-rose-400'"></i>
                                    <span :class="selectedCount >= 3 ? 'text-slate-400' : 'text-rose-300'">Min. 3 Kriteria</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" @click="nextStep()" 
                            :disabled="totalWeight !== 100 || selectedInternships.length < 2 || selectedCount < 3" 
                            :class="(totalWeight === 100 && selectedInternships.length >= 2 && selectedCount >= 3) ? 'btn-primary' : 'bg-slate-700 text-slate-500 cursor-not-allowed'"
                            class="btn-action">
                            Lanjut ke Penilaian <i class="ti ti-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div x-show="step === 2" x-transition>
                <div class="panel">
                    <div class="section-tag tag-blue">Langkah 02</div>
                    <h3 class="text-xl font-extrabold text-slate-900 mb-2">Berikan Penilaian Objektif</h3>
                    <p class="text-sm text-slate-500 mb-10">Isi evaluasi setiap perusahaan berdasarkan kriteria terpilih.</p>

                    @foreach($internships as $internship)
                        <template x-if="selectedInternships.includes('{{ $internship->id }}')">
                            <div class="scoring-group">
                                <div class="flex items-center gap-4 mb-8 pb-4 border-b border-slate-50">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold">{{ substr($internship->name, 0, 1) }}</div>
                                    <div>
                                        <h4 class="font-extrabold text-slate-900 leading-none">{{ $internship->name }}</h4>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase mt-1">{{ $internship->category->name ?? 'Umum' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                                    @foreach($criterias as $criteria)
                                        <template x-if="selectedCriterias['{{ $criteria->id }}']">
                                            <div class="space-y-3">
                                                <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest">{{ $criteria->name }}</label>
                                                <select name="scores[{{ $internship->id }}][{{ $criteria->id }}]" class="score-select" required>
                                                    <option value="" disabled selected>Pilih Nilai...</option>
                                                    @foreach($criteria->scales as $scale)
                                                        <option value="{{ $scale->score }}">{{ $scale->description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </template>
                                    @endforeach
                                </div>
                            </div>
                        </template>
                    @endforeach

                    <div class="flex justify-between items-center mt-10 pt-8 border-t border-slate-100">
                        <button type="button" @click="step = 1" class="btn-action btn-secondary"><i class="ti ti-arrow-left"></i> Kembali</button>
                        <button type="submit" class="btn-action btn-primary">Kalkulasi Hasil MOORA <i class="ti ti-chart-bar"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function mooraWizard() {
            return {
                step: 1,
                selectedCriterias: {},
                lockedWeights: {
                    @foreach($criterias as $criteria)
                        '{{ $criteria->id }}': false,
                    @endforeach
                },
                weights: {
                    @foreach($criterias as $criteria)
                        '{{ $criteria->id }}': 0,
                    @endforeach
                },
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

                toggleIntern(id) {
                    if(this.selectedInternships.includes(id)) {
                        this.selectedInternships = this.selectedInternships.filter(i => i !== id);
                    } else {
                        this.selectedInternships.push(id);
                    }
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
                    this.step = 2;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                init() {
                    @foreach($userWeights as $id => $w)
                        this.selectedCriterias['{{ $id }}'] = true;
                        this.weights['{{ $id }}'] = {{ (int)$w }};
                    @endforeach
                    if (this.selectedCount === 0) {
                        [1, 2, 3].forEach(id => { this.selectedCriterias[id] = true; });
                        this.balanceWeights();
                    }
                }
            }
        }
    </script>
</x-app-layout>
