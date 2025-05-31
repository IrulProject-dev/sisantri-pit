<?php

namespace App\Http\Controllers\Assesments;

use App\Models\AssessmentDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentDetailController extends Controller
{
    public function update(Request $request, AssessmentDetail $assessmentDetail)
    {
        $validated = $request->validate([
            'score' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        $assessmentDetail->update($validated);
        return redirect()->back()->with('success', 'Detail penilaian berhasil diupdate');
    }

    public function destroy(AssessmentDetail $assessmentDetail)
    {
        $assessmentDetail->delete();
        return redirect()->back()->with('success', 'Detail penilaian berhasil dihapus');
    }
}
