<?php

namespace App\Http\Controllers;

use App\Models\AssessmentSession;
use App\Models\Asset;
use App\Models\AssetThreatLibrary;
use App\Models\AuditLog;
use App\Models\RiskAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiskAssessmentController extends Controller
{
    public function index()
    {
        $assessments = RiskAssessment::with(['asset', 'session', 'assessor'])->orderBy('assessment_date', 'desc')->get();

        return view('risk_assessments.index', compact('assessments'));
    }

    public function create(Request $request)
    {
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. Only IT Security Analysts access this.');
        }
        $sessions = AssessmentSession::where('status', 'Ongoing')->get();

        // If session_id is provided, load assets for that session
        // Otherwise, load all assets
        $preselectedSession = $request->query('session_id');
        if ($preselectedSession) {
            $assets = Asset::where('session_id', $preselectedSession)->orderBy('asset_name')->get();
        } else {
            // Load all assets grouped by session for the dropdown
            $assets = Asset::orderBy('asset_name')->get();
        }

        return view('risk_assessments.create', compact('sessions', 'assets', 'preselectedSession'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. Only IT Security Analysts access this.');
        }

        // Debug: Log the incoming request
        \Log::info('Risk Assessment Store Request:', $request->all());

        $validated = $request->validate([
            'session_id' => 'required|exists:assessment_sessions,session_id',
            'threat_description' => 'required|string|max:255',
            'vulnerability_description' => 'required|string|max:255',
            'likelihood' => 'required|integer|between:1,3',
            'impact' => 'required|integer|between:1,3',
            'mitigation_plan' => 'nullable|string',
        ]);

        if ($request->has('create_new_asset')) {
            $assetData = $request->validate([
                'new_asset_name' => 'required|string|max:100',
                'new_asset_type' => 'required|in:Hardware,Software,Database,Cloud Service',
            ]);
            $newAsset = Asset::create([
                'session_id' => $validated['session_id'],
                'asset_name' => $assetData['new_asset_name'],
                'asset_type' => $assetData['new_asset_type'],
                'managed_by' => Auth::id() ?? 1,
            ]);
            $assetId = $newAsset->asset_id;
            \Log::info('Created new asset:', ['asset_id' => $assetId]);
        } else {
            $request->validate(['asset_id' => 'required|exists:assets,asset_id']);
            $assetId = $request->asset_id;
            \Log::info('Using existing asset:', ['asset_id' => $assetId]);
        }

        $score = $validated['likelihood'] * $validated['impact'];

        if ($score <= 3) {
            $classification = 'Low';
        } elseif ($score <= 6) {
            $classification = 'Medium';
        } else {
            $classification = 'High';
        }

        try {
            $assessment = RiskAssessment::create([
                'session_id' => $validated['session_id'],
                'asset_id' => $assetId,
                'assessed_by' => Auth::id() ?? 1,
                'threat_description' => $validated['threat_description'],
                'vulnerability_description' => $validated['vulnerability_description'],
                'likelihood' => $validated['likelihood'],
                'impact' => $validated['impact'],
                'risk_score' => $score,
                'risk_classification' => $classification,
                'status' => 'Open',
                'mitigation_plan' => $validated['mitigation_plan'],
            ]);

            \Log::info('Risk Assessment Created:', ['assessment_id' => $assessment->assessment_id]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'Created Risk Assessment for Asset id: '.$assessment->asset_id,
                'ip_address' => request()->ip(),
            ]);

            // Redirect back to the specific Assessment Session page!
            return redirect()->route('assessment_sessions.show', $validated['session_id'])
                ->with('success', 'Risk Assessment recorded successfully!');

        } catch (\Exception $e) {
            \Log::error('Failed to create Risk Assessment:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Failed to create risk assessment: '.$e->getMessage(),
            ]);
        }
    }

    public function show(RiskAssessment $riskAssessment)
    {

        // Load the related models so we can display their details easily
        $riskAssessment->load(['asset', 'session', 'assessor']);

        return view('risk_assessments.show', compact('riskAssessment'));
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action.');
        }

        $riskAssessment = RiskAssessment::with('asset')->findOrFail($id);

        // Get only assets in the same session
        $assets = Asset::where('session_id', $riskAssessment->session_id)
            ->orderBy('asset_name')
            ->get();

        return view('risk_assessments.edit', compact('riskAssessment', 'assets'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action.');
        }

        $riskAssessment = RiskAssessment::findOrFail($id);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,asset_id',
            'threat_description' => 'required|string|max:1000',
            'vulnerability_description' => 'required|string|max:1000',
            'mitigation_plan' => 'nullable|string|max:2000',
            'likelihood' => 'required|integer|min:1|max:3',
            'impact' => 'required|integer|min:1|max:3',
            'status' => 'required|in:Open,In Progress,Resolved,Accepted',
        ]);

        // Dynamic scoring recalculation logic
        $score = $validated['likelihood'] * $validated['impact'];
        $validated['risk_score'] = $score;

        if ($score >= 7) {
            $validated['risk_classification'] = 'High';
        } elseif ($score >= 4) {
            $validated['risk_classification'] = 'Medium';
        } else {
            $validated['risk_classification'] = 'Low';
        }

        $riskAssessment->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Updated Risk Assessment for Asset id: '.$riskAssessment->asset_id,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('assessment_sessions.show', $riskAssessment->session_id)
            ->with('success', 'Risk item parameters adjusted and metrics updated successfully.');
    }

    public function destroy(RiskAssessment $riskAssessment)
    {

        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. Only IT Security Analysts access this.');
        }
        $sessionId = $riskAssessment->session_id;
        $riskAssessment->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Deleted Risk Assessment for Asset id: '.$riskAssessment->asset_id,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('assessment_sessions.show', $sessionId)
            ->with('success', 'Risk Assessment deleted.');
    }

    /**
     * Get assets for a specific session (AJAX endpoint)
     */
    public function getAssetsBySession($sessionId)
    {
        $assets = Asset::where('session_id', $sessionId)
            ->orderBy('asset_name')
            ->get(['asset_id', 'asset_name', 'asset_type']);

        return response()->json($assets);
    }

    /**
     * Get threats for selected asset (AJAX endpoint)
     */
    public function getAssetThreats($assetId)
    {
        $threats = AssetThreatLibrary::where('asset_id', $assetId)
            ->orderBy('severity_level', 'desc')
            ->get();

        return response()->json($threats);
    }
}
