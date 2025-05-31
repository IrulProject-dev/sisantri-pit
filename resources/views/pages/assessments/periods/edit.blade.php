@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-blue-100 max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">
            <i class="fas fa-calendar-edit text-blue-300 mr-2"></i>
            Edit Periode Penilaian
        </h2>
        <a href="{{ route('assessment-periods.index') }}"
            class="text-blue-400 hover:text-blue-600 text-sm transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('assessment-periods.update', $assessmentPeriod) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Nama Periode -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Periode</label>
                <input type="text" name="name"
                    value="{{ old('name', $assessmentPeriod->name) }}"
                    class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                    required>
                @error('name')
                <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date"
                        value="{{ old('start_date', $assessmentPeriod->start_date->format('Y-m-d')) }}"
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                        required>
                    @error('start_date')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                    <input type="date" name="end_date"
                        value="{{ old('end_date', $assessmentPeriod->end_date->format('Y-m-d')) }}"
                        min="{{ $assessmentPeriod->start_date->format('Y-m-d') }}"
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                        required>
                    @error('end_date')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="flex items-center space-x-3 pt-4">
                <input type="hidden" name="is_active" value="0"> <!-- Tambahkan ini -->
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    class="rounded border-blue-200 text-blue-400 focus:ring-blue-200"
                    {{ old('is_active', $assessmentPeriod->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-gray-700">Aktifkan Periode Ini</label>
                @error('is_active')
                <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="border-t border-blue-100 pt-6">
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('assessment-periods.index') }}"
                        class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-2 rounded-lg border border-gray-200 transition-all duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg border border-blue-200 transition-all duration-300 hover:shadow-sm">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
