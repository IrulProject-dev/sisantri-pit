<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public $statuses = ['hadir', 'izin', 'sakit', 'alfa', 'terlambat', 'piket'];

    /**
     * Display a listing of the attendances with optional filters.
     */
    public function index(Request $request)
    {
        $query = Attendance::with(['user', 'session', 'recorder']);

        // Apply filters if provided
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }

        if ($request->has('session_id') && $request->session_id) {
            $query->where('session_id', $request->session_id);
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

        $attendances = $query->paginate(15)->appends($request->query());

        // Get data for filters
        $users        = User::where('role', 'santri')->get();
        $sessionTypes = AttendanceSession::all();
        $statuses     = $this->statuses;

        return view('pages.attendances.index', compact('attendances', 'users', 'sessionTypes', 'statuses'));
    }

    /**
     * Show the form for creating a new attendance.
     */
    public function create(Request $request)
    {
        $users        = User::where('role', 'santri')->get();
        $sessionTypes = AttendanceSession::all();
        $statuses     = $this->statuses;

        // For batch creation, we'll use the same form but with multiple selection
        $isBatch = $request->has('batch') && $request->batch;

        return view('pages.attendances.create', compact('users', 'sessionTypes', 'statuses', 'isBatch'));
    }

    /**
     * Store a newly created attendance in storage.
     */
    public function store(Request $request)
    {
        // Determine if this is a batch operation
        $isBatch = $request->has('user_ids') && is_array($request->user_ids);

        if ($isBatch) {
            $validator = Validator::make($request->all(), [
                'user_ids'   => 'required|array',
                'user_ids.*' => 'exists:users,id',
                'session_id' => 'required|exists:session_types,id',
                'date'       => 'required|date',
                'status'     => 'required|in:hadir,izin,sakit,terlambat,piket',
                'notes'      => 'nullable|string|max:255',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'user_id'    => 'required|exists:users,id',
                'session_id' => 'required|exists:session_types,id',
                'date'       => 'required|date',
                'status'     => 'required|in:hadir,izin,sakit,terlambat,piket',
                'notes'      => 'nullable|string|max:255',
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
                Attendance::create([
                    'user_id'     => $userId,
                    'session_id'  => $request->session_id,
                    'date'        => $request->date,
                    'status'      => $request->status,
                    'notes'       => $request->notes,
                    'recorded_by' => Auth::id(),
                ]);
            }
            $message = 'Batch attendances created successfully.';
        } else {
            // Single creation
            Attendance::create([
                'user_id'     => $request->user_id,
                'session_id'  => $request->session_id,
                'date'        => $request->date,
                'status'      => $request->status,
                'notes'       => $request->notes,
                'recorded_by' => Auth::id(),
            ]);
            $message = 'Attendance created successfully.';
        }

        return redirect()->route('attendances.index')
            ->with('success', $message);
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
            'user_id'    => 'required|exists:users,id',
            'session_id' => 'required|exists:session_types,id',
            'date'       => 'required|date',
            'status'     => 'required|in:hadir,izin,sakit,terlambat,piket',
            'notes'      => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $attendanceRecord->update([
            'user_id'    => $request->user_id,
            'session_id' => $request->session_id,
            'date'       => $request->date,
            'status'     => $request->status,
            'notes'      => $request->notes,
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
