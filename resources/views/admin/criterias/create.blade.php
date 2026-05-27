<x-admin-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('admin.criterias.index') }}" class="inline-flex items-center text-xs font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <h1 class="text-3xl font-black text-slate-900">Tambah Kriteria Baru</h1>
            <p class="text-slate-500 text-sm mt-2">Masukkan detail kriteria untuk parameter perhitungan.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-12">
            <form action="{{ route('admin.criterias.store') }}" method="POST" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <x-input-label for="code" value="Kode Kriteria (Contoh: C1)" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                        <x-text-input id="code" name="code" type="text" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" :value="old('code')" required />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="name" value="Nama Kriteria" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                        <x-text-input id="name" name="name" type="text" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="type" value="Tipe Kriteria" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                    <select id="type" name="type" class="block w-full bg-slate-50 border-transparent focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition py-3 px-4 text-sm font-bold text-slate-700">
                        <option value="benefit" {{ old('type') == 'benefit' ? 'selected' : '' }}>BENEFIT (Semakin besar semakin baik)</option>
                        <option value="cost" {{ old('type') == 'cost' ? 'selected' : '' }}>COST (Semakin kecil semakin baik)</option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <div class="pt-4">
                    <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 py-4 rounded-2xl shadow-xl shadow-blue-500/20 text-xs font-black uppercase tracking-[0.2em]">
                        Simpan Kriteria
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
