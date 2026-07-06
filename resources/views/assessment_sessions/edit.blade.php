<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Session - CRAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    @include('partials.navbar')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold text-dark mb-0">Modify Audit Session</h2>
                        <p class="text-muted small mb-0">Update execution parameters, management timelines, and milestone tracking states.</p>
                    </div>
                    <a href="{{ route('assessment_sessions.show', $assessmentSession->session_id) }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i> Cancel
                    </a>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="{{ route('assessment_sessions.update', $assessmentSession->session_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="session_name" class="form-label fw-bold">Session Name</label>
                                <input type="text" class="form-control @error('session_name') is-invalid @enderror" id="session_name" name="session_name" value="{{ old('session_name', $assessmentSession->session_name) }}">
                                @error('session_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label fw-bold">Start Date</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($assessmentSession->start_date)->format('Y-m-d')) }}">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label fw-bold">End Date (Optional)</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ $assessmentSession->end_date ? \Carbon\Carbon::parse($assessmentSession->end_date)->format('Y-m-d') : '' }}">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="status" class="form-label fw-bold">Operational Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="Ongoing" {{ old('status', $assessmentSession->status) === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="Completed" {{ old('status', $assessmentSession->status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Archived" {{ old('status', $assessmentSession->status) === 'Archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="border-top pt-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
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