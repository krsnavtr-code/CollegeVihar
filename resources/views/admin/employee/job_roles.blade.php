@extends('admin.components.layout')
@section('main')
    <main>
        <h2 class="page_title">View Job Roles</h2>
        <div class="panel">
            <table>
                <thead>
                    <tr>
                        <th>Sr.No.</th>
                        <th>Job Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($job_roles as $i => $job_role)
                        <tr class="align-middle text-capitalize">
                            <td class="text-center fw-bold">{{ $i + 1 }}</td>
                            <td class="text-capitalize">{{ $job_role['job_role_title'] }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" onclick="view({{ $job_role['id'] }})" title="View Details">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <a href="/admin/job_role/edit/{{ $job_role['id'] }}" class="btn btn-sm btn-outline-success"
                                    title="Edit Details">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
