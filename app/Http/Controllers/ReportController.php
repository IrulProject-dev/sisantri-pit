<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        $assessments = Assessment::with(['santri', 'period'])
            ->where('status', 'approved')
            ->orderByDesc('date')
            ->paginate(10);

        return view('pages.assessments.rapots.index', compact('assessments'));
    }
    public function show($id)
    {
        $assessment = Assessment::with([
            'details.component',
            'santri',
            'assessor',
            'template.division',
            'period'
        ])->findOrFail($id);

        return view('pages.assessments.rapots.show', compact('assessment'));
    }

    public function downloadPdf($id)
    {
        $assessment = Assessment::with([
            'details.component',
            'santri',
            'assessor',
            'template.division',
            'period'
        ])->findOrFail($id);
        // dd($assessment->template);
        $pdf = PDF::loadView('pages.assessments.rapots.pdf-raport', compact('assessment'))
        ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        return $pdf->stream('rapor-' . $assessment->id . '.pdf');
    }
}


/*
                        <form action="{{ route('Report.sendEmail', $assessment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-800" title="Kirim ke Email">
                                <i class="fas fa-envelope"></i>
                            </button>
                        </form>
*/
