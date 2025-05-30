@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-blue-100 max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">
            <i class="fas fa-edit text-blue-300 mr-2"></i>
            Edit Komponen Penilaian
        </h2>
        <a href="{{ route('assessment-components.index') }}"
           class="text-blue-400 hover:text-blue-600 text-sm transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('assessment-components.update', $assessmentComponent) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Category Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="category_id"
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                        required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $assessmentComponent->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Component Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Komponen</label>
                <input type="text" name="name"
                       value="{{ old('name', $assessmentComponent->name) }}"
                       class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                       required>
                @error('name')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                >{{ old('description', $assessmentComponent->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Max Score -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Skor Maksimal</label>
                <input type="number" name="max_score"
                       value="{{ old('max_score', $assessmentComponent->max_score) }}"
                       min="1"
                       class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                       required>
                @error('max_score')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="border-t border-blue-100 pt-6">
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('assessment-components.index') }}"
                       class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-2 rounded-lg border border-gray-200 transition-all duration-300">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg border border-blue-200 transition-all duration-300 hover:shadow-sm">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
