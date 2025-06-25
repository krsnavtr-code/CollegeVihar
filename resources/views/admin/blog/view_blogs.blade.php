@extends('admin.components.layout')

@section('title', 'Manage Blogs - CV Admin')

@push('css')
<style>
    .clamp-2 {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        white-space: wrap;
    }
</style>
</style>
@endpush
@section('main')
<main>
    <section>
        <h1 class="page_title">View Blog</h1>
        <p class="mb-4">All Blogs Written by our team</p>
        <div class="overflow-auto text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $i => $blog)
                    <tr>
                        <td>{{ $i + 1 }}.</td>
                        <td class="text-primary">{{ $blog['blog_author'] }}</td>
                        <td>
                            <h6 class="clamp-2">{{ $blog['blog_title'] }}</h6>
                        <td>
                            <p class="text-sm text-secondary clamp-2">
                                {{ strip_tags($blog['blog_content']) }}
                            </p>
                        </td>
                        <td>
                            <img src="{{ url('images/blogs/' . $blog['blog_pic']) }}" alt="blog image" class="img-fluid" width="100">
                        </td>
                        <td>
                            <a class="btn btn-light blue rounded-circle" href="">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection