@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-blue-100">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">
            <i class="fas fa-bullseye text-blue-300 mr-2"></i>
            Target Penilaian Santri
        </h2>
        <a href="{{ route('assessment-targets.create') }}"
           class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg border border-blue-200 transition-all duration-300 hover:shadow-sm">
            <i class="fas fa-plus mr-2"></i>Tambah Target
        </a>
    </div>

    <!-- Content -->
    <div class="overflow-x-auto rounded-lg border border-blue-100">
        <table class="min-w-full divide-y divide-blue-100">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Santri</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Komponen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Target Nilai</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Target Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Catatan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-100">
                @foreach($targets as $target)
                <tr class="hover:bg-blue-50 transition-colors duration-200">
                    <!-- Santri -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $target->santri->name }}</div>
                    </td>

                    <!-- Komponen -->
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $target->component->name }}</div>
                        <div class="text-sm text-blue-400">Maks: {{ $target->component->max_score }}</div>
                    </td>

                    <!-- Target Nilai -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 font-medium">{{ $target->target_score }}</div>
                    </td>

                    <!-- Target Tanggal -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($target->target_date)->format('d M Y') }}
                        </div>
                        <div class="text-xs text-gray-500">
                            ({{ \Carbon\Carbon::parse($target->target_date)->diffForHumans() }})
                        </div>
                    </td>

                    <!-- Catatan -->
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500 max-w-xs">
                            {{ Str::limit($target->notes, 50) }}
                        </div>
                    </td>

                    <!-- Aksi -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('assessment-targets.edit', $target) }}"
                               class="text-blue-400 hover:text-blue-600 transform hover:scale-110 transition-all">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('assessment-targets.destroy', $target) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-400 hover:text-red-600 transform hover:scale-110 transition-all"
                                        onclick="return confirm('Hapus target ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Empty State -->
        @if($targets->isEmpty())
        <div class="text-center py-12">
            <div class="text-blue-200 mb-4">
                <i class="fas fa-bullseye text-4xl"></i>
            </div>
            <p class="text-gray-500">Belum ada target penilaian yang dibuat</p>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $targets->links() }}
    </div>
</div>
@endsection
