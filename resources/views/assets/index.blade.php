<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management - CRAS</title>
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
            background: linear-gradient(135deg, #f0f4ff 0%, #e5e7eb 100%);
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
        .page-header::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
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
        .asset-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .asset-card {
            background: white;
            border-radius: 16px;
            padding: 1.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        .asset-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }
        .asset-icon-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1rem;
            position: relative;
        }
        .asset-icon-wrapper.hardware {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        }
        .asset-icon-wrapper.software {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        .asset-icon-wrapper.network {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        .asset-icon-wrapper.data {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }
        .asset-icon-wrapper.other {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        }
        .asset-icon-wrapper i {
            color: white;
        }
        .asset-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .asset-meta {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid #f1f5f9;
        }
        .asset-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.875rem;
        }
        .asset-meta-item i {
            color: #667eea;
            width: 18px;
        }
        .asset-meta-item strong {
            color: #334155;
            font-weight: 600;
        }
        .asset-badge {
            display: inline-block;
            padding: 0.375rem 0.875rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        .badge-hardware { background: #e0f2fe; color: #0369a1; }
        .badge-software { background: #d1fae5; color: #065f46; }
        .badge-network { background: #fed7aa; color: #92400e; }
        .badge-data { background: #e9d5ff; color: #6b21a8; }
        .badge-other { background: #f1f5f9; color: #475569; }
        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }
        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        .btn-add-asset {
            background: white;
            color: #667eea;
            border: 2px solid white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .btn-add-asset:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
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
        .empty-state h5 {
            color: #64748b;
            font-weight: 600;
        }
        .stats-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-pill {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        .stat-content h6 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
        }
        .stat-content p {
            margin: 0;
            font-size: 0.875rem;
            color: #64748b;
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
                            <i class="fas fa-server me-2"></i>Asset Management
                        </h1>
                        <p class="mb-0 opacity-90">Manage and track your organization's digital assets</p>
                    </div>
                </div>
                @if(Auth::user() && Auth::user()->role === 'it_security_analyst')
                <a href="{{ route('assets.create') }}" class="btn btn-add-asset">
                    <i class="fas fa-plus me-2"></i>Register New Asset
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

        <!-- Stats Bar -->
        <div class="stats-bar">
            <div class="stat-pill flex-fill">
                <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <i class="fas fa-cubes"></i>
                </div>
                <div class="stat-content">
                    <h6>{{ $assets->count() }}</h6>
                    <p>Total Assets</p>
                </div>
            </div>
            <div class="stat-pill flex-fill">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="stat-content">
                    <h6>{{ $assets->filter(fn($a) => in_array(strtolower($a->asset_type), ['hardware', 'network']))->count() }}</h6>
                    <p>Critical Assets</p>
                </div>
            </div>
            <div class="stat-pill flex-fill">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h6>{{ $assets->pluck('manager_id')->unique()->count() }}</h6>
                    <p>Asset Managers</p>
                </div>
            </div>
        </div>

        <!-- Asset Grid -->
        @if($assets->count() > 0)
            <div class="asset-grid">
                @foreach($assets as $asset)
                    <div class="asset-card">
                        <!-- Asset Type Badge -->
                        <span class="asset-badge 
                            @if(strtolower($asset->asset_type) == 'hardware') badge-hardware
                            @elseif(strtolower($asset->asset_type) == 'software') badge-software
                            @elseif(str_contains(strtolower($asset->asset_type), 'database')) badge-data
                            @elseif(str_contains(strtolower($asset->asset_type), 'cloud')) badge-network
                            @else badge-other
                            @endif">
                            {{ ucfirst($asset->asset_type) }}
                        </span>

                        <!-- Asset Icon -->
                        <div class="asset-icon-wrapper 
                            @if(strtolower($asset->asset_type) == 'hardware') hardware
                            @elseif(strtolower($asset->asset_type) == 'software') software
                            @elseif(str_contains(strtolower($asset->asset_type), 'database')) data
                            @elseif(str_contains(strtolower($asset->asset_type), 'cloud')) network
                            @else other
                            @endif">
                            @if(strtolower($asset->asset_type) == 'hardware')
                                <i class="fas fa-hdd"></i>
                            @elseif(strtolower($asset->asset_type) == 'software')
                                <i class="fas fa-code"></i>
                            @elseif(str_contains(strtolower($asset->asset_type), 'database'))
                                <i class="fas fa-database"></i>
                            @elseif(str_contains(strtolower($asset->asset_type), 'cloud'))
                                <i class="fas fa-cloud"></i>
                            @else
                                <i class="fas fa-box"></i>
                            @endif
                        </div>

                        <!-- Asset Name -->
                        <h3 class="asset-name">{{ $asset->asset_name }}</h3>

                        <!-- Asset Meta Information -->
                        <div class="asset-meta">
                            <div class="asset-meta-item">
                                <i class="fas fa-hashtag"></i>
                                <span><strong>ID:</strong> {{ $asset->asset_id }}</span>
                            </div>
                            <div class="asset-meta-item">
                                <i class="fas fa-folder-open"></i>
                                <span><strong>Session:</strong> {{ $asset->assessmentSession ? $asset->assessmentSession->session_name : 'Unknown' }}</span>
                            </div>
                            <div class="asset-meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span><strong>Manager:</strong> {{ $asset->manager ? $asset->manager->username : 'Unknown' }}</span>
                            </div>
                        </div>

                        <!-- Delete Button -->
                        @if(Auth::user() && Auth::user()->role === 'it_security_analyst')
                        <form action="{{ route('assets.destroy', $asset->asset_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this asset?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <i class="fas fa-trash-alt me-2"></i>Delete Asset
                            </button>
                        </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h5>No assets registered yet</h5>
                <p class="text-muted">Start by registering your first asset to track and manage it</p>
                @if(Auth::user() && Auth::user()->role === 'it_security_analyst')
                <a href="{{ route('assets.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus me-2"></i>Register First Asset
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
