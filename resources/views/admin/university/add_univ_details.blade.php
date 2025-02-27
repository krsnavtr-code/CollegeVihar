@extends('admin.components.layout')
@section('main')
    <main>
        @include('admin.components.response')
        <form action="/admin/university/add/details" method="post" enctype="multipart/form-data">
            <h2 class="page_title">{{ $university['univ_name'] }}</h2>
            @csrf
            <section class="panel">
                <h3 class="section_title">Course URL slug</h3>
                <div class="field with_data aic">
                    <h6>https://collegevihar.com/university/</h6>
                    <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
                    <input type="text" name="univ_slug" id="univ_slug" placeholder="University Slug"
                        style="padding-inline: 5px;font-weight:600;"
                        value="{{ str_replace(' ', '-', strtolower($university['univ_name'])) }}">
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">University Details</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="c1" class="img_label"><img src="" alt=""><span>University
                                Logo</span></label>
                        <input type="file" onchange="display_pic(this)" name="univ_logo" id="c1"
                            accept="image/png,image/webp">
                    </div>
                    <div class="field">
                        <label for="c2" class="img_label"><img src="" alt=""><span>University
                                Campus</span></label>
                        <input type="file" onchange="display_pic(this)" name="univ_image" id="c2">
                    </div>
                </div>
                <div class="field cflex">
                    <label for="address">University Complete Address</label>
                    <input type="text" id="address" placeholder="University Address" name="univ_address">
                </div>
                <div class="field cflex">
                    <label for="address">University State</label>
                    <select required name="univ_state">
                        <option value="" disabled selected>Please Select State</option>
                        @foreach ($states as $state)
                            <option value="{{ $state['id'] }}">{{ $state['state_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">Description Introduction</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="int__id__">Paragraph __id__</label><textarea oninput="auto_grow(this)" id="int__id__" name="univ_desc[]" placeholder="Write Here..."></textarea></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">University Facts</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="over__id__">Paragraph __id__</label><textarea oninput="auto_grow(this)" id="over__id__" name="univ_facts[]" placeholder="Write Here..."></textarea></div>'></i>
            </section>
            <section class="panel">
                <h3>University Advantages</h3>
                <div class="field cflex">
                    <label for="cor">About University Advantage (optional)</label>
                    <input type="text" name="univ_adv[about]" placeholder="University Advantage About">
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field aie" style="width:auto;"><label for="advl__id__" class="logo"><img src="" alt=""></label><input type="file" id="advl__id__" name="univ_adv[data][__id__][logo]" placeholder="University Advantage Logo" onchange="display_pic(this)"></div><div class="field cflex"><label for="advt__id__">Advantage Title</label><input type="text" id="advt__id__" name="univ_adv[data][__id__][title]" placeholder="University Advantage"></div><div class="field cflex"><label for="advd__id__">Advantage Description</label><input type="text" id="advd__id__" name="univ_adv[data][__id__][description] "placeholder="University Advantage Description"></div></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Industry-Ready Programs for Enhanced Career Readiness</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="ind__id__">Industry __id__</label><input id="ind__id__" name="industry[data][]" placeholder="Industry Point" /></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Carrier Guidance</h3>
                <div class="field cflex">
                    <label for="car">About Carrier Guidance (optional)</label>
                    <input type="text" id="car" name="carrier[about]" placeholder="About Carrier">
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="car__id__">carrier __id__</label><input type="text" id="car__id__" name="carrier[data][]" placeholder="Carrier">'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Seo Work</h3>
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
            <button type="submit">Add University</button>
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
