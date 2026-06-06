<x-admin-layout>
    <div class="max-w-7xl mx-auto">
        <div class="mb-10">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Kontribusi Mahasiswa</h1>
            <p class="text-slate-500 text-sm mt-1 font-bold uppercase tracking-widest text-[10px]">Daftar perusahaan yang ditambahkan secara pribadi oleh mahasiswa.</p>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl flex items-center gap-3 animate-fade-in">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-2xl flex items-center gap-3 animate-fade-in">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <span class="text-xs font-bold uppercase tracking-widest">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-slate-900 border-b border-slate-800">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Penginput</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Nama Perusahaan</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Bidang</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($internships as $i)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-400 border border-slate-200">
                                        {{ substr($i->user->name, 0, 1) }}
                                    </div>
                                    <p class="text-xs font-bold text-slate-600 truncate max-w-[120px]">{{ $i->user->name }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <p class="text-sm font-bold text-slate-700 capitalize tracking-tight">{{ $i->name }}</p>
                                @if($i->website_link)
                                    <a href="{{ $i->website_link }}" target="_blank" class="text-[9px] text-blue-600 font-black uppercase hover:underline mt-1 inline-block">Visit Website</a>
                                @else
                                    <span class="text-[9px] text-slate-300 font-bold uppercase mt-1 inline-block italic">No Link Provided</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="px-3 py-1 bg-slate-50 text-slate-600 text-[10px] font-black rounded-lg border border-slate-100 italic capitalize">
                                    {{ $i->category->name ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.internships.edit', $i) }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-slate-200 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.user-internships.promote', $i) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition active:scale-95">
                                            Promote to Global
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-20 text-center">
                                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada kontribusi data dari mahasiswa.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-slate-50">
                @forelse($internships as $i)
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-6 bg-slate-50 p-3 rounded-2xl border border-slate-100">
                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-[10px] font-black text-slate-400 border border-slate-200 shadow-sm">
                            {{ substr($i->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Diinput Oleh:</p>
                            <p class="text-[10px] font-bold text-slate-600 uppercase">{{ $i->user->name }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-black text-slate-900 text-base leading-tight capitalize">{{ $i->name }}</h4>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="px-3 py-1 bg-slate-50 text-slate-600 text-[10px] font-black rounded-lg border border-slate-100 italic capitalize">
                                {{ $i->category->name ?? 'Umum' }}
                            </span>
                            @if($i->website_link)
                                <a href="{{ $i->website_link }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center text-white shadow-md active:scale-95 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('admin.internships.edit', $i) }}" class="flex-1 flex items-center justify-center py-3 bg-white border border-slate-200 text-slate-700 font-black text-[10px] uppercase tracking-widest rounded-2xl shadow-sm active:scale-95 transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.user-internships.promote', $i) }}" method="POST" class="flex-[1.5]">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center py-3 bg-blue-600 text-white font-black text-[10px] uppercase tracking-widest rounded-2xl shadow-lg shadow-blue-500/20 active:scale-95 transition">
                                Promote to Global
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="py-20 text-center">
                    <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest">Belum ada kontribusi mahasiswa.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>
