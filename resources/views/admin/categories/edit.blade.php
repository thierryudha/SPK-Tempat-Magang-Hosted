<x-admin-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-xs font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Bidang</h1>
            <p class="text-slate-500 text-sm mt-1">Perbarui nama kategori industri.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-12">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                <div>
                    <x-input-label for="name" value="Nama Bidang / Sektor" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                    <x-text-input id="name" name="name" type="text" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" :value="old('name', $category->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="pt-4">
                    <x-primary-button class="w-full justify-center bg-slate-900 hover:bg-slate-800 py-4 rounded-2xl shadow-xl shadow-slate-900/20 text-xs font-black uppercase tracking-[0.2em]">
                        Simpan Perubahan
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
