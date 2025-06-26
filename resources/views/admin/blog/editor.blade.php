@push('css')
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 20px;
        border-radius: 10px;
        width: 90%;
        max-width: 900px;
    }

    .modal-content img {
        max-width: 100%;
        height: auto;
        margin: 15px 0;
    }

    .close {
        color: #999;
        float: right;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: #000;
    }

    .loaded img {
        border: 2px solid #0d6efd;
        border-radius: 6px;
    }
</style>
@endpush

@extends('admin.components.layout')
@section('title', 'Editor - CV Admin')

@section('main')
<main>
    @include('admin.components.response')
    <div class="mb-4">
        <h1 class="page_title">Editor</h1>
        <p class="page_sub_title">Let's create a new blog</p>
    </div>

    <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
        @csrf

        {{-- Blog Title & Author --}}
        <section class="panel">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="blog_title" class="form-label">What's in your mind</label>
                    <input type="text" id="blog_title" name="blog_title" class="form-control" placeholder="Blog Title" required>
                </div>
                <div class="col-md-6">
                    <label for="blog_author" class="form-label">Who's posting it</label>
                    <input type="text" id="blog_author" name="blog_author" class="form-control" placeholder="Blog Author" required>
                </div>
            </div>

            {{-- Image Upload --}}
            <div class="mt-4">
                <label for="blog_pic" class="form-label">Upload Image to preview</label>
                <input class="form-control" type="file" name="blog_pic" id="blog_pic" accept="image/*" required>
                <div class="mt-3 loaded">
                    <img src="" alt="Preview Image" class="img-fluid" style="display: none;">
                </div>
            </div>
        </section>

        {{-- SEO Section --}}
        <section class="panel mt-5">
            <h4 class="section_title">SEO Work</h4>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="page_slug" class="form-label">Page Slug</label>
                    @isset($page['slug'])
                        <input type="text" readonly class="form-control" id="page_slug" required value="{{ $page['slug'] === '' ? 'Home Page' : ($page['slug'] === '*' ? 'Universal' : $page['slug']) }}">
                    @else
                        <input type="text" name="page_slug" class="form-control" placeholder="blogs/..." id="page_slug" required>
                    @endisset
                </div>
                <div class="col-md-6">
                    <label for="page_title" class="form-label">Page Title <i class="text-muted"><span>0</span> char</i></label>
                    <input type="text" name="page_title" id="page_title" class="form-control" value="{{ $page['page_title'] ?? '' }}" required>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="page_head" class="form-label">Page Heading</label>
                    <input type="text" name="page_head" id="page_head" class="form-control" value="{{ $page['page_head'] ?? '' }}" required>
                </div>
                <div class="col-md-6">
                    <label for="page_keywords" class="form-label">Page Keywords <i class="text-muted">(comma-separated)</i></label>
                    <input type="text" name="page_keywords" id="page_keywords" class="form-control" value="{{ $page['page_keywords'] ?? '' }}" required>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="page_desc" class="form-label">Page Description</label>
                    <input type="text" name="page_desc" id="page_desc" class="form-control" value="{{ $page['page_desc'] ?? '' }}" required>
                </div>
                <div class="col-md-6">
                    <label for="other_meta" class="form-label">Other Meta Tags <i class="text-warning">Don't fill unnecessarily</i></label>
                    <textarea name="other_meta" id="other_meta" class="form-control" rows="2">{{ $page['other_meta_tags'] ?? '' }}</textarea>
                </div>
            </div>
        </section>

        {{-- Blog Editor --}}
        <section class="panel mt-5">
            <label for="blog_editor" class="form-label">Blog Content</label>
            <textarea id="blog_editor" name="blog_content" style="height: 400px;"></textarea>
        </section>

        {{-- Buttons --}}
        <div class="text-end mt-4">
            <button type="button" id="previewBtn" class="btn btn-outline-primary">Preview</button>
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>

    {{-- Preview Modal --}}
    <div id="previewModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="previewContent"></div>
        </div>
    </div>
</main>
@endsection

@push('script')
<script src="https://cdn.tiny.cloud/1/rcimor377yz9qes7ugd18in1cn1ie9593dr4y5ccshxqczcx/tinymce/6/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    document.getElementById("blog_pic").addEventListener("change", function () {
        const file = this.files[0];
        const maxSize = 1048576;
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPEG, PNG, GIF)');
            this.value = '';
            return;
        }

        if (file.size > maxSize) {
            alert('Maximum file size exceeded (1MB)');
            this.value = '';
            return;
        }

        const preview = document.querySelector(".loaded img");
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    });

    tinymce.init({
        selector: '#blog_editor',
        plugins: 'link',
        link_default_target: '_blank',
        height: 400,
        menubar: false,
        branding: false,
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link',
    });

    document.getElementById("previewBtn").addEventListener("click", function () {
        const title = document.getElementById("blog_title").value;
        const author = document.getElementById("blog_author").value;
        const img = document.getElementById("blog_pic").files[0];
        const content = tinymce.get("blog_editor").getContent();
        const slug = document.getElementById("page_slug").value;
        const pageTitle = document.getElementById("page_title").value;
        const pageHead = document.getElementById("page_head").value;
        const keywords = document.getElementById("page_keywords").value;
        const desc = document.getElementById("page_desc").value;
        const meta = document.getElementById("other_meta").value;

        const previewHtml = `
            <h3>${title}</h3>
            <p><em>by ${author}</em></p>
            ${img ? `<img src="${URL.createObjectURL(img)}" alt="Blog Image">` : ''}
            <div class="mt-3">${content}</div>
            <hr>
            <h4>SEO Details</h4>
            <p><strong>Slug:</strong> ${slug}</p>
            <p><strong>Title:</strong> ${pageTitle}</p>
            <p><strong>Heading:</strong> ${pageHead}</p>
            <p><strong>Keywords:</strong> ${keywords}</p>
            <p><strong>Description:</strong> ${desc}</p>
            <p><strong>Meta:</strong> ${meta}</p>
        `;

        document.getElementById("previewContent").innerHTML = previewHtml;
        document.getElementById("previewModal").style.display = "block";
    });

    document.querySelector(".close").addEventListener("click", () => {
        document.getElementById("previewModal").style.display = "none";
    });

    window.onclick = function (event) {
        const modal = document.getElementById("previewModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endpush
