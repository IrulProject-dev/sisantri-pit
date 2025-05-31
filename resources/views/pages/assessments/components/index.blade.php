@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6 border border-blue-100">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-blue-600">Komponen Penilaian</h2>
        <a href="{{ route('assessment-components.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-transform transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>Tambah Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($components as $component)
        <div class="bg-white rounded-lg shadow-sm p-6 border border-blue-100 hover:border-blue-300 transition-all duration-300 group hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-blue-600">{{ $component->name }}</h3>
                    <p class="text-sm text-gray-500 mt-2">{{ $component->category->name }}</p>
                </div>
                <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <a href="{{ route('assessment-components.edit', $component) }}"
                       class="text-blue-400 hover:text-blue-600">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('assessment-components.destroy', $component) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-red-400 hover:text-red-600"
                                onclick="return confirm('Apakah Anda yakin?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Skor Maksimal</span>
                    <span class="font-medium text-blue-600">{{ $component->max_score }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
