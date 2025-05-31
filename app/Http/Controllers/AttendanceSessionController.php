<?php
namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendanceSessions = AttendanceSession::latest()->paginate(10);

        return view('pages.attendance-sessions.index', compact('attendanceSessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.attendance-sessions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'string|required|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time'   => 'nullable|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return redirect()->route('attendance-sessions.create')->withErrors($validator)->withInput();
        }

        AttendanceSession::create($request->all());

        return redirect()->route('attendance-sessions.index')->with('success', 'Sesi absensi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceSession $attendanceSession)
    {
        return view('pages.attendance-sessions.show', compact('attendanceSession'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceSession $attendanceSession)
    {
        return view('pages.attendance-sessions.edit', compact('attendanceSession'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceSession $attendanceSession)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'string|required|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time'   => 'nullable|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return redirect()->route('attendance-sessions.edit')->withErrors($validator)->withInput();
        }

        $attendanceSession->update($request->all());

        return redirect()->route('attendance-sessions.index')->with('success', 'Sesi absensi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceSession $attendanceSession)
    {
        try {
            $attendanceSession->delete();
            return redirect()->route('attendance-sessions.index')->with('success', 'Sesi absensi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('attendance-sessions.index')->with('error', 'Gagal menghapus sesi absen. Sesi absen mungkin sedang digunakan');
        }
    }
}
