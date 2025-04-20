@extends('layouts.app')

@section('title', 'Daftar Santri - SiSantri')

@section('content')
    <div class="container mx-auto">
        <div class="md:flex justify-between items-center mb-6">
            <div class="max-md:mb-3">
                <h1 class="text-2xl font-bold text-gray-900">Daftar Santri</h1>
                <p class="text-gray-600">Kelola data santri Pondok IT Indonesia.</p>
            </div>
            <a href="{{ route('pages.santris.create') }}"
                class="px-4 py-2 bg-primary text-primary-foreground rounded-md hover:bg-primary/90">
                Tambah Santri
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="bg-white shadow rounded-md overflow-hidden border border-gray-200 mb-6">
            <div class="p-4">
                <h2 class="text-lg font-medium text-gray-900 mb-3">Filter Santri</h2>
                <form action="{{ route('pages.santris.index') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="division_id" class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                        <select name="division_id" id="division_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:ring-1">
                            <option value="">Semua Jurusan</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ request('division_id') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="batch_id" class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                        <select name="batch_id" id="batch_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:ring-1">
                            <option value="">Semua Angkatan</option>
                            @foreach ($batches as $batch)
                                <option value="{{ $batch->id }}"
                                    {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="px-4 py-2 bg-primary text-primary-foreground rounded-md hover:bg-primary/90 mr-2">
                            Filter
                        </button>
                        <a href="{{ route('pages.santris.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        {{-- Filter Santri end --}}

        <div class="bg-white shadow rounded-md overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                NIS
                            </th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama
                            </th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jurusan
                            </th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Angkatan
                            </th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($santris as $santri)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $santri->nis }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $santri->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $santri->division->name ?? 'Belum ada jurusan' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $santri->batch->name ?? 'Belum ada angkatan' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $santri->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $santri->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('pages.santris.show', $santri->id) }}"
                                            class="text-blue-600 hover:text-blue-900 relative group">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            <span
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 px-2 py-1 text-xs font-medium text-white bg-black rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">Lihat</span>
                                        </a>
                                        <a href="{{ route('santris.edit', $santri->id) }}"
                                            class="text-yellow-600 hover:text-yellow-900 relative group">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            <span
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 px-2 py-1 text-xs font-medium text-white bg-black rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">Edit</span>
                                        </a>
                                        <form action="{{ route('santris.destroy', $santri->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 relative group"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus santri ini?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 px-2 py-1 text-xs font-medium text-white bg-red-600 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada data santri.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                @if ($santris->total() > 0)
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                        <div class="flex justify-between flex-1 sm:hidden">
                            @if ($santris->onFirstPage())
                                <span
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                    &laquo; Previous
                                </span>
                            @else
                                <a href="{{ $santris->appends(request()->all())->previousPageUrl() }}"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500">
                                    &laquo; Previous
                                </a>
                            @endif

                            @if ($santris->hasMorePages())
                                <a href="{{ $santris->appends(request()->all())->nextPageUrl() }}"
                                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500">
                                    Next &raquo;
                                </a>
                            @else
                                <span
                                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                    Next &raquo;
                                </span>
                            @endif
                        </div>

                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ $santris->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $santris->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $santris->total() }}</span>
                                    results
                                </p>
                            </div>

                            <div>
                                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                    {{-- Previous Page Link --}}
                                    @if ($santris->onFirstPage())
                                        <span aria-disabled="true" aria-label="Previous">
                                            <span
                                                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md"
                                                aria-hidden="true">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </span>
                                    @else
                                        <a href="{{ $santris->appends(request()->all())->previousPageUrl() }}"
                                            rel="prev"
                                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50"
                                            aria-label="Previous">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($santris->appends(request()->all())->getUrlRange(1, $santris->lastPage()) as $page => $url)
                                        @if ($page == $santris->currentPage())
                                            <span aria-current="page">
                                                <span
                                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-primary-foreground bg-primary border border-primary cursor-default">{{ $page }}</span>
                                            </span>
                                        @else
                                            <a href="{{ $url }}"
                                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50"
                                                aria-label="Go to page {{ $page }}">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($santris->hasMorePages())
                                        <a href="{{ $santris->appends(request()->all())->nextPageUrl() }}" rel="next"
                                            class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50"
                                            aria-label="Next">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @else
                                        <span aria-disabled="true" aria-label="Next">
                                            <span
                                                class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md"
                                                aria-hidden="true">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </nav>
                @endif
            </div>
            <!-- Pagination end -->

        </div>
    </div>
@endsection
