@extends('admin.components.layout')
@section('main')
<!-- http://localhost:8000/admin/university/edit/details/34 -->
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
        <h2 class="page_title">Edit {{ $university['univ_name'] }} Details</h2>
        @csrf
        <section class="panel">
            <h3 class="section_title">Course URL slug</h3>
            <div class="with_data flex">
                <h6 class="fw-bold text-secondary">https://collegevihar.com/university/</h6>
                <div class="field">
                    <input type="text" name="url_slug" value="{{ $university['metadata']['url_slug'] }}">
                    <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
                </div>
            </div>
        </section>
        <section>
            <h3 class="section_title">University Details</h3>
            <div class="row">
                <div class="col-lg-6">
                    <span>University Logo</span>
                    <input type="file" onchange="display_pic(this)" name="univ_logo" id="c1"
                        accept="image/png,image/webp">
                    @error('univ_logo')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <label for="c1" class="img_label">
                        <img src="/images/university/logo/{{ $university['univ_logo'] }}" alt="" class="img-fluid rounded">
                    </label>
                </div>
                <div class="col-lg-6">
                    <span>University Campus</span>
                    <input type="file" onchange="display_pic(this)" name="univ_image" id="c2"
                        accept="image/png,image/webp">
                    @error('univ_image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <label for="c1" class="img_label">
                        <img src="/images/university/campus/{{ $university['univ_image'] }}" alt="" class="img-fluid rounded">
                    </label>
                </div>
            </div>
        </section>
        <section>
            <div class="row">
                <div class="col-lg-6">
                    <div class="field">
                        <label for="address">University Complete Address</label>
                        <input type="text" id="address" placeholder="University Address" name="univ_address"
                            value="{{ $university['univ_address'] }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="field">
                        <label for="address">University State</label>
                        <select required name="univ_state">
                            <option value="" disabled selected>Please Select State</option>
                            @foreach ($states as $state)
                            <option value="{{ $state['id'] }}" @if ($state['id']==$university['univ_state']) selected @endif>
                                {{ $state['state_name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </section>


        <section class="panel">
            <h3 class="section_title">Description Introduction</h3>
            @php
            $desc = json_decode($university['univ_description'], true);
            @endphp
            @foreach ($desc as $i => $para)
            <div class="field_group head_field flex">
                <div class="field">
                    <label for="int{{ $i + 1 }}">Paragraph {{ $i + 1 }}</label>
                    <textarea oninput="auto_grow(this)" id="int{{ $i + 1 }}" name="univ_desc[]" placeholder="Write Here...">{{ $para }}</textarea>
                </div>
                <button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            @endforeach
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field"><div class="field"><label for="int__id__">Paragraph __id__</label><textarea oninput="auto_grow(this)" id="int__id__" name="univ_desc[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'>
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
            <div class="field_group head_field flex">
                <div class="field">
                    <label for="over{{ $i + 1 }}">Paragraph {{ $i + 1 }}</label>
                    <textarea oninput="auto_grow(this)" id="over{{ $i + 1 }}" name="univ_facts[]" placeholder="Write Here...">{{ $para }}</textarea>
                </div>
                <button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
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
            <div class="field_group head_field flex">
                <div class="field">
                    <label for="advl{{ $i + 1 }}" class="logo"><img src="/icon_png/{{ $adv['logo'] }}"
                            alt=""></label>
                    <input type="file" id="advl{{ $i + 1 }}"
                        name="univ_adv[data][{{ $i + 1 }}][logo]" onchange="display_pic(this)">
                    @error("univ_adv.data.{{ $i + 1 }}.logo")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field">
                    <label for="advt{{ $i + 1 }}">Advantage Title</label>
                    <input type="text" id="advt{{ $i + 1 }}"
                        name="univ_adv[data][{{ $i + 1 }}][title]" placeholder="University Advantage"
                        value="{{ $adv['title'] }}">
                </div>
                <input type="hidden" name="univ_adv[data][{{ $i + 1 }}][old]" value="{{ $adv['logo'] }}">
                <div class="field">
                    <label for="advd{{ $i + 1 }}">Advantage Description</label>
                    <input type="text" id="advd{{ $i + 1 }}"
                        name="univ_adv[data][{{ $i + 1 }}][description] " placeholder="University Advantage Description"
                        value="{{ $adv['description'] }}">
                </div>
                <button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            @endforeach
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field"><div class="field aie" style="width:auto;"><label for="advl__id__" class="logo"><img src="" alt=""></label><input type="file" id="advl__id__" name="univ_adv[data][__id__][logo]" onchange="display_pic(this)"></div><div class="field"><label for="advt__id__">Advantage Title</label><input type="text" id="advt__id__" name="univ_adv[data][__id__][title]" placeholder="University Advantage"></div><div class="field"><label for="advd__id__">Advantage Description</label><input type="text" id="advd__id__" name="univ_adv[data][__id__][description] "placeholder="University Advantage Description"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
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
                <div class="col-lg-6">
                    <div class="field_group head_field flex">
                        <div class="field"><label for="ind{{ $i + 1 }}">Industry
                                {{ $i + 1 }}</label><input id="ind{{ $i + 1 }}" name="industry[data][]"
                                placeholder="Industry Point" value="{{ $para }}" /></div>
                        <button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field"><div class="field"><label for="ind__id__">Industry __id__</label><input id="ind__id__" name="industry[data][]" placeholder="Industry Point" /></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
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
                <div class="field_group head_field flex col-lg-6">
                    <div class="field">
                        <label for="car{{ $i + 1 }}">carrier {{ $i + 1 }}</label>
                        <input type="text" id="car{{ $i + 1 }}" name="carrier[data][]"
                            placeholder="Carrier" value="{{ $para }}">
                    </div>
                    <button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
                @endforeach
            </div>
            @endisset
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field"><div class="field"><label for="car__id__">carrier __id__</label><input type="text" id="car__id__" name="carrier[data][]" placeholder="Carrier"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
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