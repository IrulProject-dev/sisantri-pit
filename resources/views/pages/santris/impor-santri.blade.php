@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Impor Data Santri</h2>

        <!-- Form Impor Lokal -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">Impor dari File Lokal</h3>
            <form action="{{ route('impor-santri.lokal') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        File Excel/CSV
                    </label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                    <p class="text-gray-600 text-sm mt-1">
                        Format file: .xlsx, .xls, atau .csv.
                        <a href="{{ asset('templates/santri-template.xlsx') }}"
                            class="text-blue-600 hover:underline">Download template</a>
                    </p>
                </div>

                <button type="submit"
                    class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary/90">
                    Impor Data Sekarang
                </button>
            </form>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
        <div class="mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
        @endif

        @if(session()->has('import_errors'))
        <div class="mt-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            <h3 class="font-bold mb-2">Error pada beberapa data:</h3>
            <ul class="list-disc pl-5">
                @foreach(session('import_errors') as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if($errors->any())
        <div class="mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Petunjuk Format -->
        <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
            <h3 class="font-bold text-lg mb-2">Format File Impor:</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border-b">Kolom</th>
                            <th class="py-2 px-4 border-b">Wajib</th>
                            <th class="py-2 px-4 border-b">Contoh</th>
                            <th class="py-2 px-4 border-b">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-4 border-b">Nama Lengkap</td>
                            <td class="py-2 px-4 border-b">Ya</td>
                            <td class="py-2 px-4 border-b">Ahmad Budiman</td>
                            <td class="py-2 px-4 border-b">-</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Email</td>
                            <td class="py-2 px-4 border-b">Tidak</td>
                            <td class="py-2 px-4 border-b">ahmad@example.com</td>
                            <td class="py-2 px-4 border-b">Jika kosong, akan dibuat otomatis</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Nomor HP</td>
                            <td class="py-2 px-4 border-b">Tidak</td>
                            <td class="py-2 px-4 border-b">08123456789</td>
                            <td class="py-2 px-4 border-b">Tidak Boleh Kosong</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Nama Divisi</td>
                            <td class="py-2 px-4 border-b">Ya</td>
                            <td class="py-2 px-4 border-b">Programmer</td>
                            <td class="py-2 px-4 border-b">Akan dibuat jika belum ada</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Kode Divisi</td>
                            <td class="py-2 px-4 border-b">Tidak</td>
                            <td class="py-2 px-4 border-b">PRG</td>
                            <td class="py-2 px-4 border-b">Jika kosong, akan digenerate otomatis</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Angkatan</td>
                            <td class="py-2 px-4 border-b">Ya</td>
                            <td class="py-2 px-4 border-b">2024</td>
                            <td class="py-2 px-4 border-b">Format 4 digit tahun</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
