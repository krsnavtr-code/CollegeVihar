@extends('admin.components.layout')
@section('main')
    <main>
        @include('admin.components.response')
        <form action="/admin/course/add/details" method="post">
            <h2 class="page_title">Add Course </h2>
            @csrf
            <section class="panel">
                <h3 class="section_title">Course URL slug</h3>
                <div class="field with_data aic">
                    <input type="hidden" name="course_id" value="{{ $course['id'] }}">
                    <h6>https://firstvite.com/course/</h6>
                    <input type="text" name="course_slug" id="course_slug" placeholder="Course Slug"
                        style="padding-inline: 5px;font-weight:600;"
                        value="{{ str_replace(' ', '-', strtolower($course['course_name'])) }}">
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">Course Duration and Eligibility</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="f1">Course Duration</label>
                        <input type="text" id="f1" name="course_duration" placeholder="Duration">
                    </div>
                    <div class="field">
                        <label for="f2">Course Eligibility</label>
                        <input type="text" id="f2" name="course_eligibility_short" placeholder="Eligibility">
                    </div>
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">Course Introduction</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field"><label for="int__id__">Paragraph __id__</label><textarea id="int__id__" name="course_intro[]" placeholder="Write Here..."></textarea></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Course Overview</h3>
                <i class="icon fa-solid fa-plus add_field" data-field='<div class="field"><label for="over__id__">Paragraph __id__</label><textarea id="over__id__" name="course_overview[]" placeholder="Write Here..."></textarea></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Course Heighlights</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="highti__id__">Highlight Title</label><input type="text" id="highti__id__" name="course_highlights[__id__][title]" placeholder="Title"></div><div class="field"><label for="highde__id__">Highlight Description</label><input type="text" id="highde__id__" name="course_highlights[__id__][desc]" placeholder="Description"></div></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Course Subjects</h3>
                <div class="field">
                    <label for="cor">About Course Subjects (optional)</label>
                    <input type="text" id="cor" name="course_subjects[about]" placeholder="About">
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field"><label for="cou__id__">Subject __id__</label><input type="text" id="cou__id__" name="course_subjects[data][]" placeholder="Subject"></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Course Eligibility</h3>
                <div class="field">
                    <label for="eli">About Course Eligibility (optional)</label>
                    <input type="text" id="eli" name="course_eligibility[about]" placeholder="About">
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field"><label for="eli__id__">Eligibilty</label><input type="text" id="eli__id__" name="course_eligibility[data][]" placeholder="Title"></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Course freights</h3>
                <div class="field">
                    <label for="fri">Course freights</label>
                    <input type="text" id="fri" name="course_freights" placeholder="About Course freights">
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">Specializations</h3>
                <div class="field">
                    <label for="spe">About Course Specializations (optional)</label>
                    <input type="text" id="spe" name="course_specialization[about]" placeholder="About Specialization">
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field"><label for="spe__id__">Specialization __id__</label><input type="text" id="spe__id__" name="course_specialization[data][]" placeholder="Specialization"></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Job Opportunity</h3>
                <div class="field">
                    <label for="opp">About Job Opportunity (optional)</label>
                    <input type="text" id="opp" name="course_job[about]" placeholder="About Opportunity">
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field"><label for="opp__id__">Opportunity __id__</label><input type="text" id="opp__id__" name="course_job[data][]" placeholder="Opportunity">'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Types of Course</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="cort__id__">Course Type Title</label><input type="text" id="cort__id__" name="course_type[__id__][title]" placeholder="Title"></div><div class="field"><label for="cord__id__">Course Type Description</label><input type="text" id="cord__id__" name="course_type[__id__][desc]" placeholder="Description"></div></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Why this Course</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field"><label for="why__id__">Paragraph __id__</label><textarea id="why__id__" name="why_this_course[]" placeholder="Write Here..."></textarea></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Faqs</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="faqg__id__">Faq Question</label><input type="text" id="faqg__id__" name="faq[__id__][question]" placeholder="Question"></div><div class="field"><label for="faqa__id__">Faq Question</label><input type="text" id="faqa__id__" name="faq[__id__][answer]" placeholder="Answer"></div></div>'></i>
                {{-- <i class="icon fa-solid fa-trash"></i> --}}
            </section>
            <section class="panel">
                <h3 class="section_title">Seo Work</h3>
                <div class="field">
                    <label for="meta_h1">Text to display in H1 tag</label>
                    <input type="text" id="meta_h1" name="meta_h1" placeholder="meta_h1">
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="meta_title">Meta Title of Page</label>
                        <input type="text" id="meta_title" name="meta_title" placeholder="meta_title">
                    </div>
                    <div class="field">
                        <label for="meta_description">Meta Description of Page</label>
                        <input type="text" id="meta_description" name="meta_description" placeholder="meta_description">
                    </div>
                </div>
                <div class="field">
                    <label for="meta_key">Meta Keywords of Page (key1, key2, key3)</label>
                    <input type="text" id="meta_key" name="meta_keywords" placeholder="meta_keywords">
                </div>
                <div class="field">
                    <label for="om">If any (Write complete tags)</label>
                    <input type="text" id="om" name="other_meta_tags" placeholder="other_meta_tags">
                </div>
            </section>
            <div class="field">
                <input type="checkbox" name="course_detail_added" id="course_active" value="1">
                <label for="course_active">Show on frontend</label>
            </div>
            <div class="p-4 text-end">
                <button class="btn btn-primary btn-lg" type="submit">Add Course</button>
            </div>
        </form>
    </main>
    @push('script')
        <script>
            $(".add_field").perform((n) => {
                let i = 1;
                n.addEventListener('click', function() {
                    n.insert(0, n.get('data-field').replaceAll('__id__', i++));
                });
            })
        </script>
    @endpush
@endsection
