<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Tempat Magang') }}
            </h2>
            <a href="{{ route('internships.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Tambah Tempat
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :links="[['label' => 'Daftar Tempat Magang']]" />

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($internships->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">Belum ada tempat magang yang ditambahkan.</p>
                            <a href="{{ route('internships.create') }}" class="text-blue-600 hover:underline">Mulai tambah tempat magang pertama Anda</a>
                        </div>
                    @else
                        <!-- Desktop Table View -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Nama Perusahaan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Kota</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Bidang</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($internships as $internship)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 capitalize">{{ $internship->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500 capitalize">{{ $internship->city }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-black rounded-full bg-blue-100 text-blue-800 uppercase tracking-tight capitalize">
                                                    {{ $internship->category->name ?? 'Umum' }}
                                                </span>
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
                                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1 capitalize">{{ $internship->city }}</p>
                                    </div>
                                    <span class="ml-2 px-3 py-1 text-[9px] font-black rounded-xl bg-blue-100 text-blue-700 uppercase whitespace-nowrap capitalize">
                                        {{ $internship->category->name ?? 'Umum' }}
                                    </span>
                                </div>
                                <div class="flex gap-3 mt-6">
                                    <a href="{{ route('internships.edit', $internship) }}" class="flex-1 flex items-center justify-center py-3 bg-white border border-slate-200 text-slate-700 font-black text-xs rounded-2xl shadow-sm active:scale-95 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('internships.destroy', $internship) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full flex items-center justify-center py-3 bg-red-50 text-red-600 font-black text-xs rounded-2xl active:scale-95 transition" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h14"></path></svg>
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
