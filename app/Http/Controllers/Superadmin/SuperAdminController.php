<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\User;
use App\Models\Batch;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
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


    public function update(Request $request, $id)
    {
        // Find the santri by ID and ensure it has the role 'santri'
        $santri = User::findOrFail($id);

        // Proper validation with rules
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'gender'        => 'required|in:male,female',
            'role'          => 'required|in:superadmin,admin,mentor,santri',
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
