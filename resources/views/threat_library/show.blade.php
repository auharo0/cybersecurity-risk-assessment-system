<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $threat->threat_name }} - CRAS</title>
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
        }
        .detail-card {
            background: rgba(30, 41, 59, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            margin-bottom: 2rem;
        }
        .detail-header {
            border-bottom: 2px solid rgba(148, 163, 184, 0.2);
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }
        .detail-title {
            font-size: 2rem;
            font-weight: 800;
            color: #f1f5f9;
            margin-bottom: 1rem;
        }
        .severity-badge {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 800;
            font-size: 1.125rem;
        }
        .severity-badge.critical { background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; }
        .severity-badge.high { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #78350f; }
        .severity-badge.medium { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: #78350f; }
        .severity-badge.low { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #064e3b; }
        .info-section {
            margin-bottom: 2rem;
        }
        .info-label {
            color: #94a3b8;
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .info-label i {
            color: #a5b4fc;
        }
        .info-content {
            color: #e2e8f0;
            line-height: 1.8;
            font-size: 1.0625rem;
            background: rgba(102, 126, 234, 0.1);
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 4px solid #667eea;
        }
        .btn-back {
            background: rgba(148, 163, 184, 0.2);
            color: #cbd5e1;
            border: 2px solid rgba(148, 163, 184, 0.3);
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
        }
        .btn-back:hover {
            background: rgba(148, 163, 184, 0.3);
            color: #f1f5f9;
        }
        .meta-info {
            background: rgba(102, 126, 234, 0.1);
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 2rem;
        }
        .meta-item {
            color: #cbd5e1;
            margin-bottom: 0.5rem;
        }
        .meta-item strong {
            color: #f1f5f9;
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <div class="page-header">
        <div class="container">
            <a href="{{ route('threat_library.index') }}" class="btn btn-back mb-3">
                <i class="fas fa-arrow-left me-2"></i>Back to Threat Library
            </a>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-title">
                            <i class="fas fa-shield-virus me-3" style="color: #ef4444;"></i>
                            {{ $threat->threat_name }}
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="severity-badge {{ strtolower($threat->severity_level) }}">
                                {{ $threat->severity_level }} Severity
                            </span>
                            <span style="color: #94a3b8;">
                                <i class="fas fa-server me-1"></i>
                                {{ $threat->asset->asset_name ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="info-label">
                            <i class="fas fa-info-circle"></i>Threat Description
                        </div>
                        <div class="info-content">
                            {{ $threat->threat_description }}
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="info-label">
                            <i class="fas fa-bug"></i>Vulnerabilities
                        </div>
                        <div class="info-content">
                            {{ $threat->vulnerabilities }}
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="info-label">
                            <i class="fas fa-shield-alt"></i>Prevention & Mitigation Steps
                        </div>
                        <div class="info-content">
                            {{ $threat->prevention_steps }}
                        </div>
                    </div>

                    <div class="meta-info">
                        <div class="meta-item">
                            <i class="fas fa-user me-2"></i>
                            <strong>Imported by:</strong> {{ $threat->importer->name ?? 'Unknown' }}
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar me-2"></i>
                            <strong>Created:</strong> {{ $threat->created_at ? $threat->created_at->format('M d, Y - h:i A') : 'N/A' }}
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Last Updated:</strong> {{ $threat->updated_at ? $threat->updated_at->format('M d, Y - h:i A') : 'N/A' }}
                        </div>
                    </div>

                    @if(Auth::user()->role === 'it_security_analyst' || Auth::user()->role === 'administrator')
                    <div class="d-flex gap-3 mt-4">
                        <a href="{{ route('threat_library.edit', $threat->threat_id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <form action="{{ route('threat_library.destroy', $threat->threat_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this threat information?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt me-2"></i>Delete
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
