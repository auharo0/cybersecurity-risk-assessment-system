<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs - CRAS</title>
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
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2.5rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(30%, -30%);
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
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .search-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            background: white;
            margin-bottom: 1.5rem;
        }
        .search-input {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
        }
        .search-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        .btn-filter {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .btn-clear {
            background: #64748b;
            border: none;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
        }
        .timeline-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            background: white;
            overflow: hidden;
        }
        .log-item {
            border-left: 4px solid transparent;
            padding: 1.25rem;
            position: relative;
        }
        .log-time {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .log-time i {
            color: #667eea;
        }
        .log-user {
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .log-user-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
        }
        .log-action {
            color: #475569;
            margin-top: 0.5rem;
            font-weight: 500;
        }
        .log-ip {
            display: inline-block;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #475569;
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-left: 4px solid;
        }
        .stat-card.total { border-left-color: #667eea; }
        .stat-card.today { border-left-color: #10b981; }
        .stat-card.users { border-left-color: #f59e0b; }
        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }
        .stat-label {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #94a3b8;
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <!-- Page Header with Logo -->
    <div class="page-header">
        <div class="container">
            <div class="logo-header">
                <img src="{{ asset('logo/ChatGPT Image Jul 6, 2026, 03_34_47 PM.png') }}" alt="CRAS Logo">
                <div>
                    <h1 class="mb-0 h2 fw-bold">
                        <i class="fas fa-clipboard-list me-2"></i>System Audit Logs
                    </h1>
                    <p class="mb-0 opacity-90">Track all system activities and user actions</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <!-- Quick Stats -->
        <div class="stats-row">
            <div class="stat-card total">
                <div class="stat-value text-primary">{{ $logs->total() }}</div>
                <div class="stat-label"><i class="fas fa-list me-1"></i>Total Logs</div>
            </div>
            <div class="stat-card today">
                <div class="stat-value" style="color: #10b981;">{{ $logs->filter(fn($log) => $log->created_at->isToday())->count() }}</div>
                <div class="stat-label"><i class="fas fa-calendar-day me-1"></i>Today's Activity</div>
            </div>
            <div class="stat-card users">
                <div class="stat-value" style="color: #f59e0b;">{{ $logs->pluck('user_id')->unique()->count() }}</div>
                <div class="stat-label"><i class="fas fa-users me-1"></i>Active Users</div>
            </div>
        </div>

        <!-- Search Card -->
        <div class="search-card">
            <div class="card-body p-4">
                <form action="{{ route('audit_logs.index') }}" method="GET">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border: 2px solid #e2e8f0; border-right: none;">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="search-input form-control border-start-0" placeholder="Search by action, user, or IP address..." value="{{ request('search') }}" style="border-radius: 0 12px 12px 0;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-filter text-white flex-grow-1">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>
                                <a href="{{ route('audit_logs.index') }}" class="btn btn-clear text-white">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Timeline Logs -->
        <div class="timeline-card">
            @forelse($logs as $log)
                <div class="log-item border-bottom">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="log-time">
                                <i class="fas fa-clock"></i>
                                {{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y') }}
                            </div>
                            <div class="log-time mt-1">
                                <i class="fas fa-history"></i>
                                {{ \Carbon\Carbon::parse($log->created_at)->format('h:i A') }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="log-user">
                                <div class="log-user-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span>{{ $log->user->username ?? $log->user->name ?? 'System/Guest' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="log-action">
                                <i class="fas fa-bolt me-1 text-warning"></i>
                                {{ $log->action }}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="log-ip">
                                <i class="fas fa-network-wired me-1"></i>
                                {{ $log->ip_address ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p class="mb-0 fw-semibold">No logs found matching your search criteria</p>
                    <p class="small">Try adjusting your filters or search terms</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="mt-4">
                {{ $logs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>