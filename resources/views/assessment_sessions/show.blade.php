<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Details - CRAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    @include('partials.navbar')

    <div class="container pb-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold text-dark mb-1">Session: {{ $assessmentSession->session_name }}</h2>
                <p class="text-muted mb-0">
                    <i class="fa-solid fa-calendar-days me-1"></i> Timeline: 
                    {{ \Carbon\Carbon::parse($assessmentSession->start_date)->format('M d, Y') }} to 
                    {{ $assessmentSession->end_date ? \Carbon\Carbon::parse($assessmentSession->end_date)->format('M d, Y') : 'Ongoing' }}
                </p>
            </div>
            <div>
                <a href="{{ route('assessment_sessions.index') }}" class="btn btn-secondary me-2">Back to Sessions</a>
                
                @if(Auth::check() && Auth::user()->role === 'it_security_analyst')
                    <a href="{{ route('assessment_sessions.edit', $assessmentSession->session_id) }}" class="btn btn-outline-warning me-2 fw-bold text-dark">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Session
                    </a>
                    <a href="{{ route('risk_assessments.create', ['session_id' => $assessmentSession->session_id]) }}" class="btn btn-danger fw-bold">
                        <i class="fa-solid fa-plus me-1"></i> Add Risk Assessment
                    </a>
                @endif

                @if(Auth::check() && Auth::user()->role === 'organization_manager')
                <a href="{{ route('assessment_sessions.pdf', $assessmentSession->session_id) }}" class="btn btn-outline-dark me-2">
                    <i class="fa-solid fa-file-pdf me-1"></i> Export PDF Report
                </a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @php
            $risks = $assessmentSession->riskAssessments;
            $totalRisks = $risks->count();
            
            // Severity Breakdown
            $highRisks = $risks->where('risk_classification', 'High')->count();
            $mediumRisks = $risks->where('risk_classification', 'Medium')->count();
            $lowRisks = $risks->where('risk_classification', 'Low')->count();
            
            // Remediation Statuses
            $resolvedCount = $risks->where('status', 'Resolved')->count();
            $inProgressCount = $risks->where('status', 'In Progress')->count();
            $openCount = $risks->where('status', 'Open')->count();
            $acceptedCount = $risks->where('status', 'Accepted')->count();
            
            // Averages & Rates
            $avgScore = $totalRisks > 0 ? round($risks->avg('risk_score'), 1) : 0;
            $remediationRate = $totalRisks > 0 ? round((($resolvedCount + $acceptedCount) / $totalRisks) * 100) : 0;
        @endphp

        <div class="row g-4 mb-4">
            
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h6 class="text-muted fw-bold mb-3 text-uppercase small tracking-wide">
                                <i class="fa-solid fa-chart-bar me-1 text-primary"></i> Session Metrics
                            </h6>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom border-light">
                                <span class="text-secondary">Total Risks Logged:</span>
                                <span class="badge bg-dark fs-6 rounded-pill">{{ $totalRisks }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom border-light">
                                <span class="text-secondary">Average Risk Score:</span>
                                <span class="badge bg-secondary fs-6 rounded-pill">{{ $avgScore }} / 9</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Audit Status:</span>
                                @if($assessmentSession->status == 'Ongoing')
                                    <span class="badge bg-warning text-dark px-3 rounded-pill">Ongoing</span>
                                @elseif($assessmentSession->status == 'Completed')
                                    <span class="badge bg-success px-3 rounded-pill">Completed</span>
                                @else
                                    <span class="badge bg-secondary px-3 rounded-pill">{{ $assessmentSession->status }}</span>
                                @endif
                            </div>
                        </div>

                        @if($assessmentSession->status == 'Ongoing' && Auth::check() && Auth::user()->role === 'it_security_analyst')
                            <div class="mt-3 pt-2 border-top border-light">
                                <form action="{{ route('assessment_sessions.update', $assessmentSession->session_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to mark this assessment session as Completed?');">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="session_name" value="{{ $assessmentSession->session_name }}">
                                    <input type="hidden" name="start_date" value="{{ \Carbon\Carbon::parse($assessmentSession->start_date)->format('Y-m-d') }}">
                                    <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}">
                                    <input type="hidden" name="status" value="Completed">
                                    <button type="submit" class="btn btn-sm btn-success w-100 fw-bold py-2">
                                        <i class="fa-solid fa-square-check me-1"></i> Close & Mark Completed
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h6 class="text-muted fw-bold mb-3 text-uppercase small tracking-wide">
                            <i class="fa-solid fa-triangle-exclamation me-1 text-danger"></i> Severity Breakdown
                        </h6>
                        @if($totalRisks > 0)
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1 small fw-bold">
                                    <span class="text-danger">🔴 High (7-9):</span>
                                    <span>{{ $highRisks }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ ($highRisks / $totalRisks) * 100 }}%"></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1 small fw-bold">
                                    <span class="text-warning text-dark">🟡 Medium (4-6):</span>
                                    <span>{{ $mediumRisks }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ ($mediumRisks / $totalRisks) * 100 }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between mb-1 small fw-bold">
                                    <span class="text-success">🟢 Low (1-3):</span>
                                    <span>{{ $lowRisks }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($lowRisks / $totalRisks) * 100 }}%"></div>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-muted py-3">
                                <i class="fa-solid fa-shield-halved fa-2x mb-2 text-black-50"></i>
                                <p class="mb-0 small">No risk severities to display.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h6 class="text-muted fw-bold mb-3 text-uppercase small tracking-wide">
                            <i class="fa-solid fa-gauge-high me-1 text-success"></i> Remediation Progress
                        </h6>
                        @if($totalRisks > 0)
                            <div class="d-flex align-items-center">
                                <div class="me-3 position-relative d-inline-block">
                                    <svg width="75" height="75" style="transform: rotate(-90deg);">
                                        <circle stroke="#e9ecef" stroke-width="7" fill="transparent" r="28" cx="37.5" cy="37.5"/>
                                        <circle stroke="#198754" stroke-width="7" fill="transparent" r="28" cx="37.5" cy="37.5" 
                                            stroke-dasharray="175.929" 
                                            stroke-dashoffset="{{ 175.929 - (175.929 * $remediationRate) / 100 }}" 
                                            stroke-linecap="round"/>
                                    </svg>
                                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                                        <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $remediationRate }}%</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 small shadow-none">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="fa-regular fa-circle-check text-success me-1"></i> Fixed:</span>
                                        <strong>{{ $resolvedCount }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="fa-regular fa-circle-play text-info me-1"></i> Active:</span>
                                        <strong>{{ $inProgressCount }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span><i class="fa-regular fa-circle-question text-danger me-1"></i> Open:</span>
                                        <strong>{{ $openCount }}</strong>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-muted py-3">
                                <i class="fa-solid fa-square-poll-vertical fa-2x mb-2 text-black-50"></i>
                                <p class="mb-0 small">No progress metrics available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-3 fw-bold text-dark">Identified Risks for this Session</h4>
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 20%;">Asset</th>
                                <th style="width: 35%;">Threat</th>
                                <th style="width: 15%;">Score (LxI)</th>
                                <th style="width: 15%;">Classification</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 10%; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assessmentSession->riskAssessments as $risk)
                                <tr>
                                    <td class="fw-bold text-dark">{{ $risk->asset->asset_name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 320px;" title="{{ $risk->threat_description }}">
                                            {{ $risk->threat_description }}
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $risk->risk_score }}</strong> 
                                        <small class="text-muted">({{ $risk->likelihood }}&times;{{ $risk->impact }})</small>
                                    </td>
                                    <td>
                                        @if($risk->risk_classification == 'Low')
                                            <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1 w-100 text-center">LOW</span>
                                        @elseif($risk->risk_classification == 'Medium')
                                            <span class="badge bg-warning bg-opacity-10 text-warning-emphasis fw-bold px-2 py-1 w-100 text-center">MEDIUM</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger fw-bold px-2 py-1 w-100 text-center">HIGH</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($risk->status == 'Resolved')
                                            <span class="badge bg-success rounded-pill px-3">Resolved</span>
                                        @elseif($risk->status == 'In Progress')
                                            <span class="badge bg-info text-dark rounded-pill px-3">In Progress</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3">{{ $risk->status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('risk_assessments.show', $risk->assessment_id) }}" class="btn btn-sm btn-outline-primary py-1 px-2">
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-clipboard-check fa-2x mb-2 text-secondary"></i>
                                        <p class="mb-0">No risks have been assessed for this session yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>