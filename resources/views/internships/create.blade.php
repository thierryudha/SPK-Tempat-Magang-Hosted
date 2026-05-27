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
            
            <!-- Global Suggestions -->
            @if($globalInternships->isNotEmpty())
            <div class="mb-8 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                    Pilih dari daftar yang sudah ada
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-56 overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($globalInternships as $global)
                        <button type="button" 
                                @click="fillForm({ 
                                    name: '{{ $global->name }}', 
                                    city: '{{ $global->city }}', 
                                    category_id: '{{ $global->category_id }}', 
                                    description: '{{ $global->description }}' 
                                })"
                                class="text-left p-4 bg-slate-50 border border-slate-100 rounded-[1.5rem] hover:bg-white hover:border-blue-400 hover:shadow-md transition-all group relative">
                            <div class="font-black text-sm text-slate-800 capitalize group-hover:text-blue-600">{{ $global->name }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tight mt-1 capitalize">{{ $global->city }} • {{ $global->category->name ?? 'Umum' }}</div>
                        </button>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl rounded-[2.5rem] border border-slate-100">
                <div class="p-8 md:p-12">
                    <form action="{{ route('internships.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <x-input-label for="name" value="Nama Perusahaan" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                                <x-text-input id="name" name="name" type="text" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" x-model="formData.name" required placeholder="Contoh: PT Teknologi Maju" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="relative" x-data="{ open: false }">
                                <x-input-label for="city" value="Kota Lokasi" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                                <div class="relative">
                                    <input type="text" 
                                           id="city" 
                                           name="city" 
                                           x-model="formData.city"
                                           @focus="open = true"
                                           @click.away="open = false"
                                           autocomplete="off"
                                           class="block w-full rounded-xl border-transparent bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 shadow-sm transition py-3 px-4 text-sm font-bold text-slate-700"
                                           placeholder="Ketik kota..."
                                           required>
                                    <div x-show="open" 
                                         class="absolute z-20 mt-2 w-full bg-white shadow-2xl border border-slate-100 max-h-60 rounded-2xl py-2 text-base overflow-auto focus:outline-none sm:text-sm custom-scrollbar"
                                         x-transition>
                                        <template x-for="city in filteredCities" :key="city">
                                            <div @click="formData.city = city; open = false" 
                                                 class="cursor-pointer select-none relative py-2.5 px-5 hover:bg-blue-600 hover:text-white transition-colors text-xs font-bold text-slate-600">
                                                <span class="block truncate" x-text="city"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-8">
                            <x-input-label for="category_id" value="Bidang Perusahaan" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                            <select id="category_id" name="category_id" x-model="formData.category_id" class="block w-full border-transparent bg-slate-50 focus:bg-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition py-3 px-4 text-sm font-bold text-slate-700">
                                <option value="">Pilih Bidang</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div class="mb-10">
                            <x-input-label for="description" value="Deskripsi Singkat" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                            <textarea id="description" name="description" x-model="formData.description" class="block w-full border-transparent bg-slate-50 focus:bg-white rounded-[1.5rem] shadow-sm focus:border-blue-500 focus:ring-blue-500 transition py-3 px-4 text-sm font-bold text-slate-700" rows="4" placeholder="Apa yang menarik dari tempat ini?"></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-6">
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
                    name: '',
                    city: '',
                    category_id: '',
                    description: ''
                },
                cities: {!! json_encode($indonesianCities) !!},
                fillForm(data) {
                    this.formData = data;
                    window.scrollTo({ top: document.querySelector('form').offsetTop - 100, behavior: 'smooth' });
                },
                get filteredCities() {
                    if (!this.formData.city) return this.cities;
                    return this.cities.filter(c => c.toLowerCase().includes(this.formData.city.toLowerCase()));
                }
            }
        }
    </script>
</x-app-layout>
