@extends('layouts.app')

@section('title', 'Detail Angkatan - SiSantri')

@section('content')
    <div class="container mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detail Angkatan</h1>
            <p class="text-gray-600">Informasi lengkap tentang angkatan.</p>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $batch->name }}</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Masuk:</p>
                        <p class="text-base font-medium">{{ \Carbon\Carbon::parse($batch->entry_date)->format('d M Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Lulus:</p>
                        <p class="text-base font-medium">
                            {{ \Carbon\Carbon::parse($batch->graduation_date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dibuat pada:</p>
                        <p class="text-base font-medium">
                            {{ \Carbon\Carbon::parse($batch->created_at)->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Terakhir diperbarui:</p>
                        <p class="text-base font-medium">
                            {{ \Carbon\Carbon::parse($batch->updated_at)->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Daftar Santri</h3>
                    @if ($batch->santris->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Divisi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($batch->santris as $index => $santri)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $santri->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $santri->division->name ?? 'Belum ada divisi' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada santri yang terdaftar di angkatan ini.</p>
                    @endif
                </div>

                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('pages.batches.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Kembali</a>
                    <a href="{{ route('pages.batches.edit', $batch->id) }}"
                        class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Edit</a>
                    <form action="{{ route('batches.destroy', $batch->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus angkatan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
