<x-admin-layout>
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Manajemen Bidang</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola daftar sektor industri perusahaan magang.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                Tambah Bidang
            </a>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden w-full">
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-900 border-b border-slate-800">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Nama Bidang / Sektor Industri</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Tindakan Pengelola</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($categories as $cat)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-5 text-center">
                                <p class="text-sm font-bold text-slate-700">{{ $cat->name }}</p>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('admin.categories.edit', $cat) }}" class="action-btn bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus bidang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn bg-red-50 text-red-600 hover:bg-red-600 hover:text-white shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h14"></path></svg>
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
                @foreach($categories as $cat)
                <div class="p-6 text-center">
                    <h4 class="font-black text-slate-900 text-base leading-tight mb-4">{{ $cat->name }}</h4>
                    <div class="flex gap-3 mt-4">
                        <a href="{{ route('admin.categories.edit', $cat) }}" class="flex-1 flex items-center justify-center py-2.5 bg-white border border-slate-200 text-slate-700 font-black text-[10px] uppercase tracking-widest rounded-xl shadow-sm active:scale-95 transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center py-2.5 bg-red-50 text-red-600 font-black text-[10px] uppercase tracking-widest rounded-xl active:scale-95 transition" onclick="return confirm('Hapus bidang ini?')">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-admin-layout>
