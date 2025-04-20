@extends('layouts.app')

@section('title', 'Edit Jurusan - SiSantri')

@section('content')
    <div class="container mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Jurusan Baru</h1>
            <p class="text-gray-600">Silakan isi form di bawah ini untuk memperbarui jurusan baru.</p>
        </div>
        <div class="bg-white border shadow-sm rounded-lg p-6">
            <form action="{{ route('divisions.update', $division->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Jurusan</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $division->name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                        placeholder="Contoh: Entrepreneur" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Jurusan</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                        placeholder="Deskripsi tentang jurusan ini">{{ old('description', $division->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('pages.divisions.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-primary text-primary-foreground rounded-md hover:bg-primary/90">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
