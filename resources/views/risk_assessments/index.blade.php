<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Risk Assessments - CRAS</title>
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            min-height: 100vh;
        }
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2.5rem 0;
            margin-bottom: 2.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ef4444, #f59e0b, #10b981);
        }
        .logo-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 1;
        }
        .logo-header img {
            width: 70px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }
        .btn-new-assessment {
            background: white;
            color: #667eea;
            border: 2px solid white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .btn-new-assessment:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .risk-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .risk-stat-card {
            background: white;
            padding: 1.75rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            text-align: center;
            border-top: 4px solid;
            position: relative;
            overflow: hidden;
        }
        .risk-stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: -50px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            opacity: 0.1;
        }
        .risk-stat-card.high {
            border-top-color: #ef4444;
        }
        .risk-stat-card.high::after {
            background: #ef4444;
        }
        .risk-stat-card.medium {
            border-top-color: #f59e0b;
        }
        .risk-stat-card.medium::after {
            background: #f59e0b;
        }
        .risk-stat-card.low {
            border-top-color: #10b981;
        }
        .risk-stat-card.low::after {
            background: #10b981;
        }
        .risk-stat-card.total {
            border-top-color: #667eea;
        }
        .risk-stat-card.total::after {
            background: #667eea;
        }
        .risk-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        .risk-label {
            color: #64748b;
            font-weight: 600;
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }
        .risk-item {
            background: white;
            border-radius: 16px;
            padding: 1.75rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-left: 6px solid;
            position: relative;
            overflow: hidden;
        }
        .risk-item.high {
            border-left-color: #ef4444;
            background: linear-gradient(135deg, white 0%, #fef2f2 100%);
        }
        .risk-item.medium {
            border-left-color: #f59e0b;
            background: linear-gradient(135deg, white 0%, #fffbeb 100%);
        }
        .risk-item.low {
            border-left-color: #10b981;
            background: linear-gradient(135deg, white 0%, #f0fdf4 100%);
        }
        .risk-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1.25rem;
        }
        .risk-title-section {
            flex: 1;
        }
        .risk-asset-name {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .risk-session-link {
            display: inline-block;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 0.375rem 0.875rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .risk-session-link:hover {
            background: rgba(102, 126, 234, 0.2);
            transform: translateX(4px);
            color: #667eea;
        }
        .risk-classification {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 800;
            font-size: 1.125rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        .risk-classification.high {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        .risk-classification.medium {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #78350f;
        }
        .risk-classification.low {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            color: #064e3b;
        }
        .risk-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1.25rem;
        }
        .risk-detail-box {
            background: rgba(255, 255, 255, 0.7);
            padding: 1rem;
            border-radius: 12px;
            border: 2px solid rgba(102, 126, 234, 0.1);
        }
        .risk-detail-label {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .risk-detail-label i {
            color: #667eea;
        }
        .risk-detail-value {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
        }
        .risk-threat {
            background: rgba(239, 68, 68, 0.05);
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.25rem;
            border-left: 4px solid #ef4444;
        }
        .risk-threat-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .risk-threat-label i {
            color: #ef4444;
        }
        .risk-threat-text {
            color: #1e293b;
            font-weight: 600;
            line-height: 1.6;
        }
        .risk-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        .btn-view-risk {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-view-risk:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-delete-risk {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-delete-risk:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-weight: 500;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .empty-state i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }
        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }
        .filter-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .filter-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: white;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .filter-btn.active.high {
            background: #ef4444;
            border-color: #ef4444;
            color: white;
        }
        .filter-btn.active.medium {
            background: #f59e0b;
            border-color: #f59e0b;
            color: white;
        }
        .filter-btn.active.low {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }
        .filter-btn.active.all {
            background: #667eea;
            border-color: #667eea;
            color: white;
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <!-- Page Header with Logo -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo-header">
                    <img src="{{ asset('logo/ChatGPT Image Jul 6, 2026, 03_34_47 PM.png') }}" alt="CRAS Logo">
                    <div>
                        <h1 class="mb-0 h2 fw-bold">
                            <i class="fas fa-shield-alt me-2"></i>All Risk Assessments
                        </h1>
                        <p class="mb-0 opacity-90">Comprehensive view of all identified cybersecurity risks</p>
                    </div>
                </div>
                @if(Auth::user() && Auth::user()->role === 'it_security_analyst')
                <a href="{{ route('risk_assessments.create') }}" class="btn btn-new-assessment">
                    <i class="fas fa-plus me-2"></i>New Assessment
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Risk Statistics -->
        <div class="risk-stats">
            <div class="risk-stat-card total">
                <div class="risk-number" style="color: #667eea;">{{ $assessments->count() }}</div>
                <div class="risk-label"><i class="fas fa-list-check me-1"></i>Total Assessments</div>
            </div>
            <div class="risk-stat-card high">
                <div class="risk-number" style="color: #ef4444;">{{ $assessments->where('risk_classification', 'High')->count() }}</div>
                <div class="risk-label"><i class="fas fa-exclamation-triangle me-1"></i>High Risk</div>
            </div>
            <div class="risk-stat-card medium">
                <div class="risk-number" style="color: #f59e0b;">{{ $assessments->where('risk_classification', 'Medium')->count() }}</div>
                <div class="risk-label"><i class="fas fa-exclamation-circle me-1"></i>Medium Risk</div>
            </div>
            <div class="risk-stat-card low">
                <div class="risk-number" style="color: #10b981;">{{ $assessments->where('risk_classification', 'Low')->count() }}</div>
                <div class="risk-label"><i class="fas fa-check-circle me-1"></i>Low Risk</div>
            </div>
        </div>

        <!-- Risk Assessments List -->
        @if($assessments->count() > 0)
            @foreach($assessments as $assessment)
                <div class="risk-item {{ strtolower($assessment->risk_classification) }}">
                    <div class="risk-header">
                        <div class="risk-title-section">
                            <div class="risk-asset-name">
                                <i class="fas fa-server" style="color: #667eea;"></i>
                                {{ $assessment->asset->asset_name ?? 'N/A' }}
                            </div>
                            <a href="{{ route('assessment_sessions.show', $assessment->session_id) }}" class="risk-session-link">
                                <i class="fas fa-folder-open me-1"></i>{{ $assessment->session->session_name ?? 'N/A' }}
                            </a>
                        </div>
                        <div>
                            @if($assessment->risk_classification == 'Low')
                                <span class="risk-classification low">
                                    <i class="fas fa-check-circle"></i>LOW RISK
                                </span>
                            @elseif($assessment->risk_classification == 'Medium')
                                <span class="risk-classification medium">
                                    <i class="fas fa-exclamation-circle"></i>MEDIUM RISK
                                </span>
                            @else
                                <span class="risk-classification high">
                                    <i class="fas fa-exclamation-triangle"></i>HIGH RISK
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Threat Description -->
                    <div class="risk-threat">
                        <div class="risk-threat-label">
                            <i class="fas fa-bug"></i>
                            <span>Identified Threat</span>
                        </div>
                        <div class="risk-threat-text">{{ $assessment->threat_description }}</div>
                    </div>

                    <!-- Risk Details -->
                    <div class="risk-details">
                        <div class="risk-detail-box">
                            <div class="risk-detail-label">
                                <i class="fas fa-chart-line"></i>Risk Score
                            </div>
                            <div class="risk-detail-value">{{ $assessment->risk_score }} / 100</div>
                        </div>
                        <div class="risk-detail-box">
                            <div class="risk-detail-label">
                                <i class="fas fa-hashtag"></i>Assessment ID
                            </div>
                            <div class="risk-detail-value">#{{ $assessment->assessment_id }}</div>
                        </div>
                        <div class="risk-detail-box">
                            <div class="risk-detail-label">
                                <i class="fas fa-calendar"></i>Assessed On
                            </div>
                            <div class="risk-detail-value">{{ $assessment->created_at ? $assessment->created_at->format('M d, Y') : 'N/A' }}</div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="risk-actions">
                        <a href="{{ route('risk_assessments.show', $assessment->assessment_id) }}" class="btn btn-view-risk">
                            <i class="fas fa-eye me-2"></i>View Full Report
                        </a>
                        @if(Auth::user()->role === 'it_security_analyst')
                        <form action="{{ route('risk_assessments.destroy', $assessment->assessment_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this assessment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete-risk">
                                <i class="fas fa-trash-alt me-2"></i>Delete
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-shield-alt"></i>
                <h5>No risk assessments found</h5>
                <p class="text-muted">Start by creating your first risk assessment</p>
                @if(Auth::user() && Auth::user()->role === 'it_security_analyst')
                <a href="{{ route('risk_assessments.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus me-2"></i>Create First Assessment
                </a>
                @endif
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Auto-hide alerts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 4000);
            });
        });
    </script>
</body>
</html>
