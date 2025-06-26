@extends('admin.components.layout')

@section('main')
<main class="container py-4">
    @include('admin.components.response')

    <form action="/admin/lead/create" method="POST">
        @csrf

        <h5 class="page_title mb-3">Add New Lead</h5>
        <p class="text-muted mb-4 text-center">Fill the form below to add a new lead.</p>

        <!-- Agent Info -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Agent Name</label>
                    <input type="text" class="form-control" name="agent_name" placeholder="Agent Name" required>
                </div>
            </div>
        </div>

        <!-- Lead Details -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="mb-3">Lead Details</h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Lead Name</label>
                        <input type="text" class="form-control" name="lead_name" placeholder="Lead Name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth <small class="text-muted">(optional)</small></label>
                        <input type="date" class="form-control" name="lead_dob">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Contact Number</label>
                        <input type="text" class="form-control" name="lead_contact" placeholder="Phone Number" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email <small class="text-muted">(optional)</small></label>
                        <input type="email" class="form-control" name="lead_email" placeholder="example@mail.com">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Previous Qualification <small class="text-muted">(optional)</small></label>
                        <input type="text" class="form-control" name="lead_old_qualification" placeholder="e.g. 12th Pass, B.Sc., etc.">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">State</label>
                        <select class="form-select" name="state" required>
                            <option disabled selected value="">-- Select State --</option>
                            @foreach ($states as $state)
                                <option value="{{ $state['id'] }}">{{ $state['state_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mode of Admission</label>
                    <select class="form-select" name="mode_of_admission" required>
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                        <option value="Single-Seating">Single-Seating</option>
                        <option value="Back-Date">Back-Date</option>
                        <option value="Distance">Distance</option>
                        <option value="International">International</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Interested In -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="mb-3">Interested In</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">University <small class="text-muted">(Don't select for short courses)</small></label>
                        <select class="form-select" name="lead_university" onchange="load_courses(this)">
                            <option selected value="">-- Select University --</option>
                            @foreach ($universities as $university)
                                <option value="{{ $university['id'] }}">{{ $university['univ_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course</label>
                        <select class="form-select" name="lead_course" id="courses">
                            <option selected disabled>-- Select Course --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course['id'] }}">{{ $course['course_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Send Mail -->
        <div class="form-check mb-4">
            <input type="checkbox" class="form-check-input" name="send_mail" id="send_mail">
            <label class="form-check-label" for="send_mail">Send Welcome Mail</label>
        </div>

        <!-- Submit -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-upload me-1"></i> Upload Lead
            </button>
        </div>
    </form>
</main>
@endsection

@push('script')
<script>
    let default_courses = document.getElementById("courses").innerHTML;

    function load_courses(node) {
        let univ = node.value;
        const courseSelect = document.getElementById("courses");
        if (!univ) {
            courseSelect.innerHTML = default_courses;
            return;
        }

        ajax({
            url: "/api/univCourses/" + univ,
            success: (res) => {
                res = JSON.parse(res);
                let options = `<option value="" selected disabled>-- Select Course --</option>`;
                res.forEach(c => {
                    const course = c.course;
                    options += `<option value="${course.id}">${course.course_name} (${course.course_short_name})</option>`;
                });
                courseSelect.innerHTML = options;
            }
        });
    }
</script>
@endpush
