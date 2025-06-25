@extends('admin.components.layout')
@section('title', 'Add University Details - CV Admin')

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f9f9f9;
    }

    main {
        padding: 2rem;
        max-width: 1000px;
        margin: auto;
    }

    .panel {
        background: #fff;
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .section_title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }

    .field,
    .field_group {
        margin-bottom: 1rem;
    }

    .field label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    input[type="text"],
    input[type="file"],
    textarea,
    select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #5a67d8;
        outline: none;
    }

    .field_group {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .cflex {
        display: flex;
        flex-direction: column;
    }

    .aie {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .img_label {
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
    }

    .img_label img {
        height: 50px;
        width: 50px;
        object-fit: cover;
        border-radius: 6px;
        background-color: #eee;
    }

    .add_field {
        color: #4a5568;
        font-size: 1.1rem;
        cursor: pointer;
        display: inline-block;
        margin-top: 10px;
    }

    .add_field:hover {
        color: #2b6cb0;
    }

    button[type="submit"] {
        padding: 0.75rem 1.5rem;
        background: #4a90e2;
        color: #fff;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    button[type="submit"]:hover {
        background: #357ac9;
    }

    @media (max-width: 768px) {
        .field_group {
            flex-direction: column;
        }

        .aie {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    input[type="file"] {
        padding: 10px;
        background-color: #f0f0f0;
    }

    input[type="checkbox"] {
        transform: scale(1.3);
        margin-right: 0.5rem;
    }

    .field input:invalid {
        border-color: #e53e3e;
    }

    .field input:valid {
        border-color: #48bb78;
    }
</style>


@section('main')
    <main>
        @include('admin.components.response')
        <form action="/admin/university/add/details" method="post" enctype="multipart/form-data">
            <h5>Add University Details</h5>
            <h6 class="page_title text-center">Now Adding <b class="text-primary">{{ $university['univ_name'] }}</b> Details</h6>
            @csrf
            <section class="panel">
                <h3 class="section_title">University URL slug</h3>
                <div class="field with_data aic">
                    <h6>https://collegevihar.com/university/</h6>
                    <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
                    <input type="text" name="univ_slug" id="univ_slug" placeholder="University Slug"
                        style="padding-inline: 5px;font-weight:600;"
                        class="text-center"
                        value="{{ str_replace(' ', '-', strtolower($university['univ_name'])) }}">
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">University Details</h3>
                <div class="field_group">
                    <div class="field">
                        <span>University Logo</span> <br>
                        <label for="c1" class="img_label"><img src="" alt="univ_logo" class="img-fluid rounded h-100 w-100 object-fit-cover object-position-center border border-2 border-primary"></label>
                        <input type="file" onchange="display_pic(this)" name="univ_logo" id="c1"
                            accept="image/png,image/webp">
                    </div>
                    <div class="field">
                        <span>University Campus</span> <br>
                        <label for="c2" class="img_label"><img src="" alt="univ_image" class="img-fluid rounded h-100 w-100 object-fit-cover object-position-center border border-2 border-primary"></label>
                        <input type="file" onchange="display_pic(this)" name="univ_image" id="c2"   >
                    </div>
                </div>

            </section>
            <section class="panel">
                <h3 class="section_title">Info: {{ $university['univ_name'] }}</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="int__id__">Paragraph __id__</label><textarea oninput="auto_grow(this)" id="int__id__" name="univ_desc[]" placeholder="Write Here..."></textarea></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Facts: {{ $university['univ_name'] }}</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="over__id__">Paragraph __id__</label><textarea oninput="auto_grow(this)" id="over__id__" name="univ_facts[]" placeholder="Write Here..."></textarea></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Advantages: {{ $university['univ_name'] }}</h3>
                <div class="field cflex">
                    <label for="cor">About University Advantage (optional)</label>
                    <input type="text" name="univ_adv[about]" placeholder="University Advantage About">
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field aie" style="width:auto;"><label for="advl__id__" class="logo"><img src="" alt="advl__id__"></label><input type="file" id="advl__id__" name="univ_adv[data][__id__][logo]" placeholder="University Advantage Logo" onchange="display_pic(this)"></div><div class="field cflex"><label for="advt__id__">Advantage Title</label><input type="text" id="advt__id__" name="univ_adv[data][__id__][title]" placeholder="University Advantage"></div><div class="field cflex"><label for="advd__id__">Advantage Description</label><input type="text" id="advd__id__" name="univ_adv[data][__id__][description] "placeholder="University Advantage Description"></div></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Industry-Ready Programs for Enhanced Career Readiness: {{ $university['univ_name'] }}</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="ind__id__">Industry __id__</label><input id="ind__id__" name="industry[data][]" placeholder="Industry Point" /></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Carrier Guidance: {{ $university['univ_name'] }}</h3>
                <div class="field cflex">
                    <label for="car">About Carrier Guidance (optional)</label>
                    <input type="text" id="car" name="carrier[about]" placeholder="About Carrier">
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="car__id__">carrier __id__</label><input type="text" id="car__id__" name="carrier[data][]" placeholder="Carrier">'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Seo Work: {{ $university['univ_name'] }}</h3>
                <div class="field cflex">
                    <label for="meta_h1">Text to display in H1 tag</label>
                    <input type="text" id="meta_h1" name="meta_h1" placeholder="meta_h1">
                </div>
                <div class="field_group">
                    <div class="field cflex">
                        <label for="meta_title">Meta Title of Page</label>
                        <input type="text" id="meta_title" name="meta_title" placeholder="meta_title">
                    </div>
                    <div class="field cflex">
                        <label for="meta_description">Meta Description of Page</label>
                        <input type="text" id="meta_description" name="meta_description" placeholder="meta_description">
                    </div>
                </div>
                <div class="field cflex">
                    <label for="meta_key">Meta Keywords of Page (key1, key2, key3)</label>
                    <input type="text" id="meta_key" name="meta_keywords" placeholder="meta_keywords">
                </div>
                <div class="field cflex">
                    <label for="om">If any (Write complete tags)</label>
                    <input type="text" id="om" name="other_meta_tags" placeholder="other_meta_tags">
                </div>
            </section>
            <div class="field">
                <input type="checkbox" name="univ_detail_added" id="univ_active" value="1">
                <label for="univ_active">Show on frontend</label>
            </div>
            <button type="submit">Add University Details</button>
        </form>
    </main>
    @push('script')
        <script>
            function display_pic(node) {
                $(`label[for='${node.id}'] img`)[0].src = URL.createObjectURL(node.files[0]);
            }
            $(".add_field").perform((n) => {
                let i = 1;
                n.addEventListener('click', function() {
                    n.insert(0, n.get('data-field').replaceAll('__id__', i++));
                });
            })
        </script>
    @endpush
@endsection
