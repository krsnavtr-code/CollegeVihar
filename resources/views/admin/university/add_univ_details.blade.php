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

    .error {
        border-color: #e53e3e !important;
    }

    .remove-field {
        background: #e53e3e;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 16px;
        line-height: 1;
        padding: 0;
        margin-left: 10px;
    }

    .remove-field:hover {
        background: #c53030;
    }

    .field_group {
        position: relative;
        padding: 15px;
        border: 1px dashed #ddd;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .field {
        position: relative;
        margin-bottom: 15px;
    }

    .field:last-child {
        margin-bottom: 0;
    }
</style>


@section('main')
    <main>
        @include('admin.components.response')
        <form id="universityDetailsForm" action="{{ route('admin.university.details.store') }}" method="post">
            @csrf
            <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
            <h5>Add University Details</h5>
            <h6 class="page_title text-center">Now Adding <b class="text-primary">{{ $university['univ_name'] }}</b> Details
            </h6>
            <!-- Info -->
            <section class="panel">
                <h3 class="section_title">Info: {{ $university['univ_name'] }}</h3>
                <div class="field cflex">
                    <label for="int_1">Paragraph 1</label>
                    <textarea oninput="auto_grow(this)" id="int_1" name="univ_desc[]"
                        placeholder="Write Here..."></textarea>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="int__id__">Paragraph __id__</label><textarea oninput="auto_grow(this)" id="int__id__" name="univ_desc[]" placeholder="Write Here..."></textarea></div>'
                    data-prefix="int">
                </i>
            </section>

            <!-- Campus Area -->
            <section class="panel">
                <h3 class="section_title">Campus Area: {{ $university['univ_name'] }}</h3>
                <div class="field cflex">
                    <label for="ca_1">Paragraph 1</label>
                    <textarea oninput="auto_grow(this)" id="ca_1" name="univ_campus_area[]"
                        placeholder="Write Here..."></textarea>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="ca__id__">Paragraph __id__</label><textarea oninput="auto_grow(this)" id="ca__id__" name="univ_campus_area[]" placeholder="Write Here..."></textarea></div>'
                    data-prefix="ca">
                </i>
            </section>

            <!-- Student Strength -->
            <section class="panel">
                <h3 class="section_title">Student Strength: {{ $university['univ_name'] }}</h3>
                <div class="field cflex">
                    <label for="ss_1">Paragraph 1</label>
                    <textarea oninput="auto_grow(this)" id="ss_1" name="univ_student_strength[]"
                        placeholder="Write Here..."></textarea>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="ss__id__">Paragraph __id__</label><textarea oninput="auto_grow(this)" id="ss__id__" name="univ_student_strength[]" placeholder="Write Here..."></textarea></div>'
                    data-prefix="ss">
                </i>
            </section>

            <!-- Faculty Strength -->
            <section class="panel">
                <h3 class="section_title">Faculty Strength: {{ $university['univ_name'] }}</h3>
                <div class="field cflex">
                    <label for="fs_1">Paragraph 1</label>
                    <textarea oninput="auto_grow(this)" id="fs_1" name="univ_faculty_strength[]"
                        placeholder="Write Here..."></textarea>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="fs__id__">Paragraph __id__</label><textarea oninput="auto_grow(this)" id="fs__id__" name="univ_faculty_strength[]" placeholder="Write Here..."></textarea></div>'
                    data-prefix="fs">
                </i>
            </section>

            <!-- Highlights -->
            <section class="panel">
                <h3 class="section_title">Highlights: {{ $university['univ_name'] }}</h3>
                <hr style="margin: 1rem 0; color: red;">
                <p style="margin: 1rem 0; font-weight: bold;">Popular Course Details</p>

                <!-- Undergraduate Programs -->
                <p>Undergraduate Programs</p>
                <div class="field_group">
                    <div class="field">
                        <label for="up_1">Program Name</label>
                        <input type="text" id="up_1" name="univ_highlights[data][1][name]" placeholder="Program Name">
                    </div>
                    <div class="field">
                        <label for="upd_1">Program Description</label>
                        <input type="text" id="upd_1" name="univ_highlights[data][1][description]"
                            placeholder="Program Description">
                    </div>
                    <div class="field">
                        <label for="ups_1">Program Specializations</label>
                        <input type="text" id="ups_1" name="univ_highlights[data][1][specializations]"
                            placeholder="Program Specializations">
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="up__id__">Program Name</label><input type="text" id="up__id__" name="univ_highlights[data][__id__][name]" placeholder="Program Name"></div><div class="field"><label for="upd__id__">Program Description</label><input type="text" id="upd__id__" name="univ_highlights[data][__id__][description]" placeholder="Program Description"></div><div class="field"><label for="ups__id__">Program Specializations</label><input type="text" id="ups__id__" name="univ_highlights[data][__id__][specializations]" placeholder="Program Specializations"></div></div>'
                    data-prefix="up">
                </i>

                <hr>

                <!-- Postgraduate Programs -->
                <p>Postgraduate Programs</p>
                <div class="field_group">
                    <div class="field">
                        <label for="pgp_1">Program Name</label>
                        <input type="text" id="pgp_1" name="univ_highlights[data][2][name]" placeholder="Program Name">
                    </div>
                    <div class="field">
                        <label for="pgpd_1">Program Description</label>
                        <input type="text" id="pgpd_1" name="univ_highlights[data][2][description]"
                            placeholder="Program Description">
                    </div>
                    <div class="field">
                        <label for="pgps_1">Program Specializations</label>
                        <input type="text" id="pgps_1" name="univ_highlights[data][2][specializations]"
                            placeholder="Program Specializations">
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="pgp__id__">Program Name</label><input type="text" id="pgp__id__" name="univ_highlights[data][__id__][name]" placeholder="Program Name"></div><div class="field"><label for="pgpd__id__">Program Description</label><input type="text" id="pgpd__id__" name="univ_highlights[data][__id__][description]" placeholder="Program Description"></div><div class="field"><label for="pgps__id__">Program Specializations</label><input type="text" id="pgps__id__" name="univ_highlights[data][__id__][specializations]" placeholder="Program Specializations"></div></div>'
                    data-prefix="pgp">
                </i>

                <hr>

                <!-- Diploma Programs -->
                <p>Diploma Programs</p>
                <div class="field_group">
                    <div class="field">
                        <label for="dip_1">Program Name</label>
                        <input type="text" id="dip_1" name="univ_highlights[data][3][name]" placeholder="Program Name">
                    </div>
                    <div class="field">
                        <label for="dipd_1">Program Description</label>
                        <input type="text" id="dipd_1" name="univ_highlights[data][3][description]"
                            placeholder="Program Description">
                    </div>
                    <div class="field">
                        <label for="dips_1">Program Specializations</label>
                        <input type="text" id="dips_1" name="univ_highlights[data][3][specializations]"
                            placeholder="Program Specializations">
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="dip__id__">Program Name</label><input type="text" id="dip__id__" name="univ_highlights[data][__id__][name]" placeholder="Program Name"></div><div class="field"><label for="dipd__id__">Program Description</label><input type="text" id="dipd__id__" name="univ_highlights[data][__id__][description]" placeholder="Program Description"></div><div class="field"><label for="dips__id__">Program Specializations</label><input type="text" id="dips__id__" name="univ_highlights[data][__id__][specializations]" placeholder="Program Specializations"></div></div>'
                    data-prefix="dip">
                </i>

                <hr>

                <!-- Other Programs -->
                <p>Other Programs</p>
                <div class="field_group">
                    <div class="field">
                        <label for="op_1">Program Name</label>
                        <input type="text" id="op_1" name="univ_highlights[data][4][name]" placeholder="Program Name">
                    </div>
                    <div class="field">
                        <label for="opd_1">Program Description</label>
                        <input type="text" id="opd_1" name="univ_highlights[data][4][description]"
                            placeholder="Program Description">
                    </div>
                    <div class="field">
                        <label for="ops_1">Program Specializations</label>
                        <input type="text" id="ops_1" name="univ_highlights[data][4][specializations]"
                            placeholder="Program Specializations">
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="op__id__">Program Name</label><input type="text" id="op__id__" name="univ_highlights[data][__id__][name]" placeholder="Program Name"></div><div class="field"><label for="opd__id__">Program Description</label><input type="text" id="opd__id__" name="univ_highlights[data][__id__][description]" placeholder="Program Description"></div><div class="field"><label for="ops__id__">Program Specializations</label><input type="text" id="ops__id__" name="univ_highlights[data][__id__][specializations]" placeholder="Program Specializations"></div></div>'
                    data-prefix="op">
                </i>
            </section>

            <!-- Admission Process -->
            <section class="panel">
                <h3 class="section_title">Admission Process: {{ $university['univ_name'] }}</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="ad_1">Admission Process Step 1</label>
                        <textarea oninput="auto_grow(this)" id="ad_1" name="univ_admission[data][1][title]"
                            placeholder="Write Here..."></textarea>
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="ad__id__">Admission Process Step __id__</label><textarea oninput="auto_grow(this)" id="ad__id__" name="univ_admission[data][__id__][title]" placeholder="Write Here..."></textarea></div></div>'
                    data-prefix="ad">
                </i>
            </section>

            <!-- Important Dates -->
            <section class="panel">
                <h3 class="section_title">Important Dates: {{ $university['univ_name'] }}</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="id_1">Important Date 1</label>
                        <textarea oninput="auto_grow(this)" id="id_1" name="univ_important_dates[data][1][title]"
                            placeholder="Write Here..."></textarea>
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="id__id__">Important Date __id__</label><textarea oninput="auto_grow(this)" id="id__id__" name="univ_important_dates[data][__id__][title]" placeholder="Write Here..."></textarea></div></div>'
                    data-prefix="id">
                </i>
            </section>

            <!-- Placement Details -->
            <section class="panel">
                <h3 class="section_title">Placement Details: {{ $university['univ_name'] }}</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="pd_1">Placement Detail 1</label>
                        <textarea oninput="auto_grow(this)" id="pd_1" name="univ_placement[data][1][title]"
                            placeholder="Write Here..."></textarea>
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="pd__id__">Placement Detail __id__</label><textarea oninput="auto_grow(this)" id="pd__id__" name="univ_placement[data][__id__][title]" placeholder="Write Here..."></textarea></div></div>'
                    data-prefix="pd">
                </i>
            </section>

            <!-- Scholarship -->
            <section class="panel">
                <h3 class="section_title">Scholarship: {{ $university['univ_name'] }}</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="sc_1">Scholarship Detail 1</label>
                        <textarea oninput="auto_grow(this)" id="sc_1" name="univ_scholarship[data][1][title]"
                            placeholder="Write Here..."></textarea>
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="sc__id__">Scholarship Detail __id__</label><textarea oninput="auto_grow(this)" id="sc__id__" name="univ_scholarship[data][__id__][title]" placeholder="Write Here..."></textarea></div></div>'
                    data-prefix="sc">
                </i>
            </section>

            <!-- Facilities -->
            <section class="panel">
                <h3 class="section_title">Facilities: {{ $university['univ_name'] }}</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="fa_1">Facility Name</label>
                        <input type="text" id="fa_1" name="univ_facilities[data][1][title]" placeholder="Facility Name">
                    </div>
                    <div class="field">
                        <label for="fad_1">Facility Description</label>
                        <textarea oninput="auto_grow(this)" id="fad_1" name="univ_facilities[data][1][description]"
                            placeholder="Facility Description"></textarea>
                    </div>

                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="fa__id__">Facility Name</label><input type="text" id="fa__id__" name="univ_facilities[data][__id__][title]" placeholder="Facility Name"></div><div class="field"><label for="fad__id__">Facility Description</label><textarea oninput="auto_grow(this)" id="fad__id__" name="univ_facilities[data][__id__][description]" placeholder="Facility Description"></textarea></div></div>'
                    data-prefix="fa">
                </i>
            </section>

            <!-- Gallery -->
            <section class="panel">
                <h3 class="section_title">Gallery: {{ $university['univ_name'] }}</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="gl_1">Image Title</label>
                        <input type="text" id="gl_1" name="univ_gallery[data][1][title]" placeholder="Image Title">
                    </div>

                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="gl__id__">Image Title</label><input type="text" id="gl__id__" name="univ_gallery[data][__id__][title]" placeholder="Image Title"></div></div>'
                    data-prefix="gl">
                </i>
            </section>

            <!-- Career Guidance -->
            <section class="panel">
                <h3 class="section_title">Career Guidance: {{ $university['univ_name'] }}</h3>
                <div class="field cflex">
                    <label for="car">About Carrier Guidance (optional)</label>
                    <input type="text" id="car" name="carrier[about]" placeholder="About Carrier">
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="car_1">Career Guidance Detail 1</label>
                        <textarea oninput="auto_grow(this)" id="car_1" name="univ_career_guidance[data][1][title]"
                            placeholder="Write Here..."></textarea>
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="car__id__">Career Guidance Detail __id__</label><textarea oninput="auto_grow(this)" id="car__id__" name="univ_career_guidance[data][__id__][title]" placeholder="Write Here..."></textarea></div></div>'
                    data-prefix="car">
                </i>
            </section>

            <!-- Industry-Ready Programs -->
            <section class="panel">
                <h3 class="section_title">Industry-Ready Programs: {{ $university['univ_name'] }}</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="ind_1">Industry Program 1</label>
                        <input type="text" id="ind_1" name="industry[data][]" placeholder="Industry Program Name">
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="ind__id__">Industry Program __id__</label><input type="text" id="ind__id__" name="industry[data][]" placeholder="Industry Program Name"></div></div>'
                    data-prefix="ind">
                </i>
            </section>

            <!-- Top Recruiters -->
            <section class="panel">
                <h3 class="section_title">Top Recruiters: {{ $university['univ_name'] }}</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="tr_1">Recruiter 1</label>
                        <input type="text" id="tr_1" name="univ_top_recruiters[data][1][title]" placeholder="Company Name">
                    </div>
                    <div class="field">
                        <label for="trl_1">Recruiter Logo (optional)</label>
                        <input type="file" id="trl_1" name="univ_top_recruiters[data][1][logo]"
                            onchange="display_pic(this)">
                        <img id="trl_1_preview" src="{{ asset('assets/images/placeholder.jpg') }}" alt="Recruiter Logo"
                            style="max-width: 200px; max-height: 100px; display: block; margin-top: 10px;">
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="tr__id__">Recruiter __id__</label><input type="text" id="tr__id__" name="univ_top_recruiters[data][__id__][title]" placeholder="Company Name"></div><div class="field"><label for="trl__id__">Recruiter Logo (optional)</label><input type="file" id="trl__id__" name="univ_top_recruiters[data][__id__][logo]" onchange="display_pic(this)"><img id="trl__id___preview" src="{{ asset('assets/images/placeholder.jpg') }}" alt="Recruiter Logo" style="max-width: 200px; max-height: 100px; display: block; margin-top: 10px;"></div></div>'
                    data-prefix="tr">
                </i>
            </section>

            <!-- Why this University -->
            <section class="panel">
                <h3 class="section_title">Why this University: {{ $university['univ_name'] }}</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="why_1">Reason 1</label>
                        <textarea oninput="auto_grow(this)" id="why_1" name="univ_why_this_university[data][1][title]"
                            placeholder="Write a compelling reason..."></textarea>
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="why__id__">Reason __id__</label><textarea oninput="auto_grow(this)" id="why__id__" name="univ_why_this_university[data][__id__][title]" placeholder="Write a compelling reason..."></textarea></div></div>'
                    data-prefix="why">
                </i>
            </section>

            <!-- FAQs -->
            <section class="panel">
                <h3 class="section_title">Frequently Asked Questions: {{ $university['univ_name'] }}</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="faqq_1">Question 1</label>
                        <input type="text" id="faqq_1" name="univ_faqs[data][1][question]" placeholder="Enter question">
                    </div>
                    <div class="field">
                        <label for="faqa_1">Answer 1</label>
                        <textarea oninput="auto_grow(this)" id="faqa_1" name="univ_faqs[data][1][answer]"
                            placeholder="Enter answer"></textarea>
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="faqq__id__">Question __id__</label><input type="text" id="faqq__id__" name="univ_faqs[data][__id__][question]" placeholder="Enter question"></div><div class="field"><label for="faqa__id__">Answer __id__</label><textarea oninput="auto_grow(this)" id="faqa__id__" name="univ_faqs[data][__id__][answer]" placeholder="Enter answer"></textarea></div></div>'
                    data-prefix="faq">
                </i>
            </section>

            <!-- Facts -->
            <section class="panel">
                <h3 class="section_title">Key Facts: {{ $university['univ_name'] }}</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="fact_1">Fact 1</label>
                        <input type="text" id="fact_1" name="univ_facts[data][1][title]"
                            placeholder="Enter an interesting fact">
                    </div>
                    <div class="field">
                        <label for="factd_1">Description (optional)</label>
                        <textarea oninput="auto_grow(this)" id="factd_1" name="univ_facts[data][1][description]"
                            placeholder="Add more details about this fact"></textarea>
                    </div>
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="fact__id__">Fact __id__</label><input type="text" id="fact__id__" name="univ_facts[data][__id__][title]" placeholder="Enter an interesting fact"></div><div class="field"><label for="factd__id__">Description (optional)</label><textarea oninput="auto_grow(this)" id="factd__id__" name="univ_facts[data][__id__][description]" placeholder="Add more details about this fact"></textarea></div></div>'
                    data-prefix="fact">
                </i>
            </section>

            <!-- Advantages -->
            <section class="panel">
                <h3 class="section_title">Advantages: {{ $university['univ_name'] }}</h3>
                <div class="field cflex">
                    <label for="cor">About University Advantage (optional)</label>
                    <input type="text" name="univ_adv[about]" placeholder="University Advantage About">
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field aie" style="width:auto;"><label for="advl__id__" class="logo"><img src="" alt="advl__id__"></label><input type="file" id="advl__id__" name="univ_adv[data][__id__][logo]" placeholder="University Advantage Logo" onchange="display_pic(this)"></div><div class="field cflex"><label for="advt__id__">Advantage Title</label><input type="text" id="advt__id__" name="univ_adv[data][__id__][title]" placeholder="University Advantage"></div><div class="field cflex"><label for="advd__id__">Advantage Description</label><input type="text" id="advd__id__" name="univ_adv[data][__id__][description] "placeholder="University Advantage Description"></div></div>'></i>
            </section>

            <!-- Industry -->
            <section class="panel">
                <h3 class="section_title">Industry: {{ $university['univ_name'] }}</h3>
                <div class="field cflex">
                    <label for="ind">About Industry (optional)</label>
                    <input type="text" name="industry[about]" placeholder="Industry About">
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="ind__id__">Industry __id__</label><input id="ind__id__" name="industry[data][]" placeholder="Industry Point" /></div>'></i>
            </section>

            <!-- Carrier Guidance -->
            <section class="panel">
                <h3 class="section_title">Career Guidance: {{ $university['univ_name'] }}</h3>
                <div class="field cflex">
                    <label for="car">About Carrier Guidance (optional)</label>
                    <input type="text" id="car" name="carrier[about]" placeholder="About Carrier">
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field cflex"><label for="car__id__">carrier __id__</label><input type="text" id="car__id__" name="carrier[data][]" placeholder="Carrier">'></i>
            </section>

            <!-- Seo Work -->
            <section class="panel">
                <h3 class="section_title">SEO Work: {{ $university['univ_name'] }}</h3>
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
            </section>
            <div class="field">
                <input type="checkbox" name="univ_detail_added" id="univ_active" value="1">
                <label for="univ_active">Show on frontend</label>
            </div>
            <button type="submit">Add University Details</button>
        </form>
    </main>
    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('universityDetailsForm');
                if (form) {
                    // Remove any existing submit event listeners
                    const newForm = form.cloneNode(true);
                    form.parentNode.replaceChild(newForm, form);

                    // Add our own submit handler
                    newForm.addEventListener('submit', function (e) {
                        // Let the form submit normally
                        return true;
                    });
                }
            });
        </script>
        <script>
            // Initialize counters for each section starting from 2 (since we have 1 default field)
            const fieldCounters = {
                'int': 2,   // Info
                'ca': 2,    // Campus Area
                'ss': 2,    // Student Strength
                'fs': 2,    // Faculty Strength
                'up': 1,    // Undergraduate Programs
                'pp': 1,    // Postgraduate Programs
                'pd': 1,    // Placement Details
                'ad': 1,    // Admission Details
                'sc': 1,    // Scholarship
                'fa': 1,    // Facilities
                'gl': 1,    // Gallery
                'cd': 1,    // Career Guidance
                'faq': 1,   // FAQs
                'over': 1,  // Facts
                'ind': 1,   // Industry
                'car': 1    // Carrier Guidance
            };

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.add_field').forEach(button => {
                    button.addEventListener('click', function (e) {
                        e.preventDefault();

                        const fieldHTML = this.getAttribute('data-field');
                        const fieldContainer = this.parentNode;

                        // Get the prefix from data-prefix attribute or extract it from the field HTML
                        let prefix = this.getAttribute('data-prefix');
                        if (!prefix) {
                            const fieldType = fieldHTML.match(/id="([a-z]{2})__/i);
                            prefix = fieldType ? fieldType[1] : 'field';
                        }

                        // Initialize counter for this field type if it doesn't exist
                        if (!fieldCounters[prefix]) {
                            fieldCounters[prefix] = 1;
                        }

                        // Replace all __id__ placeholders with the current counter value
                        let newField = fieldHTML.replace(/__id__/g, fieldCounters[prefix]);

                        // Create a temporary container to hold the new field
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = newField;

                        // Insert the new field before the add button
                        fieldContainer.insertBefore(tempDiv.firstChild, this);

                        // Update the label text to show the correct paragraph number
                        const label = tempDiv.querySelector('label[for^="' + prefix + '"]');
                        if (label) {
                            label.textContent = 'Paragraph ' + fieldCounters[prefix];
                        }

                        // Increment the counter for the next field of this type
                        fieldCounters[prefix]++;
                    });
                });
            });

            // Auto-grow textarea
            function auto_grow(element) {
                element.style.height = 'auto';
                element.style.height = (element.scrollHeight) + 'px';
            }

            // Form validation - temporarily disabled for testing
            const form = document.getElementById('universityDetailsForm');
            if (form) {
                // Validation temporarily disabled for testing
                // form.addEventListener('submit', function (e) {
                //     let isValid = true;
                //     const requiredFields = form.querySelectorAll('[required]');

                //     requiredFields.forEach(field => {
                //         if (!field.value.trim()) {
                //             isValid = false;
                //             field.classList.add('error');
                //         } else {
                //             field.classList.remove('error');
                //         }
                //     });


                //     if (!isValid) {
                //         e.preventDefault();
                //         alert('Please fill in all required fields');
                //     }
                // });

                // Initialize auto-grow for existing textareas
                const textareas = form.querySelectorAll('textarea');
                textareas.forEach(ta => {
                    ta.addEventListener('input', function () {
                        auto_grow(this);
                    });
                    // Trigger auto-grow on page load
                    auto_grow(ta);
                });

                // Initialize file input preview for existing file inputs
                const fileInputs = form.querySelectorAll('input[type="file"]');
                fileInputs.forEach(input => {
                    input.addEventListener('change', function () {
                        display_pic(this);
                    });
                });

                // Initialize all textareas with auto-grow
                document.querySelectorAll('textarea').forEach(ta => {
                    auto_grow(ta);
                    ta.addEventListener('input', function () {
                        auto_grow(this);
                    });
                });
            }
        </script>
    @endpush
@endsection