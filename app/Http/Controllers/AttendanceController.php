<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Batch;
use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public $statuses = ['hadir', 'izin', 'sakit', 'alfa', 'terlambat', 'piket'];

    /**
     * Display a listing of the attendances with optional filters.
     */
    public function index(Request $request)
    {
        $query = Attendance::query()
            ->with(['user.division', 'user.batch', 'attendanceSession']);

        // Filter by division
        if ($request->filled('division_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('division_id', $request->division_id);
            });
        }

        // Filter by batch
        if ($request->filled('batch_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('batch_id', $request->batch_id);
            });
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->where('date', $request->date);
        } else {
            $query->where('date', date('Y-m-d'));

        }

        // Filter by session
        if ($request->filled('attendance_session_id')) {
            $query->where('attendance_session_id', $request->attendance_session_id);
        }

        $attendances       = $query->latest()->paginate(15);
        $divisions         = Division::orderBy('name')->get();
        $batches           = Batch::orderBy('name')->get();
        $attendanceSession = AttendanceSession::orderBy('name')->get();

        return view('pages.attendances.index', compact(
            'attendances',
            'divisions',
            'batches',
            'attendanceSession'
        ));
    }

    /**
     * Show the form for creating a new attendance.
     */
    public function create(Request $request)
    {
        $divisions    = Division::orderBy('name')->get();
        $batches      = Batch::orderBy('name')->get();
        $sessionTypes = AttendanceSession::orderBy('name')->get();
        $statuses     = ['hadir', 'sakit', 'izin', 'alfa', 'terlambat', 'piket'];

        $users               = collect();
        $existingAttendances = collect();

        if ($request->filled('date') && $request->filled('attendance_session_id')) {
            $query = User::query()->with(['division', 'batch']);

            if ($request->filled('division_id')) {
                $query->where('division_id', $request->division_id);
            }

            if ($request->filled('batch_id')) {
                $query->where('batch_id', $request->batch_id);
            }

            $users = $query->orderBy('name')->get();

            // Check for existing attendance records
            $existingAttendances = Attendance::where('date', $request->date)
                ->where('attendance_session_id', $request->attendance_session_id)
                ->whereIn('user_id', $users->pluck('id'))
                ->get()
                ->keyBy('user_id');
        }

        return view('pages.attendances.create', compact(
            'divisions',
            'batches',
            'sessionTypes',
            'statuses',
            'users',
            'existingAttendances'
        ));
    }

    /**
     * Store a newly created attendance in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_ids'              => 'required|array',
            'user_ids.*'            => 'exists:users,id',
            'status'                => 'required|array',
            'attendance_session_id' => 'required|exists:attendance_sessions,id',
            'date'                  => 'required|date',
        ]);

        $date      = $request->date;
        $sessionId = $request->attendance_session_id;
        $userIds   = $request->user_ids;
        $statuses  = $request->status;

        // Get the currently authenticated user's ID
        $recordedBy = auth()->id();

        // Get existing attendance records for this date and session
        $existingAttendances = Attendance::where('date', $date)
            ->where('attendance_session_id', $sessionId)
            ->whereIn('user_id', $userIds)
            ->get()
            ->keyBy('user_id');

        foreach ($userIds as $userId) {
            if (isset($statuses[$userId])) {
                if ($existingAttendances->has($userId)) {
                    // Update existing record
                    $existingAttendances[$userId]->update([
                        'status'      => $statuses[$userId],
                        'recorded_by' => $recordedBy,
                    ]);
                } else {
                    // Create new record
                    Attendance::create([
                        'user_id'               => $userId,
                        'attendance_session_id' => $sessionId,
                        'date'                  => $date,
                        'status'                => $statuses[$userId],
                        'recorded_by'           => $recordedBy,
                    ]);
                }
            }
        }

        return redirect()->route('attendances.index')
            ->with('success', 'Data absensi berhasil disimpan.');
    }

    /**
     * Display the specified attendance.
     */
    public function show(Attendance $attendanceRecord)
    {
        $attendanceRecord->load(['user', 'session', 'recorder']);

        return view('pages.attendances.show', compact('attendanceRecord'));
    }

    /**
     * Show the form for editing the specified attendance
     */
    public function edit(Attendance $attendanceRecord)
    {
        $users        = User::where('role', 'santri')->get();
        $sessionTypes = AttendanceSession::all();
        $statuses     = $this->statuses;

        return view('pages.attendances.edit', compact('attendanceRecord', 'users', 'sessionTypes', 'statuses'));
    }

    /**
     * Update the specified attendance in storage.
     */
    public function update(Request $request, Attendance $attendanceRecord)
    {
        $validator = Validator::make($request->all(), [
            'user_id'               => 'required|exists:users,id',
            'attendance_session_id' => 'required|exists:session_types,id',
            'date'                  => 'required|date',
            'status'                => 'required|in:hadir,izin,sakit,terlambat,piket',
            'notes'                 => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $attendanceRecord->update([
            'user_id'               => $request->user_id,
            'attendance_session_id' => $request->attendance_session_id,
            'date'                  => $request->date,
            'status'                => $request->status,
            'notes'                 => $request->notes,
        ]);

        return redirect()->route('attendances.index')
            ->with('success', 'Attendance updated successfully.');
    }

    /**
     * Remove the specified attendance from storage.
     */
    public function destroy(Attendance $attendanceRecord)
    {
        $attendanceRecord->delete();

        return redirect()->route('attendances.index')
            ->with('success', 'Attendance deleted successfully.');
    }
}
