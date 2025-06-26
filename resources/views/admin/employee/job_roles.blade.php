@extends('admin.components.layout')

@section('main')
<main class="container my-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">View Job Roles</h5>
            <p class="text-muted mb-4 text-center">View all job roles here and manage them</p>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center">Sr. No.</th>
                            <th scope="col">Job Role</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($job_roles as $i => $job_role)
                            <tr class="text-capitalize">
                                <td class="text-center fw-semibold">{{ $i + 1 }}</td>
                                <td>{{ $job_role['job_role_title'] }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-primary" onclick="view( $job_role['id'])" title="View Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <a href="/admin/job_role/edit/{{ $job_role['id'] }}" class="btn btn-sm btn-outline-success" title="Edit Details">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No job roles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
