@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-blue-100">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">
            <i class="fas fa-clipboard-list text-blue-300 mr-2"></i>
            Daftar Penilaian
        </h2>
        <a href="{{ route('assessments.create') }}"
           class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg border border-blue-200 transition-all duration-300 hover:shadow-sm">
            <i class="fas fa-plus mr-2"></i>Tambah Penilaian
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-blue-100">
        <table class="min-w-full divide-y divide-blue-100">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Santri</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Penilai</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Template</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Periode</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Detail</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-100">
                @foreach($assessments as $assessment)
                <tr class="hover:bg-blue-50 transition-colors duration-200">
                    <!-- Santri -->
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $assessment->santri->name ?? '-' }}</td>

                    <!-- Penilai -->
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $assessment->assessor->name ?? '-' }}</td>

                    <!-- Template -->
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $assessment->template->name ?? '-' }}</td>

                    <!-- Periode -->
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $assessment->period->name ?? '-' }}</td>

                    <!-- Tanggal -->
                    <td class="px-4 py-3 text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($assessment->date)->format('d M Y') }}
                    </td>

                    <!-- Status -->
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            {{ $assessment->status === 'approved' ? 'bg-green-100 text-green-800' :
                               ($assessment->status === 'submitted' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($assessment->status) }}
                        </span>
                    </td>

                    <!-- Detail -->
                    <td class="px-4 py-3 text-sm">
                        @if($assessment->details->count())
                        <div class="space-y-2">
                            @foreach($assessment->details as $detail)
                            <div class="flex justify-between items-center border-b border-blue-50 pb-2 last:border-0">
                                <div>
                                    <p class="text-gray-700">{{ $detail->component->name ?? '-' }}</p>
                                    @if($detail->notes)
                                    <p class="text-xs text-gray-500 mt-1">{{ $detail->notes }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-3 ml-4">
                                    <span class="text-blue-600 font-medium">{{ $detail->score }}</span>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('assessment-details.edit', $detail->id) }}"
                                           class="text-blue-400 hover:text-blue-600 transition-colors">
                                            <i class="fas fa-pencil-alt text-xs"></i>
                                        </a>
                                        <form action="{{ route('assessment-details.destroy', $detail->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-400 hover:text-red-600 transition-colors"
                                                    onclick="return confirm('Hapus detail penilaian?')">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <span class="text-gray-400 text-xs">Belum ada detail</span>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('assessments.edit', $assessment->id) }}"
                               class="text-blue-400 hover:text-blue-600 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('assessments.destroy', $assessment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-400 hover:text-red-600 transition-colors"
                                        onclick="return confirm('Hapus penilaian ini?')">
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
