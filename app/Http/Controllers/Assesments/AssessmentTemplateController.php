<?php
// app/Http/Controllers/AssessmentTemplateController.php

namespace App\Http\Controllers\Assesments;

use App\Http\Requests\StoreAssessmentTemplateRequest;
use App\Models\Division;
use App\Models\{AssessmentTemplate, AssessmentComponent};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentTemplateController extends Controller
{
    public function index()
    {
        $templates = AssessmentTemplate::with('components', 'division')->get();
        return view('pages.assessments.templates.index', compact('templates'));
    }

    public function create()
    {
        $divisions = Division::all();
        $components = AssessmentComponent::all();
        return view('pages.assessments.templates.create', compact('divisions', 'components'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'division_id' => 'required|exists:divisions,id',
            'components' => 'required|array',
            'components.*.id' => 'exists:assessment_components,id',
            'components.*.weight' => 'nullable|numeric|min:0|max:100'
        ]);

        $filtered = array_filter($request->components, function ($c) {
            return !empty($c['id']) && isset($c['weight']) && $c['weight'] !== '';
        });

        if (empty($filtered)) {
            return back()
                ->withInput()
                ->withErrors(['components' => 'Pilih minimal satu komponen dan isi bobotnya!']);
        }

        $template = AssessmentTemplate::create($validated);

        foreach ($filtered as $component) {
            $template->components()->attach($component['id'], ['weight' => $component['weight']]);
        }

        return redirect()->route('assessment-templates.index')->with('success', 'Template berhasil dibuat');
    }

    public function show(AssessmentTemplate $assessmentTemplate)
    {
        return view('pages.assessments.templates.show', compact('assessmentTemplate'));
    }

    public function edit(AssessmentTemplate $assessmentTemplate)
    {
        $divisions = Division::all();
        $components = AssessmentComponent::all();
        return view('pages.assessments.templates.edit', compact('assessmentTemplate', 'divisions', 'components'));
    }

    public function update(Request $request, AssessmentTemplate $assessmentTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'division_id' => 'required|exists:divisions,id',
            'components' => 'required|array',
            'components.*.id' => 'exists:assessment_components,id',
            'components.*.weight' => 'numeric|min:0|max:100'
        ]);

        $filtered = array_filter($request->components, function ($c) {
            return !empty($c['id']) && isset($c['weight']) && $c['weight'] !== '';
        });

        if (empty($filtered)) {
            return back()
                ->withInput()
                ->withErrors(['components' => 'Pilih minimal satu komponen dan isi bobotnya!']);
        }

        $assessmentTemplate->update($validated);
        $assessmentTemplate->components()->sync([]);

        foreach ($filtered as $component) {
            $assessmentTemplate->components()->attach($component['id'], ['weight' => $component['weight']]);
        }

        return redirect()->route('assessment-templates.index')->with('success', 'Template berhasil diupdate');
    }

    public function destroy(AssessmentTemplate $assessmentTemplate)
    {
        $assessmentTemplate->delete();
        return redirect()->route('assessment-templates.index')->with('success', 'Template berhasil dihapus');
    }
}
