<?php

namespace App\Http\Controllers\Assesments;

use App\Models\AssessmentTarget;
use App\Models\User;
use App\Models\AssessmentComponent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentTargetController extends Controller
{
     public function index()
    {
        $targets = AssessmentTarget::with(['santri', 'component'])->paginate(10);
        return view('pages.assessments.targets.index', compact('targets'));
    }

    public function create()
    {
        $santris = User::where('role', 'santri')->get();
        $components = AssessmentComponent::all();
        return view('pages.assessments.targets.create', compact('santris', 'components'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:users,id',
            'assessment_component_id' => 'required|exists:assessment_components,id',
            'target_score' => 'required|numeric|min:0',
            'target_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        AssessmentTarget::create($validated);
        return redirect()->route('assessment-targets.index')->with('success', 'Target berhasil dibuat');
    }

    public function edit(AssessmentTarget $assessmentTarget)
    {
        $santris = User::where('role', 'santri')->get();
        $components = AssessmentComponent::all();
        return view('pages.assessments.targets.edit', compact('assessmentTarget', 'santris', 'components'));
    }

    public function update(Request $request, AssessmentTarget $assessmentTarget)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:users,id',
            'assessment_component_id' => 'required|exists:assessment_components,id',
            'target_score' => 'required|numeric|min:0',
            'target_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $assessmentTarget->update($validated);
        return redirect()->route('assessment-targets.index')->with('success', 'Target berhasil diupdate');
    }

    public function destroy(AssessmentTarget $assessmentTarget)
    {
        $assessmentTarget->delete();
        return redirect()->route('assessment-targets.index')->with('success', 'Target berhasil dihapus');
    }
}
