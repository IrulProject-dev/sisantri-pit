<?php

namespace App\Http\Controllers\Assesments;

use App\Models\AssessmentPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentPeriodController extends Controller
{
    public function index()
    {
        $periods = AssessmentPeriod::latest()->get();
        return view('pages.assessments.periods.index', compact('periods'));
    }

    public function create()
    {
        return view('pages.assessments.periods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'sometimes|boolean'
        ]);

        AssessmentPeriod::create($validated);
        return redirect()->route('assessment-periods.index')->with('success', 'Periode berhasil dibuat');
    }

    public function show(AssessmentPeriod $assessmentPeriod)
    {
        return view('assessments.periods.show', compact('assessmentPeriod'));
    }

    public function edit(AssessmentPeriod $assessmentPeriod)
    {
        return view('pages.assessments.periods.edit', compact('assessmentPeriod'));
    }

    public function update(Request $request, AssessmentPeriod $assessmentPeriod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'sometimes|boolean'
        ]);

        $assessmentPeriod->update($validated);
        return redirect()->route('assessment-periods.index')->with('success', 'Periode berhasil diupdate');
    }

    public function destroy(AssessmentPeriod $assessmentPeriod)
    {
        $assessmentPeriod->delete();
        return redirect()->route('assessment-periods.index')->with('success', 'Periode berhasil dihapus');
    }
}
