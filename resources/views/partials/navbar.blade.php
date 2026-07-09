<!-- Security CSS - Disable Inspect -->
<link rel="stylesheet" href="{{ asset('css/security.css') }}">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('assessment_sessions.index') }}">
            <i class="fas fa-shield-alt me-2"></i>CRAS System
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            @if(Auth::check() && in_array(Auth::user()->role, ['administrator', 'it_security_analyst', 'organization_manager']))
            <!-- Left Side -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard') || Request::is('/') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                @if(Auth::user()->role === 'administrator')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="fas fa-users me-1"></i>Accounts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('audit_logs.index') }}">
                        <i class="fas fa-clipboard-list me-1"></i>Audit Logs
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('assets.index') }}">
                        <i class="fas fa-server me-1"></i>Assets
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('assessment_sessions.index') }}">
                        <i class="fas fa-calendar-check me-1"></i>Sessions
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('risk_assessments.index') }}">
                        <i class="fas fa-shield-alt me-1"></i>All Risks
                    </a>
                </li>
                
                @if(in_array(Auth::user()->role, ['it_security_analyst', 'administrator']))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('threat_library.index') }}">
                        <i class="fas fa-book-medical me-1"></i>Threat Library
                    </a>
                </li>
                @endif
            </ul>
            @endif

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto">
                <!-- Dark Mode Toggle -->
                <li class="nav-item">
                    <button id="darkModeToggle" class="btn btn-link nav-link border-0" title="Toggle Dark Mode">
                        <i class="fas fa-moon" id="darkModeIcon"></i>
                    </button>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-link nav-link border-0">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </form>
                    </li>

                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Disable Inspect Element -->
<script src="{{ asset('js/disable-inspect.js') }}"></script>

<!-- Dark Mode Script -->
<script>
    // Initialize dark mode from localStorage
    const darkModeToggle = document.getElementById('darkModeToggle');
    const darkModeIcon = document.getElementById('darkModeIcon');
    const htmlElement = document.documentElement;

    // Check for saved dark mode preference
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    
    if (isDarkMode) {
        htmlElement.setAttribute('data-theme', 'dark');
        darkModeIcon.classList.remove('fa-moon');
        darkModeIcon.classList.add('fa-sun');
    }

    // Toggle dark mode
    darkModeToggle.addEventListener('click', function() {
        const currentTheme = htmlElement.getAttribute('data-theme');
        
        if (currentTheme === 'dark') {
            htmlElement.setAttribute('data-theme', 'light');
            localStorage.setItem('darkMode', 'false');
            darkModeIcon.classList.remove('fa-sun');
            darkModeIcon.classList.add('fa-moon');
        } else {
            htmlElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('darkMode', 'true');
            darkModeIcon.classList.remove('fa-moon');
            darkModeIcon.classList.add('fa-sun');
        }
    });
</script>