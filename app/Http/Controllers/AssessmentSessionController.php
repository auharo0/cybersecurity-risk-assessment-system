<?php

namespace App\Http\Controllers;

use App\Models\AssessmentSession;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class AssessmentSessionController extends Controller
{
    public function index()
    {
        // Fetch all assessment sessions and the user who created them
        $sessions = AssessmentSession::with('creator')->orderBy('start_date', 'desc')->get();
        return view('assessment_sessions.index', compact('sessions'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. Only IT Security Analysts access this.');
        }
        return view('assessment_sessions.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. Only IT Security Analysts access this.');
        }
        $validated = $request->validate([
            'session_name' => 'required|string|max:150',
            'status' => 'required|in:Ongoing,Completed,Archived',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Automatically assign the logged-in user (fallback to 1 for testing without auth)
        $validated['created_by'] = Auth::id() ?? 1;

        AssessmentSession::create($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Created a new Assessment Session: ' . $request->session_name,
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('assessment_sessions.index')->with('success', 'Assessment Session created successfully.');
    }

    public function show(AssessmentSession $assessmentSession)
    {
        // Load the associated risk assessments and their assets to display on the details page
        $assessmentSession->load('riskAssessments.asset');
        return view('assessment_sessions.show', compact('assessmentSession'));
    }

    // Add this method inside app/Http/Controllers/AssessmentSessionController.php

    public function edit(AssessmentSession $assessmentSession)
    {
        // Authorization Guard
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. Only IT Security Analysts can modify sessions.');
        }

        return view('assessment_sessions.edit', compact('assessmentSession'));
    }

    public function update(Request $request, AssessmentSession $assessmentSession)
    {
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. Only IT Security Analysts access this.');
        }

        $validated = $request->validate([
            'session_name' => 'required|string|max:150',
            'status' => 'required|in:Ongoing,Completed,Archived',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $assessmentSession->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Updated Assessment Session: ' . $request->session_name,
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('assessment_sessions.index')->with('success', 'Assessment Session updated successfully.');
    }

    public function destroy(AssessmentSession $assessmentSession)
    {
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. Only IT Security Analysts access this.');
        }

        $assessmentSession->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Deleted Assessment Session: ' . $assessmentSession->session_name,
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('assessment_sessions.index')->with('success', 'Assessment Session deleted successfully.');
    }


    public function downloadPdf(AssessmentSession $assessmentSession)
    {
        // Explicitly load all assessments and linked hardware/software assets
        $assessmentSession->load('riskAssessments.asset', 'riskAssessments.assessor');

        // Share the session model data directly with the PDF blade template
        $pdf = Pdf::loadView('assessment_sessions.pdf', compact('assessmentSession'));

        // Format clean file names (e.g., "Session_Report_Audit_Q3_2026.pdf")
        $safeName = Str::slug($assessmentSession->session_name, '_');

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Downloaded PDF for Assessment Session: ' . $assessmentSession->session_name,
            'ip_address' => request()->ip()
        ]);

        return $pdf->download("Session_Report_{$safeName}.pdf");
    }
}
