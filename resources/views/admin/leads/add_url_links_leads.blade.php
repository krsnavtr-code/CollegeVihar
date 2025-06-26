@extends('admin.components.layout')

@section('main')
<main class="container py-4">
    @include('admin.components.response')

    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center mb-3">
            <i class="fa-solid fa-check me-2"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center mb-3">
            <i class="fa-solid fa-bug me-2"></i> {{ session('error') }}
        </div>
    @endif

    <form action="/admin/lead/create-add-url-links" method="POST">
        @csrf

        <h2 class="mb-3">Add URL Links Leads</h2>

        <!-- Agent Info -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Agent Name</label>
                    <input type="text" class="form-control" name="agent_name" placeholder="Agent Name" required>
                </div>
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="mb-3">Social Media Links</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Social Media Link 1</label>
                        <input type="url" class="form-control" name="social_media_1" placeholder="https://..." required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Social Media Link 2</label>
                        <input type="url" class="form-control" name="social_media_2" placeholder="https://..." required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Social Media Link 3</label>
                        <input type="url" class="form-control" name="social_media_3" placeholder="https://..." required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Social Media Link 4</label>
                        <input type="url" class="form-control" name="social_media_4" placeholder="https://..." required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Job Opening Link</label>
                        <input type="url" class="form-control" name="job_opening" placeholder="https://..." required>
                    </div>
                </div>
            </div>
        </div>

        <!-- LinkedIn Links -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="mb-3">LinkedIn Profiles</h5>
                @for ($i = 1; $i <= 5; $i++)
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">LinkedIn Profile Link {{ $i * 2 - 1 }}</label>
                            <input type="url" class="form-control" name="linkedin_profile_{{ $i * 2 - 1 }}" placeholder="https://..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">LinkedIn Profile Link {{ $i * 2 }}</label>
                            <input type="url" class="form-control" name="linkedin_profile_{{ $i * 2 }}" placeholder="https://..." required>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Submit -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-upload me-1"></i> Add Lead
            </button>
        </div>
    </form>
</main>
@endsection
