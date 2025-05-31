@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6 border border-blue-100">
    <h2 class="text-2xl font-semibold text-blue-600 mb-6">Daftar Rapor Penilaian</h2>
    <div class="overflow-x-auto rounded-lg border border-blue-50">
        <table class="min-w-full divide-y divide-blue-100">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">Santri</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">Periode</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-blue-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-100">
                @foreach($assessments as $assessment)
                <tr>
                    <td class="px-4 py-2">{{ $assessment->santri->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $assessment->period->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($assessment->date)->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ ucfirst($assessment->status) }}</td>
                    <td class="px-4 py-2 flex space-x-2">
                        <a href="{{ route('report.show', $assessment->id) }}"
                            class="text-blue-500 hover:text-blue-700" title="Lihat Rapor">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('report.downloadPdf', $assessment->id) }}"
                            class="text-red-500 hover:text-red-700" title="Cetak PDF" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                        </a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $assessments->links() }}
        </div>
    </div>
</div>
@endsection
