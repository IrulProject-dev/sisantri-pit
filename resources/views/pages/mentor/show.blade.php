@extends('layouts.app')

@section('title', 'Detail Santri - SiSantri')

@section('content')

    <div class="container mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detail Santri</h1>
            <p class="text-gray-600">Informasi lengkap tentang santri.</p>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row">
                    <!-- Foto Santri -->
                    <div class="md:w-1/4 mb-6 md:mb-0 flex justify-center">
                        @if ($santri->photo)
                            <img src="{{ asset($santri->photo) }}" alt="{{ $santri->name }}"
                                class="h-48 w-48 object-cover rounded-lg shadow">
                        @else
                            <div
                                class="h-48 w-48 bg-gray-200 flex items-center justify-center rounded-lg shadow text-gray-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Informasi Santri -->
                    <div class="md:w-3/4 md:pl-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ $santri->name }}</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                            <div>
                                <p class="text-sm text-gray-600">Status:</p>
                                <p class="text-base font-medium">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $santri->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $santri->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Jenis Kelamin:</p>
                                <p class="text-base font-medium">
                                    {{ $santri->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Tanggal Lahir:</p>
                                <p class="text-base font-medium">
                                    {{ \Carbon\Carbon::parse($santri->date_of_birth)->format('d M Y') }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Jurusan:</p>
                                <p class="text-base font-medium">{{ $santri->division->name ?? 'Belum ada jurusan' }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Angkatan:</p>
                                <p class="text-base font-medium">{{ $santri->batch->name ?? 'Belum ada angkatan' }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">No. Telepon:</p>
                                <p class="text-base font-medium">{{ $santri->phone }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Terakhir diperbarui:</p>
                                <p class="text-base font-medium">
                                    {{ \Carbon\Carbon::parse($santri->updated_at)->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Alamat:</p>
                            <p class="text-base font-medium">{{ $santri->address }}</p>
                        </div>
                    </div>
                </div>



                <!-- Tombol Aksi -->
                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('santris.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Kembali</a>
                        <a href="{{ route('mentors.edit', $santri->id) }}"
                            class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Edit</a>
                    </div>


            </div>
        </div>
    </div>
@endsection
