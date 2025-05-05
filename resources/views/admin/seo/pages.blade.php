@php
$permissions = Request::get('admin_permissions');
@endphp
@extends('admin.components.layout')
@section('main')
<main>
    <h2 class="page_title">View University</h2>
    <form method="GET" action="/admin/web_pages" class="mb-3 d-flex" style="max-width: 800px;">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search by page URL">
        <button type="submit" class="btn btn-primary" style="margin: 0.6rem;">Search</button>
    </form>
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead class="text-center">
                <tr>
                    <th>Sr.No.</th>
                    <th>Pages</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $i => $page)
                <tr>
                    <td>{{ $i + 1 }}.</td>
                    <td>{{ $page['url_slug'] }}</td>
                    <td>
                        <a class="btn btn-success rounded-circle" href="/{{ $page['url_slug'] }}" target="_blank" title="Visit this page">
                            <i class="icon fa-solid fa-eye"></i>
                        </a>
                        <a class="btn btn-primary rounded-circle" href="/admin/web_pages/edit/{{ $page['id'] }}" title="Edit this page">
                            <i class="icon fa-solid fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- pagination -->
    @if ($com['last_page'] > 1)
    <nav aria-label="Page navigation" class="d-flex justify-content-center mt-3">
        <ul class="pagination" style="display: flex; flex-wrap: wrap; justify-content: center;">
            <!-- Previous Page Link -->
            <li class="page-item {{ $com['current_page'] == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="/admin/web_pages?page={{ $com['current_page'] - 1 }}{{ request('search') ? '&search='.request('search') : '' }}">Previous</a>
            </li>

            <!-- Page Number Links -->
            @for ($i = 1; $i <= $com['last_page']; $i++)
                <li class="page-item {{ $com['current_page'] == $i ? 'active' : '' }}">
                <a class="page-link" href="/admin/web_pages?page={{ $i }}{{ request('search') ? '&search='.request('search') : '' }}">
                    {{ $i }}
                </a>
                </li>
            @endfor

            <!-- Next Page Link -->
            <li class="page-item {{ $com['current_page'] == $com['last_page'] ? 'disabled' : '' }}">
                <a class="page-link" href="/admin/web_pages?page={{ $com['current_page'] + 1 }}{{ request('search') ? '&search='.request('search') : '' }}">Next</a>
            </li>
        </ul>
    </nav>
    @endif

</main>
@push('script')
<script>
    function switch_status(node, univId) {
        ajax({
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