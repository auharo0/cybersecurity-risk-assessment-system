<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Sessions - CRAS</title>
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
            background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
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
            top: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
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
        .btn-create {
            background: white;
            color: #667eea;
            border: 2px solid white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .btn-create:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .session-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            border-left: 6px solid;
            position: relative;
            overflow: hidden;
        }
        .session-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }
        .session-card.ongoing {
            border-left-color: #f59e0b;
            background: linear-gradient(135deg, white 0%, #fffbeb 100%);
        }
        .session-card.completed {
            border-left-color: #10b981;
            background: linear-gradient(135deg, white 0%, #f0fdf4 100%);
        }
        .session-card.archived {
            border-left-color: #64748b;
            background: linear-gradient(135deg, white 0%, #f8fafc 100%);
        }
        .session-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1.25rem;
            position: relative;
            z-index: 1;
        }
        .session-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .session-id {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 700;
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9375rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .status-badge.ongoing {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #78350f;
        }
        .status-badge.completed {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            color: #064e3b;
        }
        .status-badge.archived {
            background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
            color: white;
        }
        .session-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }
        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 12px;
        }
        .detail-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }
        .detail-content {
            flex: 1;
        }
        .detail-label {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .detail-value {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
        }
        .session-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }
        .btn-view {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .btn-delete-session {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-delete-session:hover {
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
        .summary-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .summary-card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            text-align: center;
        }
        .summary-number {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        .summary-label {
            color: #64748b;
            font-weight: 600;
            font-size: 0.9375rem;
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
                            <i class="fas fa-calendar-check me-2"></i>Assessment Sessions
                        </h1>
                        <p class="mb-0 opacity-90">Manage your cybersecurity assessment sessions</p>
                    </div>
                </div>
                @if(Auth::check() && Auth::user()->role === 'it_security_analyst')
                <a href="{{ route('assessment_sessions.create') }}" class="btn btn-create">
                    <i class="fas fa-plus me-2"></i>Create New Session
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

        <!-- Summary Stats -->
        <div class="summary-stats">
            <div class="summary-card" style="border-top: 4px solid #f59e0b;">
                <div class="summary-number" style="color: #f59e0b;">
                    {{ $sessions->where('status', 'Ongoing')->count() }}
                </div>
                <div class="summary-label">
                    <i class="fas fa-spinner me-1"></i>Ongoing Sessions
                </div>
            </div>
            <div class="summary-card" style="border-top: 4px solid #10b981;">
                <div class="summary-number" style="color: #10b981;">
                    {{ $sessions->where('status', 'Completed')->count() }}
                </div>
                <div class="summary-label">
                    <i class="fas fa-check-circle me-1"></i>Completed Sessions
                </div>
            </div>
            <div class="summary-card" style="border-top: 4px solid #64748b;">
                <div class="summary-number" style="color: #64748b;">
                    {{ $sessions->where('status', 'Archived')->count() }}
                </div>
                <div class="summary-label">
                    <i class="fas fa-archive me-1"></i>Archived Sessions
                </div>
            </div>
        </div>

        <!-- Session Cards -->
        @if($sessions->count() > 0)
            @foreach($sessions as $session)
                <div class="session-card {{ strtolower($session->status) }}">
                    <div class="session-header">
                        <div>
                            <div class="session-title">
                                <span class="session-id">#{{ $session->session_id }}</span>
                                {{ $session->session_name }}
                            </div>
                        </div>
                        <div>
                            @if($session->status == 'Ongoing')
                                <span class="status-badge ongoing">
                                    <i class="fas fa-spinner fa-pulse"></i>Ongoing
                                </span>
                            @elseif($session->status == 'Completed')
                                <span class="status-badge completed">
                                    <i class="fas fa-check-circle"></i>Completed
                                </span>
                            @else
                                <span class="status-badge archived">
                                    <i class="fas fa-archive"></i>Archived
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="session-details">
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Start Date</div>
                                <div class="detail-value">{{ $session->start_date ? $session->start_date->format('M d, Y') : 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">End Date</div>
                                <div class="detail-value">{{ $session->end_date ? $session->end_date->format('M d, Y') : 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Created By</div>
                                <div class="detail-value">{{ $session->creator ? $session->creator->username : 'Unknown' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="session-actions">
                        <a href="{{ route('assessment_sessions.show', $session->session_id) }}" class="btn btn-view">
                            <i class="fas fa-eye me-2"></i>View Details
                        </a>
                        @if(Auth::user()->role === 'it_security_analyst')
                        <form action="{{ route('assessment_sessions.destroy', $session->session_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this session? All linked assessments will also be deleted!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete-session">
                                <i class="fas fa-trash-alt me-2"></i>Delete Session
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-calendar-xmark"></i>
                <h5>No assessment sessions created yet</h5>
                <p class="text-muted">Start by creating your first assessment session</p>
                @if(Auth::check() && Auth::user()->role === 'it_security_analyst')
                <a href="{{ route('assessment_sessions.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus me-2"></i>Create First Session
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
