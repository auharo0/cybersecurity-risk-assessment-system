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
    <style>
        /* Inline Critical CSS for Better Performance */
        :root {
            --cras-primary: #2563eb;
            --cras-success: #10b981;
            --cras-warning: #f59e0b;
            --cras-danger: #ef4444;
        }
        body { 
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
            transition: all 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            transform: translateY(-2px);
        }
        .metric-icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.75rem;
            font-size: 1.75rem;
        }
        .metric-value {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1;
        }
        .metric-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
        }
        .page-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }
        .page-header h1 {
            font-weight: 800;
            font-size: 2rem;
        }
        .progress {
            border-radius: 0.5rem;
            height: 14px;
        }
        .progress-bar {
            transition: width 1.5s ease;
        }
        .risk-badge-critical {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            padding: 0.375rem 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }
        .risk-badge-high {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            padding: 0.375rem 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }
        .risk-badge-medium {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            padding: 0.375rem 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }
        .risk-badge-low {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 0.375rem 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }
        .table thead {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f1f5f9;
        }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #64748b;
        }
        .btn {
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
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

        <!-- 1. METRIC SUMMARY ROW -->
        <div class="row g-4 mb-4">
            <!-- Total Assets -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="metric-icon bg-primary bg-opacity-10 text-primary me-3">
                            <i class="fa-solid fa-laptop-code"></i>
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

            <!-- Ongoing Sessions -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="metric-icon bg-warning bg-opacity-10 text-warning me-3">
                            <i class="fa-solid fa-folder-open"></i>
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

            <!-- Total Risks Evaluated -->
            <div class="col-md-12 col-lg-4">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="metric-icon bg-danger bg-opacity-10 text-danger me-3">
                            <i class="fa-solid fa-shield-virus"></i>
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

        <!-- 2. ANALYTICS & REMEDIATION PROGRESS -->
        <div class="row g-4 mb-4">
            
            <!-- Risk Level Classification Distribution -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-chart-pie me-2 text-primary"></i>Risk Distribution (Severity Breakdown)</h5>
                    </div>
                    <div class="card-body">
                        @if($totalRisksAssessed > 0)
                            <!-- Progress charts modeling low/mid/high -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1 small fw-bold">
                                    <span class="text-danger">🔴 High Severity Risks (Score 7-9)</span>
                                    <span>{{ $highRisksCount }} / {{ $totalRisksAssessed }}</span>
                                </div>
                                <div class="progress" style="height: 12px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ ($highRisksCount / $totalRisksAssessed) * 100 }}%"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1 small fw-bold">
                                    <span class="text-warning text-dark">🟡 Medium Severity Risks (Score 4-6)</span>
                                    <span>{{ $mediumRisksCount }} / {{ $totalRisksAssessed }}</span>
                                </div>
                                <div class="progress" style="height: 12px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ ($mediumRisksCount / $totalRisksAssessed) * 100 }}%"></div>
                                </div>
                            </div>

                            <div class="mb-1">
                                <div class="d-flex justify-content-between mb-1 small fw-bold">
                                    <span class="text-success">🟢 Low Severity Risks (Score 1-3)</span>
                                    <span>{{ $lowRisksCount }} / {{ $totalRisksAssessed }}</span>
                                </div>
                                <div class="progress" style="height: 12px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($lowRisksCount / $totalRisksAssessed) * 100 }}%"></div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fa-solid fa-chart-simple fa-3x mb-3 text-secondary"></i>
                                <p class="mb-0">Assessments must be added to view severity distributions.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Remediation Progress -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-gauge-high me-2 text-primary"></i>Remediation Progress</h5>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="row align-items-center">
                            <div class="col-md-5 text-center mb-3 mb-md-0">
                                <!-- Circular progress tracker using pure HTML inline SVG -->
                                <div class="position-relative d-inline-block">
                                    <svg class="progress-ring" width="120" height="120">
                                        <circle class="progress-ring__circle" stroke="#e9ecef" stroke-width="12" fill="transparent" r="50" cx="60" cy="60"/>
                                        <circle class="progress-ring__circle" stroke="#198754" stroke-width="12" fill="transparent" r="50" cx="60" cy="60" 
                                            stroke-dasharray="314.159" 
                                            stroke-dashoffset="{{ 314.159 - (314.159 * $remediationRate) / 100 }}" />
                                    </svg>
                                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                                        <h3 class="fw-bold mb-0">{{ $remediationRate }}%</h3>
                                        <small class="text-muted small">Fixed</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h6 class="fw-bold mb-3">Remediation Statuses:</h6>
                                <div class="d-flex justify-content-between mb-1">
                                    <span><i class="fa-regular fa-circle-check text-success me-1"></i> Resolved / Fixed:</span>
                                    <strong>{{ $resolvedCount }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span><i class="fa-regular fa-circle-play text-info me-1"></i> Mitigation In Progress:</span>
                                    <strong>{{ $inProgressCount }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span><i class="fa-regular fa-circle-question text-danger me-1"></i> Open & Unresolved:</span>
                                    <strong>{{ $openRisksCount }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span><i class="fa-regular fa-eye text-secondary me-1"></i> Accepted (Risks Logged):</span>
                                    <strong>{{ $acceptedCount }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. CRITICAL ALERTS & RECENT RISKS -->
        <div class="row g-4">
            <!-- Critical High Risk Unresolved Vulnerabilities -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-danger text-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i>Critical Security Alarms</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Asset</th>
                                        <th>Threat</th>
                                        <th>Score</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($criticalRisks as $risk)
                                        <tr>
                                            <td><span class="fw-bold text-dark">{{ $risk->asset->asset_name ?? 'N/A' }}</span></td>
                                            <td><small>{{ Str::limit($risk->threat_description, 35) }}</small></td>
                                            <td><span class="badge bg-danger">Critical: {{ $risk->risk_score }}</span></td>
                                            <td>
                                                <a href="{{ route('risk_assessments.show', $risk->assessment_id) }}" class="btn btn-sm btn-outline-danger">Remediate</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                <i class="fa-solid fa-circle-check text-success fa-2x mb-2"></i>
                                                <p class="mb-0">Awesome! No active high severity threats logged.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Assessments Log -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-list-check me-2"></i>Recent Activity Feed</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Asset</th>
                                        <th>Risk level</th>
                                        <th>Status</th>
                                        <th>Recorded On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentAssessments as $recent)
                                        <tr>
                                            <td>
                                                <span class="fw-bold">{{ $recent->asset->asset_name ?? 'N/A' }}</span>
                                                <br><small class="text-muted">{{ $recent->session->session_name ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                @if($recent->risk_classification == 'Low')
                                                    <span class="badge bg-success">Low ({{ $recent->risk_score }})</span>
                                                @elseif($recent->risk_classification == 'Medium')
                                                    <span class="badge bg-warning text-dark">Medium ({{ $recent->risk_score }})</span>
                                                @else
                                                    <span class="badge bg-danger">High ({{ $recent->risk_score }})</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $recent->status }}</span>
                                            </td>
                                            <td><small class="text-muted">{{ \Carbon\Carbon::parse($recent->assessment_date)->diffForHumans() }}</small></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">No activities assessed yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
                if (isNaN(target)) return;
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