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
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        text-align: center;
    }

    .modal-content img {
        display: block;
        margin: 20px auto;
        max-width: 100%;
        height: auto;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
    }
</style>
@endpush

@extends('admin.components.layout')

@section('main')
<main>
    @include('admin.components.response')
    <div>
        <h1 class="page_title">Editor</h1>
        <p class="page_sub_title">Let's Create a new blog</p>
    </div>
    <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
        @csrf
        <section class="panel">
            <div class="field_group">
                <div class="field">
                    <label for="blog_title">What's in your mind</label>
                    <input type="text" id="blog_title" name="blog_title" placeholder="Blog Title" required>
                </div>
                <div class="field">
                    <label for="blog_author">Who's posting it</label>
                    <input type="text" id="blog_author" name="blog_author" placeholder="Blog Author" required>
                </div>
            </div>

            <div class="row align-items-start">
                <span>Upload Image to preview</span>
                <input class="d-block" type="file" name="blog_pic" id="blog_pic" required>
                <div class="col-lg-6">
                    <label for="blog_pic">
                        <div class="display">
                            <img src="" alt="" class="img-fluid">
                        </div>
                    </label>
                </div>
            </div>
        </section>

        <section>
            <h4 class="section_title">SEO Work</h4>
            <div class="field_group">
                <div class="field">
                    <label for="page_slug">Page Slug</label>
                    @isset($page['slug'])
                    <input type="text" readonly id="page_slug" required
                        value="{{ $page['slug'] === '' ? 'Home Page' : ($page['slug'] === '*' ? 'Universal' : $page['slug']) }}">
                    @else
                    <input type="text" name="page_slug" placeholder="blogs/....." id="page_slug" required>
                    @endisset
                </div>
                <div class="field">
                    <label for="page_title" class="">Page Title
                        <i class="text success"><span>0</span>char</i>
                    </label>
                    <input type="text" name="page_title" id="page_title" required value="{{ $page['page_title'] ?? '' }}">
                </div>
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="page_head" class="">Page Heading
                        <i class="text info"><span></span></i>
                    </label>
                    <input type="text" name="page_head" id="page_head" required value="{{ $page['page_head'] ?? '' }}">
                </div>
                <div class="field">
                    <label for="page_keywords" class="">
                        <span>Page Keywords <i class="text info">(',' separated)</i></span>
                        <i class="text prime"><span class="count_info"></span> Keywords</i>
                    </label>
                    <input type="text" name="page_keywords" id="page_keywords" required value="{{ $page['page_keywords'] ?? '' }}">
                </div>
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="page_desc" class="">Page Description
                        <i class="text info"><span></span></i>
                    </label>
                    <input type="text" name="page_desc" id="page_desc" required value="{{ $page['page_desc'] ?? '' }}">
                </div>
                <div class="field">
                    <label for="other_meta">Other Meta Tags
                        <i class="text warn">Don't fill unnecessarily</i>
                    </label>
                    <textarea name="other_meta" id="other_meta">{{ $page['other_meta_tags'] ?? '' }}</textarea>
                </div>
            </div>
        </section>

        <section class="panel">
            <textarea id="blog_editor" name="blog_content" style="height: 400px"></textarea>
        </section>
        <div class="p-4 text-end">
            <button type="button" id="previewBtn" class="btn btn-primary">Preview</button>
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>

    <!-- Modal Structure -->
    <div id="previewModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="previewContent"></div>
        </div>
    </div>

</main>
@endsection

@push('script')
<script src="https://cdn.tiny.cloud/1/rcimor377yz9qes7ugd18in1cn1ie9593dr4y5ccshxqczcx/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.getElementById("blog_pic").addEventListener("change", function() {
        const file = this.files[0];
        const maxSize = 1048576; // 1MB
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        // Check file type and size
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

        let parent = this.parentElement;
        parent.querySelector("label").classList.add("loaded");
        parent.querySelector("img").src = URL.createObjectURL(file);
    });

    tinymce.init({
        selector: '#blog_editor',
        plugins: 'link',
        link_default_target: '_blank',
        height: 400,
        menubar: false,
        branding: false,
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
    });

    document.getElementById("previewBtn").addEventListener("click", function() {
        let blogTitle = document.getElementById("blog_title").value;
        let blogAuthor = document.getElementById("blog_author").value;
        let blogPic = document.getElementById("blog_pic").files[0];
        let blogContent = tinymce.get("blog_editor").getContent({
            format: 'raw'
        }); // Ensure raw content without controls
        let pageSlug = document.getElementById("page_slug").value;
        let pageTitle = document.getElementById("page_title").value;
        let pageHead = document.getElementById("page_head").value;
        let pageKeywords = document.getElementById("page_keywords").value;
        let pageDesc = document.getElementById("page_desc").value;
        let otherMeta = document.getElementById("other_meta").value;

        let previewContent = `
            <div style="text-align: center;">
                <h4>What's in your mind: ${blogTitle}</h4>
                <h4>Who's posting it: By ${blogAuthor}</h4>
                ${blogPic ? `<img src="${URL.createObjectURL(blogPic)}" alt="Blog Image">` : ""}
                <div>${blogContent}</div>
                <h3>SEO Details</h3>
                <p><strong>Page Slug:</strong> ${pageSlug}</p>
                <p><strong>Page Title:</strong> ${pageTitle}</p>
                <p><strong>Page Heading:</strong> ${pageHead}</p>
                <h3>Additional Information</h3>
                <p><strong>Page Keywords:</strong> ${pageKeywords}</p>
                <p><strong>Page Description:</strong> ${pageDesc}</p>
                <p><strong>Other Meta:</strong> ${otherMeta}</p>
            </div>
        `;

        document.getElementById("previewContent").innerHTML = previewContent;
        document.getElementById("previewModal").style.display = "block";
    });

    document.querySelector(".close").addEventListener("click", function() {
        document.getElementById("previewModal").style.display = "none";
    });

    window.onclick = function(event) {
        let modal = document.getElementById("previewModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endpush