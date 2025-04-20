<?php
namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = Division::latest()->paginate(10);

        return view('pages.divisions.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.divisions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'string|required|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('divisions.create')->withErrors($validator)->withInput();
        }

        Division::create($request->all());

        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Division $division)
    {
        return view('pages.divisions.index', compact('division'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        return view('pages.divisions.edit', compact('division'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'string|required|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect('divisions.index', $division->id)->withErrors($validator)->withInput();
        }

        $division->update($request->all());

        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        $division->delete();

        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil dihapus');
    }
}
