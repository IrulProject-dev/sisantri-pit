@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-blue-50">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">
            <i class="fas fa-calendar-alt text-blue-300 mr-2"></i>
            Periode Penilaian
        </h2>
        <a href="{{ route('assessment-periods.create') }}"
           class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg transition-all duration-300 border border-blue-200">
            <i class="fas fa-plus mr-2"></i>Tambah Periode
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-blue-50">
        <table class="min-w-full divide-y divide-blue-50">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Nama Periode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-50">
                @foreach($periods as $period)
                <tr class="hover:bg-blue-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-700">{{ $period->name }}</div>
                        <div class="text-sm text-gray-500 mt-1">Durasi: {{ $period->start_date->diffInDays($period->end_date) }} hari</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">
                            <i class="fas fa-play-circle text-blue-200 mr-2"></i>
                            {{ $period->start_date->format('d M Y') }}
                        </div>
                        <div class="text-sm text-gray-700 mt-1">
                            <i class="fas fa-flag-checkered text-blue-200 mr-2"></i>
                            {{ $period->end_date->format('d M Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $period->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $period->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('assessment-periods.edit', $period) }}"
                               class="text-blue-300 hover:text-blue-500 transform hover:scale-110 transition-all">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('assessment-periods.destroy', $period) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-300 hover:text-red-500 transform hover:scale-110 transition-all"
                                        onclick="return confirm('Hapus periode ini?')">
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

    @if($periods->isEmpty())
    <div class="text-center py-12">
        <div class="text-blue-200 mb-4">
            <i class="fas fa-calendar-times text-4xl"></i>
        </div>
        <p class="text-gray-500">Belum ada periode penilaian yang dibuat</p>
    </div>
    @endif

   
</div>
@endsection
