<?php
namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\SessionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttendanceRecordController extends Controller
{
    /**
     * Display a listing of the attendance records with optional filters.
     */
    public function index(Request $request)
    {
        $query = AttendanceRecord::with(['user', 'sessionType', 'recorder']);

        // Apply filters if provided
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }

        if ($request->has('session_type_id') && $request->session_type_id) {
            $query->where('session_type_id', $request->session_type_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('division_id') && $request->division_id) {
            // Assuming users belong to divisions
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('division_id', $request->division_id);
            });
        }

        // Default sorting by date (newest first)
        $query->orderBy('date', 'desc');

        // Allow custom sorting
        if ($request->has('sort_by') && $request->has('sort_order')) {
            $query->orderBy($request->sort_by, $request->sort_order);
        }

        $attendanceRecords = $query->paginate(15)->appends($request->query());

        // Get data for filters
        $users        = User::where('role', 'santri')->get();
        $sessionTypes = SessionType::all();

        return view('attendance.index', compact('attendanceRecords', 'users', 'sessionTypes', 'statuses'));
    }

    /**
     * Show the form for creating a new attendance record.
     */
    public function create(Request $request)
    {
        $users        = User::where('role', 'santri')->get();
        $sessionTypes = SessionType::all();
        $statuses     = ['hadir', 'izin', 'sakit', 'alfa', 'terlambat', 'piket'];

        // For batch creation, we'll use the same form but with multiple selection
        $isBatch = $request->has('batch') && $request->batch;

        return view('attendance.create', compact('users', 'sessionTypes', 'statuses', 'isBatch'));
    }

    /**
     * Store a newly created attendance record in storage.
     */
    public function store(Request $request)
    {
        // Determine if this is a batch operation
        $isBatch = $request->has('user_ids') && is_array($request->user_ids);

        if ($isBatch) {
            $validator = Validator::make($request->all(), [
                'user_ids'        => 'required|array',
                'user_ids.*'      => 'exists:users,id',
                'session_type_id' => 'required|exists:session_types,id',
                'date'            => 'required|date',
                'status'          => 'required|in:hadir,izin,sakit,terlambat,piket',
                'notes'           => 'nullable|string|max:255',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'user_id'         => 'required|exists:users,id',
                'session_type_id' => 'required|exists:session_types,id',
                'date'            => 'required|date',
                'status'          => 'required|in:hadir,izin,sakit,terlambat,piket',
                'notes'           => 'nullable|string|max:255',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($isBatch) {
            // Batch creation
            foreach ($request->user_ids as $userId) {
                AttendanceRecord::create([
                    'user_id'         => $userId,
                    'session_type_id' => $request->session_type_id,
                    'date'            => $request->date,
                    'status'          => $request->status,
                    'notes'           => $request->notes,
                    'recorded_by'     => Auth::id(),
                ]);
            }
            $message = 'Batch attendance records created successfully.';
        } else {
            // Single record creation
            AttendanceRecord::create([
                'user_id'         => $request->user_id,
                'session_type_id' => $request->session_type_id,
                'date'            => $request->date,
                'status'          => $request->status,
                'notes'           => $request->notes,
                'recorded_by'     => Auth::id(),
            ]);
            $message = 'Attendance record created successfully.';
        }

        return redirect()->route('attendance.index')
            ->with('success', $message);
    }

    /**
     * Display the specified attendance record.
     */
    public function show(AttendanceRecord $attendanceRecord)
    {
        $attendanceRecord->load(['user', 'sessionType', 'recorder']);

        return view('attendance.show', compact('attendanceRecord'));
    }

    /**
     * Show the form for editing the specified attendance record
     */
    public function edit(AttendanceRecord $attendanceRecord)
    {
        $users        = User::where('role', 'santri')->get();
        $sessionTypes = SessionType::all();
        $statuses     = ['hadir', 'izin', 'sakit', 'alfa', 'terlambat', 'piket'];

        return view('attendance.edit', compact('attendanceRecord', 'users', 'sessionTypes', 'statuses'));
    }

    /**
     * Update the specified attendance record in storage.
     */
    public function update(Request $request, AttendanceRecord $attendanceRecord)
    {
        $validator = Validator::make($request->all(), [
            'user_id'         => 'required|exists:users,id',
            'session_type_id' => 'required|exists:session_types,id',
            'date'            => 'required|date',
            'status'          => 'required|in:hadir,izin,sakit,terlambat,piket',
            'notes'           => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $attendanceRecord->update([
            'user_id'         => $request->user_id,
            'session_type_id' => $request->session_type_id,
            'date'            => $request->date,
            'status'          => $request->status,
            'notes'           => $request->notes,
        ]);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance record updated successfully.');
    }

    /**
     * Remove the specified attendance record from storage.
     */
    public function destroy(AttendanceRecord $attendanceRecord)
    {
        $attendanceRecord->delete();

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance record deleted successfully.');
    }
}
