<x-admin-layout>
    <div class="mt-4">
        <x-breadcrumbs :links="[
            ['label' => 'Kriteria', 'url' => route('admin.criterias.index')],
            ['label' => 'Edit Kriteria']
        ]" />
        
        <div class="mb-8">
            <h1 class="text-[26px] font-[800] text-[#0F172A] tracking-tight leading-none mb-2">Edit Kriteria</h1>
            <p class="text-[14px] text-[#64748B] font-medium">Perbarui informasi kriteria dan deskripsi skalanya untuk perhitungan MOORA.</p>
        </div>

        <div class="max-w-4xl">
            <form action="{{ route('admin.criterias.update', $criteria) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="bg-white border-[0.5px] border-[#E2E8F0] rounded-[16px] overflow-hidden shadow-sm shadow-slate-200/50 mb-6">
                    <div class="px-6 py-5 border-b border-[#F1F5F9]">
                        <h3 class="text-[15px] font-bold text-[#0F172A]">Informasi Dasar</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="text-[12px] font-bold text-[#64748B] uppercase tracking-wider">Nama Kriteria</label>
                                <input type="text" id="name" name="name" 
                                    class="w-full h-[44px] px-4 bg-[#F8FAFC] border border-[#E2E8F0] rounded-[10px] text-[14px] font-semibold text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/5 transition-all" 
                                    required placeholder="Contoh: Gaji / Uang Saku" value="{{ old('name', $criteria->name) }}">
                                @error('name') <p class="text-rose-500 text-[11px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="type" class="text-[12px] font-bold text-[#64748B] uppercase tracking-wider">Jenis Kriteria</label>
                                <select id="type" name="type" 
                                    class="w-full h-[44px] px-4 bg-[#F8FAFC] border border-[#E2E8F0] rounded-[10px] text-[14px] font-semibold text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/5 transition-all">
                                    <option value="benefit" {{ old('type', $criteria->type) == 'benefit' ? 'selected' : '' }}>Benefit (Semakin besar semakin baik)</option>
                                    <option value="cost" {{ old('type', $criteria->type) == 'cost' ? 'selected' : '' }}>Cost (Semakin kecil semakin baik)</option>
                                </select>
                                @error('type') <p class="text-rose-500 text-[11px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border-[0.5px] border-[#E2E8F0] rounded-[16px] overflow-hidden shadow-sm shadow-slate-200/50 mb-8">
                    <div class="px-6 py-5 border-b border-[#F1F5F9] flex items-center gap-2">
                        <i class="ti ti-list-numbers text-[#2563EB] text-lg"></i>
                        <h3 class="text-[15px] font-bold text-[#0F172A]">Definisi Skala Penilaian (1-5)</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @for($i = 1; $i <= 5; $i++)
                        @php
                            $scale = $criteria->scales->where('score', $i)->first();
                        @endphp
                        <div class="flex items-start gap-4 p-4 bg-[#F8FAFC] rounded-xl border border-[#E2E8F0]/50">
                            <div class="w-10 h-10 bg-[#0F172A] text-white flex items-center justify-center rounded-[10px] text-[16px] font-extrabold flex-shrink-0 shadow-lg shadow-slate-900/10">
                                {{ $i }}
                            </div>
                            <div class="flex-1 space-y-2">
                                <label class="text-[11px] font-bold text-[#94A3B8] uppercase tracking-widest">Deskripsi Skor {{ $i }}</label>
                                <input type="text" name="scales[{{ $i }}]" 
                                    class="w-full h-[44px] px-4 bg-white border border-[#E2E8F0] rounded-[10px] text-[14px] font-semibold text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/5 transition-all" 
                                    required placeholder="Deskripsi untuk skor {{ $i }}..." value="{{ old('scales.'.$i, $scale ? $scale->description : '') }}">
                                @error('scales.'.$i) <p class="text-rose-500 text-[11px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-8 h-[48px] bg-[#2563EB] text-white text-[14px] font-bold rounded-[12px] hover:bg-[#1D4ED8] transition-all shadow-lg shadow-blue-500/20 active:scale-[0.98]">
                        <i class="ti ti-device-floppy text-lg"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.criterias.index') }}" class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-8 h-[48px] bg-[#F1F5F9] text-[#475569] text-[14px] font-bold rounded-[12px] hover:bg-[#E2E8F0] transition-all active:scale-[0.98]">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
