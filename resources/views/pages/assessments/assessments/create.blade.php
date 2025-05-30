<!-- Blade View -->
@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-blue-100 max-w-5xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">
            <i class="fas fa-plus text-blue-300 mr-2"></i>
            Tambah Penilaian
        </h2>
        <a href="{{ route('assessments.index') }}"
            class="text-blue-400 hover:text-blue-600 text-sm transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
    </div>

    <!-- Filter Section -->
    <div class="bg-white shadow rounded-md overflow-hidden border border-gray-200 mb-6">
        <div class="p-4">
            <h2 class="text-lg font-medium text-gray-900 mb-3">Filter Penilaian</h2>
            <form action="{{ route('assessments.create') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="division_id" class="block text-sm font-medium text-gray-700 mb-1">Divisi</label>
                    <select name="division_id" id="division_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 hover:shadow-sm">
                        <option value="">Pilih Divisi</option>
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
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 hover:shadow-sm">
                        <option value="">Pilih Angkatan</option>
                        @foreach ($batches as $batch)
                        <option value="{{ $batch->id }}"
                            {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                            {{ $batch->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="period_id" class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
                    <select name="period_id" id="period_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 hover:shadow-sm"
                        required>
                        <option value="">Pilih Periode</option>
                        @foreach ($periods as $period)
                        <option value="{{ $period->id }}"
                            {{ request('period_id') == $period->id ? 'selected' : '' }}>
                            {{ $period->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="assessment_template_id" class="block text-sm font-medium text-gray-700 mb-1">Template</label>
                    <select name="assessment_template_id" id="assessment_template_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 hover:shadow-sm"
                        required>
                        <option value="">Pilih Template</option>
                        @foreach ($templates as $template)
                        <option value="{{ $template->id }}"
                            {{ request('assessment_template_id') == $template->id ? 'selected' : '' }}>
                            {{ $template->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-4 flex justify-end space-x-3">
                    <a href="{{ route('assessments.create') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Reset
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 cursor-pointer">
                        Apply
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($santris->isNotEmpty())
    <form action="{{ route('assessments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="period_id" value="{{ request('period_id') }}">
        <input type="hidden" name="assessment_template_id" value="{{ request('assessment_template_id') }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Santri</label>
                <select name="santri_id"
                    class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                    required>
                    <option value="">Pilih Santri</option>
                    @foreach($santris as $santri)
                    @php
                    $isAssessed = $existingAssessments->has($santri->id);
                    @endphp
                    <option value="{{ $santri->id }}"
                        {{ old('santri_id') == $santri->id ? 'selected' : '' }}
                        @if($isAssessed) disabled @endif>
                        {{ $santri->name }} ({{ $santri->batch->name }})
                        @if($isAssessed)
                        ✅ <span class="text-xs text-green-600">Sudah dinilai</span>
                        @endif
                    </option>
                    @endforeach
                </select>
                @error('santri_id')
                <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror

                @if($santris->isNotEmpty() && $existingAssessments->count() > 0 &&
                $existingAssessments->count() == $santris->count())
                <div class="mt-2 bg-blue-50 border-l-4 border-blue-400 p-2 text-sm text-blue-700">
                    <i class="fas fa-info-circle mr-1"></i>
                    Semua santri pada divisi dan angkatan ini sudah dinilai untuk periode dan template terpilih
                </div>
                @endif
            </div>


            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Penilai</label>
                <select name="assessor_id"
                    class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                    required>
                    <option value="">Pilih Penilai</option>
                    @foreach($assessors as $assessor)
                    <option value="{{ $assessor->id }}" {{ old('assessor_id') == $assessor->id ? 'selected' : '' }}>
                        {{ $assessor->name }}
                    </option>
                    @endforeach
                </select>
                @error('assessor_id')
                <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                <input type="date" name="date"
                    value="{{ old('date', date('Y-m-d')) }}"
                    class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                    required>
                @error('date')
                <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status"
                    class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                    required>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="submitted" {{ old('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                </select>
                @error('status')
                <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Detail Skor -->
        @if($selectedTemplate)
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-clipboard-list text-blue-300 mr-2"></i>
                Detail Skor Komponen
            </h3>
            <div class="space-y-4" id="component-container">
                @foreach($selectedTemplate->components as $i => $component)
                <div class="flex flex-col p-4 border border-blue-100 rounded-lg bg-white hover:bg-blue-50 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex-1">
                            <p class="font-medium text-gray-700">{{ $component->name }}</p>
                            @if($component->description)
                            <p class="text-xs text-gray-500 mt-1">{{ $component->description }}</p>
                            @endif
                        </div>
                        <div class="w-32">
                            <input type="number"
                                name="scores[{{ $i }}][score]"
                                min="0"
                                max="{{ $component->max_score }}"
                                step="0.01"
                                value="{{ old("scores.$i.score", '') }}"
                                class="w-full rounded-md border-blue-200 shadow-sm text-right font-medium text-blue-600 focus:border-blue-300"
                                required>
                            <div class="text-xs text-gray-500 text-right mt-1">
                                Maks: {{ $component->max_score }}
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Catatan per Komponen -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Catatan</label>
                        <textarea name="scores[{{ $i }}][notes]"
                            rows="2"
                            class="w-full text-sm rounded-md border-gray-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                            placeholder="Evaluasi khusus untuk komponen ini...">{{ old("scores.$i.notes", '') }}</textarea>
                        <input type="hidden"
                            name="scores[{{ $i }}][assessment_component_id]"
                            value="{{ $component->id }}">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Catatan -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
            <textarea name="note" rows="2"
                class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">{{ old('note') }}</textarea>
            @error('note')
            <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="border-t border-blue-100 pt-6">
            <div class="flex justify-end space-x-4">
                <a href="{{ route('assessments.index') }}"
                    class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-2 rounded-lg border border-gray-200 transition-all duration-300">
                    Batal
                </a>
                <button type="submit"
                    class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg border border-blue-200 transition-all duration-300 hover:shadow-sm">
                    <i class="fas fa-save mr-2"></i>Simpan Penilaian
                </button>
            </div>
        </div>
    </form>
    @else
    @if(request()->has('division_id') || request()->has('batch_id'))
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    Tidak ditemukan santri dengan filter yang dipilih. Silakan coba kombinasi filter lain.
                </p>
            </div>
        </div>
    </div>
    @endif
    @endif
</div>
@endsection
