<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - CRAS</title>
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
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
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
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
        .btn-create-user {
            background: white;
            color: #667eea;
            border: 2px solid white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .btn-create-user:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }
        .stat-box {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            border-top: 4px solid;
            position: relative;
            overflow: hidden;
        }
        .stat-box::after {
            content: '';
            position: absolute;
            bottom: -30px;
            right: -30px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            opacity: 0.08;
        }
        .stat-box.total {
            border-top-color: #667eea;
        }
        .stat-box.total::after {
            background: #667eea;
        }
        .stat-box.active {
            border-top-color: #10b981;
        }
        .stat-box.active::after {
            background: #10b981;
        }
        .stat-box.inactive {
            border-top-color: #ef4444;
        }
        .stat-box.inactive::after {
            background: #ef4444;
        }
        .stat-box.admins {
            border-top-color: #f59e0b;
        }
        .stat-box.admins::after {
            background: #f59e0b;
        }
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        .stat-label {
            color: #cbd5e1;
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            z-index: 1;
        }
        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.5rem;
        }
        .user-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            border-left: 6px solid;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .user-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(40%, -40%);
        }
        .user-card.active {
            border-left-color: #10b981;
        }
        .user-card.inactive {
            border-left-color: #ef4444;
            opacity: 0.85;
        }
        .user-header {
            display: flex;
            align-items: start;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }
        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            font-weight: 800;
            position: relative;
            flex-shrink: 0;
        }
        .user-avatar.active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        .user-avatar.inactive {
            background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
            box-shadow: 0 4px 12px rgba(148, 163, 184, 0.3);
        }
        .user-info {
            flex: 1;
        }
        .user-name {
            font-size: 1.375rem;
            font-weight: 800;
            color: #f1f5f9;
            margin-bottom: 0.25rem;
        }
        .user-email {
            color: #cbd5e1;
            font-size: 0.9375rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .user-email i {
            color: #667eea;
        }
        .status-badge-card {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.875rem;
        }
        .status-badge-card.active {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }
        .status-badge-card.inactive {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }
        .user-details {
            background: rgba(102, 126, 234, 0.15);
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.25rem;
            position: relative;
            z-index: 1;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }
        .detail-row:not(:last-child) {
            border-bottom: 1px solid rgba(203, 213, 225, 0.15);
        }
        .detail-label {
            color: #cbd5e1;
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .detail-label i {
            color: #a5b4fc;
            width: 18px;
        }
        .detail-value {
            font-weight: 700;
            color: #f1f5f9;
        }
        .role-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.375rem 0.875rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.8125rem;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }
        .user-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }
        .btn-edit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            flex: 1;
        }
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
            color: white;
        }
        .btn-toggle {
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            flex: 1;
        }
        .btn-toggle.activate {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        .btn-toggle.deactivate {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        .btn-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .btn-current-user {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9375rem;
            flex: 1;
            cursor: not-allowed;
        }
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-weight: 500;
            margin-bottom: 2rem;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
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
        .empty-state .text-muted {
            color: #cbd5e1 !important;
        }
        .search-filter-bar {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            margin-bottom: 2rem;
        }
        .search-input-wrapper {
            position: relative;
        }
        .search-input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.125rem;
        }
        .search-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid rgba(148, 163, 184, 0.3);
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            background: rgba(15, 23, 42, 0.5);
            color: #f1f5f9;
        }
        .search-input::placeholder {
            color: #94a3b8;
        }
        .search-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
            outline: none;
            background: rgba(15, 23, 42, 0.7);
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
                            <i class="fas fa-users-cog me-2"></i>User Management
                        </h1>
                        <p class="mb-0 opacity-90">Manage system users and their access permissions</p>
                    </div>
                </div>
                <a href="{{ route('users.create') }}" class="btn btn-create-user">
                    <i class="fas fa-user-plus me-2"></i>Create User
                </a>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-box total">
                <div class="stat-number" style="color: #667eea;">{{ $users->count() }}</div>
                <div class="stat-label">
                    <i class="fas fa-users"></i>Total Users
                </div>
            </div>
            <div class="stat-box active">
                <div class="stat-number" style="color: #10b981;">{{ $users->where('status', 'active')->count() }}</div>
                <div class="stat-label">
                    <i class="fas fa-user-check"></i>Active Users
                </div>
            </div>
            <div class="stat-box inactive">
                <div class="stat-number" style="color: #ef4444;">{{ $users->where('status', 'inactive')->count() }}</div>
                <div class="stat-label">
                    <i class="fas fa-user-slash"></i>Inactive Users
                </div>
            </div>
            <div class="stat-box admins">
                <div class="stat-number" style="color: #f59e0b;">{{ $users->where('role', 'administrator')->count() }}</div>
                <div class="stat-label">
                    <i class="fas fa-user-shield"></i>Administrators
                </div>
            </div>
        </div>

        <!-- Search/Filter Bar -->
        <div class="search-filter-bar">
            <div class="search-input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="userSearch" class="search-input" placeholder="Search by name, email, or role...">
            </div>
        </div>

        <!-- Users Grid -->
        @if($users->count() > 0)
            <div class="users-grid">
                @foreach($users as $user)
                    <div class="user-card {{ $user->status }}" data-user-search="{{ strtolower($user->name . ' ' . $user->email . ' ' . $user->role) }}">
                        <div class="user-header">
                            <div class="user-avatar {{ $user->status }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-email">
                                    <i class="fas fa-envelope"></i>
                                    {{ $user->email }}
                                </div>
                                <span class="status-badge-card {{ $user->status }}">
                                    @if($user->status === 'active')
                                        <i class="fas fa-check-circle"></i>Active
                                    @else
                                        <i class="fas fa-times-circle"></i>Inactive
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="user-details">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-id-badge"></i>User ID
                                </div>
                                <div class="detail-value">#{{ $user->id }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-user-tag"></i>Role
                                </div>
                                <div class="detail-value">
                                    <span class="role-badge">
                                        {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-calendar-plus"></i>Joined
                                </div>
                                <div class="detail-value">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="user-actions">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-edit">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>

                            @if(auth()->id() != $user->id)
                                <form action="{{ route('users.toggleStatus', $user) }}" method="POST" style="flex: 1;">
                                    @csrf
                                    @method('PATCH')
                                    
                                    @if($user->status === 'active')
                                        <button type="submit" class="btn btn-toggle deactivate w-100" onclick="return confirm('Deactivate this user? They will not be able to login.')">
                                            <i class="fas fa-ban me-1"></i>Deactivate
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-toggle activate w-100" onclick="return confirm('Activate this user? They will be able to login again.')">
                                            <i class="fas fa-check me-1"></i>Activate
                                        </button>
                                    @endif
                                </form>
                            @else
                                <button class="btn btn-current-user" disabled>
                                    <i class="fas fa-user-shield me-1"></i>Current User
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <h5>No users found</h5>
                <p class="text-muted">Start by creating your first user</p>
                <a href="{{ route('users.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-user-plus me-2"></i>Create First User
                </a>
            </div>
        @endif

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Auto-hide alerts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });

        // Live search functionality
        const searchInput = document.getElementById('userSearch');
        const userCards = document.querySelectorAll('.user-card');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            userCards.forEach(card => {
                const searchData = card.getAttribute('data-user-search');
                
                if (searchData.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide empty state if no results
            const visibleCards = Array.from(userCards).filter(card => card.style.display !== 'none');
            if (visibleCards.length === 0 && searchTerm !== '') {
                // Could add a "no results" message here
            }
        });
    </script>
</body>
</html>
