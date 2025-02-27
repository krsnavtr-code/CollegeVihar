 <!-- search offcanvas -->
 <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSearch" aria-labelledby="offcanvasSearchLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasSearchLabel"></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body text-center">
        <img src="/images/web assets/logo_mini.jpeg" alt="logo" width="200">
        <h5>
            <span class="blue">collage</span>
            <span class="red">vihar</span>
        </h5>
        <h5>Search College or Course</h5>
        <div class="">
            <input class="form-control mr-sm-2" type="search" placeholder="Search college or course here..." aria-label="Search" id="searchInput">
            <div id="searchResults"></div>
        </div>
        <p>Trending Searches...</p>
        <div class="search-tabs">
            <button type="button" class="btn btn-outline-primary">Online MCA</button>
            <button type="button" class="btn btn-outline-primary">Online BTECH</button>
            <button type="button" class="btn btn-outline-primary">Online MBA</button>
            <button type="button" class="btn btn-outline-primary">Online MCA</button>
            <button type="button" class="btn btn-outline-primary">Online BCA</button>
            <button type="button" class="btn btn-outline-primary">Diploma Course</button>
        </div>
    </div>
</div>
<!-- search offcanvas end -->
<!-- Query Form modal -->
<!-- <script type="text/javascript">
    $(window).on('load', function() {
        $('#queryModal').modal('show');
    });
</script> -->
<div class="modal fade" id="queryModal" tabindex="-1" aria-labelledby="queryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="queryModalLabel">Query Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/query-form" method="post" class="row flex-column gap-2">
                    <div class="flex">
                        <img src="/images/web assets/user.png" alt="User icon" class="img-fluid">
                        <input type="text" name="name" id="getName" class="form-control validate" placeholder="Enter your name here..." value="{{ session('success') ? old('name') : '' }}" required>
                    </div>
                    <div class="flex">
                        <img src="/images/web assets/contact.png" alt="contact icon" class="img-fluid">
                        <input type="tel" id="getNumber" class="form-control validate" name="phone" placeholder="Phone (10 digits)" pattern="[0-9]{10}" title="Please enter a 10-digit phone number" value="{{ session('success') ? old('phone') : '' }}" required>
                    </div>
                    <div class="flex">
                        <img src="/images/web assets/email.png" alt="email icon" class="img-fluid">
                        <input type="email" name="email" id="getEmail" class="form-control validate" placeholder="Enter your email here..." value="{{ session('success') ? old('email') : '' }}" required>
                    </div>
                    <div class="flex">
                        <img src="/images/web assets/course.png" alt="course icon" class="img-fluid">
                        <select class="form-select" name="course" id="getCourse" aria-label=".form-select-lg example" required>
                            <option selected disabled>--select course--</option>
                            @if(!empty($courseData) && is_array($courseData))
                            @foreach($courseData as $course)
                            @if(isset($course['id']) && isset($course['course_name']))
                            <option value="{{ $course['id'] }}">{{ $course['course_name'] }}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="flex">
                        <img src="/images/web assets/description.png" alt="course icon" class="img-fluid">
                        <textarea name="message" class="form-control validate" placeholder="Enter Your Message"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Submit <i class="fa fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
