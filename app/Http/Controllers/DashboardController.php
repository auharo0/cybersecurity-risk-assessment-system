<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssessmentSession;
use App\Models\RiskAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {

        Log::info("hellworlld");
        // 1. Core Summary Metrics
        $totalAssets = Asset::count();
        $activeSessions = AssessmentSession::where('status', 'Ongoing')->count();
        $totalRisksAssessed = RiskAssessment::count();

        // 2. Risk Classification Distribution
        $lowRisksCount = RiskAssessment::where('risk_classification', 'Low')->count();
        $mediumRisksCount = RiskAssessment::where('risk_classification', 'Medium')->count();
        $highRisksCount = RiskAssessment::where('risk_classification', 'High')->count();

        // 3. Remediation Status Tracking
        $openRisksCount = RiskAssessment::where('status', 'Open')->count();
        $inProgressCount = RiskAssessment::where('status', 'In Progress')->count();
        $resolvedCount = RiskAssessment::where('status', 'Resolved')->count();
        $acceptedCount = RiskAssessment::where('status', 'Accepted')->count();

        // Calculate a remediation percentage
        $remediationRate = 0;
        if ($totalRisksAssessed > 0) {
            $remediationRate = round((($resolvedCount + $acceptedCount) / $totalRisksAssessed) * 100);
        }

        // 4. Critical Active Risks (High Risk level and still Open/In Progress)
        $criticalRisks = RiskAssessment::with(['asset', 'session'])
            ->where('risk_classification', 'High')
            ->whereIn('status', ['Open', 'In Progress'])
            ->orderBy('risk_score', 'desc')
            ->take(5)
            ->get();

        // 5. Recent Risk Entries (All levels)
        $recentAssessments = RiskAssessment::with(['asset', 'session'])
            ->orderBy('assessment_date', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalAssets',
            'activeSessions',
            'totalRisksAssessed',
            'lowRisksCount',
            'mediumRisksCount',
            'highRisksCount',
            'openRisksCount',
            'inProgressCount',
            'resolvedCount',
            'acceptedCount',
            'remediationRate',
            'criticalRisks',
            'recentAssessments'
        ));
    }
}
