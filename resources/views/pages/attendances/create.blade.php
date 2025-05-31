@extends('layouts.app')

@section('title', 'Tambah Absensi')

@section('content')
    <div class="container mx-auto">
        <div class="md:flex justify-between items-center mb-6">
            <div class="max-md:mb-3">
                <h1 class="text-2xl font-bold text-gray-900">Tambah Absensi</h1>
                <p class="text-gray-600">Silakan isi form di bawah ini untuk menambahkan data absensi baru.</p>
            </div>
        </div>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="bg-white shadow rounded-md overflow-hidden border border-gray-200 mb-6">
            <div class="p-4">
                <h2 class="text-lg font-medium text-gray-900 mb-3">Filter Absensi</h2>
                <form action="{{ route('attendances.create') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="division_id" class="block text-sm font-medium text-gray-700 mb-1">Divisi</label>
                        <select name="division_id" id="division_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 hover:shadow-sm">
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 hover:shadow-sm">
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
                            class="w-full px-3 py-[6px] border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 hover:shadow-sm"
                            required>
                    </div>

                    <div>
                        <label for="attendance_session_id" class="block text-sm font-medium text-gray-700 mb-1">Sesi</label>
                        <select name="attendance_session_id" id="attendance_session_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 hover:shadow-sm"
                            required>
                            <option value="">Pilih Sesi</option>
                            @foreach ($sessionTypes as $session)
                                <option value="{{ $session->id }}"
                                    {{ request('attendance_session_id') == $session->id ? 'selected' : '' }}>
                                    {{ $session->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-4 flex justify-end space-x-3">
                        <a href="{{ route('attendances.create') }}"
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

        <!-- Status Massal Section -->
        <div class="bg-white shadow rounded-md overflow-hidden border border-gray-200 mb-6">
            <div class="p-4">
                <h2 class="text-lg font-medium text-gray-900 mb-3">Status Massal:</h2>
                <div class="flex flex-wrap gap-2">
                    <button type="button"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 status-mass-btn cursor-pointer"
                        data-status="hadir">
                        <i class="fas fa-check-circle mr-1"></i> Semua Hadir
                    </button>
                    <button type="button"
                        class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 status-mass-btn cursor-pointer"
                        data-status="sakit">
                        <i class="fas fa-procedures mr-1"></i> Semua Sakit
                    </button>
                    <button type="button"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 status-mass-btn cursor-pointer"
                        data-status="izin">
                        <i class="fas fa-envelope mr-1"></i> Semua Izin
                    </button>
                    <button type="button"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 status-mass-btn cursor-pointer"
                        data-status="alfa">
                        <i class="fas fa-times-circle mr-1"></i> Semua Alfa
                    </button>
                    <button type="button"
                        class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 status-mass-btn cursor-pointer"
                        data-status="terlambat">
                        <i class="fas fa-clock mr-1"></i> Semua Terlambat
                    </button>
                    <button type="button"
                        class="px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600 status-mass-btn cursor-pointer"
                        data-status="piket">
                        <i class="fas fa-broom mr-1"></i> Semua Piket
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white border border-border shadow-sm rounded-lg p-6">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (request('date') && request('attendance_session_id') && $existingAttendances->count() > 0)
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">
                        <i class="fas fa-info-circle mr-1"></i>
                        Anda sedang mengedit data absensi yang sudah ada untuk tanggal
                        {{ \Carbon\Carbon::parse(request('date'))->format('d M Y') }}
                        dan sesi {{ $sessionTypes->where('id', request('attendance_session_id'))->first()->name ?? '' }}.
                    </span>
                </div>
            @endif

            <form action="{{ route('attendances.store') }}" method="POST">
                @csrf
                <!-- Hidden fields for attendance_session_id and date -->
                <input type="hidden" name="attendance_session_id" value="{{ request('attendance_session_id') }}">
                <input type="hidden" name="date" value="{{ request('date', date('Y-m-d')) }}">

                @if (count($users) > 0)
                    <div class="mb-4">
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
                                            <div class="flex items-center">
                                                <input type="checkbox" id="select-all"
                                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded cursor-pointer">
                                                <span class="ml-2">Nama Santri</span>
                                            </div>
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
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                                        id="user-{{ $user->id }}" checked
                                                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded user-checkbox cursor-pointer">
                                                    <label for="user-{{ $user->id }}"
                                                        class="ml-2 text-sm font-medium text-gray-900 cursor-pointer">
                                                        {{ $user->name }}
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->division->name ?? 'Belum ada divisi' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->batch->name ?? 'Belum ada angkatan' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <select name="status[{{ $user->id }}]"
                                                    class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-foreground focus:ring-1 hover:shadow-sm cursor-pointer user-status-select">
                                                    @foreach ($statuses as $status)
                                                        <option value="{{ $status }}"
                                                            {{ (isset($existingAttendances[$user->id]) && $existingAttendances[$user->id]->status == $status) ||
                                                            (!isset($existingAttendances[$user->id]) && $status == 'hadir')
                                                                ? 'selected'
                                                                : '' }}>
                                                            {{ ucfirst($status) }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="mb-4 p-4 bg-gray-50 rounded-md text-center">
                        <p class="text-gray-500">Silakan pilih filter untuk menampilkan daftar santri.</p>
                    </div>
                @endif

                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('attendances.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                    @if (count($users) > 0 && request('attendance_session_id') && request('date'))
                        <button type="submit"
                            class="px-4 py-2 bg-primary text-primary-foreground rounded-md hover:bg-primary/90 cursor-pointer">
                            {{ $existingAttendances->count() > 0 ? 'Update' : 'Simpan' }}
                        </button>
                    @else
                        <button type="button" disabled
                            class="px-4 py-2 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">Simpan</button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle mass status buttons
            const massStatusButtons = document.querySelectorAll('.status-mass-btn');
            const userStatusSelects = document.querySelectorAll('.user-status-select');

            massStatusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const status = this.getAttribute('data-status');

                    userStatusSelects.forEach(select => {
                        // Find the option with the matching value and select it
                        for (let i = 0; i < select.options.length; i++) {
                            if (select.options[i].value === status) {
                                select.selectedIndex = i;
                                break;
                            }
                        }
                    });
                });
            });

            // Handle select all checkbox
            const selectAllCheckbox = document.getElementById('select-all');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');

            // Initialize the select all checkbox state
            updateSelectAllCheckbox();

            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;

                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                    toggleUserFields(checkbox);
                });
            });

            // Handle individual checkboxes
            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    toggleUserFields(this);
                    updateSelectAllCheckbox();
                });

                // Initialize status fields
                toggleUserFields(checkbox);
            });

            // Function to update the select all checkbox state
            function updateSelectAllCheckbox() {
                const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
                const totalCount = userCheckboxes.length;

                if (checkedCount === 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                } else if (checkedCount === totalCount) {
                    selectAllCheckbox.checked = true;
                    selectAllCheckbox.indeterminate = false;
                } else {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = true;
                }
            }

            // Function to toggle status fields
            function toggleUserFields(checkbox) {
                const userId = checkbox.value;
                const statusSelect = document.querySelector(`select[name="status[${userId}]"]`);

                if (checkbox.checked) {
                    statusSelect.disabled = false;
                } else {
                    statusSelect.disabled = true;
                }
            }
        });
    </script>
@endsection
