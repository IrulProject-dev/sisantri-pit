<?php
namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = Batch::latest()->paginate(10);

        return view('pages.batches.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.batches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'string|required|max:255',
            'entry_date'      => 'required|date',
            'graduation_date' => 'nullable|date|after:entry_date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('batches.create')->withErrors($validator)->withInput();
        }

        Batch::create($request->all());

        return redirect()->route('batches.index')->with('success', 'Angkatan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Batch $batch)
    {
        return view('pages.batches.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        return view('pages.batches.edit', compact('batch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'string|required|max:255',
            'entry_date'      => 'required|date',
            'graduation_date' => 'nullable|date|after:entry_date',
        ]);

        if ($validator->fails()) {
            return redirect('batches.edit', $batch->id)->withErrors($validator)->withInput();
        }

        $batch->update($request->all());

        return redirect()->route('batches.index')->with('success', 'Angkatan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $batch = \App\Models\Batch::findOrFail($id);

        // Cek apakah ada user yang terkait dengan batch ini
        if ($batch->users()->count() > 0) {
            return redirect()->route('batches.index')
                ->with('error', 'Tidak dapat menghapus angkatan karena masih ada santri yang terkait.');
        }

        $batch->delete();

        return redirect()->route('batches.index')->with('success', 'Angkatan berhasil dihapus');
    }
}
