@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6 border border-blue-100">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-blue-600">Kategori Penilaian</h2>
        <a href="{{ route('assessment-categories.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-transform transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>Tambah Baru
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-blue-50">
        <table class="min-w-full divide-y divide-blue-100">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-100">
                @foreach($categories as $category)
                <tr class="hover:bg-blue-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                    <td class="px-6 py-4">{{ Str::limit($category->description, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-2">
                            <a href="{{ route('assessment-categories.edit', $category) }}"
                               class="text-blue-400 hover:text-blue-600 transform hover:scale-110 transition-all">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('assessment-categories.destroy', $category) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-400 hover:text-red-600 transform hover:scale-110 transition-all"
                                        onclick="return confirm('Apakah Anda yakin?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
