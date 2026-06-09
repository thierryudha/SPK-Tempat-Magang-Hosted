<x-admin-layout>
    <div class="mt-4">
        <x-breadcrumbs :links="[
            ['label' => 'Perusahaan', 'url' => route('admin.internships.index')],
            ['label' => 'Edit Perusahaan']
        ]" />
        
        <div class="mb-8">
            <h1 class="text-[26px] font-[800] text-[#0F172A] tracking-tight leading-none mb-2">Edit Perusahaan</h1>
            <p class="text-[14px] text-[#64748B] font-medium">Perbarui detail perusahaan <span class="text-[#2563EB] font-bold">{{ $internship->name }}</span>.</p>
        </div>

        <div class="max-w-2xl">
            <form action="{{ route('admin.internships.update', $internship) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="bg-white border-[0.5px] border-[#E2E8F0] rounded-[16px] overflow-hidden shadow-sm shadow-slate-200/50 mb-8">
                    <div class="px-6 py-5 border-b border-[#F1F5F9]">
                        <h3 class="text-[15px] font-bold text-[#0F172A]">Detail Perusahaan</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="space-y-2">
                            <label for="name" class="text-[12px] font-bold text-[#64748B] uppercase tracking-wider">Nama Perusahaan</label>
                            <input type="text" id="name" name="name" 
                                class="w-full h-[48px] px-4 bg-[#F8FAFC] border border-[#E2E8F0] rounded-[10px] text-[14px] font-semibold text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/5 transition-all" 
                                required placeholder="Contoh: PT. Teknologi Maju" value="{{ old('name', $internship->name) }}">
                            @error('name') <p class="text-rose-500 text-[11px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="category_id" class="text-[12px] font-bold text-[#64748B] uppercase tracking-wider">Bidang / Sektor Industri</label>
                            <select id="category_id" name="category_id" 
                                class="w-full h-[48px] px-4 bg-[#F8FAFC] border border-[#E2E8F0] rounded-[10px] text-[14px] font-semibold text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/5 transition-all appearance-none" 
                                required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $internship->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-rose-500 text-[11px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="website_link" class="text-[12px] font-bold text-[#64748B] uppercase tracking-wider">Link Website / Lowongan</label>
                            <input type="url" id="website_link" name="website_link" 
                                class="w-full h-[48px] px-4 bg-[#F8FAFC] border border-[#E2E8F0] rounded-[10px] text-[14px] font-semibold text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/5 transition-all" 
                                required placeholder="https://perusahaan.com/karir" value="{{ old('website_link', $internship->website_link) }}">
                            @error('website_link') <p class="text-rose-500 text-[11px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-8 h-[48px] bg-[#2563EB] text-white text-[14px] font-bold rounded-[12px] hover:bg-[#1D4ED8] transition-all shadow-lg shadow-blue-500/20 active:scale-[0.98]">
                        <i class="ti ti-device-floppy text-lg"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.internships.index') }}" class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-8 h-[48px] bg-[#F1F5F9] text-[#475569] text-[14px] font-bold rounded-[12px] hover:bg-[#E2E8F0] transition-all active:scale-[0.98]">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
