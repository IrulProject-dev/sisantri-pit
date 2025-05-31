<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Division;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class ImporSantriController extends Controller
{
    public function index()
    {
        return view('pages.santris.impor-santri');
    }

    public function imporLokal(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('file');
        $errors = [];
        $import = Excel::toArray(null, $file)[0];

        if (count($import) < 2) {
            return back()->with('error', 'File kosong atau format tidak sesuai!');
        }

        // Lewati header
        array_shift($import);
        $rows = $import;
        $successCount = 0;

        foreach ($rows as $index => $row) {
            if (collect($row)->filter()->isEmpty()) {
                continue;
            }
            try {
                // Validasi jumlah kolom minimal 16
                if (count($row) < 16) {
                    throw new \Exception("Jumlah kolom tidak sesuai (minimal 15 kolom)");
                }

                // Mapping berdasarkan struktur gambar
                $data = [
                    // Kolom 0: Times (diabaikan)
                    'name'          => (string) ($row[1] ?? ''),      // Kolom 1: Name Lengths (Nama Lengkap)
                    'email'         => $row[2] ?? null,               // Kolom 2: Email
                    'phone'         => $row[3] ?? '',                 // Kolom 3: Phone
                    'batch_name'    => (string) ($row[4] ?? ''),      // Kolom 3: Angliction (Angkatan)
                    'gender'        => $row[5] ?? '',                 // Kolom 4: Gender
                    'place_of_birth' => $row[6] ?? '',                // Kolom 5: Tempat Ishir (Tempat Lahir)
                    'date_of_birth' => $row[7] ?? '',                 // Kolom 6: Tanggal Lahir
                    'address'       => $row[8] ?? '',                 // Kolom 7: Alamat
                    'father_name'   => $row[9] ?? '',                 // Kolom 8: Nama Ayah
                    'father_phone'  => $row[10] ?? '',                 // Kolom 9: No.Ip Ayah (No. HP Ayah)
                    'mother_name'   => $row[11] ?? '',                // Kolom 10: Nama ibu
                    'mother_phone'  => $row[12] ?? '',                // Kolom 11: No.Ip ibu (No. HP Ibu)
                    'division_name' => $row[13] ?? '',                // Kolom 12: Juntaan (Jurusan)
                    'photo'         => $row[14] ?? null,              // Kolom 13: Upload Foto
                    // Kolom 14: (diabaikan)
                ];

                // Validasi data penting
                if (empty($data['name'])) {
                    throw new \Exception("Nama wajib diisi");
                }

                if (empty($data['division_name'])) {
                    throw new \Exception("Jurusan wajib diisi");
                }

                if (empty($data['batch_name'])) {
                    throw new \Exception("Angkatan wajib diisi");
                }

                // Handle divisi
                $division = Division::updateOrCreate(
                    ['name' => $data['division_name']],
                    [
                        'code' => $this->generateDivisionCode($data['division_name']),
                        'description' => $data['division_name']
                    ]
                );


                // Handle batch - CARI BERDASARKAN NAMA
                $batch = Batch::where('name', $data['batch_name'])->first();

                if (!$batch) {
                    // Buat batch baru dengan tanggal acak
                    $entry_date = now()->subYears(rand(1, 5))->startOfYear();
                    $graduation_date = $entry_date->copy()->addYears(3);

                    $batch = Batch::create([
                        'name' => $data['batch_name'],
                        'entry_date' => $entry_date,
                        'graduation_date' => $graduation_date,
                        'is_active' => true,
                    ]);
                }

                // Normalisasi gender
                $gender = $this->normalizeGender($data['gender']);
                if (!$gender) {
                    throw new \Exception("Gender tidak valid: {$data['gender']}");
                }

                // Format tanggal lahir (DD/MM/YYYY ke YYYY-MM-DD)
                $dob = null;
                if (!empty($data['date_of_birth'])) {
                    try {
                        $dob = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Coba format lain
                        try {
                            $dob = Carbon::parse($data['date_of_birth'])->format('Y-m-d');
                        } catch (\Exception $e) {
                            throw new \Exception("Format tanggal lahir tidak valid: {$data['date_of_birth']}");
                        }
                    }
                }


                // Generate NIS
                $nis = $this->generateNIS($data['batch_name'], $division->code);

                // Buat user baru
                User::create([
                    'nis' => $nis,
                    'name' => $data['name'],
                    'email' => $data['email'] ?: ($nis . '@pondok.com'),
                    'password' => Hash::make('password123'),
                    'role' => 'santri',
                    'gender' => $gender,
                    'place_of_birth' => $data['place_of_birth'],
                    'date_of_birth' => $dob,
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'father_name' => $data['father_name'],
                    'father_phone' => $data['father_phone'],
                    'mother_name' => $data['mother_name'],
                    'mother_phone' => $data['mother_phone'],
                    'division_id' => $division->id,
                    'batch_id' => $batch->id,
                    'is_active' => true,
                    'status' => 'active',
                    'photo' => $data['photo'],
                ]);

                $successCount++;
            } catch (\Exception $e) {
                $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
            }
        }

        $message = "Berhasil mengimpor $successCount dari " . count($rows) . " data";
        return back()->with('success', $message)->with('import_errors', $errors);
    }

    private function normalizeGender($value)
    {
        $value = strtolower(trim($value));

        if (in_array($value, ['laki-laki', 'laki', 'pria', 'cowok', 'male', 'l', 'ikhwan', 'lkhwan'])) {
            return 'male';
        }

        if (in_array($value, ['perempuan', 'wanita', 'cewek', 'female', 'p', 'akhwat'])) {
            return 'female';
        }

        return null;
    }

    private function generateDivisionCode($name)
    {
        $name = strtolower(trim($name));
        $map = [
            'marketing' => 'MT',
            'programmer' => 'PRG',
            'multimedia' => 'MM',
        ];

        if (!isset($map[$name])) {
            throw new \Exception("Kode jurusan untuk '$name' tidak ditemukan dalam mapping.");
        }

        return $map[$name];
    }

    private function generateNIS($batch_name, $kodeDivisi)
    {
        // Ekstrak angka tahun dari nama batch
        preg_match('/\d+/', $batch_name, $matches);
        $tahun = $matches[0] ?? date('y'); // Gunakan 2 digit tahun terakhir

        // Jika tahun 4 digit, ambil 2 digit terakhir
        if (strlen($tahun) === 4) {
            $tahun = substr($tahun, -2);
        }

        $kodeDivisi = substr(preg_replace('/[^A-Za-z]/', '', strtoupper($kodeDivisi)), 0, 3);

        $lastSantri = User::where('nis', 'like', $tahun . $kodeDivisi . '%')
            ->orderBy('nis', 'desc')
            ->first();

        $lastNumber = 0;
        if ($lastSantri) {
            $lastNis = $lastSantri->nis;
            $lastNumber = intval(substr($lastNis, -4));
        }

        $newNumber = $lastNumber + 1;
        return $tahun . $kodeDivisi . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
