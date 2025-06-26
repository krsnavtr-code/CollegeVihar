@extends('admin.components.layout')

@section('main')
<main class="container my-4">
    @include('admin.components.response')

    <form action="/admin/job_role/edit" method="POST">
        @csrf

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-2">Edit Job Role</h5>
                <p class="text-muted text-center mb-3">
                    Now editing <b class="text-primary">{{ $job_role['job_role_title'] }}</b> job role
                </p>

                <input type="hidden" name="job_id" value="{{ $job_role['id'] }}">

                <div class="mb-4">
                    <label for="a" class="form-label">Job Role Title</label>
                    <input type="text" id="a" class="form-control-plaintext" readonly value="{{ $job_role['job_role_title'] }}">
                </div>

                @php
                    $permissions = json_decode($job_role['permissions']);
                @endphp

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label mb-0">Assign Permissions</label>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="togglePermissions(this)">
                            Select All
                        </button>
                    </div>
                    <p class="text-muted small">Click checkboxes below to assign or remove permissions.</p>

                    <div class="row mt-3">
                        @foreach ($pages as $i => $page)
                            <div class="col-md-4 col-lg-3 mb-2">
                                <div class="form-check custom-permission-check">
                                    <input 
                                        class="form-check-input permission-checkbox" 
                                        type="checkbox" 
                                        name="job_role_permissions[]" 
                                        value="{{ $page['id'] }}" 
                                        id="f{{ $i }}"
                                        @if (in_array($page['id'], $permissions) || ($permissions && $permissions[0] == '*')) checked @endif
                                    >
                                    <label class="form-check-label rounded px-2 py-1" for="f{{ $i }}">
                                        {{ $page['admin_page_title'] }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Update Role
                    </button>
                </div>
            </div>
        </div>
    </form>
</main>

@push('style')
<style>
    .custom-permission-check .form-check-label {
        cursor: pointer;
        display: inline-block;
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
        border: 1px solid #dee2e6;
    }
    .custom-permission-check .form-check-label:hover {
        background-color: #e2e6ea;
    }
    .form-check-input:checked + .form-check-label {
        background-color: #cfe2ff;
        border-color: #9ec5fe;
    }
</style>
@endpush

@push('script')
<script>
    function togglePermissions(btn) {
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        const allChecked = [...checkboxes].every(checkbox => checkbox.checked);

        checkboxes.forEach(cb => cb.checked = !allChecked);
        btn.textContent = allChecked ? 'Select All' : 'Deselect All';
    }
</script>
@endpush
@endsection
