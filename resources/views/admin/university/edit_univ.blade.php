@php
$added = [];
foreach ($university['courses'] as $course) {
$added[] = $course['id'];
}
@endphp
@extends('admin.components.layout')
@section('main')
<main>
    <!-- http://localhost:8000/admin/university/edit/34 -->
    @include('admin.components.response')
    <form action="/admin/university/edit" method="post">
        <h2 class="page_title">Edit University</h2>
        <section class="panel">
            @csrf
            <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
            <h3 class="section_title left">University Details</h3>
            <div class="field_group">
                <div class="field">
                    <label for="">University Name <i class="text">( Full Name - Chota nhi dalna)</i></label>
                    <input type="text" placeholder="University Name" name="univ_name"
                        value="{{ $university['univ_name'] }}">
                </div>
                <div class="field">
                    <label for="">University Url</label>
                    <input type="text" placeholder="University Url" name="univ_url"
                        value="{{ $university['univ_url'] }}">
                </div>
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="">University Payout <i class="text">(In Months)</i></label>
                    <input type="number" placeholder="0" min="0" name="univ_payout">
                </div>
                <div class="field">
                    <label for="">University Type</label>
                    <select name="univ_type" id="" required>
                        <option value="" selected disabled>--- Please Select ---</option>
                        <option @if ($university['univ_type']=='offline' ) selected @endif value="offline">offline</option>
                        <option @if ($university['univ_type']=='online' ) selected @endif value="online">online</option>
                    </select>
                </div>
            </div>
        </section>
        <section class="panel">
            <h3 class="section_title">University Person Details</h3>
            <div class="field">
                <label for="">Connected Person Name</label>
                <input type="test" placeholder="Person Name" name="univ_person"
                    value="{{ $university['univ_person'] }}">
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="">Connected Person Email</label>
                    <input type="email" placeholder="Person Email" name="univ_person_email"
                        value="{{ $university['univ_person_email'] }}">
                </div>
                <div class="field">
                    <label for="">Connected Person Contact</label>
                    <input type="text" placeholder="Person Contact" name="univ_person_phone"
                        value="{{ $university['univ_person_phone'] }}">
                </div>
            </div>
        </section>
        <section class="card p-2 mb-4">
            <div class="flex">
                <h3>UG Courses</h3>
                <input type="search" name="" id="" placeholder="Search UG Courses">
            </div>
            <div class="courses">
                @foreach ($courses as $i => $course)
                @if ($course['course_type'] == 'UG')
                <div @class(['disable'=> in_array($course['id'], $added)]) title="{{ $course['course_name'] }}">
                    <input type="checkbox" value="{{ $course['id'] }}"
                        data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                        id="f{{ $i }}" @if (in_array($course['id'], $added)) checked disabled @endif
                        onchange="add_commision_field(this,{{ $course['id'] }})">
                    <label for="f{{ $i }}" class="btn btn-outline-primary rounded-pill m-1">({{ $course['course_short_name'] }}) {{ $course['course_name'] }}</label>
                </div>
                @endif
                @endforeach
            </div>
        </section>
        <section class="card p-2 mb-4">
            <div class="flex">
                <h3>PG Courses</h3>
                <input type="search" name="" id="" placeholder="Search PG Courses">
            </div>
            <div class="courses">
                @foreach ($courses as $i => $course)
                @if ($course['course_type'] == 'PG')
                <div @class(['disable'=> in_array($course['id'], $added)]) title="{{ $course['course_name'] }}">
                    <input type="checkbox" value="{{ $course['id'] }}"
                        data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                        id="f{{ $i }}" @if (in_array($course['id'], $added)) checked disabled @endif
                        onchange="add_commision_field(this,{{ $course['id'] }})">
                    <label for="f{{ $i }}" class="btn btn-outline-primary rounded-pill m-1">({{ $course['course_short_name'] }}) {{ $course['course_name'] }}</label>
                </div>
                @endif
                @endforeach
            </div>
        </section>
        <section class="card p-2 mb-4">
            <div class="flex">
                <h3>DIPLOMA Courses</h3>
                <input type="search" name="" id="" placeholder="Search DIPLOMA Courses">
            </div>
            <div class="courses">
                @foreach ($courses as $i => $course)
                @if ($course['course_type'] == 'Diploma')
                <div @class(['disable'=> in_array($course['id'], $added)]) title="{{ $course['course_name'] }}">
                    <input type="checkbox" value="{{ $course['id'] }}"
                        data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                        id="f{{ $i }}" @if (in_array($course['id'], $added)) checked disabled @endif
                        onchange="add_commision_field(this,{{ $course['id'] }})">
                    <label for="f{{ $i }}" class="btn btn-outline-primary rounded-pill m-1">({{ $course['course_short_name'] }}) {{ $course['course_name'] }}</label>
                </div>
                @endif
                @endforeach
            </div>
        </section>
        <section class="card p-2 mb-4">
            <div class="flex">
                <h3>CERTIFICATION Courses</h3>
                <input type="search" name="" id="" placeholder="Search CERTIFICATION Courses">
            </div>
            <div class="courses">
                @foreach ($courses as $i => $course)
                @if ($course['course_type'] == 'Certification')
                <div @class(['field', 'disable'=> in_array($course['id'], $added)]) title="{{ $course['course_name'] }}">
                    <input type="checkbox" value="{{ $course['id'] }}"
                        data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                        id="f{{ $i }}" @if (in_array($course['id'], $added)) checked disabled @endif
                        onchange="add_commision_field(this,{{ $course['id'] }})">
                    <label for="f{{ $i }}" class="btn btn-outline-primary rounded-pill m-1">({{ $course['course_short_name'] }}) {{ $course['course_name'] }}</label>
                </div>
                @endif
                @endforeach
            </div>
        </section>
        <section class="card p-2">
            <h3 class="section_title">Commision</h3>
            <section id="courses">
                @foreach ($university['courses'] as $course)
                <div class="row" id="field{{ $course['id'] }}">
                    <div class="col-lg-6">
                        <h6>
                            {{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}
                        </h6>
                    </div>
                    <div class="col-lg-6">
                        {{-- <input type="hidden" name="course[{{ $course['id'] }}][old]" value="1"> --}}
                        <input type="hidden" name="course[{{ $course['id'] }}][old_id]"
                            value="{{ $course['pivot']['id'] }}">
                        <input type="hidden" name="course[{{ $course['id'] }}][id]" value="{{ $course['id'] }}">
                        <div class="flex">
                            <input type="text" name="course[{{ $course['id'] }}][fee]"
                                placeholder="Fees" value="{{ $course['pivot']['univ_course_fee'] }}">
                            <input type="text" name="course[{{ $course['id'] }}][commision]"
                                placeholder="Commision" value="{{ $course['pivot']['univ_course_commision'] }}">
                        </div>
                    </div>
                </div>
                @endforeach
            </section>
        </section>
        <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">Update University</button>
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
            `<div class="field_group head_field" id="field${no}" data-linked="${link}"><h6 style="color:var(--btn_primary);">${course}</h6><div class="field_group"><div class="field"><input type="hidden" name="course[${no}][id]" value="${no}"><input style="border:1px solid var(--btn_primary);" type="text" name="course[${no}][fee]" placeholder="Total Univ-Course Fees"></div><div class="field"><input style="border:1px solid var(--btn_primary);" type="text" name="course[${no}][commision]" placeholder="Commision %"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div></div>`;
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