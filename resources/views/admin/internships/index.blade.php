<x-admin-layout>
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Direktori Perusahaan</h1>
                <p class="text-slate-500 text-sm mt-2 font-bold uppercase tracking-widest text-[10px]">Kelola data perusahaan magang global untuk referensi mahasiswa.</p>
            </div>
            <a href="{{ route('admin.internships.create') }}" class="inline-flex items-center px-8 py-4 bg-blue-600 border border-transparent rounded-[1.5rem] font-black text-xs text-white uppercase tracking-widest hover:bg-blue-700 shadow-xl shadow-blue-500/20 transition transform active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                Tambah Perusahaan
            </a>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl flex items-center gap-3 animate-fade-in">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-slate-900 border-b border-slate-800">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Nama Perusahaan</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Bidang / Sektor</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Link Website</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($internships as $i)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-5 text-center">
                                <p class="text-sm font-bold text-slate-700 capitalize tracking-tight">{{ $i->name }}</p>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg border border-blue-100 italic capitalize">
                                    {{ $i->category->name ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <a href="{{ $i->website_link }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    Visit Site
                                </a>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.internships.edit', $i) }}" class="action-btn bg-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.internships.destroy', $i) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn bg-red-50 text-red-500 hover:bg-red-600 hover:text-white transition" onclick="return confirm('Hapus perusahaan ini?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-slate-50">
                @foreach($internships as $i)
                <div class="p-6">
                    <div class="mb-4">
                        <h4 class="font-black text-slate-900 text-base leading-tight capitalize">{{ $i->name }}</h4>
                        <span class="inline-block mt-2 px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg border border-blue-100 italic capitalize">
                            {{ $i->category->name ?? 'Umum' }}
                        </span>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <a href="{{ route('admin.internships.edit', $i) }}" class="flex-1 flex items-center justify-center py-3 bg-white border border-slate-200 text-slate-700 font-black text-[10px] uppercase tracking-widest rounded-2xl shadow-sm active:scale-95 transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.internships.destroy', $i) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center py-3 bg-red-50 text-red-600 font-black text-[10px] uppercase tracking-widest rounded-2xl active:scale-95 transition" onclick="return confirm('Hapus perusahaan ini?')">
                                Hapus
                            </button>
                        </form>
                    </div>

                    <a href="{{ $i->website_link }}" target="_blank" class="w-full mt-3 flex items-center justify-center py-3 bg-slate-900 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl shadow-lg shadow-slate-900/20 active:scale-95 transition">
                        <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Visit Website
                    </a>
                </div>
                @endforeach
            </div>

            @if($internships->isEmpty())
            <div class="py-20 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-[1.5rem] flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada data perusahaan.</p>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
