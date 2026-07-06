<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Include the Navbar Partial -->
    @include('partials.navbar')
<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header">
                    <h3>Edit User</h3>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Name</label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $user->name) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email', $user->email) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>

                            <select name="role" class="form-select" required>

                                <option value="administrator"
                                    {{ old('role', $user->role) == 'administrator' ? 'selected' : '' }}>
                                    Administrator
                                </option>

                                <option value="it_security_analyst"
                                    {{ old('role', $user->role) == 'it_security_analyst' ? 'selected' : '' }}>
                                    IT Security Analyst
                                </option>

                                <option value="organization_manager"
                                    {{ old('role', $user->role) == 'organization_manager' ? 'selected' : '' }}>
                                    Organization Manager
                                </option>

                            </select>
                        </div>

                        <hr>

                        {{-- <p class="text-muted">
                            Leave the password fields blank if you don't want to change the password.
                        </p>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control">
                        </div> --}}

                        <div class="d-flex justify-content-between">

                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                Back
                            </a>

                            <button type="submit" class="btn btn-success">
                                Update User
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>