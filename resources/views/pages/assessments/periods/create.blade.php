@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-blue-50 max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">
            <i class="fas fa-calendar-plus text-blue-300 mr-2"></i>
            Buat Periode Baru
        </h2>
    </div>

    <form action="{{ route('assessment-periods.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <!-- Nama Periode -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Periode</label>
                <input type="text" name="name" required
                    class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                    placeholder="Contoh: Triwulan I 2024">
            </div>

            <!-- Tanggal Mulai & Selesai -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" required
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                    <input type="date" name="end_date" required
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="flex items-center space-x-3">
                <input type="hidden" name="is_active" value="0"> <!-- Tambahkan ini -->
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    class="rounded border-blue-200 text-blue-400 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <label for="is_active" class="text-sm text-gray-700">Aktifkan periode ini</label>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('assessment-periods.index') }}"
                    class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-2 rounded-lg border border-gray-200 transition-all duration-300">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit"
                    class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg border border-blue-200 transition-all duration-300">
                    <i class="fas fa-save mr-2"></i>Simpan Periode
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
