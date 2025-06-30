@extends('admin.components.layout')
@section('title', 'Add University Details - CV Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/university.css') }}">
@endpush


@section('main')
    <main>
        @include('admin.components.response')
        <h5>Add University Details</h5>
        <h6 class="page_title text-center">Now Adding <b class="text-primary">{{ $university['univ_name'] }}</b> Details</h6>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <!-- University URL slug -->
            <form id="slugForm" action="{{ route('admin.university.add.details.update.slug') }}" method="post" class="section-form">
                @csrf
                <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
                <div class="section-header">
                    <h3>University URL Slug</h3>
                </div>
                @if(session('section') === 'slug')
                    <div class="alert alert-success">
                        {{ session('message', 'URL slug updated successfully!') }}
                    </div>
                @endif
                <section class="panel">
                    <h3 class="section_title">University URL slug</h3>
                    <div class="field with_data aic">
                        <h6>https://collegevihar.com/university/</h6>
                        <input type="text" name="univ_slug" id="univ_slug" placeholder="University Slug"
                            style="padding-inline: 5px;font-weight:600;" class="text-center"
                            value="{{ str_replace(' ', '-', strtolower($university['univ_name'])) }}" required>
                    </div>
                </section>
            </form>

            <!-- University Info -->
            <form id="infoForm" action="{{ route('university.update.info') }}" method="post" class="section-form">
                @csrf
                <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
                <div class="section-header">
                    <h3>University Information</h3>
                </div>
                @if(session('section') === 'info')
                    <div class="alert alert-success">
                        {{ session('message', 'University information updated successfully!') }}
                    </div>
                @endif
                <section class="panel">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="section_title">Info: {{ $university['univ_name'] }}</h3>
                        <button type="submit" class="btn-save">Save University Info</button>
                    </div>
                    <div id="desc_container">
                        @php
                            $descriptions = isset($university['univ_description']) ? json_decode($university['univ_description'], true) : [''];
                            if (empty($descriptions)) {
                                $descriptions = [''];
                            }
                        @endphp
                        
                        @foreach($descriptions as $index => $desc)
                            <div class="field cflex">
                                <label for="desc_{{ $index + 1 }}">Paragraph {{ $index + 1 }}</label>
                                <div class="field-wrapper">
                                    <textarea oninput="auto_grow(this)" id="desc_{{ $index + 1 }}" 
                                        name="univ_description[]" placeholder="Write Here..."
                                        class="form-control">{{ old('univ_description.' . $index, $desc) }}</textarea>
                                    @if($index > 0)
                                        <button type="button" class="remove-field" onclick="removeField(this)">
                                            <i class="fa-solid fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- Add Field Button --}}
                    <div class="mt-2">
                        <button type="button" class="btn btn-sm btn-primary" onclick="window.addDescriptionField()">
                            <i class="fa-solid fa-plus"></i> Add Another Paragraph
                        </button>
                    </div>
                </section>
            </form>

            <!-- Overview -->
            <form id="overviewForm" action="{{ route('admin.university.add.details.update.overview') }}" method="post" class="section-form">
                @csrf
                <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
                @if(session('section') === 'overview')
                    <div class="alert alert-success">
                        {{ session('message', 'University overview updated successfully!') }}
                    </div>
                @endif
                <section class="panel" data-name="univ_overview" data-label="Overview">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="section_title">Overview: {{ $university['univ_name'] }}</h3>
                        <button type="submit" class="btn-save">Save Overview</button>
                    </div>
                    
                    <div class="row g-3">
                        <!-- Campus Area -->
                        <div class="col-md-6">
                            <div class="field cflex">
                                <label for="univ_campus_area">Campus Area (in acres)</label>
                                <input type="number" id="univ_campus_area" name="univ_campus_area" 
                                    class="form-control" placeholder="Enter campus area in acres"
                                    value="{{ old('univ_campus_area', $university['univ_campus_area'] ?? '') }}">
                            </div>
                        </div>
                        
                        <!-- Courses Offered -->
                        <div class="col-md-6">
                            <div class="field cflex">
                                <label for="univ_courses_offered">Courses Offered (comma separated)</label>
                                <input type="text" id="univ_courses_offered" name="univ_courses_offered" 
                                    class="form-control" placeholder="e.g., B.Tech, MBA, BBA, BCA"
                                    value="{{ old('univ_courses_offered', $university['univ_courses_offered'] ?? '') }}">
                            </div>
                        </div>
                        
                        <!-- Student Strength -->
                        <div class="col-md-6">
                            <div class="field cflex">
                                <label for="univ_student_strength">Student Strength</label>
                                <input type="number" id="univ_student_strength" name="univ_student_strength" 
                                    class="form-control" placeholder="Enter total number of students"
                                    value="{{ old('univ_student_strength', $university['univ_student_strength'] ?? '') }}">
                            </div>
                        </div>
                        
                        <!-- Faculty Strength -->
                        <div class="col-md-6">
                            <div class="field cflex">
                                <label for="univ_faculty_strength">Faculty Strength</label>
                                <input type="number" id="univ_faculty_strength" name="univ_faculty_strength" 
                                    class="form-control" placeholder="Enter total number of faculty members"
                                    value="{{ old('univ_faculty_strength', $university['univ_faculty_strength'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                </section>
            </form>

            <!-- University Popular Courses -->
            <form id="popularCoursesForm" action="{{ route('admin.university.add.details.update.popular-courses') }}" method="post" class="section-form mb-4">
                @csrf
                <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
                @if(session('section') === 'popular-courses')
                    <div class="alert alert-success">
                        {{ session('message', 'Popular courses updated successfully!') }}
                    </div>
                @endif
                <section class="panel" data-name="univ_popular_courses" data-label="Popular Courses">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="section_title">Popular Courses: {{ $university['univ_name'] }}</h3>
                        <button type="submit" class="btn-save">Save Popular Courses</button>
                    </div>
                    
                    @php
                        $popularCourses = [
                            'undergraduate' => [['program' => '', 'duration' => '', 'specializations' => '']],
                            'postgraduate' => [['program' => '', 'duration' => '', 'specializations' => '']],
                            'diploma' => [['program' => '', 'duration' => '', 'specializations' => '']],
                            'others' => [['program' => '', 'duration' => '', 'specializations' => '']]
                        ];
                        
                        if (isset($university['univ_popular_courses'])) {
                            if (is_string($university['univ_popular_courses'])) {
                                $decoded = json_decode($university['univ_popular_courses'], true);
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    $popularCourses = array_merge($popularCourses, $decoded);
                                }
                            } elseif (is_array($university['univ_popular_courses'])) {
                                $popularCourses = array_merge($popularCourses, $university['univ_popular_courses']);
                            }
                        }
                    @endphp
                    
                    <!-- Undergraduate Programs -->
                    <div class="program-type mb-4">
                        <h4 class="program-type-title">Undergraduate Programs</h4>
                        <div id="undergrad-programs-container">
                            @foreach(($popularCourses['undergraduate'] ?? [['program' => '', 'duration' => '', 'specializations' => '']]) as $index => $program)
                                <div class="program-entry mb-3 p-3 border rounded">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label>Program Name</label>
                                            <input type="text" name="undergrad_programs[{{ $index }}][program]" 
                                                class="form-control" placeholder="e.g., B.Tech"
                                                value="{{ old('undergrad_programs.'.$index.'.program', $program['program'] ?? '') }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Duration</label>
                                            <input type="text" name="undergrad_programs[{{ $index }}][duration]" 
                                                class="form-control" placeholder="e.g., 4 years"
                                                value="{{ old('undergrad_programs.'.$index.'.duration', $program['duration'] ?? '') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Specializations</label>
                                            <input type="text" name="undergrad_programs[{{ $index }}][specializations]" 
                                                class="form-control" placeholder="e.g., CSE, ECE, Mechanical"
                                                value="{{ old('undergrad_programs.'.$index.'.specializations', $program['specializations'] ?? '') }}">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            @if($index > 0)
                                                <button type="button" class="btn btn-sm btn-danger remove-program" data-type="undergrad">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-2 add-program" data-type="undergrad">
                            <i class="fa-solid fa-plus"></i> Add Undergraduate Program
                        </button>
                    </div>

                    <!-- Postgraduate Programs -->
                    <div class="program-type mb-4">
                        <h4 class="program-type-title">Postgraduate Programs</h4>
                        <div id="postgrad-programs-container">
                            @foreach(($popularCourses['postgraduate'] ?? [['program' => '', 'duration' => '', 'specializations' => '']]) as $index => $program)
                                <div class="program-entry mb-3 p-3 border rounded">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label>Program Name</label>
                                            <input type="text" name="postgrad_programs[{{ $index }}][program]" 
                                                class="form-control" placeholder="e.g., M.Tech"
                                                value="{{ old('postgrad_programs.'.$index.'.program', $program['program'] ?? '') }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Duration</label>
                                            <input type="text" name="postgrad_programs[{{ $index }}][duration]" 
                                                class="form-control" placeholder="e.g., 2 years"
                                                value="{{ old('postgrad_programs.'.$index.'.duration', $program['duration'] ?? '') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Specializations</label>
                                            <input type="text" name="postgrad_programs[{{ $index }}][specializations]" 
                                                class="form-control" placeholder="e.g., Data Science, AI"
                                                value="{{ old('postgrad_programs.'.$index.'.specializations', $program['specializations'] ?? '') }}">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            @if($index > 0)
                                                <button type="button" class="btn btn-sm btn-danger remove-program" data-type="postgrad">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-2 add-program" data-type="postgrad">
                            <i class="fa-solid fa-plus"></i> Add Postgraduate Program
                        </button>
                    </div>

                    <!-- Diploma Programs -->
                    <div class="program-type mb-4">
                        <h4 class="program-type-title">Diploma Programs</h4>
                        <div id="diploma-programs-container">
                            @foreach(($popularCourses['diploma'] ?? [['program' => '', 'duration' => '', 'specializations' => '']]) as $index => $program)
                                <div class="program-entry mb-3 p-3 border rounded">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label>Program Name</label>
                                            <input type="text" name="diploma_programs[{{ $index }}][program]" 
                                                class="form-control" placeholder="e.g., Diploma in Engineering"
                                                value="{{ old('diploma_programs.'.$index.'.program', $program['program'] ?? '') }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Duration</label>
                                            <input type="text" name="diploma_programs[{{ $index }}][duration]" 
                                                class="form-control" placeholder="e.g., 3 years"
                                                value="{{ old('diploma_programs.'.$index.'.duration', $program['duration'] ?? '') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Specializations</label>
                                            <input type="text" name="diploma_programs[{{ $index }}][specializations]" 
                                                class="form-control" placeholder="e.g., Mechanical, Civil, Electrical"
                                                value="{{ old('diploma_programs.'.$index.'.specializations', $program['specializations'] ?? '') }}">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            @if($index > 0)
                                                <button type="button" class="btn btn-sm btn-danger remove-program" data-type="diploma">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-2 add-program" data-type="diploma">
                            <i class="fa-solid fa-plus"></i> Add Diploma Program
                        </button>
                    </div>

                    <!-- Other Programs -->
                    <div class="program-type">
                        <h4 class="program-type-title">Other Programs</h4>
                        <div id="other-programs-container">
                            @foreach(($popularCourses['others'] ?? [['program' => '', 'duration' => '', 'specializations' => '']]) as $index => $program)
                                <div class="program-entry mb-3 p-3 border rounded">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label>Program Name</label>
                                            <input type="text" name="other_programs[{{ $index }}][program]" 
                                                class="form-control" placeholder="e.g., Certificate Course"
                                                value="{{ old('other_programs.'.$index.'.program', $program['program'] ?? '') }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Duration</label>
                                            <input type="text" name="other_programs[{{ $index }}][duration]" 
                                                class="form-control" placeholder="e.g., 6 months"
                                                value="{{ old('other_programs.'.$index.'.duration', $program['duration'] ?? '') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Specializations</label>
                                            <input type="text" name="other_programs[{{ $index }}][specializations]" 
                                                class="form-control" placeholder="e.g., Web Development, Digital Marketing"
                                                value="{{ old('other_programs.'.$index.'.specializations', $program['specializations'] ?? '') }}">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            @if($index > 0)
                                                <button type="button" class="btn btn-sm btn-danger remove-program" data-type="other">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-2 add-program" data-type="other">
                            <i class="fa-solid fa-plus"></i> Add Other Program
                        </button>
                    </div>
                </section>
            </form>

            <!-- University Facts -->
            <form id="factsForm" action="{{ route('admin.university.add.details.update.facts') }}" method="post" class="section-form">
                @csrf
                <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
                <div class="section-header">
                    <h3>University Facts</h3>
                </div>
                @if(session('section') === 'facts')
                    <div class="alert alert-success">
                        {{ session('message', 'University facts updated successfully!') }}
                    </div>
                @endif
                <section class="panel" data-name="univ_facts" data-label="Facts">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="section_title">Facts: {{ $university['univ_name'] }}</h3>
                        <button type="submit" class="btn-save">Save University Facts</button>
                    </div>
                    <div class="fields_container">
                        <div class="field cflex">
                            <label for="univ_facts1">Paragraph 1</label>
                            <textarea oninput="auto_grow(this)" id="univ_facts1" name="univ_facts[]"
                                placeholder="Write Here..."></textarea>
                        </div>
                    </div>
                    <i class="icon fa-solid fa-plus add_field" onclick="addDynamicField(this)"></i>
                </section>
            </form>


            <!-- University Advantages -->
            <form id="advantagesForm" action="{{ route('admin.university.add.details.update.advantages') }}" method="post" class="section-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
                <div class="section-header">
                    <h3>University Advantages</h3>
                </div>
                @if(session('section') === 'advantages')
                    <div class="alert alert-success">
                        {{ session('message', 'University advantages updated successfully!') }}
                    </div>
                @endif
                <section class="panel" data-name="univ_advantages" data-label="Advantages">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="section_title">Advantages: {{ $university['univ_name'] }}</h3>
                        <button type="submit" class="btn-save">Save Advantages</button>
                    </div>
                    <div class="field cflex">
                        <label for="cor">About University Advantage (optional)</label>
                        <input type="text" name="univ_adv[about]" placeholder="University Advantage About" value="{{ $university['univ_advantage'] ? json_decode($university['univ_advantage'], true)['about'] ?? '' : '' }}">
                    </div>
                    <div id="advantages-container">
                        @if($university['univ_advantage'] && isset(json_decode($university['univ_advantage'], true)['data']))
                            @foreach(json_decode($university['univ_advantage'], true)['data'] as $index => $advantage)
                                <div class="field_group">
                                    <div class="field aie" style="width:auto;">
                                        <label for="advl_{{ $index }}" class="logo">
                                            <img src="{{ asset('images/university/advantages/' . ($advantage['logo'] ?? '')) }}" alt="Advantage Logo">
                                        </label>
                                        <input type="file" id="advl_{{ $index }}" name="univ_adv[data][{{ $index }}][logo]" placeholder="University Advantage Logo" onchange="display_pic(this)">
                                    </div>
                                    <div class="field cflex">
                                        <label for="advt_{{ $index }}">Advantage Title</label>
                                        <input type="text" id="advt_{{ $index }}" name="univ_adv[data][{{ $index }}][title]" placeholder="University Advantage" value="{{ $advantage['title'] ?? '' }}">
                                    </div>
                                    <div class="field cflex">
                                        <label for="advd_{{ $index }}">Advantage Description</label>
                                        <input type="text" id="advd_{{ $index }}" name="univ_adv[data][{{ $index }}][description]" placeholder="University Advantage Description" value="{{ $advantage['description'] ?? '' }}">
                                    </div>
                                    <i class="icon fa-solid fa-trash remove-field" onclick="removeField(this)"></i>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <i class="icon fa-solid fa-plus add_field" data-field='<div class="field_group"><div class="field aie" style="width:auto;"><label for="advl__id__" class="logo"><img src="" alt="advl__id__"></label><input type="file" id="advl__id__" name="univ_adv[data][__id__][logo]" placeholder="University Advantage Logo" onchange="display_pic(this)"></div><div class="field cflex"><label for="advt__id__">Advantage Title</label><input type="text" id="advt__id__" name="univ_adv[data][__id__][title]" placeholder="University Advantage"></div><div class="field cflex"><label for="advd__id__">Advantage Description</label><input type="text" id="advd__id__" name="univ_adv[data][__id__][description]" placeholder="University Advantage Description"></div><i class="icon fa-solid fa-trash remove-field" onclick="removeField(this)"></i></div>' data-target="#advantages-container"></i>
                </section>
            </form>

            <!-- University Industry-Ready Programs -->
            <form id="industryForm" action="{{ route('admin.university.add.details.update.industry') }}" method="post" class="section-form">
                @csrf
                <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
                <div class="section-header">
                    <h3>Industry-Ready Programs</h3>
                </div>
                @if(session('section') === 'industry')
                    <div class="alert alert-success">
                        {{ session('message', 'Industry programs updated successfully!') }}
                    </div>
                @endif
                <section class="panel" data-name="univ_industry" data-label="Industry-Ready Programs">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="section_title">Industry-Ready Programs for Enhanced Career Readiness: {{ $university['univ_name'] }}</h3>
                        <button type="submit" class="btn-save">Save Industry Programs</button>
                    </div>
                    <div id="industry-container">
                        @if($university['univ_industry'] && isset(json_decode($university['univ_industry'], true)['data']))
                            @foreach(json_decode($university['univ_industry'], true)['data'] ?? [] as $index => $industry)
                                <div class="field cflex">
                                    <label for="ind_{{ $index }}">Industry {{ $index + 1 }}</label>
                                    <input id="ind_{{ $index }}" name="industry[data][]" placeholder="Industry Point" value="{{ $industry }}" />
                                    <i class="icon fa-solid fa-trash remove-field" onclick="removeField(this)"></i>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <i class="icon fa-solid fa-plus add_field" data-field='<div class="field cflex"><label for="ind__id__">Industry __id__</label><input id="ind__id__" name="industry[data][]" placeholder="Industry Point" /><i class="icon fa-solid fa-trash remove-field" onclick="removeField(this)"></i></div>' data-target="#industry-container"></i>
                </section>
            </form>

            <!-- University Career Guidance -->
            <form id="careerGuidanceForm" action="{{ route('admin.university.add.details.update.career-guidance') }}" method="post" class="section-form">
                @csrf
                <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
                @if(session('section') === 'career-guidance')
                    <div class="alert alert-success">
                        {{ session('message', 'Career guidance updated successfully!') }}
                    </div>
                @endif
                <section class="panel" data-name="univ_career_guidance" data-label="Career Guidance">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="section_title">Career Guidance: {{ $university['univ_name'] }}</h3>
                        <button type="submit" class="btn-save">Save Career Guidance</button>
                    </div>
                    <div class="field cflex">
                        <label for="car">About Career Guidance (optional)</label>
                        <input type="text" id="car" name="carrier[about]" placeholder="About Career" value="{{ $university['univ_career_guidance'] ? json_decode($university['univ_career_guidance'], true)['about'] ?? '' : '' }}">
                    </div>
                    <div id="career-container">
                        @if($university['univ_career_guidance'] && isset(json_decode($university['univ_career_guidance'], true)['data']))
                            @foreach(json_decode($university['univ_career_guidance'], true)['data'] as $index => $career)
                                <div class="field cflex">
                                    <label for="car_{{ $index }}">Career {{ $index + 1 }}</label>
                                    <input type="text" id="car_{{ $index }}" name="carrier[data][]" placeholder="Career" value="{{ $career }}">
                                    <i class="icon fa-solid fa-trash remove-field" onclick="removeField(this)"></i>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <i class="icon fa-solid fa-plus add_field" data-field='<div class="field cflex"><label for="car__id__">Career __id__</label><input type="text" id="car__id__" name="carrier[data][]" placeholder="Career"><i class="icon fa-solid fa-trash remove-field" onclick="removeField(this)"></i></div>' data-target="#career-container"></i>
                </section>
            </form>

            <!-- University SEO Work -->
            <form id="seoForm" action="{{ route('admin.university.add.details.update.seo') }}" method="post" class="section-form">
                @csrf
                <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
                <div class="section-header">
                    <h3>SEO Work</h3>
                </div>
                @if(session('section') === 'seo')
                    <div class="alert alert-success">
                        {{ session('message', 'SEO information updated successfully!') }}
                    </div>
                @endif
                <section class="panel">
                    <h3 class="section_title">SEO Work: {{ $university['univ_name'] }}</h3>
                    <div class="text-right" style="margin: 1rem 0;">
                        <button type="submit" class="btn-save">Save SEO Settings</button>
                    </div>
                    <div class="field cflex">
                        <label for="meta_h1">Text to display in H1 tag</label>
                        <input type="text" id="meta_h1" name="meta_h1" placeholder="meta_h1">
                </div>
                <div class="field_group">
                    <div class="field cflex">
                        <label for="meta_title">Meta Title of Page</label>
                        <input type="text" id="meta_title" name="meta_title" placeholder="meta_title">
                    </div>
                    <div class="field cflex">
                        <label for="meta_description">Meta Description of Page</label>
                        <input type="text" id="meta_description" name="meta_description" placeholder="meta_description">
                    </div>
                </div>
                <div class="field cflex">
                    <label for="meta_key">Meta Keywords of Page (key1, key2, key3)</label>
                    <input type="text" id="meta_key" name="meta_keywords" placeholder="meta_keywords">
                </div>
                <div class="field cflex">
                    <label for="om">If any (Write complete tags)</label>
                    <input type="text" id="om" name="other_meta_tags" placeholder="other_meta_tags">
                </div>
            </section>

            <!-- University Show on the Front -->
            <div class="field">
                <input type="checkbox" name="univ_detail_added" id="univ_active" value="1">
                <label for="univ_active">Show on frontend</label>
            </div>
            <button type="submit">Add University Details</button>
                </section>
            </form>
    </main>
    @push('script')
        <script>
            // Function to handle adding new program entries
            document.addEventListener('DOMContentLoaded', function() {
                // Add program entry
                document.addEventListener('click', function(e) {
                    if (e.target.matches('.add-program') || e.target.closest('.add-program')) {
                        const button = e.target.matches('.add-program') ? e.target : e.target.closest('.add-program');
                        const programType = button.dataset.type;
                        addProgramEntry(programType);
                    }
                    
                    // Remove program entry
                    if (e.target.matches('.remove-program') || e.target.closest('.remove-program')) {
                        const button = e.target.matches('.remove-program') ? e.target : e.target.closest('.remove-program');
                        const programType = button.dataset.type;
                        removeProgramEntry(button, programType);
                    }
                });
                
                // Initialize form validation
                const form = document.getElementById('popularCoursesForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        if (!form.checkValidity()) {
                            e.preventDefault();
                            e.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    });
                }
            });
            
            // Add a new program entry
            function addProgramEntry(programType) {
                const container = document.getElementById(`${programType}-programs-container`);
                if (!container) return;
                
                const entries = container.querySelectorAll('.program-entry');
                const index = entries.length;
                
                // Get the display name for the program type
                let displayType = '';
                switch(programType) {
                    case 'undergrad':
                        displayType = 'Undergraduate';
                        break;
                    case 'postgrad':
                        displayType = 'Postgraduate';
                        break;
                    case 'diploma':
                        displayType = 'Diploma';
                        break;
                    case 'other':
                        displayType = 'Other';
                        break;
                    default:
                        displayType = 'Program';
                }
                
                const newEntry = document.createElement('div');
                newEntry.className = 'program-entry mb-3 p-3 border rounded';
                newEntry.innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label>Program Name</label>
                            <input type="text" name="${programType}_programs[${index}][program]" 
                                class="form-control" placeholder="e.g., ${displayType} Program" required>
                        </div>
                        <div class="col-md-3">
                            <label>Duration</label>
                            <input type="text" name="${programType}_programs[${index}][duration]" 
                                class="form-control" placeholder="e.g., 4 years" required>
                        </div>
                        <div class="col-md-4">
                            <label>Specializations</label>
                            <input type="text" name="${programType}_programs[${index}][specializations]" 
                                class="form-control" placeholder="e.g., Specialization 1, Specialization 2">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-sm btn-danger remove-program" data-type="${programType}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                
                container.appendChild(newEntry);
                newEntry.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
            
            // Remove a program entry
            function removeProgramEntry(button, programType) {
                const entry = button.closest('.program-entry');
                if (entry) {
                    entry.remove();
                    // Rename remaining entries to maintain array indexing
                    const container = document.getElementById(`${programType}-programs-container`);
                    if (container) {
                        const entries = container.querySelectorAll('.program-entry');
                        entries.forEach((entry, index) => {
                            entry.querySelectorAll('input').forEach(input => {
                                input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
                            });
                        });
                    }
                }
            }
            // Check if jQuery is loaded
            if (typeof jQuery == 'undefined') {
                console.error('jQuery is not loaded');
            } else {
                console.log('jQuery version:', jQuery.fn.jquery);
            }
            // Function to display image preview
            function display_pic(node) {
                $(`label[for='${node.id}'] img`)[0].src = URL.createObjectURL(node.files[0]);
            }
            
            // Function to remove a field
            // Function to auto-grow textareas
            function auto_grow(element) {
                element.style.height = '5px';
                element.style.height = (element.scrollHeight) + 'px';
            }
            
            // Function to update field indices
            function updateFieldIndices(container) {
                $(container).find('.field').each(function(index) {
                    const $field = $(this);
                    const newIndex = index + 1;
                    
                    // Update labels
                    $field.find('label').each(function() {
                        const $label = $(this);
                        const forAttr = $label.attr('for');
                        if (forAttr) {
                            const newFor = forAttr.replace(/\d+$/, '') + newIndex;
                            $label.attr('for', newFor);
                            
                            // Update corresponding input/textarea
                            const $input = $('#' + forAttr);
                            if ($input.length) {
                                $input.attr('id', newFor);
                            }
                        }
                        
                        // Update label text if it contains a number
                        const labelText = $label.text();
                        if (/\d+$/.test(labelText)) {
                            $label.text(labelText.replace(/\d+$/, newIndex));
                        }
                    });
                });
            }
            
            // Function to remove a field
            function removeField(button) {
                const $field = $(button).closest('.field');
                if ($field.siblings('.field').length > 0) { // Keep at least one field
                    $field.remove();
                    updateFieldIndices($field.parent());
                } else {
                    // If it's the last field, just clear it
                    $field.find('input[type="text"], textarea').val('');
                }
            }
            
            // Add a new description field
            function addDescriptionField() {
                const container = $('#desc_container');
                const fieldCount = container.find('.field').length;
                const newField = $(`
                    <div class="field cflex">
                        <label for="desc_${fieldCount + 1}">Paragraph ${fieldCount + 1}</label>
                        <div class="field-wrapper">
                            <textarea oninput="auto_grow(this)" id="desc_${fieldCount + 1}" 
                                name="univ_description[]" placeholder="Write Here..." 
                                class="form-control"></textarea>
                            <button type="button" class="remove-field" onclick="removeField(this)">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                    </div>
                `);
                container.append(newField);
                newField[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                // Initialize auto-grow for the new textarea
                auto_grow(newField.find('textarea')[0]);
            }
            
            // Make the function globally available
            window.addDescriptionField = function() {
                console.log('addDescriptionField called');
                try {
                    const container = document.getElementById('desc_container');
                    if (!container) {
                        console.error('Container not found');
                        return;
                    }
                    
                    const fieldCount = container.querySelectorAll('.field').length;
                    const newField = document.createElement('div');
                    newField.className = 'field cflex';
                    newField.innerHTML = `
                        <label for="desc_${fieldCount + 1}">Paragraph ${fieldCount + 1}</label>
                        <div class="field-wrapper">
                            <textarea oninput="window.auto_grow(this)" id="desc_${fieldCount + 1}" 
                                name="univ_description[]" placeholder="Write Here..." 
                                class="form-control"></textarea>
                            <button type="button" class="remove-field" onclick="window.removeField(this)">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                    `;
                    container.appendChild(newField);
                    newField.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    window.auto_grow(newField.querySelector('textarea'));
                    console.log('Field added successfully');
                } catch (error) {
                    console.error('Error in addDescriptionField:', error);
                }
            };
            
            window.removeField = function(button) {
                const field = button.closest('.field');
                if (field && field.parentElement.querySelectorAll('.field').length > 1) {
                    field.remove();
                } else if (field) {
                    field.querySelector('textarea').value = '';
                }
            };
            
            window.auto_grow = function(element) {
                element.style.height = '5px';
                element.style.height = (element.scrollHeight) + 'px';
            };
            
            $(document).ready(function() {
                console.log('Document ready');
                // Initialize auto-grow for existing textareas
                $('textarea').each(function() {
                    window.auto_grow(this);
                });
                
                // Handle adding other fields
                $(document).on('click', '.add_field:not(.add-description-field)', function() {
                    const fieldHtml = $(this).data('field');
                    const target = $($(this).data('target') || this).parent();
                    const id = new Date().getTime();
                    const newField = fieldHtml.replace(/__id__/g, id);
                    
                    if (target.length) {
                        target.append(newField);
                    } else {
                        $(this).before(newField);
                    }
                    
                    // Initialize any new textareas
                    $('textarea').each(function() {
                        if (!$(this).hasClass('initialized')) {
                            auto_grow(this);
                            $(this).addClass('initialized');
                        }
                    });
                });
                
                // Form submission handler
                $('.section-form').on('submit', function() {
                    const submitBtn = $(this).find('button[type="submit"]');
                    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
                    return true; // Allow form to submit normally
                });
                
                // Initialize any existing textareas
                $('textarea').addClass('initialized');
            });
        </script>
    @endpush
@endsection