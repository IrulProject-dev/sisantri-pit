@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-blue-100 max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">
            <i class="fas fa-edit text-blue-300 mr-2"></i>
            Edit Penilaian
        </h2>
        <a href="{{ route('assessments.index') }}"
           class="text-blue-400 hover:text-blue-600 text-sm transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
    </div>

    <form action="{{ route('assessments.update', $assessment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Grid Input -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Santri -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Santri</label>
                <select name="santri_id"
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                        required>
                    @foreach($santris as $santri)
                    <option value="{{ $santri->id }}" {{ $assessment->santri_id == $santri->id ? 'selected' : '' }}>
                        {{ $santri->name }}
                    </option>
                    @endforeach
                </select>
                @error('santri_id')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Assessor -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Penilai</label>
                <select name="assessor_id"
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                        required>
                    @foreach($assessors as $assessor)
                    <option value="{{ $assessor->id }}" {{ $assessment->assessor_id == $assessor->id ? 'selected' : '' }}>
                        {{ $assessor->name }}
                    </option>
                    @endforeach
                </select>
                @error('assessor_id')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Template -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Template</label>
                <select name="assessment_template_id"
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                        required>
                    @foreach($templates as $template)
                    <option value="{{ $template->id }}" {{ $assessment->assessment_template_id == $template->id ? 'selected' : '' }}>
                        {{ $template->name }}
                    </option>
                    @endforeach
                </select>
                @error('assessment_template_id')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Periode -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                <select name="period_id"
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                        required>
                    @foreach($periods as $period)
                    <option value="{{ $period->id }}" {{ $assessment->period_id == $period->id ? 'selected' : '' }}>
                        {{ $period->name }}
                    </option>
                    @endforeach
                </select>
                @error('period_id')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                <input type="date" name="date"
                       value="{{ old('date', $assessment->date) }}"
                       class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                       required>
                @error('date')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status"
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                        required>
                    <option value="draft" {{ $assessment->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="submitted" {{ $assessment->status == 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="approved" {{ $assessment->status == 'approved' ? 'selected' : '' }}>Approved</option>
                </select>
                @error('status')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Catatan -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
            <textarea name="note" rows="2"
                      class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
            >{{ old('note', $assessment->note) }}</textarea>
            @error('note')
                <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Detail Skor -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-clipboard-list text-blue-300 mr-2"></i>
                Detail Skor Komponen
            </h3>
            <div class="space-y-4">
                @foreach($assessment->details as $i => $detail)
                <div class="flex items-center justify-between p-4 border border-blue-100 rounded-lg bg-white hover:bg-blue-50 transition-colors">
                    <div class="flex-1">
                        <p class="font-medium text-gray-700">{{ $detail->component->name ?? 'Komponen' }}</p>
                        @if($detail->component->description)
                        <p class="text-xs text-gray-500 mt-1">{{ $detail->component->description }}</p>
                        @endif
                    </div>
                    <div class="w-32">
                        <input type="number"
                               name="scores[{{ $i }}][score]"
                               min="0"
                               step="0.01"
                               value="{{ old("scores.$i.score", $detail->score) }}"
                               class="w-full rounded-md border-blue-200 shadow-sm text-right font-medium text-blue-600 focus:border-blue-300"
                               required>
                        <input type="hidden" name="scores[{{ $i }}][assessment_component_id]" value="{{ $detail->assessment_component_id }}">
                    </div>
                </div>
                @endforeach
            </div>
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
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
