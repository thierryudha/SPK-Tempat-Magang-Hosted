<x-admin-layout>
    <div class="mt-4">
        <x-breadcrumbs :links="[
            ['label' => 'Administrator', 'url' => route('admin.administrators.index')],
            ['label' => 'Edit']
        ]" />
        
        <div class="mb-8">
            <h1 class="text-[26px] font-[800] text-[#0F172A] tracking-tight leading-none mb-2">Edit Administrator</h1>
            <p class="text-[14px] text-[#64748B] font-medium">Perbarui informasi akun administrator <span class="text-[#2563EB] font-bold">{{ $admin->name }}</span>.</p>
        </div>

        <div class="max-w-3xl">
            <div class="bg-white border-[0.5px] border-[#E2E8F0] rounded-[16px] shadow-sm shadow-slate-200/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-[#F1F5F9]">
                    <h3 class="text-[15px] font-bold text-[#0F172A] flex items-center gap-2">
                        <i class="ti ti-user-edit text-[#2563EB]"></i>
                        Informasi Akun
                    </h3>
                </div>

                <form action="{{ route('admin.administrators.update', $admin) }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2">
                        <x-input-label for="name" value="Nama Lengkap" class="text-[12px] font-bold text-[#64748B] ml-1" />
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#94A3B8] group-focus-within:text-[#2563EB] transition-colors">
                                <i class="ti ti-user text-lg"></i>
                            </div>
                            <input id="name" name="name" type="text" 
                                class="block w-full pl-11 pr-4 py-3 bg-[#F8FAFC] border-[0.5px] border-[#E2E8F0] text-[#0F172A] text-[14px] font-medium rounded-[12px] focus:bg-white focus:border-[#2563EB] focus:ring-4 focus:ring-blue-500/5 transition-all outline-none" 
                                value="{{ old('name', $admin->name) }}" required placeholder="Masukkan nama lengkap" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1 ml-1" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="email" value="Alamat Email" class="text-[12px] font-bold text-[#64748B] ml-1" />
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#94A3B8] group-focus-within:text-[#2563EB] transition-colors">
                                <i class="ti ti-mail text-lg"></i>
                            </div>
                            <input id="email" name="email" type="email" 
                                class="block w-full pl-11 pr-4 py-3 bg-[#F8FAFC] border-[0.5px] border-[#E2E8F0] text-[#0F172A] text-[14px] font-medium rounded-[12px] focus:bg-white focus:border-[#2563EB] focus:ring-4 focus:ring-blue-500/5 transition-all outline-none" 
                                value="{{ old('email', $admin->email) }}" required placeholder="nama@email.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1 ml-1" />
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between ml-1">
                            <x-input-label for="password" value="Password Baru" class="text-[12px] font-bold text-[#64748B]" />
                            <span class="text-[10px] font-bold text-[#94A3B8] uppercase tracking-wider italic">Kosongkan jika tidak ingin ganti</span>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#94A3B8] group-focus-within:text-[#2563EB] transition-colors">
                                <i class="ti ti-lock text-lg"></i>
                            </div>
                            <input id="password" name="password" type="password" 
                                class="block w-full pl-11 pr-4 py-3 bg-[#F8FAFC] border-[0.5px] border-[#E2E8F0] text-[#0F172A] text-[14px] font-medium rounded-[12px] focus:bg-white focus:border-[#2563EB] focus:ring-4 focus:ring-blue-500/5 transition-all outline-none" 
                                placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 ml-1" />
                    </div>

                    <div class="pt-4 flex items-center gap-3">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 h-[48px] bg-[#2563EB] text-white text-[14px] font-bold rounded-[10px] hover:bg-[#1D4ED8] transition-all shadow-sm shadow-blue-500/20">
                            <i class="ti ti-device-floppy text-lg"></i>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.administrators.index') }}" class="inline-flex items-center justify-center px-6 h-[48px] bg-[#F1F5F9] text-[#475569] text-[14px] font-bold rounded-[10px] hover:bg-[#E2E8F0] transition-all">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
