@extends('user.components.layout')
@php
// dd($course);
$page_title = $course['course_name'] . ' - (' . $course['course_short_name'] . ')';
@endphp
@push('css')
<link rel="stylesheet" href="{{ url('/css/course_page.css') }}">
@endpush
@section('main')
<main>
@include('user.components.breadcrumbs.course-breadcrumb')
    {{-- @php dd($course['universities']) ;@endphp --}}
    <section class="text-center p-2">
        <div class="container card py-2 bg-blue">
            <div class="row">
                <div class="col-4">
                    <article>
                        <h4>Duration</h4>
                        <h5>{{ $course['course_duration'] }}</h5>
                    </article>
                </div>
                <div class="col-4">
                    <article class="border-start border-end">
                        <h4>Universities</h4>
                        <h5>{{ count($course['universities']) }}</h5>
                    </article>
                </div>
                <div class="col-4">
                    <article>
                        <h4>Eligibility</h4>
                        <h5>{{ $course['course_eligibility_short'] }}</h5>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <section style="text-transform: none;">
        <div class="container">
            <h1 class="blue text-center">Course Introduction</h1>
            <h4 class="blue">{{ $course['course_name'] }}</h4>
            {{-- @php dd( $course); @endphp --}}
            @foreach (json_decode($course['course_intro'], true) ?? [] as $intro)
            <p class="p-2">{{ $intro }}</p>
            @endforeach
        </div>
    </section>
    <section class="container" style="text-transform: none;">
        <h4 class="blue">Course Overview</h4>
        @foreach (json_decode($course['course_overview'], true) ?? [] as $intro)
        <p class="p-2">{{ $intro }}</p>
        @endforeach
    </section>
    <section class="container" style="text-transform: none;">
        @php
        $course['course_eligibility'] = json_decode($course['course_eligibility'], true) ?? [];
        @endphp
        <h4 class="blue">Course Eligibility</h4>
        <p class="p-2">{{ $course['course_eligibility']['about'] ?? '' }}</p>
        @isset($course['course_eligibility']['data'])
        <ul>
            @foreach ($course['course_eligibility']['data'] as $li)
            <li class="p-2">{{ $li }}</li>
            @endforeach
        </ul>
        @endisset
    </section>
    <section class="container" style="text-transform: none;">
        <h4 class="blue">Universities </h4>
        <div class="row p-2">
            @foreach ($course['universities'] as $univ)
            @php
            $metadata = DB::table('metadata')->where('id', $univ['univ_slug'])->first();
            $url = $metadata->url_slug ?? ''; // Use null coalescing operator to handle null value
            @endphp
            <div class="col-lg-2 col-md-4 col-sm-3 col-6 p-2">
                <a href="/{{ $url }}" class="card h-100 uni-card">
                    <img src="/images/university/logo/{{ $univ['univ_logo'] }}" alt="{{ $univ['univ_name'] }}"
                        class="img-fluid">
                    <h6>{{ $univ['univ_name'] }}</h6>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    <section class="py-2" style="text-transform: none;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 p-2">
                    <article>
                        <h4>Admission Process</h4>
                        <p>There is an online admissions process available at Online {{ $course['course_name'] }}, therefore there is
                            no need to physically visit the campus to apply for admission. There is no entrance exam required to apply for
                            admission to {{ $course['course_name'] }} Online because admissions are made directly. The following
                            describes the {{ $course['course_name'] }}'s admissions process for online courses:</p>
                        <a class="btn btn-primary my-2" title="get recommendation" href="#queryModal" data-bs-toggle="modal" data-bs-target="#queryModal">
                            Ask Admission Query
                        </a>
                    </article>
                </div>
                <div class="col-lg-6 p-2">
                    <div class="accordion">
                        @php
                        $steps = [['step_title' => 'Explore Programs', 'step_desc' => 'Browse our diverse range of programs like MBA, BBA, MA, B.COM, Machine Learning, Python and many more...'], ['step_title' => 'Fill Application', 'step_desc' => 'Fill online application form with accurate.'], ['step_title' => 'Get Expert Help', 'step_desc' => "You get your own education mentor who helps with all your questions about courses, university, colleges and fees. They're there to make things clear and easy for you."], ['step_title' => 'Upload Documents', 'step_desc' => 'Make your college application faster by sending your documents and paying the registeration fees.'], ['step_title' => 'Confirm Admission', 'step_desc' => 'Upon acceptance, pay fees to secure your seat and finalize enrollment'], ['step_title' => 'Start Class & Claim Gift', 'step_desc' => 'Confirm your class date, seat, enrollment number and get your gift as reward points']];
                        @endphp
                        @for ($i = 0; $i < count($steps); $i++)
                            <article class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel{{ $i + 1 }}" aria-expanded="true" aria-controls="panel{{ $i + 1 }}">
                                    <span>Step {{ $i + 1 }} : </span>
                                    <span class="ms-1">{{ $steps[$i]['step_title'] }}</span>
                                </button>
                            </h2>
                            <div id="panel{{ $i + 1 }}" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p class="step_desc">{{ $steps[$i]['step_desc'] }}</p>
                                </div>
                            </div>
                            </article>
                            @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="Programs" style="text-transform: none;">
        <div class="container">
            <div class="row">
                @php
                $course['course_subjects'] = json_decode($course['course_subjects'], true);
                @endphp
                <h4 class="blue">Course Subjects</h4>
                <ul class="list-unstyled row">
                    @foreach ($course['course_subjects']['data'] ?? [] as $li)
                    <li class="col-6 p-2">
                        <span class="blue">#</span>{{ $li }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section class="highlights" style="text-transform: none;">
        <div class="container">
            <div class="row">
                @php
                $course['course_highlights'] = json_decode($course['course_highlights'], true) ?? [];
                @endphp
                <h4 class="blue">{{ $course['course_name'] }}'s Highlights</h4>
                @foreach ($course['course_highlights'] ?? [] as $i => $type)
                @if ($type['title'])
                <div class="col-lg-4 col-sm-6 p-2 m-md-0 m-2">
                    <div class="card bg-light text-center h-100 p-2 rounded-1 bordered border-2 border-primary m-2">
                        <h5 class="count rounded-circle bg-blue position-absolute start-0 top-0 center" style="width: 40px; height: 40px; transform: translate(-50%, 50%);">{{ $i + 1 }}</h5>
                        <h6 class="blue">{{ $type['title'] }}</h6>
                        <p class="text-secondary">{{ $type['desc'] }}</p>
                        <span class="bottom-line"></span>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </section>

    <section class="freights" style="text-transform: none;">
        <div class="container">
            <div class="row gap-3">
                <article>
                    <h4 class="blue">{{ $course['course_name'] }}'s Freights</h4>
                    <p class="p-2">{{ $course['course_freights'] }}</p>
                </article>
                <article>
                    @php
                    $course['course_specialization'] = json_decode($course['course_specialization'], true) ?? [] ;
                    @endphp
                    <h4 class="blue">{{ $course['course_name'] }}'s Specialization</h4>
                    <p class="p-2">{{ $course['course_specialization']['about'] ?? 'N/A' }}</p>
                    @isset($course['course_specialization']['data'])
                    <ul class="list-unstyled row">
                        @foreach ($course['course_specialization']['data'] ?? [] as $i => $li)
                        <li class="p-2 col-6">
                            <span class="blue">#</span>{{ $li }}
                        </li>
                        @endforeach
                    </ul>
                    @endisset
                </article>
            </div>
        </div>
    </section>

    {{-- @isset($course_job['data']) --}}
    <section class="container">
        @php
        $course['course_job'] = json_decode($course['course_job'], true) ?? [];
        @endphp
        <h4 class="blue">Course Job</h4>
        <p>{{ $course['course_job']['about'] ?? '' }}</p>
        <ul class="list-unstyled row">
            @foreach ($course['course_job']['data'] ?? [] as $li)
            <li class="p-2 col-6">
                <span class="blue">#</span>{{ $li }}
            </li>
            @endforeach
        </ul>
    </section>
    {{-- @endisset --}}
    <section class="container">
        @php
        $course['course_types'] = json_decode($course['course_types'], true) ?? [];
        @endphp
        <h4 class="blue">Course Types</h4>
        @foreach ($course['course_types'] ?? [] as $type)
        @if ($type['title'])
        <article class="p-2">
            <h5 class="blue">{{ $type['title'] }}</h5>
            <p style="text-transform: none;">{{ $type['desc'] }}</p>
        </article>
        @endif
        @endforeach
    </section>
    <section class="container">
        <h5 class="blue">Why this Course ?</h5>
        <ul>
            @foreach (json_decode($course['why_this_course'], true) ?? [] as $li)
            <li style="text-transform: none;">{{ $li }}</li>
            @endforeach
        </ul>
    </section>
    <section class="container"> 
        <h4 class="blue">Frequently Asked Questions</h4>
        @foreach (json_decode($course['course_faqs'], true)??[] as $i => $faq)
        <div class="accordion p-1">
            <article class="accordion-item">
                <h4 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel{{ $i + 1 }}" aria-expanded="true" aria-controls="panel{{ $i + 1 }}">
                        <span>Q {{ $i + 1 }} : </span>
                        <span class="ms-1">{{ $faq['question'] }}</span>
                    </button>
                </h4>
                <div id="panel{{ $i + 1 }}" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <p class="step_desc" style="text-transform: none;">A {{ $i + 1 }} : {{ $faq['answer'] }}</p>
                    </div>
                </div>
            </article>
        </div>
        @endforeach
    </section>
</main>
@push('script')
<script>
    $(".accordion_title").perform((n, i, no) => {
        let desc = n.nextElementSibling;
        let height = desc.clientHeight + "px";
        n.addEventListener('click', () => {
            no.perform((x) => {
                if (n == x && !x.parentElement.hasClass("active")) {
                    x.parentElement.addClass("active");
                    x.nextElementSibling.addCSS('height', height);
                } else {
                    x.parentElement.removeClass("active");
                    x.nextElementSibling.addCSS('height', "0");
                }
            })
        })
        desc.addCSS('height', "0");
    });
    $("#query_form").ajaxSubmit();
</script>
@endpush
@endsection