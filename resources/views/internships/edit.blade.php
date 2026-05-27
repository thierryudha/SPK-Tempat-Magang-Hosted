<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Tempat Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :links="[
                ['label' => 'Daftar Tempat Magang', 'url' => route('internships.index')],
                ['label' => 'Edit Tempat Magang']
            ]" />
            <div class="bg-white overflow-hidden shadow-2xl rounded-[2.5rem] border border-slate-100">
                <div class="p-8 md:p-12">
                    <form action="{{ route('internships.update', $internship) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-8">
                            <x-input-label for="name" value="Nama Perusahaan" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                            <x-text-input id="name" name="name" type="text" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" :value="old('name', $internship->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <x-input-label for="category_id" value="Bidang Perusahaan" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                                <select id="category_id" name="category_id" class="block w-full border-transparent bg-slate-50 focus:bg-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition py-3 px-4 text-sm font-bold text-slate-700">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $internship->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="city" value="Kota" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                                <x-text-input id="city" name="city" type="text" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" :value="old('city', $internship->city)" required />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-10">
                            <x-input-label for="description" value="Deskripsi Singkat" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                            <textarea id="description" name="description" class="block w-full border-transparent bg-slate-50 focus:bg-white rounded-[1.5rem] shadow-sm focus:border-blue-500 focus:ring-blue-500 transition py-3 px-4 text-sm font-bold text-slate-700" rows="4">{{ old('description', $internship->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-6">
                            <a href="{{ route('internships.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition">Batal</a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700 px-10 py-4 rounded-2xl shadow-xl shadow-blue-500/20 transition transform active:scale-95 text-[10px] font-black uppercase tracking-[0.2em]">
                                Update Perusahaan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
