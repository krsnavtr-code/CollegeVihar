@php
$permissions = Request::get('admin_permissions');
@endphp

@extends('admin.components.layout')
@section('main')
<main>

    <h2 class="page_title">View University</h2>
    <!-- Search University -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ request()->url() }}" method="GET" class="mb-0">
                <div class="row g-3 align-items-center">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="search" 
                                   name="search" 
                                   placeholder="Search by university name, type, or category..." 
                                   class="form-control" 
                                   value="{{ request('search') }}"
                                   aria-label="Search universities">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-2">
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
                </div>
            </form>
        </div>
    </div>
    
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>University</th>
                    <th>Courses</th>
                    @if ( $permissions[0] == '*') <th>Status</th> @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($universities as $i => $university)
                <tr @class(['disable' => !$university['univ_status']])>
                    <td>
                        {{ ($universities->currentPage() - 1) * $universities->perPage() + $i + 1 }}
                        @if (!$university['univ_detail_added'])
                        <i class="fa-solid fa-triangle-exclamation text-warning"
                            title="University details are not uploaded"></i>
                        @endif
                        @if (!$university['univ_status'])
                        <i class="fa-solid fa-circle-xmark text-danger"
                            title="University is not activated"></i>
                        @endif
                    </td>
                    <td>{{ ucwords(strtolower($university['univ_name'])) }}</td>
                    <td>
                        <a href="/admin/university/courses/{{ $university['id'] }}"
                            class="btn btn-light">
                            {{ count($university['courses']) }} Courses
                        </a>
                    </td>
                    @if ( $permissions[0] == '*')
                        <td @class(['disable' => !$university['univ_status']])>                      
                            <button class="disable_btn btn btn-secondary" title="University is disabled">Disable</button>
                            <button class="active_btn btn btn-success" title="University is active">Active</button>                          
                        </td>
                    @endif
                    <td>
                        @if (in_array(3, $permissions) || $permissions[0] == '*')
                        <a href="/admin/university/edit/{{ $university['id'] }}" title="Edit University"
                            class="btn btn-light rounded-circle">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        @endif
                        {{-- Add University Details --}}
                        @if ((in_array(4, $permissions) || $permissions[0] == '*') && !$university['univ_detail_added'])
                        <a href="/admin/university/add/details/{{ $university['id'] }}"
                            title="Add University Details">
                            <i class="fa-solid fa-plus"></i>
                            {{-- <i class="fa-solid fa-pencil"></i> --}}
                        </a>
                        @endif
                        @if ((in_array(15, $permissions) || $permissions[0] == '*') && $university['univ_detail_added'])
                        <a href="/admin/university/edit/details/{{ $university['id'] }}" title="Edit University Details"
                            class="btn btn-light rounded-circle">
                            <i class="fa-solid fa-pen-fancy"></i>
                        </a>
                        @endif
                        @if ((in_array(18, $permissions) || $permissions[0] == '*') && $university['univ_detail_added'])
                        <a href="/admin/web_pages/edit/{{$university['univ_slug']}}"
                            class="btn btn-primary">
                            SEO 
                        </a>
                        <button class="btn btn-success rounded-circle">
                            <i class="fa-solid fa-file-arrow-up"></i>
                        </button>
                        @endif
                        @if ( in_array(19, $permissions) || $permissions[0] == '*')
                        <!-- Check permission for delete -->
                        <form action="/admin/university/delete/{{ $university['id'] }}" method="GET" style="display:inline;">
                            @csrf
                            <button type="submit" title="Delete University" onclick="return confirm('Are you sure you want to delete this university?')"
                                class="btn btn-danger rounded-circle">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- pagination --}}
    <x-pagination :paginator="$universities" />
</main>
@push('script')
<script>
    function switch_status(node, univId) {
        ajax({
            url: "/api/university/status/" + univId,
            success: (res) => {
                res = JSON.parse(res);
                if (res.success) {
                    node.closest("tr").toggleClass("disable");
                }
            }
        });
    }
</script>
@endpush
@endsection
