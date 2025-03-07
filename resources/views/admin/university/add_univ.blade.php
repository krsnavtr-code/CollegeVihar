@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <form action="/admin/university/add" method="post">
        <h2 class="page_title">Add University</h2>
        <section class="panel">
            @csrf
            <h3 class="section_title left">University Details</h3>
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="field_group">
                <div class="field">
                    <label for="">University Name <i class="text">( Full Name )</i></label>
                    <input type="text" placeholder="University Name" name="univ_name" required>
                    @error('univ_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field">
                    <label for="">University Url</label>
                    <input type="text" placeholder="University Url" name="univ_url" required>

                    @error('univ_url')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="">University Payout <i class="text">( In Months )</i></label>
                    <input type="number" placeholder="0" min="0" name="univ_payout">
                </div>
                <div class="field">
                    <label for="">University Type</label>
                    <select name="univ_type" id="">
                        <option value="" selected disabled>--- Please Select ---</option>
                        <option value="offline">offline</option>
                        <option value="online">online</option>
                    </select>
                </div>
                <div class="field">
                    <label for="">University Category</label>
                    <select name="univ_category" id="">
                        <option value="" selected disabled>--- Please Select ---</option>
                        <option value="central university">Central University</option>
                        <option value="state university">State University</option>
                        <option value="state private university">State Private University</option>
                        <option value="state public university">State Public University</option>
                        <option value="deemed university">Deemed University</option>
                        <option value="autonomous institude">Autonomous Institude</option>
                    </select>
                </div>
            </div>
        </section>
        <section class="panel">
            <h3 class="section_title">University Person Details</h3>
            <div class="field ">
                <label for="">Connected Person Name</label>
                <input type="test" placeholder="Person Name" name="univ_person">
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="">Connected Person Email</label>
                    <input type="email" placeholder="Person Email" name="univ_person_email">
                </div>
                <div class="field">
                    <label for="">Connected Person Contact</label>
                    <input type="text" placeholder="Person Contact" name="univ_person_phone">
                </div>
            </div>
        </section>
        <section class="card p-2 mb-4">
            <div class="flex">
                <h3>UG Course :</h3>
                <input type="search" name="" id="searchUG" placeholder="Search UG Courses" oninput="filterCourses('UG')">
            </div>
            <div class="courses">
                @foreach ($courses as $i => $course)
                @if ($course['course_type'] == 'UG')
                <div class="course-item-UG" title="{{ $course['course_name'] }}">
                    <input type="checkbox" value="{{ $course['id'] }}"
                        data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                        id="f{{ $i }}" onchange="add_commision_field(this,{{ $course['id'] }})">
                    <label for="f{{ $i }}" class="btn btn-outline-primary rounded-pill m-1">
                        {{ $course['course_name'] }} ({{ $course['course_short_name'] }})
                    </label>
                </div>
                @endif
                @endforeach
            </div>
            
        </section>
        <section class="card p-2 mb-4">
            <div class="flex">
                <h3>PG Courses :</h3>
                <input type="search" name="" id="searchPG" placeholder="Search PG Courses" oninput="filterCourses('PG')">
            </div>
            <div class="courses">
                @foreach ($courses as $i => $course)
                @if ($course['course_type'] == 'PG')
                <div class="course-item-PG" title="{{ $course['course_name'] }}">
                    <input type="checkbox" value="{{ $course['id'] }}"
                        data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                        id="f{{ $i }}"
                        onchange="add_commision_field(this,{{ $course['id'] }})">
                    <label for="f{{ $i }}" class="btn btn-outline-primary rounded-pill m-1">{{ $course['course_name'] }} ({{ $course['course_short_name'] }})</label>
                </div>
                @endif
                @endforeach
            </div>
        </section>
        <section class="card p-2 mb-4">
            <div class="flex">
                <h3>DIPLOMA Courses :</h3>
                <input type="search" name="" id="searchDIPLOMA" placeholder="Search DIPLOMA Courses" oninput="filterCourses('DIPLOMA')">
            </div>
            <div class="courses">
                @foreach ($courses as $i => $course)
                @if ($course['course_type'] == 'Diploma')
                <div class="course-item-DIPLOMA" title="{{ $course['course_name'] }}">
                    <input type="checkbox" value="{{ $course['id'] }}"
                        data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                        id="f{{ $i }}"
                        onchange="add_commision_field(this,{{ $course['id'] }})">
                    <label for="f{{ $i }}" class="btn btn-outline-primary rounded-pill m-1">{{ $course['course_name'] }} ({{ $course['course_short_name'] }})</label>
                </div>
                @endif
                @endforeach
            </div>
        </section>
        <section class="card p-2 mb-4">
            <div class="flex">
                <h3>CERTIFICATION Courses :</h3>
                <input type="search" name="" id="searchCERTIFICATION" placeholder="Search CERTIFICATION Courses" oninput="filterCourses('CERTIFICATION')">
            </div>
            <div class="courses">
                @foreach ($courses as $i => $course)
                @if ($course['course_type'] == 'Certification')
                <div class="course-item-CERTIFICATION" title="{{ $course['course_name'] }}">
                    <input type="checkbox" value="{{ $course['id'] }}"
                        data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                        id="f{{ $i }}" onchange="add_commision_field(this,{{ $course['id'] }})">
                    <label for="f{{ $i }}" class="btn btn-outline-primary rounded-pill m-1">{{ $course['course_name'] }} ({{ $course['course_short_name'] }})</label>
                </div>
                @endif
                @endforeach
            </div>
        </section>
        <section class="card p-2 mb-4">
            <div class="flex">
                <h3>TECHNICAL Courses :</h3>
                <input type="search" name="" id="searchTECHNICAL" placeholder="Search TECHNICAL Courses" oninput="filterCourses('TECHNICAL')">
            </div>
            <div class="courses">
                @foreach ($courses as $i => $course)
                @if ($course['course_type'] == 'TECHNICAL COURSES')
                <div class="course-item-TECHNICAL" title="{{ $course['course_name'] }}">
                    <input type="checkbox" value="{{ $course['id'] }}"
                    data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                    id="f{{ $i }}"
                    onchange="add_commision_field(this,{{ $course['id'] }})">
                    <label for="f{{ $i }}" class="btn btn-outline-primary rounded-pill m-1">{{ $course['course_name'] }} ({{ $course['course_short_name'] }})</label>
                </div>
                @endif
                @endforeach
            </div>
        </section>

        <section class="card p-2 mb-4">
            <div class="flex">
                <h3>MANAGEMENT Courses :</h3>
                <input type="search" name="" id="searchMANAGEMENT" placeholder="Search MANAGEMENT Courses" oninput="filterCourses('MANAGEMENT')">
            </div>
            <div class="courses">
                @foreach ($courses as $i => $course)
                @if ($course['course_type'] == 'MANAGEMENT COURSES')
                <div class="course-item-MANAGEMENT" title="{{ $course['course_name'] }}">
                    <input type="checkbox" value="{{ $course['id'] }}"
                    data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                    id="f{{ $i }}"
                    onchange="add_commision_field(this,{{ $course['id'] }})">
                    <label for="f{{ $i }}" class="btn btn-outline-primary rounded-pill m-1">{{ $course['course_name'] }} ({{ $course['course_short_name'] }})</label>
                </div>
                @endif
                @endforeach
            </div>
        </section>

        <section class="card p-2 mb-4">
            <div class="flex">
                <h3>MEDICAL Courses :</h3>
                <input type="search" name="" id="searchMEDICAL" placeholder="Search MEDICAL Courses" oninput="filterCourses('MEDICAL')">
            </div>
            <div class="courses">
                @foreach ($courses as $i => $course)
                @if ($course['course_type'] == 'MEDICAL COURSES')
                <div class="course-item-MEDICAL" title="{{ $course['course_name'] }}">
                    <input type="checkbox" value="{{ $course['id'] }}"
                    data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                    id="f{{ $i }}"
                    onchange="add_commision_field(this,{{ $course['id'] }})">
                    <label for="f{{ $i }}" class="btn btn-outline-primary rounded-pill m-1">{{ $course['course_name'] }} ({{ $course['course_short_name'] }})</label>
                </div>
                @endif
                @endforeach
            </div>
        </section>

        <section class="card p-2 mb-4">
            <div class="flex">
                <h3>TRADITIONAL Courses :</h3>
                <input type="search" name="" id="searchTRADITIONAL" placeholder="Search TRADITIONAL Courses" oninput="filterCourses('TRADITIONAL')">
            </div>
            <div class="courses">
                @foreach ($courses as $i => $course)
                @if ($course['course_type'] == 'TRADITIONAL COURSES')
                <div class="course-item-TRADITIONAL" title="{{ $course['course_name'] }}">
                    <input type="checkbox" value="{{ $course['id'] }}"
                    data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                    id="f{{ $i }}"
                    onchange="add_commision_field(this,{{ $course['id'] }})">
                    <label for="f{{ $i }}" class="btn btn-outline-primary rounded-pill m-1">{{ $course['course_name'] }} ({{ $course['course_short_name'] }})</label>
                </div>
                @endif
                @endforeach
            </div>
        </section>

        <section class="panel">
            <h3 class="section_title">Commision</h3>
            <section id="courses"></section>
        </section>
        <div class="text-center p-4">
            <button type="submit" class="btn btn-primary btn-lg">Add University</button>
        </div>
    </form>
</main>
@push('script')
<script>
    function display_pic(node) {
        $(`label[for='${node.id}'] img`)[0].src = URL.createObjectURL(node.files[0]);
    }
    $(".add_field").perform((n) => {
        n.addEventListener("click", () => {
            let parent = n.parentElement;
            let field_group = parent.$(".field_group")[0];
            let new_node = field_group.cloneNode(true);
            field_group.insert(3, new_node);
        })
    })

    function  filterCourses(courseType) {
        let input = document.getElementById('search' + courseType);
        let filter = input.value.toLowerCase();
        let courseItems = document.querySelectorAll('.course-item-' + courseType);

        courseItems.forEach(function(item) {
            let courseName = item.textContent || item.innerText;
            if (courseName.toLowerCase().indexOf(filter) > -1) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    }

    function add_commision_field(node, no) {
        if (node.checked) {
            addField(no, node.get("data-course"), node.get("id"));
        } else {
            $("#field" + no).remove();
        }
    }

    function addField(no, course, link) {
        let courses = $("#courses");
        let fields = courses.$(".field_group").length;
        let newField =
            `<div class="field_group head_field" id="field${no}" data-linked="${link}"><h6>${course}</h6><div class="field_group"><div class="field"><input type="hidden" name="course[${no}][id]" value="${no}"><input type="text" name="course[${no}][fee]" placeholder="Total Univ-Course Fees"></div><div class="field"><input type="text" name="course[${no}][commision]" placeholder="Commision %"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div></div>`;
        courses.append(newField);
    }

    function delete_field(n) {
        let main = n.closest(".head_field");
        let link = $("#" + main.get("data-linked"));
        link.checked = false;
        main.remove();
    }
</script>
@endpush
@endsection