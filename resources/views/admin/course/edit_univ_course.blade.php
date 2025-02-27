@extends('admin.components.layout')
@section('main')
    <main>
        @include('admin.components.response')
        <form action="/admin/university/courses/edit" method="post">
            <h2 class="page_title">Add Course </h2>
            @csrf
            <section class="panel">
                <h3 class="section_title">Course URL slug</h3>
                <div class="field with_data aic">
                    <input type="hidden" name="course_id" value="{{ $course['id'] }}">
                    <h6>https://collegevihar.com/course/</h6>
                    <input type="text" name="course_slug" id="course_slug" placeholder="Course Slug"
                        style="padding-inline: 5px;font-weight:600;"
                        value="{{ str_replace(' ', '-', strtolower($course['university']['univ_name'])) }}-{{ str_replace(' ', '-', strtolower($course['course']['course_name'])) }}">
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">About University Course</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="int__id__">Paragraph __id__</label><textarea id="int__id__" name="uc_about[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">University Course Overview</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="over__id__">Paragraph __id__</label><textarea id="over__id__" name="uc_overview[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">University Course Heighlights</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label>Highlight Title</label><input type="text" id="highti__id__" name="uc_highlights[]" placeholder="Title"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">How CollegeVihar Help you</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="over__id__">Paragraph __id__</label><textarea id="over__id__" name="uc_cv_help[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            {{-- <section class="panel">
                <h3 class="section_title">Specialization of Collegevihar to Course</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="over__id__">Paragraph __id__</label><textarea id="over__id__" name="uc_speci[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section> --}}
            <section class="panel">
                <h3 class="section_title">Collaboration to succeed</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="over__id__">Paragraph __id__</label><textarea id="over__id__" name="uc_collab[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Grouping with experts</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="over__id__">Paragraph __id__</label><textarea id="over__id__" name="uc_expert[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            <section class="panel semester_panel">
                <h3 class="section_title">University Course <i class="text">Subject block 1</i></h3>
                <div class="field">
                    <label for="">Subject Block Title <i class="text">(Semester/Year)</i></label>
                    <input type="text" value="Semester 1" name="uc_subjects[0][title]">
                </div>
                <i class="icon fa-solid fa-plus" onclick="add_field(this)"
                    data-field='<div class="field_group head_field"><div class="field"><label for="">Subject block 1 - <i class="text">Subject __id__</i></label><input type="text" placeholder="Subject Name" name="uc_subjects[0][subjects][]"></div></div>'></i>
                <i class="fa-solid fa-list-tree icon" onclick="addsubjects(this)"></i>
                <i class="sem_btn ase" style="border: 1px solid; padding:10px 20px;border-radius:5px;cursor:pointer;"
                    onclick="addsemester()">Add Subject Group</i>
            </section>
            <section class="panel">
                <h3 class="section_title">Course Assignments</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="opp__id__">Assignment __id__</label><input type="text" id="opp__id__" name="uc_assign[]" placeholder="Assignment"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">University Course Details</h3>
                <div class="field_group">
                    <div class="field">
                        <label for="highti1">Detail Title</label>
                        <input type="text" name="uc_details[0][title]" value="course" readonly>
                    </div>
                    <div class="field">
                        <label for="highti1">Detail Value</label>
                        <input type="text" name="uc_details[0][desc]" placeholder="Description">
                    </div>
                </div>
                <div class="field_group">
                    <div class="field">
                        <label>Detail Title</label>
                        <input type="text" name="uc_details[1][title]" value="course level" readonly>
                    </div>
                    <div class="field">
                        <label>Detail Value</label>
                        <input type="text" name="uc_details[1][desc]" placeholder="Description">
                    </div>
                </div>
                <div class="field_group">
                    <div class="field">
                        <label>Detail Title</label>
                        <input type="text" name="uc_details[2][title]" value="mode of education" readonly>
                    </div>
                    <div class="field">
                        <label>Detail Value</label>
                        <input type="text" name="uc_details[2][desc]" placeholder="Description">
                    </div>
                </div>
                <div class="field_group">
                    <div class="field">
                        <label>Detail Title</label>
                        <input type="text" name="uc_details[3][title]" value="approvals" readonly>
                    </div>
                    <div class="field">
                        <label>Detail Value</label>
                        <input type="text" name="uc_details[3][desc]" placeholder="Description">
                    </div>
                </div>
                <div class="field_group">
                    <div class="field">
                        <label>Detail Title</label>
                        <input type="text" name="uc_details[4][title]" value="duration" readonly>
                    </div>
                    <div class="field">
                        <label>Detail Value</label>
                        <input type="text" name="uc_details[4][desc]" placeholder="Description">
                    </div>
                </div>
                <div class="field_group">
                    <div class="field">
                        <label>Detail Title</label>
                        <input type="text" name="uc_details[5][title]" value="eligibilty" readonly>
                    </div>
                    <div class="field">
                        <label>Detail Value</label>
                        <input type="text" name="uc_details[5][desc]" placeholder="Description">
                    </div>
                </div>
                <div class="field_group">
                    <div class="field">
                        <label>Detail Title</label>
                        <input type="text" name="uc_details[6][title]" value="career transitions" readonly>
                    </div>
                    <div class="field">
                        <label>Detail Value</label>
                        <input type="text" name="uc_details[6][desc]" placeholder="Description">
                    </div>
                </div>
                <i class="icon fa-solid fa-plus " onclick="add_field(this)"
                    data-field='<div class="field_group head_field"><div class="field"><label>Detail Title</label><input type="text" id="highti__id__" name="uc_details[__id__][title]" placeholder="Title"></div><div class="field"><label for="highde__id__">Detail Value</label><input type="text" id="highde__id__" name="uc_details[__id__][desc]" placeholder="Description"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'
                    data-count="7"></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Job Opportunity</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="opp__id__">Opportunity __id__</label><input type="text" id="opp__id__" name="uc_job[]" placeholder="Opportunity"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
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
                        <input type="text" id="meta_description" name="meta_description"
                            placeholder="meta_description">
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

            function add_field(n) {
                let count = Number(n.get('data-count') ?? 1);
                n.insert(0, n.get('data-field').replaceAll('__id__', count));
                n.set("data-count", ++count)
            }

            function delete_field(n) {
                let main = n.closest(".head_field");
                main.remove();
            }

            function addsemester() {
                let all_panels = $(".semester_panel");
                let last_panel = all_panels[all_panels.length - 1];
                let data =
                    `<section class="panel semester_panel"><h3 class="section_title">University Course <i class="text">Subject block __semid__</i></h3><div class="field"><label for="">Subject Block Title <i class="text">(Semester/Year)</i></label><input type="text" name="uc_subjects[__semid__][title]"  value="Semester __semid__"></div><i class="icon fa-solid fa-plus" onclick="add_field(this)" data-field='<div class="field_group head_field"><div class="field"><label for="">Subject block __semid__ - <i class="text">Subject __id__</i></label><input type="text" placeholder="Subject Name" name="uc_subjects[__semid__][subjects][]"></div></div>'></i><i class="fa-solid fa-list-tree icon" onclick="addsubjects(this)"></i><i class="ase sem_btn" style="border: 1px solid; padding:10px 20px;border-radius:5px;cursor:pointer;" onclick="addsemester()">Add Subject block</i></section>`;
                last_panel.$(".sem_btn")[0].remove();
                last_panel.insert(3, data.replaceAll('__semid__', all_panels.length + 1));
            }

            function addsubjects(node) {
                let subjects = prompt("Enter Subjects Buddy").split("\r\n").map(x => x.trim());
                let add_field_btn = node.previousElementSibling;
                for (let i = 0; i < subjects.length; i++) {
                    const subject = subjects[i];
                    add_field(add_field_btn);
                    let last_added = add_field_btn.previousElementSibling;
                    last_added.$("input")[0].value = subject;
                }
            }
        </script>
    @endpush
@endsection