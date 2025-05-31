@extends('layouts.app')

@section('title', 'Detail Absensi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Absensi</h1>
            <p class="text-gray-600">Informasi lengkap data absensi</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('attendances.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Alert Section -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 mb-6">
        <!-- Card Header -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Informasi Utama</h2>
        </div>

        <!-- Card Body -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column - Attendance Info -->
            <div>
                <h3 class="text-md font-medium text-gray-700 mb-4 pb-2 border-b border-gray-200">Data Absensi</h3>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tanggal</p>
                        <p class="mt-1 text-gray-900">
                            {{ \Carbon\Carbon::parse($attendanceRecord->date)->translatedFormat('l, d F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Sesi</p>
                        <p class="mt-1 text-gray-900">
                            {{ $attendanceRecord->attendanceSession->name ?? 'Tidak ada sesi' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        @php
                            $statusClasses = [
                                'hadir' => 'bg-green-100 text-green-800',
                                'sakit' => 'bg-yellow-100 text-yellow-800',
                                'izin' => 'bg-blue-100 text-blue-800',
                                'alfa' => 'bg-red-100 text-red-800',
                                'terlambat' => 'bg-orange-100 text-orange-800',
                            ];
                            $statusClass = $statusClasses[strtolower($attendanceRecord->status)] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                            {{ ucfirst($attendanceRecord->status) }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Dicatat Oleh</p>
                        <p class="mt-1 text-gray-900">
                            {{ $attendanceRecord->recorder->name ?? 'System' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Column - Student Info -->
            <div>
                <h3 class="text-md font-medium text-gray-700 mb-4 pb-2 border-b border-gray-200">Data Santri</h3>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nama Santri</p>
                        <p class="mt-1 text-gray-900">
                            {{ $attendanceRecord->user->name ?? 'Data santri tidak tersedia' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Divisi</p>
                        <p class="mt-1 text-gray-900">
                            {{ $attendanceRecord->user->division->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Angkatan</p>
                        <p class="mt-1 text-gray-900">
                            {{ $attendanceRecord->user->batch->name ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        @if($attendanceRecord->notes)
        <div class="px-6 pb-6">
            <h3 class="text-md font-medium text-gray-700 mb-2">Catatan</h3>
            <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                <p class="text-gray-800 whitespace-pre-line">{{ $attendanceRecord->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Recent Attendances Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Riwayat Absensi Terkini</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sesi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dicatat Oleh
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentAttendances as $attendance)
                    <tr class="{{ $attendance->id === $attendanceRecord->id ? 'bg-blue-50' : 'hover:bg-gray-50' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $attendance->attendanceSession->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClass = $statusClasses[strtolower($attendance->status)] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $attendance->recorder->name ?? 'System' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada riwayat absensi lainnya
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
