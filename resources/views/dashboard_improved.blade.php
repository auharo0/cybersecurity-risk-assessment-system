<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Dashboard - CRAS</title>
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-light">

    <!-- Include the Navbar Partial -->
    @include('partials.navbar')

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-shield-halved me-3"></i>Security Dashboard</h1>
                    <p class="mb-0">Real-time Cybersecurity Risk Monitoring & Analytics</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <span class="badge bg-success fs-6 px-3 py-2">
                        <i class="fas fa-check-circle me-2"></i>System Secure
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        
        <!-- Key Metrics Row -->
        <div class="row g-4 mb-4">
            <!-- Total Assets -->
            <div class="col-md-6 col-lg-4">
                <div class="card hover-lift h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="metric-icon bg-primary bg-opacity-10 text-primary me-3">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="metric-label mb-1">Registered Assets</p>
                            <h2 class="metric-value text-primary">{{ $totalAssets }}</h2>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-2">
                        <a href="{{ route('assets.index') }}" class="text-decoration-none text-primary fw-semibold small">
                            View Inventory <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Active Sessions -->
            <div class="col-md-6 col-lg-4">
                <div class="card hover-lift h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="metric-icon bg-warning bg-opacity-10 text-warning me-3">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="metric-label mb-1">Active Audit Sessions</p>
                            <h2 class="metric-value text-warning">{{ $activeSessions }}</h2>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-2">
                        <a href="{{ route('assessment_sessions.index') }}" class="text-decoration-none text-warning fw-semibold small">
                            View Sessions <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Vulnerabilities -->
            <div class="col-md-12 col-lg-4">
                <div class="card hover-lift h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="metric-icon bg-danger bg-opacity-10 text-danger me-3">
                            <i class="fas fa-shield-virus"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="metric-label mb-1">Identified Vulnerabilities</p>
                            <h2 class="metric-value text-danger">{{ $totalRisksAssessed }}</h2>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-2">
                        <a href="{{ route('risk_assessments.index') }}" class="text-decoration-none text-danger fw-semibold small">
                            View All Risks <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Row -->
        <div class="row g-4 mb-4">
            
            <!-- Risk Distribution -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-chart-pie me-2 text-primary"></i>Risk Distribution by Severity
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($totalRisksAssessed > 0)
                            <!-- High Severity -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="badge risk-badge-high me-2">HIGH</span>
                                        <span class="small fw-semibold text-muted">Score 7-9</span>
                                    </div>
                                    <span class="fw-bold">{{ $highRisksCount }} of {{ $totalRisksAssessed }}</span>
                                </div>
                                <div class="progress" style="height: 14px;">
                                    <div class="progress-bar progress-bar-animated bg-danger" 
                                         role="progressbar" 
                                         style="width: {{ $totalRisksAssessed > 0 ? ($highRisksCount / $totalRisksAssessed) * 100 : 0 }}%"
                                         aria-valuenow="{{ $highRisksCount }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="{{ $totalRisksAssessed }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Medium Severity -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="badge risk-badge-medium me-2">MEDIUM</span>
                                        <span class="small fw-semibold text-muted">Score 4-6</span>
                                    </div>
                                    <span class="fw-bold">{{ $mediumRisksCount }} of {{ $totalRisksAssessed }}</span>
                                </div>
                                <div class="progress" style="height: 14px;">
                                    <div class="progress-bar progress-bar-animated bg-warning" 
                                         role="progressbar" 
                                         style="width: {{ $totalRisksAssessed > 0 ? ($mediumRisksCount / $totalRisksAssessed) * 100 : 0 }}%"
                                         aria-valuenow="{{ $mediumRisksCount }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="{{ $totalRisksAssessed }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Low Severity -->
                            <div class="mb-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="badge risk-badge-low me-2">LOW</span>
                                        <span class="small fw-semibold text-muted">Score 1-3</span>
                                    </div>
                                    <span class="fw-bold">{{ $lowRisksCount }} of {{ $totalRisksAssessed }}</span>
                                </div>
                                <div class="progress" style="height: 14px;">
                                    <div class="progress-bar progress-bar-animated bg-success" 
                                         role="progressbar" 
                                         style="width: {{ $totalRisksAssessed > 0 ? ($lowRisksCount / $totalRisksAssessed) * 100 : 0 }}%"
                                         aria-valuenow="{{ $lowRisksCount }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="{{ $totalRisksAssessed }}">
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-chart-simple"></i>
                                </div>
                                <p class="mb-0">No risk assessments available yet.<br>Start by creating an assessment session.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Remediation Progress -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-gauge-high me-2 text-primary"></i>Remediation Progress
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="row align-items-center">
                            <div class="col-md-5 text-center mb-4 mb-md-0">
                                <!-- Circular Progress -->
                                <div class="position-relative d-inline-block">
                                    <svg class="progress-ring" width="140" height="140">
                                        <circle class="progress-ring__circle" stroke="#e2e8f0" stroke-width="14" fill="transparent" r="56" cx="70" cy="70"/>
                                        <circle class="progress-ring__circle" stroke="#10b981" stroke-width="14" fill="transparent" r="56" cx="70" cy="70" 
                                            stroke-dasharray="351.858" 
                                            stroke-dashoffset="{{ 351.858 - (351.858 * $remediationRate) / 100 }}"
                                            stroke-linecap="round"
                                            style="transition: stroke-dashoffset 1.5s ease;" />
                                    </svg>
                                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                                        <h2 class="fw-bold mb-0 text-success">{{ $remediationRate }}%</h2>
                                        <small class="text-muted fw-semibold">Complete</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h6 class="fw-bold mb-3 text-uppercase small text-muted">Status Breakdown</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded" style="background-color: #f0fdf4;">
                                    <span class="small"><i class="fas fa-circle-check text-success me-2"></i><strong>Resolved</strong></span>
                                    <span class="badge bg-success">{{ $resolvedCount }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded" style="background-color: #e0f2fe;">
                                    <span class="small"><i class="fas fa-circle-play text-info me-2"></i><strong>In Progress</strong></span>
                                    <span class="badge bg-info">{{ $inProgressCount }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded" style="background-color: #fee2e2;">
                                    <span class="small"><i class="fas fa-circle-exclamation text-danger me-2"></i><strong>Open</strong></span>
                                    <span class="badge bg-danger">{{ $openRisksCount }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background-color: #f3f4f6;">
                                    <span class="small"><i class="fas fa-circle-info text-secondary me-2"></i><strong>Accepted</strong></span>
                                    <span class="badge bg-secondary">{{ $acceptedCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Critical Alerts & Recent Activity -->
        <div class="row g-4">
            <!-- Critical Alerts -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-danger text-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-triangle-exclamation me-2"></i>Critical Security Alerts
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold small">Asset</th>
                                        <th class="fw-semibold small">Threat</th>
                                        <th class="fw-semibold small">Score</th>
                                        <th class="fw-semibold small">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($criticalRisks as $risk)
                                        <tr>
                                            <td><span class="fw-bold">{{ $risk->asset->asset_name ?? 'N/A' }}</span></td>
                                            <td><small class="text-muted">{{ Str::limit($risk->threat_description, 35) }}</small></td>
                                            <td><span class="badge risk-badge-critical">{{ $risk->risk_score }}</span></td>
                                            <td>
                                                <a href="{{ route('risk_assessments.show', $risk->assessment_id) }}" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-wrench me-1"></i>Fix
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-circle-check text-success" style="font-size: 3rem;"></i>
                                                    <p class="mb-0 mt-3 text-success fw-semibold">No critical threats detected!</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-clock-rotate-left me-2"></i>Recent Activity Feed
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold small">Asset</th>
                                        <th class="fw-semibold small">Risk Level</th>
                                        <th class="fw-semibold small">Status</th>
                                        <th class="fw-semibold small">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentAssessments as $recent)
                                        <tr>
                                            <td>
                                                <div>
                                                    <span class="fw-bold d-block">{{ $recent->asset->asset_name ?? 'N/A' }}</span>
                                                    <small class="text-muted">{{ Str::limit($recent->session->session_name ?? 'N/A', 25) }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($recent->risk_classification == 'Low')
                                                    <span class="badge risk-badge-low"><i class="fas fa-shield me-1"></i>{{ $recent->risk_score }}</span>
                                                @elseif($recent->risk_classification == 'Medium')
                                                    <span class="badge risk-badge-medium"><i class="fas fa-shield-alt me-1"></i>{{ $recent->risk_score }}</span>
                                                @else
                                                    <span class="badge risk-badge-high"><i class="fas fa-shield-virus me-1"></i>{{ $recent->risk_score }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $recent->status }}</span>
                                            </td>
                                            <td><small class="text-muted">{{ \Carbon\Carbon::parse($recent->assessment_date)->diffForHumans() }}</small></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-folder-open" style="font-size: 3rem;"></i>
                                                    <p class="mb-0 mt-3">No recent activity to display.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions (Optional) -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-4">
                        <h6 class="text-muted mb-3 fw-semibold">Quick Actions</h6>
                        <div class="d-flex flex-wrap justify-content-center gap-2">
                            <a href="{{ route('assessment_sessions.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>New Assessment Session
                            </a>
                            <a href="{{ route('assets.create') }}" class="btn btn-outline-primary">
                                <i class="fas fa-laptop-medical me-2"></i>Register Asset
                            </a>
                            <a href="{{ route('risk_assessments.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-list me-2"></i>View All Risks
                            </a>
                            @if(Auth::user() && Auth::user()->role === 'administrator')
                            <a href="{{ route('audit_logs.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-file-lines me-2"></i>Audit Logs
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Simple Animation Script -->
    <script>
        // Animate numbers on page load
        document.addEventListener('DOMContentLoaded', function() {
            const metrics = document.querySelectorAll('.metric-value');
            metrics.forEach(metric => {
                const target = parseInt(metric.textContent);
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        metric.textContent = target;
                        clearInterval(timer);
                    } else {
                        metric.textContent = Math.floor(current);
                    }
                }, 20);
            });
        });
    </script>
</body>
</html>
