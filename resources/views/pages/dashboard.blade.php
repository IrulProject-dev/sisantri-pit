@extends('layouts.app')

@section('title', 'Dashboard - SiSantri')

@section('content')
    <div class="container mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card 1: Total Santri -->
            <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Santri</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $santriCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Jurusan -->
            <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Jurusan</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $divisionCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Card 3: Total Angkatan -->
            <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Angkatan</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $batchCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Santri Terbaru</h2>
            <div class="bg-white rounded-lg shadow border border-gray-200">
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-my-5 divide-y divide-gray-200">
                            @forelse($recentSantris as $santri)
                                <li class="py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-8 h-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $santri->name }}
                                                ({{ $santri->nis }})
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $santri->created_at->diffForHumans() }} •
                                                {{ $santri->division->name ?? 'Belum ada jurusan' }} •
                                                {{ $santri->batch->name ?? 'Belum ada angkatan' }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-4">
                                    <p class="text-sm text-gray-500 text-center">Belum ada santri yang terdaftar.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    @if (count($recentSantris) > 0)
                        <div class="mt-6 text-right border-t border-gray-200 pt-5">
                            <a href="{{ route('pages.santris.index') }}"
                                class="text-sm font-medium text-primary hover:text-primary/80">
                                Lihat semua santri →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
