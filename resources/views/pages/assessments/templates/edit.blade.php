@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-blue-100 max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">
            <i class="fas fa-edit text-blue-300 mr-2"></i>
            Edit Template Penilaian
        </h2>
        <a href="{{ route('assessment-templates.index') }}"
           class="text-blue-400 hover:text-blue-600 text-sm transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('assessment-templates.update', $assessmentTemplate) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Nama Template -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Template</label>
                <input type="text" name="name"
                       value="{{ old('name', $assessmentTemplate->name) }}"
                       class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                       required>
                @error('name')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                >{{ old('description', $assessmentTemplate->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Divisi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Divisi</label>
                <select name="division_id"
                        class="mt-1 block w-full rounded-md border-blue-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200"
                        required>
                    <option value="">Pilih Divisi</option>
                    @foreach($divisions as $division)
                    <option value="{{ $division->id }}"
                        {{ old('division_id', $assessmentTemplate->division_id) == $division->id ? 'selected' : '' }}>
                        {{ $division->name }}
                    </option>
                    @endforeach
                </select>
                @error('division_id')
                    <p class="mt-1 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Komponen Penilaian -->
            <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Komponen Penilaian</label>

                @if($components->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($components as $component)
                        @php
                            $templateComponent = $assessmentTemplate->components->firstWhere('id', $component->id);
                            $weight = old("components.{$loop->index}.weight", $templateComponent ? $templateComponent->pivot->weight : 0);
                        @endphp
                        <div class="p-4 border border-blue-100 rounded-lg hover:border-blue-200 transition-colors duration-200">
                            <div class="flex items-start justify-between">
                                <label class="flex items-center space-x-3 flex-1">
                                    <input type="checkbox"
                                           name="components[{{ $loop->index }}][id]"
                                           value="{{ $component->id }}"
                                           class="rounded border-blue-200 text-blue-400 focus:ring-blue-200"
                                           {{ $templateComponent ? 'checked' : '' }}>
                                    <span class="text-gray-700">{{ $component->name }}</span>
                                    <span class="text-sm text-blue-400">(Maks: {{ $component->max_score }})</span>
                                </label>

                                <div class="w-24">
                                    <input type="number"
                                           name="components[{{ $loop->index }}][weight]"
                                           value="{{ $weight }}"
                                           class="w-full rounded-md border-blue-200 shadow-sm text-sm focus:border-blue-300"
                                           placeholder="Bobot %"
                                           min="0"
                                           max="100">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Error Messages -->
                    <div class="space-y-1">
                        @error('components')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                        @error('components.*.id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                        @error('components.*.weight')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                @else
                    <div class="p-4 border border-blue-100 rounded-lg bg-blue-50 text-center">
                        <p class="text-gray-500 text-sm">
                            <i class="fas fa-info-circle mr-2 text-blue-300"></i>
                            Belum ada komponen penilaian yang tersedia
                        </p>
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="border-t border-blue-100 pt-4">
                <button type="submit"
                        class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg border border-blue-200 transition-all duration-300 hover:shadow-sm">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
