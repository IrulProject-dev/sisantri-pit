@extends('layouts.app')



@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="text-center mb-8">
        <div class="inline-block mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-20">
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">RAPOR PENILAIAN SANTRI</h1>
        <div class="flex justify-center items-center space-x-4 text-gray-600">
            <p><span class="font-semibold">Periode:</span> {{ $assessment->period->name ?? '-'}}</p>
            <p><span class="font-semibold">Tanggal:</span> {{ $assessment->date ? $assessment->date->format('d M Y') : '-' }}</p>
        </div>
    </div>

    <!-- Student Info Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-semibold mb-4 text-blue-600">Informasi Santri</h2>
                <div class="space-y-2">
                    <p><span class="font-medium">Nama:</span> {{ $assessment->santri->name ?? '-'}}</p>
                    <p><span class="font-medium">Divisi:</span> {{ $assessment->template->division->name ?? '-'}}</p>
                    <p><span class="font-medium">Mentor:</span> {{ $assessment->assessor->name ?? '-'}}</p>
                    <p><span class="font-medium">Periode:</span> {{ $assessment->period->name ?? '-' }} </p>
                    <p><span class="font-medium">Periode:</span> {{ $assessment->date ?? '-' }} </p>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold mb-4 text-blue-600">Status Penilaian</h2>
                <div class="flex items-center space-x-4">
                    <span class="px-4 py-2 rounded-full
                        @switch($assessment->status)
                            @case('approved') bg-green-100 text-green-800 @break
                            @case('submitted') bg-blue-100 text-blue-800 @break
                            @default bg-gray-100 text-gray-800
                        @endswitch">
                        {{ ucfirst($assessment->status) }}
                    </span>
                    <p class="text-sm text-gray-600">Terakhir update: {{ optional($assessment->updated_at)->diffForHumans() ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scores Section -->
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h2 class="text-2xl font-semibold mb-6 text-blue-600">Detail Penilaian</h2>
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 border-b-2 border-blue-200 pb-2">
                Komponen Penilaian
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Komponen</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Skor</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Catatan</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($assessment->details as $detail)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $detail->component->name }}
                                @if($detail->component->description)
                                <p class="text-xs text-gray-500 mt-1">{{ $detail->component->description }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-blue-600 font-semibold">
                                {{ $detail->score }}/{{ $detail->component->max_score }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $detail->notes ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Additional Notes -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-2 text-gray-800">Catatan Tambahan</h3>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <p class="text-gray-700">{{ $assessment->note ?? 'Tidak ada catatan tambahan' }}</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex justify-end space-x-4">
        <a href="{{ route('report.index') }}"
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-200">
            Kembali
        </a>
        @if (isset($assessment) && $assessment->id)
        <a href="{{ route('report.downloadPdf', $assessment) }}"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200" target="_blank">
            <i class="fas fa-file-pdf mr-2"></i>Download PDF
        </a>
        @endif
    </div>
</div>
@endsection
