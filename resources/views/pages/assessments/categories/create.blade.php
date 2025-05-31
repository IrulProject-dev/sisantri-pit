@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6 border border-blue-100 max-w-2xl mx-auto">
    <h2 class="text-2xl font-semibold text-blue-600 mb-6">Buat Kategori Baru</h2>

    <form action="{{ route('assessment-categories.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" required
                       class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"></textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('assessment-categories.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-transform transform hover:scale-105">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-transform transform hover:scale-105">
                    Simpan Kategori
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
