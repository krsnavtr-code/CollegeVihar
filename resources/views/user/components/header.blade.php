<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/header.css">
</head>

<body>
    {{-- @php
    dd(Request::get('state_univ'));
    @endphp --}}

    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('user.components.header.modal')
    <!-- top bar -->
    <nav class="top-bar">
        <h5 style="margin: 0px 10px;">Talk to our career expert:</h5>
        <div class="flex justify-content-evenly">
            <a title="Request a call" href="#callbackModal" data-bs-toggle="modal" data-bs-target="#callbackModal">
                <i class="fa-solid fa-bell"></i>
                <span>Request a callback</span>
            </a>
            <a title="Partner With Us" href="#" data-bs-toggle="modal" data-bs-target="#partnershipModal">
                <i class="fa-solid fa-handshake-simple"></i>
                <span>Partner with us</span>
            </a>
        </div>
        <div class="flex justify-content-evenly">
            <div class="contact-dropdown">
                <i class="fa-solid fa-phone-volume"></i>
                <span>Get In Touch</span>
                <div class="contact-options">
                    <a href="tel:+919266585858">
                        <i class="fa-solid fa-phone"></i> Call Us
                    </a>
                    <a href="mailto:info@collegevihar.com">
                        <i class="fa-solid fa-envelope"></i> Email Us
                    </a>
                </div>
            </div>
            <div class="firstvite">
                <a href="https://firstvite.com" target="_blank" rel="noopener noreferrer">
                    <span style="color: #E97D17">FIRST</span><span style="color: #0897DF">Vite</span>
                </a>
            </div>
        </div>
    </nav>


    <!-- nav bar -->
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary bottom-nav" style="padding: 0px 0px 5px 0px;">
            <div class="container ">
                <a class="navbar-brand text-center" style="margin: 0" href="/">
                    <img src="/images/logomini.png" alt="Logo" width="40">
                    <h6>
                        <span class="blue">college</span>
                        <span class="red">vihar</span>
                    </h6>
                </a>
                <div class="hm">
                    <a class="nav-link" aria-current="page" href="#">
                        <h6>
                            <span class="blue">#padhega</span>
                            <span class="red">india</span>
                        </h6>
                        <h6 class="ms-5">
                            <span class="blue">#badhega</span>
                            <span class="red">india</span>
                        </h6>
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mobile-nav-dropdown align-items-center" style="margin: auto;">
                        <li class="nav-item">
                            {{--<a class="nav-link bg-blue rounded-1" data-bs-toggle="collapse" href="#collapseOnline"
                                role="button" aria-expanded="false" aria-controls="collapseOnline">online
                                programs</a>--}}
                            <a class="nav-link rounded-1 blue-button-hover" href="/online-programs">online programs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#collapsePartnerUni" role="button"
                                aria-expanded="false" aria-controls="collapsePartnerUni">Partner Universities</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="/images/web assets/logo_mini.jpeg" alt="logo_mini" width="30">
                                <span>stopgap</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="/post-admission-support">
                                        <i class="fa-regular fa-circle-check"></i>
                                        <span>post admission support</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/job-openings">
                                        <i class="fa-regular fa-lightbulb"></i>
                                        <span>placement help</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/resume-help">
                                        <i class="fa-solid fa-user-plus"></i>
                                        <span>professional resume help</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/contact">
                                        <i class="fa-regular fa-message"></i>
                                        <span>contact us</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('blogs') }}">
                                        <i class="fa-regular fa-note-sticky"></i>
                                        <span>blogs &amp; web stories</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" title="Get a job" href="#" data-bs-toggle="modal"
                                        data-bs-target="#addUniModal">
                                        <i class="fa-solid fa-building-columns"></i>
                                        <span>add university</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" title="Get a job" href="#" data-bs-toggle="modal"
                                        data-bs-target="#edTechModal">
                                        <i class="fa-solid fa-bars"></i>
                                        <span>add Ed-tech</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/blogs">blogs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#suggestModal">Suggest
                                Quickly</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link blue-button-hover" data-bs-toggle="offcanvas" href="#offcanvasSearch" role="button"
                                aria-controls="offcanvasExample">
                                <span >search</span>
                                <!-- <span>|</span>
                                <i class="fa-solid fa-magnifying-glass"></i> -->
                            </a>
                        </li>
                        <li class="nav-item px-2 position-relative">
                            @if(session('email') || session('phone'))
                                                        @php
                                                            $userContact = session('email') ?? session('phone');
                                                            if (filter_var($userContact, FILTER_VALIDATE_EMAIL)) {
                                                                $userName = strtoupper(substr($userContact, 0, 1));
                                                            } else {
                                                                $userName = $userContact;
                                                            }
                                                        @endphp
                                                        <p title="{{ $userContact }}" style="cursor: pointer;" id="userDropdown"><i
                                                                class="fa-solid fa-user" style="color: blue"></i></p>
                                                        <div id="logoutMenu" class="logout-dropdown d-none">
                                                            <p class="text-center font-weight-bold">{{ $userContact }}</p>
                                                            <form action="{{ url('/logout') }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm w-100">Logout</button>
                                                            </form>
                                                        </div>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- partner universities -->
        <div class="collapse bg-light partner-universities-dropdown p-2" id="collapsePartnerUni">
            <div class="card p-2">
                <div class="state-container" id="region-container">
                    <a class="btn-close position-absolute end-0 top-0 p-1 m-1 rounded-circle" data-bs-toggle="collapse"
                        href="#collapsePartnerUni" role="button" aria-expanded="false"
                        aria-controls="collapsePartnerUni"></a>

                    <!-- State cards will be inserted here -->
                </div>
            </div>
        </div>
        <!-- online courses -->
        <div class="collapse bg-light p-2" id="collapseOnline">
            <div class="card p-2">
                <a class="btn-close position-absolute end-0 top-0 p-1 m-1 rounded-circle" data-bs-toggle="collapse"
                    href="#collapseOnline" role="button" aria-expanded="false" aria-controls="collapseOnline"></a>
                <ul class="online-bar">
                    <li>
                        <a href="">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <h6>Under Graduate Courses</h6>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <h6>Under Graduate Courses</h6>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fa-solid fa-graduation-cap icon"></i>
                            <h6>Under Graduate Courses</h6>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <h6>Under Graduate Courses</h6>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <h6>Under Graduate Courses</h6>
                        </a>
                    </li>
                </ul>
                <div class="row p-2 online-cards">
                    @foreach (Request::get('courses') as $course)
                        <!-- @if ($course['course_type'] == 'UG') -->
                        <div class="col-lg-3 p-1">
                            <div class="card p-2">
                                <a class="" href="/{{ $course['metadata']['url_slug'] }}">
                                    <h6>
                                        <i class="fa-solid fa-graduation-cap"></i>
                                        {{ $course['course_short_name'] }}
                                    </h6>
                                    <p>{{ $course['course_name'] }}</p>
                                    <h6>
                                        <span>Compare</span>
                                        <span>{{ count($course['universities']) }}</span>
                                        <span>universities</span>
                                    </h6>
                                </a>
                            </div>
                        </div>
                        <!-- @endif -->
                    @endforeach
                </div>
            </div>
        </div>
        <img style="height: 0px;" src="/images/right-bg.png" alt="bg" width="40">
    </header>

    <!-- Rest of your HTML content -->
    <script src="{{ asset('js/state.js') }}"></script>

    <script>
        document.getElementById('userDropdown').addEventListener('click', function () {
            document.getElementById('logoutMenu').classList.toggle('d-none');
        });

        document.addEventListener('click', function (event) {
            if (!document.getElementById('userDropdown').contains(event.target) &&
                !document.getElementById('logoutMenu').contains(event.target)) {
                document.getElementById('logoutMenu').classList.add('d-none');
            }
        });
    </script>
</body>

</html>