<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluate Risk - CRAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

    <!-- Include the Navbar Partial -->
    @include('partials.navbar')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-top border-danger border-4 mb-5">
                    <div class="card-header bg-white">
                        <h4 class="mb-0 mt-2">Evaluate System Risk</h4>
                    </div>
                    <div class="card-body">
                        <!-- Display Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops! There were some problems with your input:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('risk_assessments.store') }}" method="POST">
                            @csrf
                            
                            <!-- Session Selection -->
                            @if(isset($preselectedSession) && $preselectedSession)
                                <!-- Hidden Session ID (Procedural Workflow from a specific session) -->
                                <input type="hidden" name="session_id" value="{{ $preselectedSession }}">
                                <div class="alert alert-info mb-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Session Context:</strong> You are adding a risk assessment to 
                                    <strong>{{ $sessions->where('session_id', $preselectedSession)->first()->session_name ?? 'the selected session' }}</strong>. 
                                    Only assets from this session are available below.
                                </div>
                            @else
                                <!-- Manual Session Selection (When accessed from global "New Assessment" button) -->
                                <div class="mb-4 p-3 bg-info bg-opacity-10 border border-info rounded">
                                    <label class="form-label fw-bold">Select Assessment Session</label>
                                    <select name="session_id" class="form-select @error('session_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>Choose a session...</option>
                                        @foreach($sessions as $session)
                                            <option value="{{ $session->session_id }}">{{ $session->session_name }} ({{ $session->status }})</option>
                                        @endforeach
                                    </select>
                                    @error('session_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <!-- Asset Selection & Dynamic Creation -->
                            <div class="mb-4 p-3 bg-light border rounded">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold mb-0">1. Target Asset (System)</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="create_new_asset" name="create_new_asset" value="1" {{ old('create_new_asset') ? 'checked' : '' }}>
                                        <label class="form-check-label text-primary fw-bold" for="create_new_asset">Asset not listed? Create New</label>
                                    </div>
                                </div>

                                <!-- Existing Asset Dropdown -->
                                <div id="existing_asset_div" class="{{ old('create_new_asset') ? 'd-none' : '' }}">
                                    <select name="asset_id" id="asset_id" class="form-select @error('asset_id') is-invalid @enderror">
                                        <option value="" disabled selected>Select an existing asset...</option>
                                        @foreach($assets as $asset)
                                            <option value="{{ $asset->asset_id }}">{{ $asset->asset_name }} ({{ $asset->asset_type }})</option>
                                        @endforeach
                                    </select>
                                    @error('asset_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- New Asset Fields -->
                                <div id="new_asset_div" class="{{ old('create_new_asset') ? '' : 'd-none' }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" name="new_asset_name" class="form-control" placeholder="New Asset Name" value="{{ old('new_asset_name') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <select name="new_asset_type" class="form-select">
                                                <option value="" disabled selected>Type...</option>
                                                <option value="Hardware">Hardware</option>
                                                <option value="Software">Software</option>
                                                <option value="Database">Database</option>
                                                <option value="Cloud Service">Cloud Service</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Auto-Loaded Threat Information (from Threat Library) -->
                            <div id="threat_library_section" class="mb-4 d-none">
                                <div class="alert alert-info border-start border-4 border-info">
                                    <h5 class="alert-heading">
                                        <i class="fas fa-book-medical me-2"></i>
                                        Available Threat Information for This Asset
                                    </h5>
                                    <p class="mb-2 small text-muted">The following threats have been documented in the Threat Library for this asset. You can use this information or add your own assessment below.</p>
                                    <div id="threats_list"></div>
                                </div>
                            </div>

                            <!-- Threat & Vulnerability -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">2. Identify Vulnerabilities</label>
                                <input type="text" name="threat_description" id="threat_description" class="form-control mb-2" placeholder="Describe the Threat (e.g., Malware Infection)" required>
                                <input type="text" name="vulnerability_description" id="vulnerability_description" class="form-control" placeholder="Describe the Vulnerability (e.g., Outdated Antivirus)" required>
                                <small class="text-muted">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Tip: If threats are shown above, you can click "Use This Threat" to auto-fill these fields.
                                </small>
                            </div>

                            <!-- Risk Scoring (Math) -->
                            <div class="row mb-4 bg-white p-3 border rounded shadow-sm">
                                <label class="form-label fw-bold">3. Risk Scoring (1 to 3 Scale)</label>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Likelihood</label>
                                    <select name="likelihood" id="likelihood" class="form-select" required>
                                        <option value="" disabled selected>Select Likelihood...</option>
                                        <option value="1">1 - Low (Unlikely)</option>
                                        <option value="2">2 - Medium (Possible)</option>
                                        <option value="3">3 - High (Very Likely)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Impact</label>
                                    <select name="impact" id="impact" class="form-select" required>
                                        <option value="" disabled selected>Select Impact...</option>
                                        <option value="1">1 - Low (Minor issue)</option>
                                        <option value="2">2 - Medium (Moderate damage)</option>
                                        <option value="3">3 - High (Severe damage)</option>
                                    </select>
                                </div>
                                
                                <!-- Live Score Preview -->
                                <div class="col-md-12 mt-4 text-center">
                                    <h5 class="mb-0">Live Score Preview: <span id="live_score_display" class="badge bg-secondary">Awaiting Input</span></h5>
                                </div>
                            </div>

                            <!-- Mitigation Plan -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">4. Mitigation Plan</label>
                                <textarea name="mitigation_plan" id="mitigation_plan" class="form-control" rows="2" placeholder="How do you plan to fix this? (Optional)"></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                @if(isset($preselectedSession) && $preselectedSession)
                                    <a href="{{ route('assessment_sessions.show', $preselectedSession) }}" class="btn btn-light border">Cancel</a>
                                @else
                                    <a href="{{ route('assessment_sessions.index') }}" class="btn btn-light border">Cancel</a>
                                @endif
                                <button type="submit" class="btn btn-danger fw-bold">Evaluate & Save Risk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle between existing asset and create new asset
        document.getElementById('create_new_asset').addEventListener('change', function() {
            const existingDiv = document.getElementById('existing_asset_div');
            const newDiv = document.getElementById('new_asset_div');
            
            if (this.checked) {
                existingDiv.classList.add('d-none');
                newDiv.classList.remove('d-none');
                document.getElementById('asset_id').value = ''; 
            } else {
                existingDiv.classList.remove('d-none');
                newDiv.classList.add('d-none');
            }
        });

        // Dynamic asset loading when session is selected
        const sessionSelect = document.querySelector('select[name="session_id"]');
        const assetSelect = document.getElementById('asset_id');
        
        if (sessionSelect) {
            sessionSelect.addEventListener('change', function() {
                const sessionId = this.value;
                
                if (sessionId) {
                    // Show loading state
                    assetSelect.innerHTML = '<option value="">Loading assets...</option>';
                    assetSelect.disabled = true;
                    
                    // Fetch assets for this session
                    fetch(`/api/sessions/${sessionId}/assets`)
                        .then(response => response.json())
                        .then(assets => {
                            // Clear and populate dropdown
                            assetSelect.innerHTML = '<option value="" disabled selected>Select an existing asset...</option>';
                            
                            if (assets.length === 0) {
                                assetSelect.innerHTML += '<option value="" disabled>No assets found for this session</option>';
                            } else {
                                assets.forEach(asset => {
                                    const option = document.createElement('option');
                                    option.value = asset.asset_id;
                                    option.textContent = `${asset.asset_name} (${asset.asset_type})`;
                                    assetSelect.appendChild(option);
                                });
                            }
                            
                            assetSelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error loading assets:', error);
                            assetSelect.innerHTML = '<option value="" disabled>Error loading assets</option>';
                            assetSelect.disabled = false;
                        });
                }
            });
        }
        
        // If asset dropdown already has assets loaded (from preselected session), enable threat loading immediately
        if (assetSelect && assetSelect.options.length > 1) {
            console.log('Assets already loaded for preselected session');
        }

        // Risk score calculator
        const likelihoodSelect = document.getElementById('likelihood');
        const impactSelect = document.getElementById('impact');
        const displayScore = document.getElementById('live_score_display');

        function updateRiskScore() {
            const l = parseInt(likelihoodSelect.value) || 0;
            const i = parseInt(impactSelect.value) || 0;
            
            if (l > 0 && i > 0) {
                const score = l * i;
                let classification = '';
                let badgeClass = '';

                if (score <= 3) {
                    classification = 'LOW RISK';
                    badgeClass = 'bg-success';
                } else if (score <= 6) {
                    classification = 'MEDIUM RISK';
                    badgeClass = 'bg-warning text-dark';
                } else {
                    classification = 'HIGH RISK';
                    badgeClass = 'bg-danger';
                }

                displayScore.textContent = `${score} (${classification})`;
                displayScore.className = `badge ${badgeClass} fs-5`;
            } else {
                displayScore.textContent = 'Awaiting Input';
                displayScore.className = 'badge bg-secondary';
            }
        }

        likelihoodSelect.addEventListener('change', updateRiskScore);
        impactSelect.addEventListener('change', updateRiskScore);
        updateRiskScore();

        // Load threats when asset is selected
        assetSelect.addEventListener('change', function() {
            const assetId = this.value;
            const threatSection = document.getElementById('threat_library_section');
            const threatsList = document.getElementById('threats_list');
            
            if (assetId) {
                // Fetch threats for this asset
                fetch(`/api/assets/${assetId}/threats`)
                    .then(response => response.json())
                    .then(threats => {
                        if (threats.length > 0) {
                            // Show threat section
                            threatSection.classList.remove('d-none');
                            
                            // Build threats HTML
                            let threatsHTML = '<div class="threats-container">';
                            
                            threats.forEach(threat => {
                                // Severity badge color
                                let severityClass = 'secondary';
                                if (threat.severity_level === 'Critical') severityClass = 'danger';
                                else if (threat.severity_level === 'High') severityClass = 'warning';
                                else if (threat.severity_level === 'Medium') severityClass = 'info';
                                else if (threat.severity_level === 'Low') severityClass = 'success';
                                
                                threatsHTML += `
                                    <div class="card mb-3 border-start border-4 border-${severityClass}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title mb-0">
                                                    <i class="fas fa-shield-virus text-danger me-2"></i>
                                                    ${threat.threat_name}
                                                </h6>
                                                <span class="badge bg-${severityClass}">${threat.severity_level}</span>
                                            </div>
                                            <p class="card-text small mb-2"><strong>Description:</strong> ${threat.threat_description}</p>
                                            <p class="card-text small mb-2"><strong>Vulnerabilities:</strong> ${threat.vulnerabilities}</p>
                                            <p class="card-text small mb-3"><strong>Prevention:</strong> ${threat.prevention_steps}</p>
                                            <button type="button" class="btn btn-sm btn-outline-primary use-threat-btn" 
                                                data-threat="${threat.threat_name}" 
                                                data-vuln="${threat.vulnerabilities}"
                                                data-prevention="${threat.prevention_steps}">
                                                <i class="fas fa-check me-1"></i>Use This Threat
                                            </button>
                                        </div>
                                    </div>
                                `;
                            });
                            
                            threatsHTML += '</div>';
                            threatsList.innerHTML = threatsHTML;
                            
                            // Add click handlers to "Use This Threat" buttons
                            document.querySelectorAll('.use-threat-btn').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    const threatName = this.dataset.threat;
                                    const vulnDesc = this.dataset.vuln;
                                    const prevention = this.dataset.prevention;
                                    
                                    // Auto-fill the form fields
                                    document.getElementById('threat_description').value = threatName;
                                    document.getElementById('vulnerability_description').value = vulnDesc;
                                    document.getElementById('mitigation_plan').value = prevention;
                                    
                                    // Scroll to the form fields
                                    document.getElementById('threat_description').scrollIntoView({ 
                                        behavior: 'smooth', 
                                        block: 'center' 
                                    });
                                    
                                    // Highlight the fields briefly
                                    [document.getElementById('threat_description'), 
                                     document.getElementById('vulnerability_description'),
                                     document.getElementById('mitigation_plan')].forEach(field => {
                                        field.style.backgroundColor = '#d1fae5';
                                        setTimeout(() => {
                                            field.style.backgroundColor = '';
                                        }, 1500);
                                    });
                                    
                                    // Show success message
                                    const alertDiv = document.createElement('div');
                                    alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
                                    alertDiv.innerHTML = `
                                        <i class="fas fa-check-circle me-2"></i>
                                        Threat information has been loaded into the form. Review and adjust the risk scoring below.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    `;
                                    this.closest('.card').after(alertDiv);
                                    
                                    setTimeout(() => {
                                        alertDiv.remove();
                                    }, 5000);
                                });
                            });
                            
                        } else {
                            // No threats found
                            threatSection.classList.add('d-none');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading threats:', error);
                        threatSection.classList.add('d-none');
                    });
            } else {
                // No asset selected, hide threat section
                threatSection.classList.add('d-none');
            }
        });
    </script>
</body>
</html>
