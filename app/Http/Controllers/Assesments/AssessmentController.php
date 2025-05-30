<?php
// app/Http/Controllers/AssessmentController.php

namespace App\Http\Controllers\Assesments;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssessmentRequest;
use App\Models\AssessmentComponent;
use App\Models\Batch;
use App\Models\{Assessment, User, AssessmentTemplate, AssessmentPeriod, Division};
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::with(['santri', 'assessor', 'template', 'period'])->get();
        return view('pages.assessments.assessments.index', compact('assessments'));
    }

    public function create(Request $request)
    {
        $divisions = Division::orderBy('name')->get();
        $batches = Batch::orderBy('name')->get();
        $templates = AssessmentTemplate::with('components')->get();
        $periods = AssessmentPeriod::where('is_active', true)->get();
        $assessors = User::where('role', 'mentor')->get();

        $santris = collect();
        $selectedTemplate = null;
        $existingAssessments = collect();

        if ($request->filled('division_id') && $request->filled('batch_id')) {
            $query = User::where('role', 'santri')
                ->with(['division', 'batch']);

            if ($request->filled('division_id')) {
                $query->where('division_id', $request->division_id);
            }

            if ($request->filled('batch_id')) {
                $query->where('batch_id', $request->batch_id);
            }

            $santris = $query->orderBy('name')->get();

            // Cek penilaian yang sudah ada
            if ($request->filled('period_id') && $request->filled('assessment_template_id')) {
                $existingAssessments = Assessment::where('period_id', $request->period_id)
                    ->where('assessment_template_id', $request->assessment_template_id)
                    ->whereIn('santri_id', $santris->pluck('id'))
                    ->get()
                    ->keyBy('santri_id');

                $selectedTemplate = AssessmentTemplate::with('components')
                    ->find($request->assessment_template_id);
            }
        }

        return view('pages.assessments.assessments.create', compact(
            'divisions',
            'batches',
            'templates',
            'periods',
            'assessors',
            'santris',
            'selectedTemplate',
            'existingAssessments'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:users,id',
            'assessor_id' => 'required|exists:users,id',
            'assessment_template_id' => 'required|exists:assessment_templates,id',
            'period_id' => 'required|exists:assessment_periods,id',
            'date' => 'required|date',
            'note' => 'nullable|string',
            'status' => 'required|in:draft,submitted,approved',
            'scores' => 'required|array',
            'scores.*.assessment_component_id' => 'required|exists:assessment_components,id',
            'scores.*.score' => 'required|numeric|min:0',
            'scores.*.notes' => 'nullable|string|max:500'
        ]);

        // Cek duplikasi penilaian
        $existingAssessment = Assessment::where([
            'santri_id' => $validated['santri_id'],
            'period_id' => $validated['period_id'],
            'assessment_template_id' => $validated['assessment_template_id']
        ])->exists();

        if ($existingAssessment) {
            return back()->withErrors([
                'santri_id' => 'Santri ini sudah dinilai untuk periode dan template ini'
            ])->withInput();
        }

        // Validasi skor maksimal
        foreach ($request->scores as $score) {
            $component = AssessmentComponent::find($score['assessment_component_id']);
            if (!$component) {
                return back()->withErrors([
                    'scores' => 'Komponen penilaian tidak valid'
                ])->withInput();
            }

            if ($score['score'] > $component->max_score) {
                return back()->withErrors([
                    'scores' => "Skor untuk {$component->name} melebihi batas maksimal ({$component->max_score})"
                ])->withInput();
            }
        }

        $assessment = Assessment::create($validated);

        foreach ($request->scores as $score) {
            $assessment->details()->create([
                'assessment_component_id' => $score['assessment_component_id'],
                'score' => $score['score'],
                'notes' => $score['notes'] ?? null // Simpan catatan per komponen
            ]);
        }

        return redirect()->route('assessments.index')->with('success', 'Penilaian berhasil disimpan');
    }

    public function show(Assessment $assessment)
    {
        return view('assessments.assessments.show', compact('assessment'));
    }

    public function edit(Assessment $assessment)
    {
        $santris = User::where('role', 'santri')->get();
        $assessors = User::where('role', 'mentor')->get();
        $templates = AssessmentTemplate::all();
        $periods = AssessmentPeriod::all();

        return view('pages.assessments.assessments.edit', compact('assessment', 'santris', 'assessors', 'templates', 'periods'));
    }

    public function update(Request $request, Assessment $assessment)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:users,id',
            'assessor_id' => 'required|exists:users,id',
            'assessment_template_id' => 'required|exists:assessment_templates,id',
            'period_id' => 'required|exists:assessment_periods,id',
            'date' => 'required|date',
            'note' => 'nullable|string',
            'status' => 'required|in:draft,submitted,approved',
            'scores' => 'required|array',
            'scores.*.assessment_component_id' => 'required|exists:assessment_components,id',
            'scores.*.score' => 'required|numeric|min:0'
        ]);

        $assessment->update($validated);
        $assessment->details()->delete();

        foreach ($request->scores as $score) {
            $assessment->details()->create([
                'assessment_component_id' => $score['assessment_component_id'],
                'score' => $score['score']
            ]);
        }

        return redirect()->route('assessments.index')->with('success', 'Penilaian berhasil diupdate');
    }

    public function destroy(Assessment $assessment)
    {
        $assessment->delete();
        return redirect()->route('assessments.index')->with('success', 'Penilaian berhasil dihapus');
    }
}
