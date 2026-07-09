<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threat Library - CRAS</title>
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
            background: linear-gradient(135deg, #14532d 0%, #166534 100%);
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
            background: linear-gradient(90deg, #10b981, #059669, #047857);
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
        .btn-import {
            background: white;
            color: #667eea;
            border: 2px solid white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .btn-import:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }
        .stat-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            padding: 1.75rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            border-top: 4px solid;
            text-align: center;
        }
        .stat-card.total { border-top-color: #10b981; }
        .stat-card.critical { border-top-color: #ef4444; }
        .stat-card.high { border-top-color: #f59e0b; }
        .stat-card.medium { border-top-color: #fbbf24; }
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: #cbd5e1;
            font-weight: 600;
            font-size: 0.9375rem;
        }
        .threat-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            border-left: 6px solid;
        }
        .threat-card.critical { border-left-color: #dc2626; }
        .threat-card.high { border-left-color: #f59e0b; }
        .threat-card.medium { border-left-color: #fbbf24; }
        .threat-card.low { border-left-color: #10b981; }
        .threat-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1.25rem;
        }
        .threat-name {
            font-size: 1.5rem;
            font-weight: 800;
            color: #f1f5f9;
            margin-bottom: 0.5rem;
        }
        .asset-link {
            display: inline-block;
            background: rgba(102, 126, 234, 0.2);
            color: #a5b4fc;
            padding: 0.375rem 0.875rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
        }
        .severity-badge {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 800;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        .severity-badge.critical {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
        }
        .severity-badge.high {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #78350f;
        }
        .severity-badge.medium {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #78350f;
        }
        .severity-badge.low {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #064e3b;
        }
        .threat-section {
            background: rgba(102, 126, 234, 0.1);
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 1rem;
        }
        .threat-section-title {
            color: #cbd5e1;
            font-weight: 700;
            font-size: 0.875rem;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .threat-section-title i {
            color: #a5b4fc;
        }
        .threat-section-content {
            color: #e2e8f0;
            line-height: 1.7;
        }
        .threat-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.25rem;
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
            color: white;
        }
        .btn-edit-threat {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-edit-threat:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }
        .btn-delete-threat {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-delete-threat:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }
        .importer-info {
            color: #94a3b8;
            font-size: 0.875rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(148, 163, 184, 0.2);
        }
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-weight: 500;
            margin-bottom: 2rem;
        }
        .alert-success {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border-left: 4px solid #10b981;
        }
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        .empty-state i {
            font-size: 4rem;
            color: #475569;
            margin-bottom: 1rem;
        }
        .empty-state h5 {
            color: #f1f5f9;
        }
        .empty-state p {
            color: #cbd5e1;
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo-header">
                    <img src="{{ asset('logo/ChatGPT Image Jul 6, 2026, 03_34_47 PM.png') }}" alt="CRAS Logo">
                    <div>
                        <h1 class="mb-0 h2 fw-bold">
                            <i class="fas fa-book-medical me-2"></i>Threat Library
                        </h1>
                        <p class="mb-0 opacity-90">Import and manage threat information for assets</p>
                    </div>
                </div>
                @if(Auth::user()->role === 'it_security_analyst' || Auth::user()->role === 'administrator')
                <a href="{{ route('threat_library.create') }}" class="btn btn-import">
                    <i class="fas fa-file-import me-2"></i>Import Threat Info
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
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: invert(1);"></button>
            </div>
        @endif

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-number" style="color: #10b981;">{{ $threats->count() }}</div>
                <div class="stat-label"><i class="fas fa-book me-1"></i>Total Threats</div>
            </div>
            <div class="stat-card critical">
                <div class="stat-number" style="color: #ef4444;">{{ $threats->where('severity_level', 'Critical')->count() }}</div>
                <div class="stat-label"><i class="fas fa-exclamation-triangle me-1"></i>Critical</div>
            </div>
            <div class="stat-card high">
                <div class="stat-number" style="color: #f59e0b;">{{ $threats->where('severity_level', 'High')->count() }}</div>
                <div class="stat-label"><i class="fas fa-exclamation-circle me-1"></i>High</div>
            </div>
            <div class="stat-card medium">
                <div class="stat-number" style="color: #fbbf24;">{{ $threats->where('severity_level', 'Medium')->count() }}</div>
                <div class="stat-label"><i class="fas fa-info-circle me-1"></i>Medium</div>
            </div>
        </div>

        <!-- Threat Cards -->
        @if($threats->count() > 0)
            @foreach($threats as $threat)
                <div class="threat-card {{ strtolower($threat->severity_level) }}">
                    <div class="threat-header">
                        <div>
                            <div class="threat-name">
                                <i class="fas fa-shield-virus me-2" style="color: #ef4444;"></i>
                                {{ $threat->threat_name }}
                            </div>
                            <a href="{{ route('assets.index') }}" class="asset-link">
                                <i class="fas fa-server me-1"></i>{{ $threat->asset->asset_name ?? 'N/A' }}
                            </a>
                        </div>
                        <span class="severity-badge {{ strtolower($threat->severity_level) }}">
                            {{ $threat->severity_level }}
                        </span>
                    </div>

                    <div class="threat-section">
                        <div class="threat-section-title">
                            <i class="fas fa-info-circle"></i>Threat Description
                        </div>
                        <div class="threat-section-content">{{ $threat->threat_description }}</div>
                    </div>

                    <div class="threat-section">
                        <div class="threat-section-title">
                            <i class="fas fa-bug"></i>Vulnerabilities
                        </div>
                        <div class="threat-section-content">{{ $threat->vulnerabilities }}</div>
                    </div>

                    <div class="threat-section">
                        <div class="threat-section-title">
                            <i class="fas fa-shield-alt"></i>Prevention Steps
                        </div>
                        <div class="threat-section-content">{{ $threat->prevention_steps }}</div>
                    </div>

                    <div class="importer-info">
                        <i class="fas fa-user me-1"></i>
                        Imported by: <strong>{{ $threat->importer->name ?? 'Unknown' }}</strong> • 
                        {{ $threat->created_at ? $threat->created_at->format('M d, Y - h:i A') : 'N/A' }}
                    </div>

                    <div class="threat-actions">
                        <a href="{{ route('threat_library.show', $threat->threat_id) }}" class="btn btn-view">
                            <i class="fas fa-eye me-2"></i>View Details
                        </a>
                        @if(Auth::user()->role === 'it_security_analyst' || Auth::user()->role === 'administrator')
                        <a href="{{ route('threat_library.edit', $threat->threat_id) }}" class="btn btn-edit-threat">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <form action="{{ route('threat_library.destroy', $threat->threat_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this threat information?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete-threat">
                                <i class="fas fa-trash-alt me-2"></i>Delete
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <h5>No threat information imported yet</h5>
                <p>Start by importing threat and vulnerability information for your assets</p>
                @if(Auth::user()->role === 'it_security_analyst' || Auth::user()->role === 'administrator')
                <a href="{{ route('threat_library.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-file-import me-2"></i>Import First Threat
                </a>
                @endif
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
