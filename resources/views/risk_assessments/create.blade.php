<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluate Risk - CRAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

                            <!-- Threat & Vulnerability -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">2. Identify Vulnerabilities</label>
                                <input type="text" name="threat_description" class="form-control mb-2" placeholder="Describe the Threat (e.g., Malware Infection)" required>
                                <input type="text" name="vulnerability_description" class="form-control mb-2" placeholder="Describe the Vulnerability (e.g., Outdated Antivirus)" required>
                                <input type="text" name="cve_reference" class="form-control" placeholder="CVE Reference ID (Optional - e.g., CVE-2024-123)">
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
                                <textarea name="mitigation_plan" class="form-control" rows="2" placeholder="How do you plan to fix this? (Optional)"></textarea>
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
    </script>
</body>
</html>