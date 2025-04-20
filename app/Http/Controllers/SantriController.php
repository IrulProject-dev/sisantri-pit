<?php
namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'santri');

        // Apply division filter if provided
        if ($request->has('division_id') && $request->division_id != '') {
            $query->where('division_id', $request->division_id);
        }

        // Apply batch filter if provided
        if ($request->has('batch_id') && $request->batch_id != '') {
            $query->where('batch_id', $request->batch_id);
        }

        $santris = $query->latest()->paginate(10)->withQueryString();

        // Get divisions and batches for the filter dropdowns
        $divisions = Division::all();
        $batches   = Batch::all();

        return view('pages.santris.index', compact('santris', 'divisions', 'batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Get divisions and batches for the dropdown selects
        $divisions = Division::all();
        $batches   = Batch::all();

        return view('pages.santris.create', compact('divisions', 'batches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis'           => 'required|unique:users,nis',
            'email'         => 'required|unique:users,email',
            'name'          => 'required|string|max:255',
            'gender'        => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'address'       => 'required|string',
            'phone'         => 'required|string|max:15',
            'father_name'   => 'required|string|max:255',
            'father_phone'  => 'required|string|max:15',
            'mother_name'   => 'required|string|max:255',
            'mother_phone'  => 'required|string|max:15',
            'division_id'   => 'required|exists:divisions,id',
            'batch_id'      => 'required|exists:batches,id',
            'status'        => 'required|in:active,inactive',
            'photo'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('pages.santris.create')->withErrors($validator)->withInput();
        }

        // Handle photo upload if provided
        $data             = $request->all();
        $data['role']     = 'santri';   // Ensure role is set to santri
        $data['password'] = 'password'; // Set default password.

        if ($request->hasFile('photo')) {
            $photo    = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/santri'), $filename);
            $data['photo'] = 'uploads/santri/' . $filename;
        }

        User::create($data);

        return redirect()->route('santris.index')->with('success', "Santri berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the santri by ID and ensure it has the role 'santri'
        $santri = User::where('id', $id)->where('role', 'santri')->firstOrFail();

        return view('pages.santris.show', compact('santri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find the santri by ID and ensure it has the role 'santri'
        $santri = User::where('id', $id)->where('role', 'santri')->firstOrFail();

        // Get divisions and batches for the dropdown selects
        $divisions = Division::all();
        $batches   = Batch::all();

        return view('santris.edit', compact('santri', 'divisions', 'batches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the santri by ID and ensure it has the role 'santri'
        $santri = User::where('id', $id)->where('role', 'santri')->firstOrFail();

        // Proper validation with rules
        $validator = Validator::make($request->all(), [
            'nis'           => 'required|unique:users,nis,' . $santri->id,
            'name'          => 'required|string|max:255',
            'gender'        => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'address'       => 'required|string',
            'phone'         => 'required|string|max:15',
            'father_name'   => 'required|string|max:255',
            'father_phone'  => 'required|string|max:15',
            'mother_name'   => 'required|string|max:255',
            'mother_phone'  => 'required|string|max:15',
            'division_id'   => 'required|exists:divisions,id',
            'batch_id'      => 'required|exists:batches,id',
            'status'        => 'required|in:active,inactive',
            'photo'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('santris.edit', $santri->id)->withErrors($validator)->withInput();
        }

        // Handle photo upload if provided
        $data         = $request->all();
        $data['role'] = 'santri'; // Ensure role is set to santri

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($santri->photo && file_exists(public_path($santri->photo))) {
                unlink(public_path($santri->photo));
            }

            $photo    = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/santri'), $filename);
            $data['photo'] = 'uploads/santri/' . $filename;
        }

        $santri->update($data);

        return redirect()->route('santris.index')->with('success', 'Santri berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the santri by ID and ensure it has the role 'santri'
        $santri = User::where('id', $id)->where('role', 'santri')->firstOrFail();

        // Delete photo if exists
        if ($santri->photo && file_exists(public_path($santri->photo))) {
            unlink(public_path($santri->photo));
        }

        $santri->delete();

        return redirect()->route('santris.index')->with('success', 'Santri berhasil dihapus');
    }
}
