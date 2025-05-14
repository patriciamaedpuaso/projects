@extends('layouts.org')

@section('content')
<div class="container my-5" style="max-width: 1000px;">
    <h2 class="text-center text-primary fw-bold mb-5">Organization Profile</h2>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <form action="{{ route('org.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            {{-- Left Panel: Profile Summary --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 text-center">
                    <div class="position-relative">
                        <img 
                            id="logoPreview"
                            src="{{ $organization && $organization->logo_path ? asset('storage/' . $organization->logo_path) : asset('images/default-logo.png') }}"
                            class="rounded-circle border border-light shadow-sm"
                            style="width: 160px; height: 160px; object-fit: cover;"
                            alt="Organization Logo"
                        >
                        <label for="logoUpload" class="btn btn-sm btn-outline-secondary mt-3">Change Logo</label>
                        <input type="file" id="logoUpload" name="logo" class="d-none" accept="image/*">
                        @error('logo') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                    </div>

                    <hr class="my-4">

                    <div class="text-muted small">
                        <p class="mb-1"><strong>{{ $organization->organization_name ?? 'Organization Name' }}</strong></p>
                        <p class="mb-1">{{ $organization->organization_type ?? 'Type' }}</p>
                        <p class="mb-0">{{ $organization->email ?? 'Email' }}</p>
                    </div>
                </div>
            </div>

            {{-- Right Panel: Profile Form --}}
            <div class="col-md-8">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold text-secondary mb-4">Edit Profile Details</h5>

                    <div class="mb-3">
                        <label class="form-label">Organization Name</label>
                        <input type="text" name="organization_name" class="form-control" value="{{ old('organization_name', $organization->organization_name ?? '') }}" required>
                        @error('organization_name') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Adviser Name</label>
                        <input type="text" name="adviser_name" class="form-control" value="{{ old('adviser_name', $organization->adviser_name ?? '') }}" required>
                        @error('adviser_name') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Organization Type</label>
                        <select name="organization_type" class="form-select" required>
                            <option value="">-- Select Type --</option>
                            <option value="co-curricular" {{ $organization->organization_type == 'co-curricular' ? 'selected' : '' }}>Co-Curricular</option>
                            <option value="special interest" {{ $organization->organization_type == 'special interest' ? 'selected' : '' }}>Special Interest</option>
                            <option value="mandated" {{ $organization->organization_type == 'mandated' ? 'selected' : '' }}>Mandated</option>
                            <option value="religious" {{ $organization->organization_type == 'religious' ? 'selected' : '' }}>Religious</option>
                        </select>
                        @error('organization_type') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $organization->email ?? '') }}" required>
                        @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $organization->contact_number ?? '') }}">
                        @error('contact_number') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary shadow-sm">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Change Password --}}
    <div class="card border-0 shadow-sm mt-5">
        <div class="card-body p-4">
            <h5 class="fw-bold text-secondary mb-4">Change Password</h5>

            <form action="{{ route('org.profile.password') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                        @error('current_password') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                        @error('new_password') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-warning shadow-sm">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('logoUpload').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (evt) {
                document.getElementById('logoPreview').src = evt.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection
