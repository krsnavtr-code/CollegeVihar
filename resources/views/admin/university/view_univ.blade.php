@php
$permissions = Request::get('admin_permissions');
@endphp

@extends('admin.components.layout')
@section('title', 'View Universities - CV Admin')

@section('main')
<main>
    <h5 class="page_title mb-4">View all Universities</h5>
    <h6 class="section_title text-center">Here are all universities added in the <b class="text-primary">College Vihar</b></h6>
    <!-- Search -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-md-9">
                        <input type="search" name="search" class="form-control" placeholder="Search by university name, type, or category..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 d-flex justify-content-end gap-2">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa-solid fa-search me-1"></i> Search
                        </button>
                        @if(request('search'))
                        <a href="{{ request()->url() }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-rotate-left me-1"></i> Reset
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- University Table -->
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-sm table-bordered table-hover align-middle text-nowrap">
            <thead class="table-light">
                <tr>
                    <th width="60" class="text-center">Sr.No.</th>
                    <th>University</th>
                    <th>Courses</th>
                    @if (in_array(16, $permissions) || $permissions[0] == '*') <th>Status</th> @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($universities as $i => $university)
                <tr @class(['table-danger' => !$university['univ_status']])>
                    <td class="text-center">
                        {{ ($universities->currentPage() - 1) * $universities->perPage() + $i + 1 }}
                        @if (!$university['univ_detail_added'])
                        <span class="badge bg-warning" title="Details not uploaded">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </span>
                        @endif
                        @if (!$university['univ_status'])
                        <span class="badge bg-danger" title="University is not active">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </span>
                        @endif
                    </td>
                    <td>{{ ucwords(strtolower($university['univ_name'])) }}</td>
                    <td>
                        <a href="/admin/university/courses/{{ $university['id'] }}" class="btn btn-outline-primary btn-sm">
                            {{ count($university['courses']) }} Courses
                        </a>
                    </td>
                    @if (in_array(16, $permissions) || $permissions[0] == '*')
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input rounded" type="checkbox" {{ $university['univ_status'] ? 'checked' : '' }}
                                onclick="switch_status(this,  $university['id'])">
                            <label class="form-check-label rounded px-2 ms-2">{{ $university['univ_status'] ? 'Active' : 'Disabled' }}</label>
                        </div>
                    </td>
                    @endif
                    <td>
                        <div class="d-flex flex-wrap gap-2 ">
                            @if (in_array(3, $permissions) || $permissions[0] == '*')
                            <a href="/admin/university/edit/{{ $university['id'] }}" class="btn btn-light btn-sm" title="Edit">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            @endif

                            @if ((in_array(4, $permissions) || $permissions[0] == '*') && !$university['univ_detail_added'])
                            <a href="/admin/university/add/details/{{ $university['id'] }}" class="btn btn-outline-success btn-sm" title="Add Details">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                            @endif

                            @if ((in_array(15, $permissions) || $permissions[0] == '*') && $university['univ_detail_added'])
                            <a href="/admin/university/add/details/{{ $university['id'] }}" class="btn btn-info btn-sm" title="Edit Details">
                                <i class="fa-solid fa-pen-fancy"></i>
                            </a>
                            @endif

                            @if ((in_array(18, $permissions) || $permissions[0] == '*') && $university['univ_detail_added'])
                            <a href="/admin/web_pages/edit/{{$university['univ_slug']}}" class="btn btn-primary btn-sm" title="SEO">
                                SEO
                            </a>
                            <button class="btn btn-success btn-sm" title="Upload File">
                                <i class="fa-solid fa-file-arrow-up"></i>
                            </button>
                            @endif

                            @if (in_array(19, $permissions) || $permissions[0] == '*')
                            <form action="/admin/university/delete/{{ $university['id'] }}" method="GET" onsubmit="return confirm('Are you sure?')" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <x-pagination :paginator="$universities" />

</main>

@push('script')
<script>
    function switch_status(node, univId) {
        fetch(`/api/university/status/${univId}`)
            .then(response => response.json())
            .then(res => {
                if (res.success) {
                    node.closest("tr").classList.toggle("table-danger");
                }
            });
    }
</script>
@endpush
@endsection
