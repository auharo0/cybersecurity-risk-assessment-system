<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risk Assessment Details - CRAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Include the Navbar Partial -->
    @include('partials.navbar')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Risk Assessment Details</h2>
            <!-- Procedural Return Button to specific session -->
            <a href="{{ route('assessment_sessions.show', $riskAssessment->session_id) }}" class="btn btn-secondary">
                &larr; Back to Session
            </a>
        </div>

        <div class="row">
            <div class="col-md-8">
                <!-- Main Threat Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0 text-dark">Asset: {{ $riskAssessment->asset->asset_name ?? 'Unknown Asset' }}</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="fw-bold text-danger">Threat Description</h5>
                        <p class="fs-5">{{ $riskAssessment->threat_description }}</p>
                        
                        <h5 class="fw-bold text-warning">Vulnerability</h5>
                        <p class="fs-5">{{ $riskAssessment->vulnerability_description }}</p>

                        <hr class="my-4">

                        <h5 class="fw-bold">Mitigation Plan</h5>
                        <div class="p-3 bg-light border rounded">
                            {{ $riskAssessment->mitigation_plan ?? 'No mitigation plan provided yet.' }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <!-- Scoring & Status Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0">Risk Score & Classification</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="text-muted mb-1">Likelihood ({{ $riskAssessment->likelihood }}) × Impact ({{ $riskAssessment->impact }})</p>
                        <h1 class="display-3 fw-bold">{{ $riskAssessment->risk_score }}</h1>
                        
                        <h4 class="mt-2">
                            @if($riskAssessment->risk_classification == 'Low')
                                <span class="badge bg-success w-100 py-2">LOW RISK</span>
                            @elseif($riskAssessment->risk_classification == 'Medium')
                                <span class="badge bg-warning text-dark w-100 py-2">MEDIUM RISK</span>
                            @else
                                <span class="badge bg-danger w-100 py-2">HIGH RISK</span>
                            @endif
                        </h4>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Status:</strong>
                            <span class="badge bg-secondary">{{ $riskAssessment->status }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Assessed By:</strong>
                            <span>{{ $riskAssessment->assessor->username ?? 'Unknown' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Date:</strong>
                            <span>{{ \Carbon\Carbon::parse($riskAssessment->assessment_date)->format('M d, Y') }}</span>
                        </li>
                    </ul>
                </div>
                @if(Auth::user()->role === 'it_security_analyst')
                <form action="{{ route('risk_assessments.destroy', $riskAssessment->assessment_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this specific risk assessment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">Delete Assessment</button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>