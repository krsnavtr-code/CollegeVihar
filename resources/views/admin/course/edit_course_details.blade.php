@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <form action="/admin/course/edit/details" method="post">
        <h2 class="page_title">Edit Course Details </h2>
        @csrf
        <section class="panel">
            <h3 class="section_title">Course URL slug</h3>
            <div class="with_data flex">
                <h6 class="fw-bold text-secondary">https://collegevihar.com/course/</h6>
                <div class="field">
                    <input type="text" name="url_slug" value="{{ $course['metadata']['url_slug'] }}" style="padding: 10px;">
                    <input type="hidden" name="course_id" value="{{ $course['id'] }}">
                </div>
            </div>
        </section>
        <section>
            <h3 class="section_title">Course Duration and Eligibility</h3>
            <div class="field_group">
                <div class="field">
                    <label for="f1">Course Duration</label>
                    <input type="text" id="f1" name="course_duration" placeholder="Duration"
                        value="{{ $course['course_duration'] }}">
                </div>
                <div class="field">
                    <label for="f2">Course Eligibility</label>
                    <input type="text" id="f2" name="course_eligibility_short" placeholder="Eligibility"
                        value="{{ $course['course_eligibility_short'] }}">
                </div>
            </div>
        </section>
        <section class="panel">
            <h3 class="section_title">Course Introduction</h3>
            @foreach (json_decode($course['course_intro']) as $i => $intro)
            <div class="field_group head_field flex flex">
                <div class="field">
                    <label for="int{{ $i + 1 }}">Paragraph {{ $i + 1 }}</label>
                    <textarea oninput="auto_grow(this)" id="int{{ $i + 1 }}" name="course_intro[]" placeholder="Write Here...">{{ $intro }}</textarea>
                </div>
                <button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            @endforeach
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field flex"><div class="field"><label for="int__id__">Paragraph __id__</label><textarea  oninput="auto_grow(this)" id="int__id__" name="course_intro[]" placeholder="Write Here..."></textarea></div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle"><i class="fa-solid fa-trash"></i></button></div>'>
                <i class="fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <section class="panel">
            <h3 class="section_title">Course Overview</h3>
            @foreach (json_decode($course['course_overview']) as $i => $intro)
            <div class="field_group head_field flex">
                <div class="field">
                    <label for="over{{ $i + 1 }}">Paragraph {{ $i + 1 }}</label>
                    <textarea oninput="auto_grow(this)" id="over{{ $i + 1 }}" name="course_overview[]" placeholder="Write Here...">{{ $intro }}</textarea>
                </div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            @endforeach
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field flex"><div class="field"><label for="over__id__">Paragraph __id__</label><textarea  oninput="auto_grow(this)" id="over__id__" name="course_overview[]" placeholder="Write Here..."></textarea></div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button></div>'>
                <i class="fa-solid fa-plus"></i>
                <span>Add</span>
            </button>

        </section>
        <section class="panel">
            <h3 class="section_title">Course Heighlights</h3>
            @foreach (json_decode($course['course_highlights'], true) as $i => $high)
            <div class="field_group head_field flex">
                <div class="field">
                    <label for="highti{{ $i + 1 }}">Highlight Title</label>
                    <input type="text" id="highti{{ $i + 1 }}"
                        name="course_highlights[{{ $i + 1 }}][title]" placeholder="Title"
                        value="{{ $high['title'] }}">
                </div>
                <div class="field">
                    <label for="highde{{ $i + 1 }}">Highlight Description</label>
                    <input type="text" id="highde{{ $i + 1 }}"
                        name="course_highlights[{{ $i + 1 }}][desc]" placeholder="Description"
                        value="{{ $high['desc'] }}">
                </div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            @endforeach
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field flex"><div class="field"><label for="highti__id__">Highlight Title</label><input type="text" id="highti__id__" name="course_highlights[__id__][title]" placeholder="Title"></div><div class="field"><label for="highde__id__">Highlight Description</label><input type="text" id="highde__id__" name="course_highlights[__id__][desc]" placeholder="Description"></div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button></div>'>
                <i class="fa-solid fa-plus"></i>
                <span>Add</span>
            </button>

        </section>
        <section class="panel">
            @php
            $course_subjects = json_decode($course['course_subjects'], true);
            @endphp
            <h3 class="section_title">Course Subjects</h3>
            <div class="field">
                <label for="cor">About Course Subjects (optional)</label>
                <input type="text" id="cor" name="course_subjects[about]" placeholder="About"
                    value="{{ $course_subjects['about'] }}">
            </div>
            @isset($course_subjects['data'])
            <div class="row">
                @foreach ($course_subjects['data'] as $i => $sub)
                <div class="col-lg-6">
                    <div class="field_group head_field flex">
                        <div class="field"><label for="cou{{ $i + 1 }}">Subject {{ $i + 1 }}</label><input
                                type="text" id="cou{{ $i + 1 }}" name="course_subjects[data][]"
                                placeholder="Subject" value="{{ $sub }}"></div>
                        <button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @endisset
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field flex"><div class="field"><label for="cou__id__">Subject __id__</label><input type="text" id="cou__id__" name="course_subjects[data][]" placeholder="Subject"></div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button></div>'>
                <i class="fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <section class="panel">
            @php
            $course_eligibility = json_decode($course['course_eligibility'], true);
            @endphp
            <h3 class="section_title">Course Eligibility</h3>
            <div class="field">
                <label for="eli">About Course Eligibility (optional)</label>
                <input type="text" id="eli" name="course_eligibility[about]" placeholder="About"
                    value="{{ $course_eligibility['about'] }}">
            </div>
            @isset($course_eligibility['data'])
            @foreach ($course_eligibility['data'] as $eli)
            <div class="field_group head_field flex">
                <div class="field"><label for="eli{{ $i + 1 }}">Eligibilty</label><input type="text"
                        id="eli{{ $i + 1 }}" name="course_eligibility[data][]" placeholder="Title"
                        value="{{ $eli }}"></div><i class="icon delete fa-solid fa-trash"
                    onclick="delete_field(this)"></i>
            </div>
            @endforeach
            @endisset
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field flex"><div class="field"><label for="eli__id__">Eligibilty</label><input type="text" id="eli__id__" name="course_eligibility[data][]" placeholder="Title"></div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button></div>'>
                <i class="fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <section class="panel">
            <h3 class="section_title">Course freights</h3>
            <div class="field">
                <label for="fri">Course freights</label>
                <textarea oninput="auto_grow(this)" id="fri" name="course_freights" placeholder="About Course freights">{{ $course['course_freights'] }}
                </textarea>
            </div>
        </section>
        <section class="panel">
            @php
            $specialization = json_decode($course['course_specialization'], true);
            @endphp
            <h3 class="section_title">Specializations</h3>
            <div class="field">
                <label for="spe">About Course Specializations (optional)</label>
                <input type="text" id="spe" name="course_specialization[about]"
                    placeholder="About Specialization">
            </div>
            @isset($specialization['data'])
            @foreach ($specialization['data'] as $i => $spe)
            <div class="field_group head_field flex">
                <div class="field">
                    <label for="spe{{ $i + 1 }}">Specialization {{ $i + 1 }}</label>
                    <input type="text" id="spe{{ $i + 1 }}" name="course_specialization[data][]"
                        placeholder="Specialization" value="{{ $spe }}">
                </div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            @endforeach
            @endisset
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field flex"><div class="field"><label for="spe__id__">Specialization __id__</label><input type="text" id="spe__id__" name="course_specialization[data][]" placeholder="Specialization"></div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button></div>'>
                <i class="fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <section class="panel">
            @php
            $course_job = json_decode($course['course_job'], true);
            @endphp
            <h3 class="section_title">Job Opportunity</h3>
            <div class="field">
                <label for="opp">About Job Opportunity (optional)</label>
                <input type="text" id="opp" name="course_job[about]" placeholder="About Opportunity"
                    value="{{ $course_job['about'] }}">
            </div>
            @isset($course_job['data'])
            <div class="row">
                @foreach ($course_job['data'] as $i => $job)
                <div class="col-lg-6">
                    <div class="field_group head_field flex">
                        <div class="field">
                            <label for="opp{{ $i + 1 }}">Opportunity {{ $i + 1 }}</label>
                            <input type="text" id="opp{{ $i + 1 }}" name="course_job[data][]"
                                placeholder="Opportunity" value="{{ $job }}">
                        </div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @endisset
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field flex"><div class="field"><label for="opp__id__">Opportunity __id__</label><input type="text" id="opp__id__" name="course_job[data][]" placeholder="Opportunity"></div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button></div>'>
                <i class="fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <section class="panel">
            <h3 class="section_title">Types of Course</h3>
            @foreach (json_decode($course['course_types'], true) as $i => $course_type)
            <div class="field_group head_field flex">
                <div class="field">
                    <label for="cort{{ $i + 1 }}">Course Type Title</label>
                    <input type="text" id="cort{{ $i + 1 }}"
                        name="course_type[{{ $i + 1 }}][title]" placeholder="Title"
                        value="{{ $course_type['title'] }}">
                </div>
                <div class="field">
                    <label for="cord{{ $i + 1 }}">Course Type Description</label>
                    <input type="text" id="cord{{ $i + 1 }}"
                        name="course_type[{{ $i + 1 }}][desc]" placeholder="Description"
                        value="{{ $course_type['desc'] }}">
                </div>
                <button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            @endforeach
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field flex"><div class="field"><label for="cort__id__">Course Type Title</label><input type="text" id="cort__id__" name="course_type[__id__][title]" placeholder="Title"></div><div class="field"><label for="cord__id__">Course Type Description</label><input type="text" id="cord__id__" name="course_type[__id__][desc]" placeholder="Description"></div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button></div>'>
                <i class="fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <section class="panel">
            <h3 class="section_title">Why this Course</h3>
            @foreach (json_decode($course['why_this_course']) as $i => $why)
            <div class="field_group head_field flex">
                <div class="field"><label for="why{{ $i + 1 }}">Paragraph
                        {{ $i + 1 }}</label>
                    <textarea oninput="auto_grow(this)" id="why{{ $i + 1 }}" name="why_this_course[]"
                        placeholder="Write Here...">{{ $why }}</textarea>
                </div>
                <button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            @endforeach
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field flex"><div class="field"><label for="why__id__">Paragraph __id__</label><textarea oninput="auto_grow(this)" id="why__id__" name="why_this_course[]" placeholder="Write Here..."></textarea></div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button></div>'>
                <i class="fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <section class="panel">
            <h3 class="section_title">Faqs</h3>
            @foreach (json_decode($course['course_faqs'], true) as $i => $faq)
            <div class="field_group head_field flex">
                <div class="field">
                    <label for="faqg{{ $i + 1 }}">Faq Question</label>
                    <input type="text" id="faqg{{ $i + 1 }}"
                        name="faq[{{ $i + 1 }}][question]" placeholder="Question"
                        value="{{ $faq['question'] }}">
                </div>
                <div class="field">
                    <label for="faqa{{ $i + 1 }}">Faq Question</label><input type="text"
                        id="faqa{{ $i + 1 }}" name="faq[{{ $i + 1 }}][answer]"
                        placeholder="Answer" value="{{ $faq['answer'] }}">
                </div>
                <button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            @endforeach
            <button class="add_field btn btn-primary"
                data-init={{ $i + 2 }}
                data-field='<div class="field_group head_field flex"><div class="field"><label for="faqg__id__">Faq Question</label><input type="text" id="faqg__id__" name="faq[__id__][question]" placeholder="Question"></div><div class="field"><label for="faqa__id__">Faq Question</label><input type="text" id="faqa__id__" name="faq[__id__][answer]" placeholder="Answer"></div><button onclick="delete_field(this)" class="btn btn-danger rounded-circle">
                    <i class="fa-solid fa-trash"></i>
                </button></div>'>
                <i class="fa-solid fa-plus"></i>
                <span>Add</span>
            </button>
        </section>
        <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">Update Course Details</button>
        </div>
    </form>
</main>
@push('script')
<script>
    $(".add_field").perform((n) => {
        let i = n.get('data-init');
        n.addEventListener('click', function() {
            n.insert(0, n.get('data-field').replaceAll('__id__', i++));
        });
    })

    function auto_grow(element) {
        element.style.height = (element.scrollHeight + 1.5) + "px";
    }
    $("textarea").perform((n) => {
        auto_grow(n);
    })

    function delete_field(n) {
        let main = n.closest(".head_field flex");
        main.remove();
    }
</script>
@endpush
@endsection