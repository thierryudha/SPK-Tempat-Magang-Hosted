<x-admin-layout>
    <div class="mt-4">
        <x-breadcrumbs :links="[
            ['label' => 'Mahasiswa', 'url' => route('admin.users.index')],
            ['label' => 'Tambah Mahasiswa']
        ]" />
        
        <div class="mb-8">
            <h1 class="text-[26px] font-[800] text-[#0F172A] tracking-tight leading-none mb-2">Tambah Mahasiswa</h1>
            <p class="text-[14px] text-[#64748B] font-medium">Daftarkan akun mahasiswa baru ke dalam sistem.</p>
        </div>

        <div class="max-w-2xl">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <div class="bg-white border-[0.5px] border-[#E2E8F0] rounded-[16px] overflow-hidden shadow-sm shadow-slate-200/50 mb-8">
                    <div class="px-6 py-5 border-b border-[#F1F5F9]">
                        <h3 class="text-[15px] font-bold text-[#0F172A]">Informasi Akun</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="space-y-2">
                            <label for="name" class="text-[12px] font-bold text-[#64748B] uppercase tracking-wider">Nama Lengkap</label>
                            <input type="text" id="name" name="name" 
                                class="w-full h-[48px] px-4 bg-[#F8FAFC] border border-[#E2E8F0] rounded-[10px] text-[14px] font-semibold text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/5 transition-all" 
                                required placeholder="Masukkan nama lengkap" value="{{ old('name') }}">
                            @error('name') <p class="text-rose-500 text-[11px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-[12px] font-bold text-[#64748B] uppercase tracking-wider">Alamat Email</label>
                            <input type="email" id="email" name="email" 
                                class="w-full h-[48px] px-4 bg-[#F8FAFC] border border-[#E2E8F0] rounded-[10px] text-[14px] font-semibold text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/5 transition-all" 
                                required placeholder="email@contoh.com" value="{{ old('email') }}">
                            @error('email') <p class="text-rose-500 text-[11px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="text-[12px] font-bold text-[#64748B] uppercase tracking-wider">Password Akun</label>
                            <input type="password" id="password" name="password" 
                                class="w-full h-[48px] px-4 bg-[#F8FAFC] border border-[#E2E8F0] rounded-[10px] text-[14px] font-semibold text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/5 transition-all" 
                                required placeholder="Min. 8 karakter">
                            @error('password') <p class="text-rose-500 text-[11px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-8 h-[48px] bg-[#2563EB] text-white text-[14px] font-bold rounded-[12px] hover:bg-[#1D4ED8] transition-all shadow-lg shadow-blue-500/20 active:scale-[0.98]">
                        <i class="ti ti-user-plus text-lg"></i>
                        Daftarkan Mahasiswa
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-8 h-[48px] bg-[#F1F5F9] text-[#475569] text-[14px] font-bold rounded-[12px] hover:bg-[#E2E8F0] transition-all active:scale-[0.98]">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
