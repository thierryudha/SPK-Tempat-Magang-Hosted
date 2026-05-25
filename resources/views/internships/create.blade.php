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
            <div class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                    Pilih dari daftar yang sudah ada
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($globalInternships as $global)
                        <button type="button" 
                                @click="fillForm({ 
                                    name: '{{ $global->name }}', 
                                    city: '{{ $global->city }}', 
                                    category: '{{ $global->category }}', 
                                    description: '{{ $global->description }}' 
                                })"
                                class="text-left p-3 border rounded-xl hover:bg-blue-50 hover:border-blue-200 transition group relative">
                            <div class="font-bold text-sm group-hover:text-blue-700">{{ $global->name }}</div>
                            <div class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $global->city }} • {{ $global->category }}</div>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"></path></svg>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('internships.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label for="name" value="Nama Perusahaan" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-50 border-gray-200 focus:bg-white transition" x-model="formData.name" required placeholder="Contoh: PT. Teknologi Maju" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="relative" x-data="{ open: false, search: '' }">
                                <x-input-label for="city" value="Kota Lokasi" />
                                <div class="relative mt-1">
                                    <input type="text" 
                                           id="city" 
                                           name="city" 
                                           x-model="formData.city"
                                           @focus="open = true"
                                           @click.away="open = false"
                                           class="block w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                                           placeholder="Ketik atau pilih kota..."
                                           required>
                                    <div x-show="open" 
                                         class="absolute z-20 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm custom-scrollbar"
                                         x-transition>
                                        <template x-for="city in filteredCities" :key="city">
                                            <div @click="formData.city = city; open = false" 
                                                 class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-blue-600 hover:text-white transition">
                                                <span class="block truncate" x-text="city"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="category" value="Bidang Perusahaan" />
                            <select id="category" name="category" x-model="formData.category" class="mt-1 block w-full border-gray-200 bg-gray-50 focus:bg-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
                                @foreach($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div class="mb-8">
                            <x-input-label for="description" value="Deskripsi Singkat" />
                            <textarea id="description" name="description" x-model="formData.description" class="mt-1 block w-full border-gray-200 bg-gray-50 focus:bg-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 transition" rows="4" placeholder="Apa yang menarik dari tempat ini?"></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('internships.index') }}" class="text-gray-500 font-bold hover:text-gray-700 transition">Batal</a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700 px-8 py-3 rounded-xl shadow-lg shadow-blue-100 transition transform active:scale-95">
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
                    category: 'Software House',
                    description: ''
                },
                cities: {!! json_encode($indonesianCities) !!},
                fillForm(data) {
                    this.formData = data;
                    // Trigger scroll to form
                    window.scrollTo({ top: document.querySelector('form').offsetTop - 100, behavior: 'smooth' });
                },
                get filteredCities() {
                    if (this.formData.city === '') return this.cities;
                    return this.cities.filter(c => c.toLowerCase().includes(this.formData.city.toLowerCase()));
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</x-app-layout>
