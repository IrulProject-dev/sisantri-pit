<?php
namespace App\Http\Controllers;

use App\Models\SessionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SessionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessionTypes = SessionType::latest()->paginate(10);

        return view('pages.session-types.index', compact('sessionTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.session-types.create');
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
            return redirect()->route('session-types.create')->withErrors($validator)->withInput();
        }

        return redirect()->route('session-types.index')->with('success', 'Sesi absensi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SessionType $sessionType)
    {
        return view('pages.session-types.show', compact('sessionType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SessionType $sessionType)
    {
        return view('pages.session-types.edit', compact('sessionType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SessionType $sessionType)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'string|required|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time'   => 'nullable|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return redirect()->route('session-types.edit')->withErrors($validator)->withInput();
        }

        $sessionType->update($request->all());

        return redirect()->route('session-types.index')->with('success', 'Sesi absensi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SessionType $sessionType)
    {
        try {
            $sessionType->delete();
            return redirect()->route('session-types.index')->with('success', 'Sesi absensi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('session-types.index')->with('error', 'Gagal menghapus sesi absen. Sesi absen mungkin sedang digunakan');
        }
    }
}
