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
            /* height: 300px; */
            /* position: relative; */
        }

        .blog-card {
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ddd;
            /* Default color (overwrite hoga JS se) */
        }

        .blog-card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            display: block;
        }
    </style>
@endpush
@section('main')
    <main>
        <section class="container-fluid">
            <div class="row">
                <div class="col-lg-9 col-sm-8 p-2">
                    <div class="row">
                        @foreach ($blogs as $blog)
                            <div class="col-lg-4 col-md-4 col-6 p-2">
                                <a class="card blog-card" href="{{ url($blog['metadata']['url_slug']) }}">
                                    <img src="{{url('images/blogs/' . $blog['blog_pic'])}}" alt="Blog Image"
                                        onerror="this.onerror=null; this.src='{{ url('images/blogs/blog.png') }}';">
                                    <div class="p-2 text-box">
                                        <h6>{{ $blog['blog_author'] }}</h6>
                                        <h6 class="title">{{ $blog['blog_title'] }}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4 p-3">
                    <aside class="sidebar">
                        @if ($recent)
                            @foreach ($recent as $reb)
                                <div class="card mb-2">
                                    <a class="side-card" href="{{ url($reb['metadata']['url_slug']) }}">
                                        <img class="img-fluid rounded" src="{{ url('images/blogs/' . $reb['blog_pic']) }}" alt="blog_image"
                                            width="100" onerror="this.onerror=null; this.src='{{ url('images/blogs/blog.png') }}';">
                                        <div class="">
                                            <h6 class="blue title">{{ $reb['blog_title'] }}
                                            </h6>
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
    </main>
@endsection
@push('script')
    <script>
        let urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('category')) {
            let cat = urlParams.get('category');
            $(".main_content .blog").perform((x) => {
                x.get('data-category') == cat ? x.removeClass("hide") : x.addClass("hide");
            })
        }

        // Colors= Default color (overwrite hoga JS se)
        document.querySelectorAll(".blog-card img").forEach(img => {
            img.addEventListener("load", function () {
                let colorThief = new ColorThief();
                let dominantColor = colorThief.getColor(img); // Get dominant color

                let finalColor = `rgb(${dominantColor[0]}, ${dominantColor[1]}, ${dominantColor[2]})`;

                img.parentElement.style.background = `linear-gradient(to bottom, ${finalColor}, transparent)`;
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.min.js"></script>

@endpush