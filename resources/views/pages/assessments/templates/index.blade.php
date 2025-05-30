@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6 border border-blue-100">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-blue-600">Daftar Template Penilaian</h2>
        <a href="{{ route('assessment-templates.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-transform transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>Template Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates as $template)
        <div class="bg-white rounded-lg shadow-sm p-6 border border-blue-100 hover:border-blue-300 transition-all duration-300 group hover:shadow-md relative">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-blue-600">{{ $template->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $template->division->name }}</p>
                </div>
                <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <a href="{{ route('assessment-templates.edit', $template) }}"
                       class="text-blue-400 hover:text-blue-600 transform hover:scale-110">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('assessment-templates.destroy', $template) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-red-400 hover:text-red-600 transform hover:scale-110"
                                onclick="return confirm('Hapus template ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex items-center text-sm">
                    <i class="fas fa-cubes text-blue-400 mr-2"></i>
                    <span class="text-gray-600">{{ $template->components->count() }} Komponen</span>
                </div>

                <div class="flex items-center text-sm">
                    <i class="fas fa-weight-hanging text-blue-400 mr-2"></i>
                    <span class="text-gray-600">Total Bobot: {{ $template->components->sum('pivot.weight') }}%</span>
                </div>

                <div class="flex items-center text-sm">
                    <i class="fas fa-calendar-alt text-blue-400 mr-2"></i>
                    <span class="text-gray-600">Terakhir diupdate: {{ $template->updated_at->diffForHumans() }}</span>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-blue-100">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Dibuat pada</span>
                    <span class="text-blue-500">{{ $template->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-file-alt text-4xl"></i>
            </div>
            <p class="text-gray-500">Belum ada template yang dibuat</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
