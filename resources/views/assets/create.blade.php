<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Asset - CRAS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Include the Navbar Partial -->
    @include('partials.navbar')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-top border-primary border-4">
                    <div class="card-header bg-white">
                        <h4 class="mb-0 mt-2">Register New Asset</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('assets.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="session_id" class="form-label fw-bold">Assessment Session</label>
                                <select name="session_id" id="session_id" class="form-select @error('session_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select a session...</option>
                                    @foreach($assessmentSessions as $session)
                                        <option value="{{ $session->session_id }}" {{ old('session_id') == $session->session_id ? 'selected' : '' }}>
                                            {{ $session->session_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('session_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="asset_name" class="form-label fw-bold">Asset Name</label>
                                <input type="text" name="asset_name" id="asset_name" class="form-control @error('asset_name') is-invalid @enderror" value="{{ old('asset_name') }}" placeholder="e.g., Main POS Register 1" required>
                                @error('asset_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="asset_type" class="form-label fw-bold">Asset Type</label>
                                <select name="asset_type" id="asset_type" class="form-select @error('asset_type') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select a type...</option>
                                    <option value="Hardware" {{ old('asset_type') == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                                    <option value="Software" {{ old('asset_type') == 'Software' ? 'selected' : '' }}>Software</option>
                                    <option value="Database" {{ old('asset_type') == 'Database' ? 'selected' : '' }}>Database</option>
                                    <option value="Cloud Service" {{ old('asset_type') == 'Cloud Service' ? 'selected' : '' }}>Cloud Service</option>
                                </select>
                                @error('asset_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold">Description (Optional)</label>
                                <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('assets.index') }}" class="btn btn-light border">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Asset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script></body>
</html>