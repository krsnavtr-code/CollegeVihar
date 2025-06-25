@php
$permissions = Request::get('admin_permissions');
@endphp
@extends('admin.components.layout')
@section('main')
<main>
    <h5 class="page_title">View all Web Pages <span class="badge bg-primary">Total: {{ $com['total'] ?? count($pages) }}</span></h5>
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
                        <button class="btn btn-danger rounded-circle delete-page-btn" 
                                data-page-id="{{ $page['id'] }}" 
                                title="Delete this page">
                            <i class="icon fa-solid fa-trash"></i>
                        </button>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Add click event listeners to all delete buttons
        document.querySelectorAll('.delete-page-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const pageId = this.getAttribute('data-page-id');
                const button = this;
                
                if (confirm('Are you sure you want to delete this page? This action cannot be undone.')) {
                    const deleteUrl = new URL('{{ url('/admin/web_pages/delete') }}/' + pageId, window.location.origin);
                    fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            button.closest('tr').remove();
                            alert('Page deleted successfully');
                        } else {
                            alert('Error deleting page: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the page');
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection