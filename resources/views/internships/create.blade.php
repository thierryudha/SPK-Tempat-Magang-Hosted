<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Tempat Magang') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="internshipForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :links="[
                ['label' => 'Daftar Tempat Magang', 'url' => route('internships.index')],
                ['label' => 'Tambah Tempat Magang']
            ]" />
            
            <!-- Global Suggestions (Collapsible) -->
            @if(isset($globalInternships) && $globalInternships->isNotEmpty())
            <div class="mb-8 bg-white overflow-hidden rounded-3xl shadow-sm border border-slate-100" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between p-6 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-2 rounded-xl mr-4">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div class="text-left">
                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider">Pilih dari Daftar Tersedia</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-tight mt-0.5">Ada {{ $globalInternships->count() }} rekomendasi tempat magang</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" 
                         :class="open ? 'rotate-180' : ''" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="p-6 pt-0 border-t border-slate-50 bg-slate-50/50">
                    
                    <form action="{{ route('internships.bulk') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-80 overflow-y-auto pr-2 custom-scrollbar my-4">
                            @foreach($globalInternships as $global)
                                <div class="relative flex items-center p-4 bg-white border border-slate-100 rounded-2xl hover:border-blue-400 hover:shadow-md transition-all cursor-pointer group"
                                     @click="fillForm({ 
                                         name: '{{ $global->name }}', 
                                         category_id: '{{ $global->category_id }}', 
                                         website_link: '{{ $global->website_link }}'
                                     })">
                                    <input type="checkbox" name="ids[]" value="{{ $global->id }}" 
                                           class="w-5 h-5 text-blue-600 border-slate-200 rounded-lg focus:ring-blue-500 transition cursor-pointer"
                                           @click.stop
                                           @change="updateSelectedCount()">
                                    <div class="ml-4 flex-1">
                                        <div class="font-black text-sm text-slate-800 capitalize group-hover:text-blue-600">{{ $global->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tight mt-1">{{ $global->category->name ?? 'Umum' }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between mt-6 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Terpilih: <span class="text-blue-600" x-text="selectedCount">0</span>
                            </span>
                            <x-primary-button type="submit" 
                                              x-show="selectedCount > 0"
                                              class="bg-slate-800 hover:bg-slate-900 px-6 py-3 rounded-xl shadow-lg transition transform active:scale-95 text-[9px] font-black uppercase tracking-[0.15em]">
                                Tambahkan yang Terpilih
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl rounded-[2.5rem] border border-slate-100">
                <div class="p-8 md:p-12">
                    <div class="mb-10">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center">
                            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mr-4 shadow-sm border border-blue-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            Informasi Tempat Magang Baru
                        </h3>
                    </div>

                    <form action="{{ route('internships.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-8">
                            <div>
                                <x-input-label for="name" value="Nama Perusahaan" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                                <x-text-input id="name" name="name" type="text" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" x-model="formData.name" required placeholder="Contoh: PT Teknologi Maju" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="category_id" value="Bidang Perusahaan" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                                <select id="category_id" name="category_id" x-model="formData.category_id" class="block w-full border-transparent bg-slate-50 focus:bg-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition py-3 px-4 text-sm font-bold text-slate-700">
                                    <option value="">Pilih Bidang</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="website_link" value="Link Website / Lowongan (Opsional)" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                                <x-text-input id="website_link" name="website_link" type="url" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" x-model="formData.website_link" placeholder="https://perusahaan.com/karir" />
                                <x-input-error :messages="$errors->get('website_link')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-6 border-t border-slate-50 pt-10 mt-10">
                            <a href="{{ route('internships.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition">Batal</a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700 px-10 py-4 rounded-2xl shadow-xl shadow-blue-500/20 transition transform active:scale-95 text-[10px] font-black uppercase tracking-[0.2em]">
                                Simpan Tempat Magang
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function internshipForm() {
            return {
                formData: {
                    name: '{{ old('name', '') }}',
                    category_id: '{{ old('category_id', '') }}',
                    website_link: '{{ old('website_link', '') }}'
                },
                selectedCount: 0,
                fillForm(data) {
                    this.formData.name = data.name;
                    this.formData.category_id = data.category_id;
                    this.formData.website_link = data.website_link;
                    window.scrollTo({ top: document.querySelector('form').offsetTop - 100, behavior: 'smooth' });
                },
                updateSelectedCount() {
                    this.selectedCount = document.querySelectorAll('input[name="ids[]"]:checked').length;
                }
            }
        }
    </script>
</x-app-layout>
