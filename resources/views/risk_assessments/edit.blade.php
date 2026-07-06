<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Risk Assessment - CRAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    @include('partials.navbar')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold text-dark mb-0">Edit Threat Log Metrics</h2>
                        <p class="text-muted small mb-0">Adjust exploit severities, update validation vectors, and track mitigation lifecycle progress.</p>
                    </div>
                    <a href="{{ route('assessment_sessions.show', $riskAssessment->session_id) }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Session
                    </a>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="{{ route('risk_assessments.update', $riskAssessment->assessment_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="asset_id" class="form-label fw-bold">Target Asset Node</label>
                                    <select class="form-select @error('asset_id') is-invalid @enderror" id="asset_id" name="asset_id">
                                        @foreach($assets as $asset)
                                            <option value="{{ $asset->asset_id }}" {{ old('asset_id', $riskAssessment->asset_id) == $asset->asset_id ? 'selected' : '' }}>
                                                {{ $asset->asset_name }} [{{ $asset->asset_type }}]
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('asset_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="cve_reference" class="form-label fw-bold">CVE Reference (Optional)</label>
                                    <input type="text" class="form-control font-monospace @error('cve_reference') is-invalid @enderror" id="cve_reference" name="cve_reference" placeholder="e.g., CVE-2026-XXXX" value="{{ old('cve_reference', $riskAssessment->cve_reference) }}">
                                    @error('cve_reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="threat_description" class="form-label fw-bold text-danger">Threat Profile Description</label>
                                <textarea class="form-control @error('threat_description') is-invalid @enderror" id="threat_description" name="threat_description" rows="3">{{ old('threat_description', $riskAssessment->threat_description) }}</textarea>
                                @error('threat_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="vulnerability_description" class="form-label fw-bold text-warning">Identified System Vulnerability</label>
                                <textarea class="form-control @error('vulnerability_description') is-invalid @enderror" id="vulnerability_description" name="vulnerability_description" rows="3">{{ old('vulnerability_description', $riskAssessment->vulnerability_description) }}</textarea>
                                @error('vulnerability_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="likelihood" class="form-label fw-bold">Exploit Likelihood</label>
                                    <select class="form-select @error('likelihood') is-invalid @enderror" id="likelihood" name="likelihood">
                                        <option value="1" {{ old('likelihood', $riskAssessment->likelihood) == 1 ? 'selected' : '' }}>1 - Low</option>
                                        <option value="2" {{ old('likelihood', $riskAssessment->likelihood) == 2 ? 'selected' : '' }}>2 - Medium</option>
                                        <option value="3" {{ old('likelihood', $riskAssessment->likelihood) == 3 ? 'selected' : '' }}>3 - High</option>
                                    </select>
                                    @error('likelihood')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="impact" class="form-label fw-bold">Business Impact Severity</label>
                                    <select class="form-select @error('impact') is-invalid @enderror" id="impact" name="impact">
                                        <option value="1" {{ old('impact', $riskAssessment->impact) == 1 ? 'selected' : '' }}>1 - Low Impact</option>
                                        <option value="2" {{ old('impact', $riskAssessment->impact) == 2 ? 'selected' : '' }}>2 - Moderate Impact</option>
                                        <option value="3" {{ old('impact', $riskAssessment->impact) == 3 ? 'selected' : '' }}>3 - Critical Impact</option>
                                    </select>
                                    @error('impact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label fw-bold">Remediation Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="Open" {{ old('status', $riskAssessment->status) === 'Open' ? 'selected' : '' }}>Open</option>
                                        <option value="In Progress" {{ old('status', $riskAssessment->status) === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="Resolved" {{ old('status', $riskAssessment->status) === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="Accepted" {{ old('status', $riskAssessment->status) === 'Accepted' ? 'selected' : '' }}>Risk Accepted</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="mitigation_plan" class="form-label fw-bold text-success">Countermeasure & Mitigation Roadmap</label>
                                <textarea class="form-control @error('mitigation_plan') is-invalid @enderror" id="mitigation_plan" name="mitigation_plan" rows="4" placeholder="Detail standard operational procedures applied or planned to isolate/patch this vulnerability...">{{ old('mitigation_plan', $riskAssessment->mitigation_plan) }}</textarea>
                                @error('mitigation_plan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="border-top pt-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
                                    <i class="fa-solid fa-square-check me-1"></i> Update Assessment Matrix
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>