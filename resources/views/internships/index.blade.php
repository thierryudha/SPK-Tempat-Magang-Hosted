<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Tempat Magang') }}
            </h2>
            <a href="{{ route('internships.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-2xl font-black text-[10px] text-white uppercase tracking-widest hover:bg-blue-700 shadow-xl shadow-blue-500/20 transition transform active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Tambah Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :links="[['label' => 'Daftar Tempat Magang']]" />

            <div class="bg-white overflow-hidden shadow-2xl rounded-[2.5rem] border border-slate-100">
                <div class="p-8 md:p-12">
                    @if(session('success'))
                        <div class="mb-8 p-4 bg-green-50 border border-green-100 text-green-700 text-xs font-bold rounded-2xl flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($internships->isEmpty())
                        <div class="text-center py-20">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Belum Ada Data</h3>
                            <p class="text-slate-400 text-sm mt-2 max-w-xs mx-auto font-bold uppercase tracking-widest text-[10px]">Klik tombol 'Tambah Baru' untuk mulai membandingkan tempat magang.</p>
                        </div>
                    @else
                        <!-- Desktop Table View -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Nama Perusahaan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Bidang</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Website</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($internships as $internship)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 capitalize">{{ $internship->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-black rounded-full bg-blue-100 text-blue-800 uppercase tracking-tight capitalize">
                                                    {{ $internship->category->name ?? 'Umum' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($internship->website_link)
                                                    <a href="{{ $internship->website_link }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-xs font-bold flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                        Kunjungi Website
                                                    </a>
                                                @else
                                                    <span class="text-slate-300 text-[10px] italic font-bold">Tidak ada link</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('internships.edit', $internship) }}" class="text-indigo-600 hover:text-indigo-900 mr-4 font-bold">Edit</a>
                                                <form action="{{ route('internships.destroy', $internship) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="md:hidden space-y-4">
                            @foreach($internships as $internship)
                            <div class="bg-slate-50 border border-slate-100 rounded-3xl p-6 shadow-sm">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <h4 class="font-black text-slate-900 text-lg leading-tight truncate capitalize">{{ $internship->name }}</h4>
                                        <span class="inline-block mt-2 px-3 py-1 text-[9px] font-black rounded-xl bg-blue-100 text-blue-700 uppercase whitespace-nowrap capitalize">
                                            {{ $internship->category->name ?? 'Umum' }}
                                        </span>
                                    </div>
                                </div>
                                
                                @if($internship->website_link)
                                <div class="mb-4">
                                    <a href="{{ $internship->website_link }}" target="_blank" class="inline-flex items-center text-blue-600 font-black text-[10px] uppercase tracking-widest hover:underline">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Kunjungi Website
                                    </a>
                                </div>
                                @endif

                                <div class="flex gap-3 mt-6">
                                    <a href="{{ route('internships.edit', $internship) }}" class="flex-1 bg-white border border-slate-200 text-slate-700 text-center py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition flex items-center justify-center gap-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('internships.destroy', $internship) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-50 text-red-600 text-center py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-100 transition flex items-center justify-center gap-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
