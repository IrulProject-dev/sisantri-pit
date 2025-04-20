@extends('layouts.app')

@section('title', 'Tambah Santri - SiSantri')

@section('content')
    <div class="container mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Tambah Santri Baru</h1>
            <p class="text-gray-600">Silakan isi form di bawah ini untuk menambahkan santri baru.</p>
        </div>
        <div class="bg-white border shadow-sm rounded-lg p-6">
            <form action="{{ route('santris.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIS -->
                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                        <input type="text" name="nis" id="nis" value="{{ old('nis') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            placeholder="Nomor Induk Santri" required>
                        @error('nis')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            placeholder="Nama lengkap santri" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            placeholder="santri@mail.com" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="gender" id="gender"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                            Lahir</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            required>
                        @error('date_of_birth')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea name="address" id="address" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            placeholder="Alamat lengkap santri" required>{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No. Telepon -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            placeholder="Nomor telepon santri" required>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jurusan -->
                    <div>
                        <label for="division_id" class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                        <select name="division_id" id="division_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            required>
                            <option value="">Pilih Jurusan</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('division_id')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Angkatan -->
                    <div>
                        <label for="batch_id" class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                        <select name="batch_id" id="batch_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            required>
                            <option value="">Pilih Angkatan</option>
                            @foreach ($batches as $batch)
                                <option value="{{ $batch->id }}" {{ old('batch_id') == $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('batch_id')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            required>
                            <option value="">Pilih Status</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif
                            </option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                        <input type="file" name="photo" id="photo"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maks: 2MB</p>
                        @error('photo')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="md:col-span-2 mt-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Data Orang Tua</h3>
                    </div>

                    <!-- Nama Ayah -->
                    <div>
                        <label for="father_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                        <input type="text" name="father_name" id="father_name" value="{{ old('father_name') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            placeholder="Nama lengkap ayah" required>
                        @error('father_name')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No. Telepon Ayah -->
                    <div>
                        <label for="father_phone" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon
                            Ayah</label>
                        <input type="text" name="father_phone" id="father_phone" value="{{ old('father_phone') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            placeholder="Nomor telepon ayah" required>
                        @error('father_phone')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Ibu -->
                    <div>
                        <label for="mother_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                        <input type="text" name="mother_name" id="mother_name" value="{{ old('mother_name') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            placeholder="Nama lengkap ibu" required>
                        @error('mother_name')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No. Telepon Ibu -->
                    <div>
                        <label for="mother_phone" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon
                            Ibu</label>
                        <input type="text" name="mother_phone" id="mother_phone" value="{{ old('mother_phone') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 shadow-sm"
                            placeholder="Nomor telepon ibu" required>
                        @error('mother_phone')
                            <p class="text-red-500 text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 mt-6">
                    <a href="{{ route('pages.santris.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-primary text-primary-foreground rounded-md hover:bg-primary/90">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
