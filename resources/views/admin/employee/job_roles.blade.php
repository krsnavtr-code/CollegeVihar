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
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td style="text-transform: capitalize;">{{ $job_role['job_role_title'] }}</td>
                            <td>
                                <i class="icon fa-solid fa-eye" title="View Details" onclick="view({{ $job_role['id'] }})"></i>
                                <a href="/admin/job_role/edit/{{ $job_role['id'] }}">
                                    <i class="icon fa-solid fa-pencil" title="Edit Details"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