</div>
<!-- Query Form modal end -->
<!-- Callback modal -->
<div class="modal fade" id="callbackModal" tabindex="-1" aria-labelledby="callbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('submit.form') }}" method="POST" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="callbackModalLabel">Request a call</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display Error and Success Messages -->
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <!-- form start -->
                <section class="row gap-2">
                    @csrf
                    <div class="flex">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" class="form-control validate" value="{{ old('name') }}" placeholder="Enter Your Full Name " required>
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" name="email" class="form-control validate" value="{{ old('email') }}" placeholder="Enter Your email Address" required>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="phone" class="form-control validate" value="{{ old('phone') }}" placeholder="Enter Your Phone number " required>
                        @if ($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-book"></i>
                        <select class="form-select" name="course" required>
                            <option selected disabled>--select course--</option>
                            @if(!empty($courseData) && is_array($courseData))
                            @foreach($courseData as $course)
                            @if(isset($course['id']) && isset($course['course_name']))
                            <option value="{{ $course['id'] }}">{{ $course['course_name'] }}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit <i class="fa fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>
<!-- Callback modal end -->
<!-- Partnership modal -->
<div class="modal fade" id="partnershipModal" tabindex="-1" aria-labelledby="partnershipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('univstore') }}" method="POST" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="partnershipModalLabel">Partner With Us</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display Error and Success Messages -->
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <!-- form start -->
                <section class="row gap-2">
                    @csrf
                    <div class="flex">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" class="form-control validate" value="{{ old('name') }}" placeholder="Enter Your Full Name " required>
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" name="email" class="form-control validate" value="{{ old('email') }}" placeholder="Enter Your email Address" required>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="phone" class="form-control validate" value="{{ old('phone') }}" placeholder="Enter Your Phone number " required>
                        @if ($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit <i class="fa fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>
<!-- Partnership modal end -->
<!-- Add University modal -->
<div class="modal fade" id="addUniModal" tabindex="-1" aria-labelledby="addUniModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('univstore') }}" method="POST" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addUniModalLabel">Add University</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display Error and Success Messages -->
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <!-- form start -->
                <section class="row gap-2">
                    @csrf
                    <div class="flex">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" class="form-control validate" value="{{ old('name') }}" placeholder="Enter Your Full Name " required>
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" name="email" class="form-control validate" value="{{ old('email') }}" placeholder="Enter Your email Address" required>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="phone" class="form-control validate" value="{{ old('phone') }}" placeholder="Enter Your Phone number " required>
                        @if ($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit <i class="fa fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>
<!-- Add University modal end -->
<!-- Add edTechModal modal -->
<div class="modal fade" id="edTechModal" tabindex="-1" aria-labelledby="edTechModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/edregister" method="POST" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addUniModalLabel">Add Ed-Tech</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display Error and Success Messages -->
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <!-- form start -->
                <section class="row gap-2">
                    @csrf
                    <div class="flex">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" class="form-control validate" value="{{ old('name') }}" placeholder="Enter Your Full Name " required>
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" name="email" class="form-control validate" value="{{ old('email') }}" placeholder="Enter Your email Address" required>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="phone" class="form-control validate" value="{{ old('phone') }}" placeholder="Enter Your Phone number " required>
                        @if ($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>

                    <!-- Additional Fields -->
                    <div class="flex">
                        <i class="fa-solid fa-briefcase"></i>
                        <select id="experience" name="experience" class="form-select" required>
                            <option disabled selected>Total Experience in Education Field</option>
                            <option value="Less than 1 year">Less than 1 year</option>
                            <option value="1-3 years">1-3 years</option>
                            <option value="3-5 years">3-5 years</option>
                            <option value="5-10 years">5-10 years</option>
                            <option value="More than 10 years">More than 10 years</option>
                        </select>
                    </div>

                    <div class="flex">
                        <i class="fa-solid fa-building"></i>
                        <input type="text" name="company_name" class="form-control validate" value="{{ old('company_name') }}" placeholder="Enter Company Name" required>
                        @if ($errors->has('company_name'))
                        <span class="text-danger">{{ $errors->first('company_name') }}</span>
                        @endif
                    </div>

                    <div class="flex">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="company_email" class="form-control validate" value="{{ old('company_email') }}" placeholder="Enter Company Email" required>
                        @if ($errors->has('company_email'))
                        <span class="text-danger">{{ $errors->first('company_email') }}</span>
                        @endif
                    </div>

                    <div class="flex">
                        <i class="fa-solid fa-address-card"></i>
                        <input type="text" id="company_address" name="company_address" class="form-control validate" value="{{ old('company_address') }}" placeholder="Enter Company Address" required>
                        @if ($errors->has('company_address'))
                        <span class="text-danger">{{ $errors->first('company_address') }}</span>
                        @endif
                    </div>

                    <div class="flex">
                        <i class="fa-solid fa-user-tie"></i>
                        <select name="presently_working_as" class="form-select" required>
                            <option selected disabled>Presently Working As a</option>
                            <option value="Teacher">Teacher</option>
                            <option value="Freelancer">Freelancer</option>
                            <option value="Edtech Employee">Edtech Employee</option>
                            <option value="Individual Agent">Individual Agent</option>
                            <option value="Consultancy">Consultancy</option>
                        </select>
                    </div>

                    <div class="flex">
                        <i class="fa-solid fa-bullseye"></i>
                        <select name="admission_target" class="form-select" required>
                            <option disabled selected>Monthly Admission Targe</option>
                            <option value="Less than 10">Less than 10</option>
                            <option value="10-15">10-15</option>
                            <option value=">50">More than 50</option>
                        </select>
                    </div>

                    <div class="flex">
                        <i class="fa-solid fa-pencil-alt"></i>
                        <textarea name="message" class="form-control validate" placeholder="Enter Your Message"></textarea>
                    </div>

                    <div class="flex">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">I agree to the Terms and Conditions</label>
                    </div>

                </section>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit <i class="fa fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>
<!-- Add edTech Modal end -->
<!-- Suggest Modal -->
<div class="modal fade" id="suggestModal" tabindex="-1" aria-labelledby="suggestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="suggestModalLabel">Know more about course</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach (Request::get('courses') as $course)
                    <div class="col-lg-4 col-md-6 p-1">
                        <a class="card p-2" href="/{{ $course['metadata']['url_slug'] }}">
                            <h6 class="blue">
                                <i class="fa-solid fa-graduation-cap"></i>
                                {{ $course['course_short_name'] }}
                            </h6>
                            <p class="m-1">{{ $course['course_name'] }}</p>
                            <h6>
                                <span>Compare</span>
                                <span>{{ count($course['universities']) }}</span>
                                <span>universities</span>
                            </h6>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Suggest Modal end-->
<!-- Suggest Modal -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('submit.form') }}" method="POST" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="applyModalLabel">Apply Now</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display Error and Success Messages -->
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <!-- form start -->
                <section class="row gap-2">
                    @csrf
                    <div class="flex">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" class="form-control validate" value="{{ old('name') }}" placeholder="Enter Your Full Name " required>
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" name="email" class="form-control validate" value="{{ old('email') }}" placeholder="Enter Your email Address" required>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="phone" class="form-control validate" value="{{ old('phone') }}" placeholder="Enter Your Phone number " required>
                        @if ($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-book"></i>
                        <select class="form-select" name="course" required>
                            <option selected disabled>--select course--</option>
                            @if(!empty($courseData) && is_array($courseData))
                            @foreach($courseData as $course)
                            @if(isset($course['id']) && isset($course['course_name']))
                            <option value="{{ $course['id'] }}">{{ $course['course_name'] }}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit <i class="fa fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>
<!-- Suggest Modal end-->
<!-- job Modal -->
<div class="modal fade" id="jobModal" tabindex="-1" aria-labelledby="jobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ url('/jobregister') }}" method="POST" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="jobModalLabel">Job Registration</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display Error and Success Messages -->
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <!-- form start -->
                <section class="row gap-2">
                    @csrf
                    <div class="flex">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" class="form-control validate" value="{{ old('name') }}" placeholder="Enter Your Full Name " required>
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" name="email" class="form-control validate" value="{{ old('email') }}" placeholder="Enter Your email Address" required>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="phone" class="form-control validate" value="{{ old('phone') }}" placeholder="Enter Your Phone number " required>
                        @if ($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit <i class="fa fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>
<!-- job Modal end -->
<!-- Recruiter Modal -->
<div class="modal fade" id="RecruiterModal" tabindex="-1" aria-labelledby="RecruiterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('recruiterRegister') }}"  method="POST" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="RecruiterModalLabel">Recruiter/HR Registration</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display Error and Success Messages -->
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <!-- form start -->
                <section class="row gap-2">
                    @csrf
                    <div class="flex">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" class="form-control validate" value="{{ old('name') }}" placeholder="Enter Your Full Name " required>
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" name="email" class="form-control validate" value="{{ old('email') }}" placeholder="Enter Your email Address" required>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="phone" class="form-control validate" value="{{ old('phone') }}" placeholder="Enter Your Phone number " required>
                        @if ($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit <i class="fa fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>
<!-- Recruiter Modal end -->