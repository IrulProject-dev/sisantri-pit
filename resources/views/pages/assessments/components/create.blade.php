@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-blue-50 max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">
            <i class="fas fa-puzzle-piece text-blue-300 mr-2"></i>
            Tambah Komponen Penilaian
        </h2>
    </div>

    <form action="{{ route('assessment-components.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <!-- Kategori dan Nama -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="category_id" required
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Komponen</label>
                    <input type="text" name="name" required
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                        placeholder="Contoh: Kemampuan Komunikasi">
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                    placeholder="Tambahkan deskripsi komponen..."></textarea>
            </div>

            <!-- Skor Maksimal -->
            <div class="max-w-xs">
                <label class="block text-sm font-medium text-gray-700 mb-2">Skor Maksimal</label>
                <input type="number" name="max_score" min="1" max="100" required
                    class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                    placeholder="0-100">
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('assessment-components.index') }}"
                    class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-2 rounded-lg border border-gray-200 transition-all duration-300">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit"
                    class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg border border-blue-200 transition-all duration-300">
                    <i class="fas fa-save mr-2"></i>Simpan Komponen
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
