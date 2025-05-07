@extends('user.components.layout')
@push('css')
<style>
    .sidebar {
        position: sticky;
        top: 15%;
    }

    .side-card {
        display: flex;
        gap: 1rem;
        max-height: 100px;
        overflow: hidden;

    }

    .title {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        color: var(--blue);
    }

    .blog-card {
        height: 300px;
        position: relative;

    }
</style>
@endpush
@section('main')
<main>
    <section class="container">
        <div class="row">
            <div class="col-lg-9 col-sm-8 p-2">
                <img src="{{url('images/blogs/' . $blog['blog_pic'])}}"
                    alt="Blog Image"   onerror="this.onerror=null; this.src='{{ url('images/blogs/blog.png') }}';" class="img-fluid rounded" />
                <div class="blog">
                    <h1 class="display-6">{{ $blog['blog_title'] }}</h1>
                    <div class="blog_content">
                        {!! $blog['blog_content'] !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 p-3">
                <aside class="sidebar">
                    @if ($recent)
                    @foreach ($recent as $reb)
                    <div class="card mb-2">
                        <a class="side-card" href="{{ url($reb['metadata']['url_slug']) }}">
                            <img class="img-fluid rounded" src="{{ url('images/blogs/' . $reb['blog_pic']) }}"
                                onerror="this.onerror=null; this.src='{{ url('images/blogs/blog.png') }}';"
                                alt="blog_image" width="100">
                            <div class="">
                                <h6 class="blue title">{{ $reb['blog_title'] }} </h6>
                                <p>{{ $reb['blog_author'] }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    @endif
                </aside>
            </div>

        </div>
    </section>
    {{-- <div class="cart_layout">
        <div class="main_content">
            <div class="blog_image">
                <img src="{{ url('images/blogs/' . $blog['blog_pic']) }}" alt="blog_image" onerror="this.onerror=null; this.src='{{ url('images/blogs/blog.png') }}';">
    </div>
    <div class="blog">
        <h1 class="blog_title">{{ $blog['blog_title'] }}</h1>
        <div class="blog_content">
            {!! $blog['blog_content'] !!}
        </div>
    </div>
    </div>
    <div class="side_content">
        @if ($recent)
        <div class="panel">
            @foreach ($recent as $rcb)
            <a class="blog_mini" href="{{ url($rcb['metadata']['url_slug']) }}">
                <div class="blog_img"><img src="{{ url('images/blogs/' . $rcb['blog_pic']) }}"
                        alt="blog_image" onerror="this.onerror=null; this.src='{{ url('images/blogs/blog.png') }}';">
                </div>
                <div class="blog_desc">
                    <h6 class="blog_title">{{ $rcb['blog_title'] }}</h6>
                    <p>{{ $rcb['blog_author'] }}</p>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
    </div> --}}
</main>
@endsection