<?php

namespace App\Http\Controllers\Assesments;

use App\Models\AssessmentCategory;
use App\Models\AssessmentComponent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentComponentController extends Controller
{
    public function index()
    {
        $components = AssessmentComponent::with('category')->get();
        return view('pages.assessments.components.index', compact('components'));
    }

    public function create()
    {
        $categories = AssessmentCategory::all();
        return view('pages.assessments.components.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:assessment_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score' => 'required|integer|min:1'
        ]);

        AssessmentComponent::create($validated);
        return redirect()->route('assessment-components.index')->with('success', 'Komponen berhasil dibuat');
    }

    public function show(AssessmentComponent $assessmentComponent)
    {
        return view('pages.assessments.components.show', compact('assessmentComponent'));
    }

    public function edit(AssessmentComponent $assessmentComponent)
    {
        $categories = AssessmentCategory::all();
        return view('pages.assessments.components.edit', compact('assessmentComponent', 'categories'));
    }

    public function update(Request $request, AssessmentComponent $assessmentComponent)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:assessment_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score' => 'required|integer|min:1'
        ]);

        $assessmentComponent->update($validated);
        return redirect()->route('assessment-components.index')->with('success', 'Komponen berhasil diupdate');
    }

    public function destroy(AssessmentComponent $assessmentComponent)
    {
        $assessmentComponent->delete();
        return redirect()->route('assessment-components.index')->with('success', 'Komponen berhasil dihapus');
    }
}
