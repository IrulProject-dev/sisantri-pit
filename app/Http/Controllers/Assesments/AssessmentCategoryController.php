<?php
// app/Http/Controllers/AssessmentCategoryController.php

namespace App\Http\Controllers\Assesments;

use App\Models\AssessmentCategory;
use App\Http\Requests\StoreAssessmentCategoryRequest;
use App\Http\Requests\UpdateAssessmentCategoryRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentCategoryController extends Controller
{
    public function index()
    {
        $categories = AssessmentCategory::all();
        return view('pages.assessments.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.assessments.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        AssessmentCategory::create($validated);
        return redirect()->route('assessment-categories.index')->with('success', 'Kategori berhasil dibuat');
    }

    public function show(AssessmentCategory $assessmentCategory)
    {
        return view('pages.assessments.categories.show', compact('assessmentCategory'));
    }

    public function edit(AssessmentCategory $assessmentCategory)
    {
        return view('pages.assessments.categories.edit', compact('assessmentCategory'));
    }

    public function update(Request $request, AssessmentCategory $assessmentCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $assessmentCategory->update($validated);
        return redirect()->route('assessment-categories.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(AssessmentCategory $assessmentCategory)
    {
        $assessmentCategory->delete();
        return redirect()->route('assessment-categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}
