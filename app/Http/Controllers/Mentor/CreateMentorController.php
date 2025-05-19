<?php

namespace App\Http\Controllers\Mentor;

use App\Models\User;
use App\Models\Batch;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CreateMentorController extends Controller
{
    public function create()
    {

        // Get divisions and batches for the dropdown selects
        $divisions = Division::all();
        $batches   = Batch::all();

        return view('pages.mentor.create', compact('divisions', 'batches'));
    }

    public function show($id)
    {
        // Find the santri by ID and ensure it has the role 'santri'
        $santri = User::findOrFail($id);
        return view('pages.mentor.show', compact('santri'));
    }

     public function edit($id)
    {
        // Find the santri by ID and ensure it has the role 'santri'
        $santri = User::findOrFail($id);

        // Get divisions and batches for the dropdown selects
        $divisions = Division::all();
        $batches   = Batch::all();

        return view('pages.mentor.edit', compact('santri', 'divisions', 'batches'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'         => 'required|unique:users,email',
            'name'          => 'required|string|max:255',
            'gender'        => 'required|in:male,female',
            'address'       => 'required|string',
            'phone'         => 'required|string|max:15',
            'division_id'   => 'required|exists:divisions,id',
            'batch_id'      => 'required|exists:batches,id',
            'status'        => 'required|in:active,inactive',
            'photo'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('pages.mentor.create')->withErrors($validator)->withInput();
        }

        // Handle photo upload if provided
        $data             = $request->all();
        $data['role']     = 'mentor';   // Ensure role is set to santri
        $data['password'] = Hash::make(\Carbon\Carbon::parse($request->date_of_birth)->format('dmY')); // Set default password.

        if ($request->hasFile('photo')) {
            $photo    = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/santri'), $filename);
            $data['photo'] = 'uploads/santri/' . $filename;
        }

        User::create($data);

        return redirect()->route('santris.index')->with('success', "Mentor berhasil ditambahkan");
    }

    public function update(Request $request, $id)
    {
        // Find the santri by ID and ensure it has the role 'santri'
        $santri = User::findOrFail($id);

        // Proper validation with rules
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'gender'        => 'required|in:male,female',
            'role' => 'required|in:superadmin,admin,mentor,santri',
            'address'       => 'required|string',
            'phone'         => 'required|string|max:15',
            'division_id'   => 'required|exists:divisions,id',
            'batch_id'      => 'required|exists:batches,id',
            'status'        => 'required|in:active,inactive',
            'photo'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        if ($validator->fails()) {
            return redirect()->route('mentors.edit', $santri->id)->withErrors($validator)->withInput();
        }

        // Handle photo upload if provided
        $data         = $request->all();


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

        return redirect()->route('santris.index')->with('success', 'Mentor berhasil diperbarui');
    }
}
