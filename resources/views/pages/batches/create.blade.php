@extends('layouts.app')

@section('title', 'Tambah Angkatan - SiSantri')

@section('content')
    <div class="container mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Tambah Angkatan Baru</h1>
            <p class="text-gray-600">Silakan isi form di bawah ini untuk menambahkan angkatan baru.</p>
        </div>
        <div class="bg-white border border-border shadow-sm rounded-lg p-6">
            <form action="{{ route('batches.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Angkatan</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                        placeholder="Contoh: Angkatan 21" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="entry_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                    <input type="date" name="entry_date" id="entry_date" value="{{ old('entry_date') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                        required>
                    @error('entry_date')
                        <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="graduation_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lulus <span
                            class="text-gray-500 text-xs">(Opsional)</span></label>
                    <input type="date" name="graduation_date" id="graduation_date" value="{{ old('graduation_date') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm">
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika belum ditentukan</p>
                    @error('graduation_date')
                        <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('batches.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-primary text-primary-foreground rounded-md hover:bg-primary/90">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
