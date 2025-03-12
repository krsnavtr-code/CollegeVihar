@php
$page_title = 'Job Openings';
@endphp
@push('css')

@endpush

@extends('user.info.layout')
@section('main_section')
<main>
    <section>
        <div class="container text-end">
            <a class="btn btn-primary m-1" title="Post a job" href="{{ url('/post-job') }}">Post a Requirement</a>
            <div class="card p-4 text-center search ">
                <h2 class="">India's Job Portal</h2>
                <p class=" text-center">Collegevihar helps you hire</p>
                <div class="buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#RecruiterModal">
                        Hire now
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jobModal">
                        Get a job
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4 p-2">
                    <a class="card p-2" href="{{ route('job.employment.filter', 'Intern') }}">
                        <img src="{{ asset('images/job/svg/intern.svg') }}" alt="Hire Intern" class="img-fluid">
                        <h5 class="blue">Hire Intern</h5>
                        <p>Get access to a pool of talented interns for various roles.</p>
                    </a>
                </div>
                <div class="col-md-4 p-2">
                    <a class="card p-2" href="{{ route('job.employment.filter', 'WFH') }}">
                        <img src="{{ asset('images/job/svg/wfh.svg') }}" alt="Hire for Work from Home" class="img-fluid">
                        <h5 class="blue"> Hire for Work from Home</h5>
                        <p>Find professionals ready to work remotely for your business.</p>
                    </a>
                </div>
                <div class="col-md-4 p-2">
                    <a class="card p-2" href="{{ route('job.employment.filter', 'Part Time') }}">
                        <img src="{{ asset('images/job/svg/part_time.svg') }}" alt="Hire Part Time Employee" class="img-fluid">
                        <h5 class="blue">Hire Part Time Employee</h5>
                        <p>Discover part-time employees for flexible working hours.</p>
                    </a>
                </div>
            </div>
        </div>
    </section>


    {{-- Get a Job Form Modal code start --}}
    {{-- <div class="modal fade" id="jobApplyForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h3 class="modal-title w-100 font-weight-bold">Job Registration</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
    @endif

    @if(Session::has('success'))
    <p style="color:green;">{{ Session::get('success') }}</p>
    @endif

    <!-- Form Start -->
    <form action="{{ url('/jobregister') }}" method="POST">
        @csrf
        <div class="md-form mb-5">
            <i class="fas fa-user prefix grey-text"></i>
            <label data-error="wrong" data-success="right" for="form34">Full Name</label>
            <input type="text" id="form34" name="name" class="form-control validate" value="{{ old('name') }}" required>
            @if($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="md-form mb-5">
            <i class="fas fa-envelope prefix grey-text"></i>
            <label data-error="wrong" data-success="right" for="form29"> Email Id</label>
            <input type="email" id="form29" name="email" class="form-control validate" value="{{ old('email') }}" required>
            @if($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif

        </div>

        <div class="md-form mb-5">
            <i class="fas fa-tag prefix grey-text"></i>
            <label data-error="wrong" data-success="right" for="form32">Phone No.</label>
            <input type="tel" id="form32" name="phone" class="form-control validate" value="{{ old('phone') }}" pattern="\d{10}" maxlength="10" title="Phone number should be 10 digits only" required>
            @if($errors->has('phone'))
            <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
        </div>
        </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button class="btn btn-unique" style="color: white; background-color: #007bff; border-color: #007bff;">
                Register Now <i class="fas fa-paper-plane-o ml-1"></i>
            </button>
        </div>
    </form>
    </div>
    </div> --}}

    {{-- Hire now form modal --}}
    {{-- <div class="modal fade" id="hireApplyForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h3 class="modal-title w-100 font-weight-bold">Recruiter/HR Registration</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <!-- Display Error and Success Messages -->
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
    @endif

    @if(Session::has('success'))
    <p style="color:green;">{{ Session::get('success') }}</p>
    @endif

    <!-- Form Start -->
    <form action="{{ route('recruiterRegister') }}" method="POST">
        @csrf
        <div class="md-form mb-5">
            <i class="fas fa-user prefix grey-text"></i>
            <label data-error="wrong" data-success="right" for="form34">Full Name</label>
            <input type="text" id="form34" name="name" class="form-control validate" value="{{ old('name') }}" required>
            @if($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="md-form mb-5">
            <i class="fas fa-envelope prefix grey-text"></i>
            <label data-error="wrong" data-success="right" for="form29"> Email Id</label>
            <input type="email" id="form29" name="email" class="form-control validate" value="{{ old('email') }}" required>
            @if($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif

        </div>

        <div class="md-form mb-5">
            <i class="fas fa-tag prefix grey-text"></i>
            <label data-error="wrong" data-success="right" for="form32">Phone No.</label>
            <input type="tel" id="form32" name="phone" class="form-control validate" value="{{ old('phone') }}" pattern="\d{10}" maxlength="10" title="Phone number should be 10 digits only" required>
            @if($errors->has('phone'))
            <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
        </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button class="btn btn-unique" style="color: white; background-color: #007bff; border-color: #007bff;">
                Register Now <i class="fas fa-paper-plane-o ml-1"></i>
            </button>
        </div>
    </form>
    </div>
    </div>
    </div> --}}

</main>
@endsection



{{--
<section class="search-section">
    <div class="container3">
        <h2>Search candidate database</h2>
        <form id="searchForm">
            <div class="form-group">
                <label for="jobTitle">Select job title</label>
                <select id="jobTitle" name="jobTitle">
                    <option>Select job title</option>
                </select>
            </div>
            <div class="form-group">
                <label for="city">Select city</label>
                <select id="city" name="city">
                    <option>Select city</option>
                </select>
            </div>
            <div style="text-align: center;">
            <button type="submit" class="btn" style="width: 120px; height: 40px;display: block; margin: 0 auto; text-align:center;">Search</button>
            </div>
        </form>
    </div>
</section> --}}

{{--
@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const jobTitles = [
            "Software Engineer",
            "Data Scientist",
            "Project Manager",
            "Product Manager",
            "Business Analyst",
            "UX/UI Designer",
            "Marketing Manager",
            "Sales Manager",
            "Customer Support",
            "HR Specialist"
        ];
        // Populate job titles
        $('#jobTitle').append(jobTitles.map(title => `<option value="${title}">${title}</option>`));

        // Function to fetch cities from Laravel endpoint
        function fetchCities() {
            $.ajax({
                url: '/fetch-cities',
                method: 'GET',
                success: function(response) {
                    let cities = response.geonames;
                    $('#city').append(cities.map(city => `<option value="${city.name}">${city.name}</option>`));
                },
                error: function(error) {
                    console.error('Error fetching cities:', error);
                }
            });
        }

        // Fetch cities when the document is ready
        fetchCities();
    });
</script>
@endpush--}}