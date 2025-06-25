@extends('admin.components.layout')
@section('title', 'Edit University Details - CV Admin')

@section('main')
<!-- http://localhost:8000/admin/university/edit/details/34 -->

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


<main>
    @include('admin.components.response')
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="/admin/university/edit/details" method="post" enctype="multipart/form-data">
        <h5>Edit University Details</h5>
        <h6 class="page_title text-center">Now Editing <b class="text-primary">{{ $university['univ_name'] }}</b> Details</h6>
        @csrf
        <section class="panel">
            <h3 class="section_title">Course URL slug</h3>
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
                    <label for="c1" class="img_label">
                        <span>University Logo image</span> <br>
                        <img src="/images/university/logo/{{ $university['univ_logo'] }}" alt="univ_logo" class="img-fluid rounded h-100 w-100 object-fit-cover object-position-center border border-2 border-primary">
                    </label>
                    <input type="file" onchange="display_pic(this)" name="univ_logo" id="c1"
                        accept="image/png,image/webp">
                    @error('univ_logo')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <hr>
                <div class="field">
                    <label for="c2" class="img_label">
                        <span>University Campus image</span> <br>
                        <img src="/images/university/campus/{{ $university['univ_image'] }}" alt="univ_image" class="img-fluid rounded h-100 w-100 object-fit-cover object-position-center border border-2 border-primary">
                    </label>
                    <input type="file" onchange="display_pic(this)" name="univ_image" id="c2"
                        accept="image/png,image/webp">
                    @error('univ_image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </section>

        <section class="panel">
            <h3 class="section_title">Description Introduction</h3>
            @php
            $desc = json_decode($university['univ_description'], true);
            @endphp
            @foreach ($desc as $i => $para)
            <div class="field">
                <label for="int{{ $i + 1 }}">Paragraph {{ $i + 1 }}</label>
                <textarea class="auto-expand" oninput="auto_grow(this)" id="int{{ $i + 1 }}" name="univ_desc[]" placeholder="Write Here..." style="height: auto;">{{ $para }}</textarea>
                <button onclick="delete_field(this)" class="btn btn-danger" style="width: fit-content;">
                    <i class="fa-solid fa-trash"></i> Delete Paragraph {{ $i + 1 }}
                </button>
            </div>
            @endforeach
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field"><div class="field"><label for="int__id__">Paragraph __id__</label><textarea class="auto-expand" oninput="auto_grow(this)" id="int__id__" name="univ_desc[]" placeholder="Write Here..." style="min-height: 100px;"></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'>
                <i class="icon fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <section class="panel">
            <h3 class="section_title">University Facts</h3>
            @php
            $desc = json_decode($university['univ_facts'], true);
            @endphp
            @foreach ($desc as $i => $para)
            <div class="field">
                <label for="over{{ $i + 1 }}">Paragraph {{ $i + 1 }}</label>
                <textarea class="auto-expand" oninput="auto_grow(this)" id="over{{ $i + 1 }}" name="univ_facts[]" placeholder="Write Here...">{{ $para }}</textarea>
                <button onclick="delete_field(this)" class="btn btn-danger" style="width: fit-content;">
                    <i class="fa-solid fa-trash"></i> Delete Paragraph {{ $i + 1 }}
                </button>
            </div>
            @endforeach
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field"><div class="field"><label for="over__id__">Paragraph __id__</label><textarea oninput="auto_grow(this)" id="over__id__" name="univ_facts[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
                <i class="icon fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <section class="panel">
            <h3>University Advantages</h3>
            @php
            $desc = json_decode($university['univ_advantage'], true);
            @endphp
            <div class="field">
                <label for="cor">About University Advantage (optional)</label>
                <input type="text" name="univ_adv[about]" placeholder="University Advantage About"
                    value="{{ $desc['about'] }}">
            </div>
            @foreach ($desc['data'] as $i => $adv)
            <div class="field">
                <label for="advl{{ $i + 1 }}" class="logo"><img src="/icon_png/{{ $adv['logo'] }}"
                            alt="advl{{ $i + 1 }}"></label>
                <input type="file" id="advl{{ $i + 1 }}"
                        name="univ_adv[data][{{ $i + 1 }}][logo]" onchange="display_pic(this)">
                    @error("univ_adv.data.{{ $i + 1 }}.logo")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
            </div>
            <div class="">
                <label for="advt{{ $i + 1 }}">Advantage Title</label>
                <input type="text" id="advt{{ $i + 1 }}"
                        name="univ_adv[data][{{ $i + 1 }}][title]" placeholder="University Advantage"
                        value="{{ $adv['title'] }}">
            </div>
            <input type="hidden" name="univ_adv[data][{{ $i + 1 }}][old]" value="{{ $adv['logo'] }}">
            <div class="">
                <label for="advd{{ $i + 1 }}">Advantage Description</label>
                <input type="text" id="advd{{ $i + 1 }}"
                        name="univ_adv[data][{{ $i + 1 }}][description] " placeholder="University Advantage Description"
                        value="{{ $adv['description'] }}">
            </div>
            <button onclick="delete_field(this)" class="btn btn-danger" style="width: fit-content;">
                <i class="fa-solid fa-trash"></i> Delete Advantage {{ $i + 1 }}
            </button>
            @endforeach
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field"><div class="field aie" style="width:auto;"><label for="advl__id__" class="logo"><img src="" alt="advl__id__"></label><input type="file" id="advl__id__" name="univ_adv[data][__id__][logo]" onchange="display_pic(this)"></div><div class="field"><label for="advt__id__">Advantage Title</label><input type="text" id="advt__id__" name="univ_adv[data][__id__][title]" placeholder="University Advantage"></div><div class="field"><label for="advd__id__">Advantage Description</label><input type="text" id="advd__id__" name="univ_adv[data][__id__][description] "placeholder="University Advantage Description"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'>
                <i class="icon fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <section class="panel">
            <h3 class="section_title">Industry-Ready Programs for Enhanced Career Readiness</h3>
            @php
            $desc = json_decode($university['univ_industry'], true);
            @endphp
            <div class="row">
                @foreach ($desc['data'] as $i => $para)
                <div class="col-12">
                    <div class="field_group head_field flex flex-row">
                        <div class="field"><label for="ind{{ $i + 1 }}">Industry
                                {{ $i + 1 }}</label><input id="ind{{ $i + 1 }}" name="industry[data][]"
                                placeholder="Industry Point" value="{{ $para }}" /></div>
                        <button onclick="delete_field(this)" class="btn btn-danger">
                            <i class="fa-solid fa-trash"></i> Delete Industry {{ $i + 1 }}
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field flex flex-row"><div class="field"><label for="ind__id__">Industry __id__</label><input id="ind__id__" name="industry[data][]" placeholder="Industry Point" /></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'>
                <i class="icon fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <section class="panel">
            <h3 class="section_title">Carrier Guidance</h3>
            @php
            $desc = json_decode($university['univ_carrier'], true);
            $i = -1;
            @endphp
            <div class="field">
                <label for="car">About Carrier Guidance (optional)</label>
                <input type="text" id="car" name="carrier[about]" placeholder="About Carrier"
                    value="{{ $desc['about'] }}">
            </div>
            @isset($desc['data'])
            <div class="row">
                @foreach ($desc['data'] as $i => $para)
                <div class="field_group head_field flex flex-row col-12 ">
                    <div class="field">
                        <label for="car{{ $i + 1 }}">carrier {{ $i + 1 }}</label>
                        <input type="text" id="car{{ $i + 1 }}" name="carrier[data][]"
                            placeholder="Carrier" value="{{ $para }}">
                    </div>
                    <button onclick="delete_field(this)" class="btn btn-danger" style="width: fit-content;">
                        <i class="fa-solid fa-trash"></i> Delete Carrier {{ $i + 1 }}
                    </button>
                </div>
                @endforeach
            </div>
            @endisset
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field flex flex-row"><div class="field"><label for="car__id__">carrier __id__</label><input type="text" id="car__id__" name="carrier[data][]" placeholder="Carrier"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'>
                <i class="icon fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">Edit University Details</button>
        </div>
    </form>
</main>

@push('script')
<script>
    function display_pic(node) {
        $(`label[for='${node.id}'] img`)[0].src = URL.createObjectURL(node.files[0]);
    }
    $(".add_field").perform((n) => {
        let i = n.get('data-init');
        n.addEventListener('click', function() {
            n.insert(0, n.get('data-field').replaceAll('__id__', i++));
        });
    })

    function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight + 1.5) + "px";
    }
    $("textarea").perform((n) => {
        auto_grow(n);
    })

    function delete_field(n) {
        let main = n.closest(".head_field");
        main.remove();
    }
</script>
@endpush
@endsection
