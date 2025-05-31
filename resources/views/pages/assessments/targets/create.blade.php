@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-blue-100 max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">
            <i class="fas fa-bullseye text-blue-300 mr-2"></i>
            Buat Target Penilaian Baru
        </h2>
        <a href="{{ route('assessment-targets.index') }}"
           class="text-blue-400 hover:text-blue-600 text-sm transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('assessment-targets.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <!-- Santri dan Komponen -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Santri</label>
                    <select name="santri_id" required
                            class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
                        <option value="">Pilih Santri</option>
                        @foreach($santris as $santri)
                        <option value="{{ $santri->id }}" {{ old('santri_id') == $santri->id ? 'selected' : '' }}>
                            {{ $santri->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('santri_id')
                        <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Komponen Penilaian</label>
                    <select name="assessment_component_id" required
                            class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
                        <option value="">Pilih Komponen</option>
                        @foreach($components as $component)
                        <option value="{{ $component->id }}" {{ old('assessment_component_id') == $component->id ? 'selected' : '' }}>
                            {{ $component->name }} (Maks: {{ $component->max_score }})
                        </option>
                        @endforeach
                    </select>
                    @error('assessment_component_id')
                        <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Target dan Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Target Nilai</label>
                    <input type="number" name="target_score"
                           step="0.01"
                           min="0"
                           value="{{ old('target_score') }}"
                           class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                           required>
                    @error('target_score')
                        <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Target Tanggal</label>
                    <input type="date" name="target_date"
                           min="{{ date('Y-m-d') }}"
                           value="{{ old('target_date') }}"
                           class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                           required>
                    @error('target_date')
                        <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Catatan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea name="notes" rows="3"
                          class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                          placeholder="Tambahkan catatan (opsional)">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="border-t border-blue-100 pt-6">
                <button type="submit"
                        class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg border border-blue-200 transition-all duration-300 hover:shadow-sm">
                    <i class="fas fa-save mr-2"></i>Simpan Target
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
