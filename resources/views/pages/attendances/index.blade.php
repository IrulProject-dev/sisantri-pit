@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
<div class="container mx-auto">
    <div class="md:flex justify-between items-center mb-6">
        <div class="max-md:mb-3">
            <h1 class="text-2xl font-bold text-gray-900">Data Absensi</h1>
            <p class="text-gray-600">Kelola data absensi santri di sini.</p>
        </div>
        <div>
            <a href="{{ route('attendances.create') }}"
                class="px-4 py-3 bg-primary text-primary-foreground rounded-md hover:bg-primary/90">
                Lakukan Absensi
            </a>
        </div>
    </div>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Filter Section -->
    <div class="bg-white shadow rounded-md overflow-hidden border border-gray-200 mb-6">
        <div class="p-4">
            <h2 class="text-lg font-medium text-gray-900 mb-3">Filter Absensi</h2>
            <form action="{{ route('attendances.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-3">
                    <div>
                        <label for="division_id" class="block text-sm font-medium text-gray-700 mb-1">Divisi</label>
                        <select name="division_id" id="division_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm">
                            <option value="">Semua Divisi</option>
                            @foreach ($divisions as $division)
                            <option value="{{ $division->id }}"
                                {{ request('division_id') == $division->id ? 'selected' : '' }}>
                                {{ $division->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="batch_id" class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                        <select name="batch_id" id="batch_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm">
                            <option value="">Semua Angkatan</option>
                            @foreach ($batches as $batch)
                            <option value="{{ $batch->id }}"
                                {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                                {{ $batch->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="date" id="date" value="{{ request('date', date('Y-m-d')) }}"
                            class="w-full px-3 py-[6px] border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm">
                    </div>

                    <div>
                        <label for="attendance_session_id"
                            class="block text-sm font-medium text-gray-700 mb-1">Sesi</label>
                        <select name="attendance_session_id" id="attendance_session_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm">
                            <option value="">Semua Sesi</option>
                            @foreach ($attendanceSession as $session)
                            <option value="{{ $session->id }}"
                                {{ request('attendance_session_id') == $session->id ? 'selected' : '' }}>
                                {{ $session->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('attendances.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Reset
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 cursor-pointer">
                        Filter
                    </button>
                    <a href="{{ route('attendances.export', request()->query()) }}"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 flex items-center gap-2">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                </div>

            </form>
        </div>
    </div>

    <div class="bg-white border border-border shadow-sm rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sesi
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Santri
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Divisi
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Angkatan
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        {{-- <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th> --}}
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($attendances as $index => $attendance)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $attendance->attendanceSession->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $attendance->user->name ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $attendance->user->division->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $attendance->user->batch->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                            $statusClass =
                            [
                            'hadir' => 'bg-green-100 text-green-800',
                            'sakit' => 'bg-yellow-100 text-yellow-800',
                            'izin' => 'bg-blue-100 text-blue-800',
                            'alfa' => 'bg-red-100 text-red-800',
                            'terlambat' => 'bg-orange-100 text-orange-800',
                            'piket' => 'bg-purple-100 text-purple-800',
                            ][$attendance->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        {{-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('attendances.edit', $attendance->id) }}"
                        class="text-indigo-600 hover:text-indigo-900">
                        <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
        </div>
        </td> --}}
        </tr>
        @empty
        <tr>
            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                Tidak ada data absensi yang ditemukan.
            </td>
        </tr>
        @endforelse
        </tbody>
        </table>
    </div>

    @if ($attendances->count() > 0)
    {{-- <div class="px-6 py-4 border-t border-gray-200">
                    {{ $attendances->withQueryString()->links() }}
</div> --}}
@endif
</div>
</div>
@endsection
