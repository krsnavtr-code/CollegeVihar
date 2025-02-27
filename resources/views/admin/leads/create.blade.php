@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <form action="/admin/lead/create" method="post">
        @csrf
        <h2 class="page_title">Add Leads</h2>
        <section class="panel">
            <div class="field">
                <label for="">Agent Name</label>
                <input type="text" name="agent_name" placeholder="Agent Name">

            </div>

            <h3 class="section_title">Lead Details</h3>
            <div class="field_group">
                <div class="field">
                    <label for="">Lead Name</label>
                    <input type="text" name="lead_name" placeholder="Lead Name">
                </div>
                <div class="field">
                    <label for="">Lead D.O.B. <i>( If Available )</i></label>
                    <input type="date" name="lead_dob" placeholder="Lead DOB">
                </div>
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="">Lead Contact</label>
                    <input type="text" name="lead_contact" placeholder="Lead Contact">
                </div>
                <div class="field">
                    <label for="">Lead E-mail <i>( If Available )</i></label>
                    <input type="text" name="lead_email" placeholder="Lead E-mail">
                </div>
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="">Previous Qualification <i>( If Available
                            )</i></label>
                    <input type="text" name="lead_old_qualification" placeholder="Previous Qualification">
                </div>
                <div class="field">
                    <label for="state">Select State</label>
                    <select name="state" id="state">

                        @foreach ($states as $state)
                        <option value="{{ $state['id'] }}">{{ $state['state_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="mode_of_admission">Mode of Admission</label>
                    <select name="mode_of_admission" id="mode_of_admission">
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                        <option value="Single-Seating">Single-Seating</option>
                        <option value="Back-Date">Back-Date</option>
                        <option value="Distance">Distance</option>
                        <option value="International">International</option>
                    </select>
                </div>

            </div>
        </section>
        <section>
            <h3 class="section_title">Interested In</h3>
            <div class="row">
                <div class="col-lg-6">
                    <div class="field">
                        <label for="">University <i>( Don't Select for short Courses
                                )</i></label>
                        <select name="lead_university" onchange="load_courses(this)">
                            <option value="" selected>-- Select --</option>
                            @foreach ($universities as $university)
                            <option value="{{ $university['id'] }}">{{ $university['univ_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="field">
                        <label for="">Course <i>( Auto update with university)</i></label>
                        <select name="lead_course" id="courses">
                            <option value="" selected disabled>-- Select --</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course['id'] }}">{{ $course['course_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

        </section>
        <div class="field">
            <input type="checkbox" name="send_mail" id="">
            <label for="">Send Welcome Mail</label>
        </div>
        <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">Upload Lead</button>
        </div>
    </form>
</main>
@endsection
@push('script')
<script>
    let default_courses = courses.innerHTML;

    function load_courses(node) {
        let univ = node.value;
        if (univ == '') {
            courses.innerHTML = default_courses;
            return;
        }
        ajax({
            url: "/api/univCourses/" + univ,
            success: (res) => {
                res = JSON.parse(res);
                let options = `<option value="" selected disabled>-- Select --</option>`;
                res.forEach(c => {
                    options +=
                        `<option value='${c['course']['id']}'>${c['course']['course_name']} ( ${c['course']['course_short_name']} )</option>`
                });
                courses.innerHTML = options;
            }
        });
    }
</script>
@endpush