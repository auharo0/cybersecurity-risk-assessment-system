<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Threat Information - CRAS</title>
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
        }
        .logo-header {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .logo-header img {
            width: 70px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }
        .form-card {
            background: rgba(30, 41, 59, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            margin-bottom: 2rem;
        }
        .form-label {
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .form-label i {
            color: #a5b4fc;
        }
        .form-control, .form-select {
            background: rgba(15, 23, 42, 0.7);
            border: 2px solid rgba(148, 163, 184, 0.3);
            border-radius: 10px;
            padding: 0.875rem 1rem;
            color: #f1f5f9;
            transition: all 0.3s ease;
        }
        .form-control::placeholder {
            color: #94a3b8;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(15, 23, 42, 0.9);
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
            color: #f1f5f9;
        }
        .form-select option {
            background: #1e293b;
            color: #f1f5f9;
        }
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        .btn-submit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.0625rem;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        .btn-cancel {
            background: rgba(148, 163, 184, 0.2);
            color: #cbd5e1;
            border: 2px solid rgba(148, 163, 184, 0.3);
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .btn-cancel:hover {
            background: rgba(148, 163, 184, 0.3);
            color: #f1f5f9;
        }
        .help-text {
            color: #94a3b8;
            font-size: 0.875rem;
            margin-top: 0.375rem;
        }
        .severity-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 0.75rem;
        }
        .severity-option {
            position: relative;
        }
        .severity-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        .severity-label {
            display: block;
            padding: 1rem;
            border-radius: 10px;
            border: 2px solid rgba(148, 163, 184, 0.3);
            text-align: center;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .severity-option input[type="radio"]:checked + .severity-label {
            border-width: 3px;
            transform: scale(1.05);
        }
        .severity-label.low {
            color: #10b981;
        }
        .severity-option input[type="radio"]:checked + .severity-label.low {
            background: rgba(16, 185, 129, 0.2);
            border-color: #10b981;
        }
        .severity-label.medium {
            color: #fbbf24;
        }
        .severity-option input[type="radio"]:checked + .severity-label.medium {
            background: rgba(251, 191, 36, 0.2);
            border-color: #fbbf24;
        }
        .severity-label.high {
            color: #f59e0b;
        }
        .severity-option input[type="radio"]:checked + .severity-label.high {
            background: rgba(245, 158, 11, 0.2);
            border-color: #f59e0b;
        }
        .severity-label.critical {
            color: #ef4444;
        }
        .severity-option input[type="radio"]:checked + .severity-label.critical {
            background: rgba(239, 68, 68, 0.2);
            border-color: #ef4444;
        }
        .invalid-feedback {
            color: #fca5a5;
            font-size: 0.875rem;
            margin-top: 0.375rem;
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="logo-header">
                <img src="{{ asset('logo/ChatGPT Image Jul 6, 2026, 03_34_47 PM.png') }}" alt="CRAS Logo">
                <div>
                    <h1 class="mb-0 h2 fw-bold">
                        <i class="fas fa-file-import me-2"></i>Import Threat Information
                    </h1>
                    <p class="mb-0 opacity-90">Add threat, vulnerability, and prevention information for an asset</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-card">
                    <form action="{{ route('threat_library.store') }}" method="POST">
                        @csrf

                        <!-- Asset Selection -->
                        <div class="mb-4">
                            <label for="asset_id" class="form-label">
                                <i class="fas fa-server"></i>Select Asset
                            </label>
                            <select name="asset_id" id="asset_id" class="form-select @error('asset_id') is-invalid @enderror" required>
                                <option value="">Choose an asset...</option>
                                @foreach($assets as $asset)
                                    <option value="{{ $asset->asset_id }}" {{ old('asset_id') == $asset->asset_id ? 'selected' : '' }}>
                                        {{ $asset->asset_name }} ({{ $asset->asset_type }})
                                    </option>
                                @endforeach
                            </select>
                            @error('asset_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="help-text">Select the asset this threat information applies to</div>
                        </div>

                        <!-- Threat Name -->
                        <div class="mb-4">
                            <label for="threat_name" class="form-label">
                                <i class="fas fa-shield-virus"></i>Threat Name
                            </label>
                            <input type="text" name="threat_name" id="threat_name" class="form-control @error('threat_name') is-invalid @enderror" value="{{ old('threat_name') }}" placeholder="e.g., SQL Injection Attack" required>
                            @error('threat_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="help-text">Provide a clear name for this threat</div>
                        </div>

                        <!-- Threat Description -->
                        <div class="mb-4">
                            <label for="threat_description" class="form-label">
                                <i class="fas fa-info-circle"></i>Threat Description
                            </label>
                            <textarea name="threat_description" id="threat_description" class="form-control @error('threat_description') is-invalid @enderror" placeholder="Describe the threat in detail..." required>{{ old('threat_description') }}</textarea>
                            @error('threat_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="help-text">Explain what this threat is and how it works</div>
                        </div>

                        <!-- Vulnerabilities -->
                        <div class="mb-4">
                            <label for="vulnerabilities" class="form-label">
                                <i class="fas fa-bug"></i>Vulnerabilities
                            </label>
                            <textarea name="vulnerabilities" id="vulnerabilities" class="form-control @error('vulnerabilities') is-invalid @enderror" placeholder="List the specific vulnerabilities that make this threat possible..." required>{{ old('vulnerabilities') }}</textarea>
                            @error('vulnerabilities')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="help-text">Describe the weaknesses that could be exploited</div>
                        </div>

                        <!-- Prevention Steps -->
                        <div class="mb-4">
                            <label for="prevention_steps" class="form-label">
                                <i class="fas fa-shield-alt"></i>Prevention & Mitigation Steps
                            </label>
                            <textarea name="prevention_steps" id="prevention_steps" class="form-control @error('prevention_steps') is-invalid @enderror" placeholder="Provide step-by-step instructions on how to prevent or mitigate this threat..." required>{{ old('prevention_steps') }}</textarea>
                            @error('prevention_steps')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="help-text">Include specific actions to avoid or minimize this threat</div>
                        </div>

                        <!-- Severity Level -->
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-exclamation-triangle"></i>Severity Level
                            </label>
                            <div class="severity-selector">
                                <div class="severity-option">
                                    <input type="radio" name="severity_level" id="low" value="Low" {{ old('severity_level') == 'Low' ? 'checked' : '' }}>
                                    <label for="low" class="severity-label low">
                                        <i class="fas fa-check-circle mb-2 d-block"></i>
                                        Low
                                    </label>
                                </div>
                                <div class="severity-option">
                                    <input type="radio" name="severity_level" id="medium" value="Medium" {{ old('severity_level') == 'Medium' || old('severity_level') == '' ? 'checked' : '' }}>
                                    <label for="medium" class="severity-label medium">
                                        <i class="fas fa-info-circle mb-2 d-block"></i>
                                        Medium
                                    </label>
                                </div>
                                <div class="severity-option">
                                    <input type="radio" name="severity_level" id="high" value="High" {{ old('severity_level') == 'High' ? 'checked' : '' }}>
                                    <label for="high" class="severity-label high">
                                        <i class="fas fa-exclamation-circle mb-2 d-block"></i>
                                        High
                                    </label>
                                </div>
                                <div class="severity-option">
                                    <input type="radio" name="severity_level" id="critical" value="Critical" {{ old('severity_level') == 'Critical' ? 'checked' : '' }}>
                                    <label for="critical" class="severity-label critical">
                                        <i class="fas fa-exclamation-triangle mb-2 d-block"></i>
                                        Critical
                                    </label>
                                </div>
                            </div>
                            @error('severity_level')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="help-text">Select the severity level of this threat</div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-3 justify-content-end mt-5">
                            <a href="{{ route('threat_library.index') }}" class="btn btn-cancel">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-save me-2"></i>Import Threat Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
