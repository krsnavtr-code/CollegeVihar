@extends('admin.components.layout')
@section('main')
    <main>
        @include('admin.components.response')
        
        @php
            // Debug: Uncomment to see the full course data structure
            // dd($course);
            
            // Ensure we have a course array to work with
            $course = $course ?? [];
            $course['course'] = $course['course'] ?? [];
            $course['university'] = $course['university'] ?? [];
        @endphp
        
        <form action="/admin/university/courses/edit" method="post">
            <h5 class="page_title">
                Edit University Course: 
                <b class="text-secondary">{{ $course['course']['course_name'] ?? ($course['course_name'] ?? 'N/A') }}</b> 
                at 
                <b class="text-secondary">{{ $course['university']['univ_name'] ?? ($course['university_name'] ?? 'N/A') }}</b>
            </h5>
            @csrf
            <input type="hidden" name="course_id" value="{{ $course['id'] ?? '' }}">
            <input type="hidden" name="course_slug" value="{{ $course['univ_course_slug'] ?? '' }}">
            
            <section class="panel">
                <h3 class="section_title">Course URL slug</h3>
                <div class="field with_data aic">
                    <h6>https://collegevihar.com/course/</h6>
                    <input type="text" name="course_slug" id="course_slug" placeholder="Course Slug"
                        style="padding-inline: 5px;font-weight:600;"
                        value="{{ $course['univ_course_slug'] ?? str_replace(' ', '-', strtolower(($course['university']['univ_name'] ?? ($course['university_name'] ?? '')).'-'.($course['course']['course_name'] ?? ($course['course_name'] ?? '')))) }}">
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">About University Course</h3>
                @php
                    // Helper function to safely get array data
                    function getArrayData($data, $key, $default = []) {
                        if (!isset($data[$key])) {
                            return $default;
                        }
                        
                        if (is_array($data[$key])) {
                            return $data[$key];
                        }
                        
                        if (is_string($data[$key]) && !empty($data[$key])) {
                            $decoded = json_decode($data[$key], true);
                            return (json_last_error() === JSON_ERROR_NONE) ? $decoded : $default;
                        }
                        
                        return $default;
                    }
                    
                    // Get all sections with proper fallbacks
                    $aboutSections = getArrayData($course, 'uc_about', ['']);
                    $overviewSections = getArrayData($course, 'uc_overview', ['']);
                    $highlightsSections = getArrayData($course, 'uc_highlight', ['']);
                    $helpSections = getArrayData($course, 'uc_cv_help', ['']);
                    $collaborationSections = getArrayData($course, 'uc_collab', ['']);
                    $expertsSections = getArrayData($course, 'uc_expert', ['']);
                    $subjectBlocks = getArrayData($course, 'uc_subjects', [['title' => 'Semester 1', 'description' => '', 'subjects' => '']]);
                    $details = getArrayData($course, 'uc_details', [['title' => '', 'description' => '']]);
                    $jobOpportunities = getArrayData($course, 'uc_job', ['']);
                @endphp
                @foreach($aboutSections as $index => $about)
                <div class="field_group head_field">
                    <div class="field">
                        <label for="about_{{ $index }}">Paragraph {{ $index + 1 }}</label>
                        <textarea id="about_{{ $index }}" name="uc_about[]" placeholder="Write Here...">{{ $about }}</textarea>
                    </div>
                    @if($index > 0)
                    <i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i>
                    @endif
                </div>
                @endforeach
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="int__id__">Paragraph __id__</label><textarea id="int__id__" name="uc_about[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">University Course Overview</h3>
                @php
                    $overviewSections = [];
                    if (isset($course['uc_overview'])) {
                        if (is_string($course['uc_overview'])) {
                            $overviewSections = json_decode($course['uc_overview'], true) ?: [];
                        } elseif (is_array($course['uc_overview'])) {
                            $overviewSections = $course['uc_overview'];
                        }
                    }
                    if (empty($overviewSections)) {
                        $overviewSections = [''];
                    }
                @endphp
                @foreach($overviewSections as $index => $overview)
                <div class="field_group head_field">
                    <div class="field">
                        <label for="overview_{{ $index }}">Paragraph {{ $index + 1 }}</label>
                        <textarea id="overview_{{ $index }}" name="uc_overview[]" placeholder="Write Here...">{{ $overview }}</textarea>
                    </div>
                    @if($index > 0)
                    <i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i>
                    @endif
                </div>
                @endforeach
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="over__id__">Paragraph __id__</label><textarea id="over__id__" name="uc_overview[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">University Course Highlights</h3>
                @php
                    $highlightsSections = [];
                    if (isset($course['uc_highlight'])) {
                        if (is_string($course['uc_highlight'])) {
                            $highlightsSections = json_decode($course['uc_highlight'], true) ?: [];
                        } elseif (is_array($course['uc_highlight'])) {
                            $highlightsSections = $course['uc_highlight'];
                        }
                    }
                    if (empty($highlightsSections)) {
                        $highlightsSections = [''];
                    }
                @endphp
                @foreach($highlightsSections as $index => $highlight)
                <div class="field_group head_field">
                    <div class="field">
                        <label>Highlight {{ $index + 1 }}</label>
                        <input type="text" name="uc_highlights[]" placeholder="Enter highlight" value="{{ $highlight }}">
                    </div>
                    @if($index > 0)
                    <i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i>
                    @endif
                </div>
                @endforeach
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label>Highlight Title</label><input type="text" id="highti__id__" name="uc_highlights[]" placeholder="Title"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">How CollegeVihar Helps You</h3>
                @php
                    $helpSections = [];
                    if (isset($course['uc_cv_help'])) {
                        if (is_string($course['uc_cv_help'])) {
                            $helpSections = json_decode($course['uc_cv_help'], true) ?: [];
                        } elseif (is_array($course['uc_cv_help'])) {
                            $helpSections = $course['uc_cv_help'];
                        }
                    }
                    if (empty($helpSections)) {
                        $helpSections = [''];
                    }
                @endphp
                @foreach($helpSections as $index => $help)
                <div class="field_group head_field">
                    <div class="field">
                        <label for="help_{{ $index }}">Paragraph {{ $index + 1 }}</label>
                        <textarea id="help_{{ $index }}" name="uc_cv_help[]" placeholder="Write Here...">{{ $help }}</textarea>
                    </div>
                    @if($index > 0)
                    <i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i>
                    @endif
                </div>
                @endforeach
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="help__id__">Paragraph __id__</label><textarea id="help__id__" name="uc_cv_help[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            {{-- <section class="panel">
                <h3 class="section_title">Specialization of Collegevihar to Course</h3>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="over__id__">Paragraph __id__</label><textarea id="over__id__" name="uc_speci[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section> --}}
            <section class="panel">
                <h3 class="section_title">Collaboration to Succeed</h3>
                @php
                    $collaborationSections = [];
                    if (isset($course['uc_collab'])) {
                        if (is_string($course['uc_collab'])) {
                            $collaborationSections = json_decode($course['uc_collab'], true) ?: [];
                        } elseif (is_array($course['uc_collab'])) {
                            $collaborationSections = $course['uc_collab'];
                        }
                    }
                    if (empty($collaborationSections)) {
                        $collaborationSections = [''];
                    }
                @endphp
                @foreach($collaborationSections as $index => $collab)
                <div class="field_group head_field">
                    <div class="field">
                        <label for="collab_{{ $index }}">Paragraph {{ $index + 1 }}</label>
                        <textarea id="collab_{{ $index }}" name="uc_collab[]" placeholder="Write Here...">{{ $collab }}</textarea>
                    </div>
                    @if($index > 0)
                    <i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i>
                    @endif
                </div>
                @endforeach
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="collab__id__">Paragraph __id__</label><textarea id="collab__id__" name="uc_collab[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Grouping with Experts</h3>
                @php
                    $expertsSections = [];
                    if (isset($course['uc_expert'])) {
                        if (is_string($course['uc_expert'])) {
                            $expertsSections = json_decode($course['uc_expert'], true) ?: [];
                        } elseif (is_array($course['uc_expert'])) {
                            $expertsSections = $course['uc_expert'];
                        }
                    }
                    if (empty($expertsSections)) {
                        $expertsSections = [''];
                    }
                @endphp
                @foreach($expertsSections as $index => $expert)
                <div class="field_group head_field">
                    <div class="field">
                        <label for="expert_{{ $index }}">Expert {{ $index + 1 }}</label>
                        <textarea id="expert_{{ $index }}" name="uc_experts[]" placeholder="Write Here...">{{ $expert }}</textarea>
                    </div>
                    @if($index > 0)
                    <i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i>
                    @endif
                </div>
                @endforeach
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group head_field"><div class="field"><label for="expert__id__">Expert __id__</label><textarea id="expert__id__" name="uc_experts[]" placeholder="Write Here..."></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'></i>
            </section>
            <section class="semester_panels">
                @php
                    $subjectBlocks = [];
                    if (isset($course['uc_subjects'])) {
                        if (is_string($course['uc_subjects'])) {
                            $subjectBlocks = json_decode($course['uc_subjects'], true) ?: [];
                        } elseif (is_array($course['uc_subjects'])) {
                            $subjectBlocks = $course['uc_subjects'];
                        }
                    }
                    if (empty($subjectBlocks)) {
                        $subjectBlocks = [['title' => 'Semester 1', 'description' => '', 'subjects' => '']];
                    }
                    $blockIndex = count($subjectBlocks);
                @endphp
                
                @foreach($subjectBlocks as $index => $block)
                <section class="panel semester_panel">
                    <h3 class="section_title">University Course <i class="text">Subject block {{ $index + 1 }}</i></h3>
                    <div class="field">
                        <label>Subject Block Title <i class="text">(Semester/Year)</i></label>
                        <input type="text" value="{{ $block['title'] ?? 'Semester ' . ($index + 1) }}" name="uc_subjects[{{ $index }}][title]">
                    </div>
                    <div class="field">
                        <label>Subject Block Description <i class="text">(Optional)</i></label>
                        <textarea name="uc_subjects[{{ $index }}][description]">{{ $block['description'] ?? '' }}</textarea>
                    </div>
                    <div class="field">
                        <label>Subjects <i class="text">(Separate with comma)</i></label>
                        <textarea name="uc_subjects[{{ $index }}][subjects]">{{ $block['subjects'] ?? '' }}</textarea>
                    </div>
                    @if($index > 0)
                    <i class="icon delete fa-solid fa-trash" onclick="delete_section(this)"></i>
                    @endif
                </section>
                @php $blockIndex = $index + 1; @endphp
                @endforeach
                
                <i class="icon fa-solid fa-plus add_subject_block" data-index="{{ $blockIndex }}"
                    data-field='<section class="panel semester_panel"><h3 class="section_title">University Course <i class="text">Subject block __id__</i></h3><div class="field"><label>Subject Block Title <i class="text">(Semester/Year)</i></label><input type="text" value="Semester __id__" name="uc_subjects[__id__][title]"></div><div class="field"><label>Subject Block Description <i class="text">(Optional)</i></label><textarea name="uc_subjects[__id__][description]"></textarea></div><div class="field"><label>Subjects <i class="text">(Separate with comma)</i></label><textarea name="uc_subjects[__id__][subjects]"></textarea></div><i class="icon delete fa-solid fa-trash" onclick="delete_section(this)"></i></section>'
                    data-container=".semester_panels">Add Subject Block</i>
            </section>
            <section class="panel">
                <h3 class="section_title">University Course Details</h3>
                <div id="details_fields">
                    @php
                    $details = [];
                    if (isset($course['uc_details'])) {
                        if (is_string($course['uc_details'])) {
                            $details = json_decode($course['uc_details'], true) ?: [];
                        } elseif (is_array($course['uc_details'])) {
                            $details = $course['uc_details'];
                        }
                    }
                    if (empty($details)) {
                        $details = [['title' => '', 'description' => '']];
                    }
                @endphp
                    
                    @foreach($details as $index => $detail)
                    <div class="field_group">
                        <div class="field">
                            <label for="detail_title_{{ $index }}">Detail Title</label>
                            <input type="text" id="detail_title_{{ $index }}" name="uc_details[{{ $index }}][title]" placeholder="Title" value="{{ $detail['title'] ?? '' }}">
                        </div>
                        <div class="field">
                            <label for="detail_desc_{{ $index }}">Detail Description</label>
                            <input type="text" id="detail_desc_{{ $index }}" name="uc_details[{{ $index }}][description]" placeholder="Description" value="{{ $detail['description'] ?? '' }}">
                        </div>
                        @if($index > 0)
                        <i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i>
                        @endif
                    </div>
                    @endforeach
                </div>
                <i class="icon fa-solid fa-plus add_field"
                    data-field='<div class="field_group"><div class="field"><label for="detail_title___id__">Detail Title</label><input type="text" id="detail_title___id__" name="uc_details[__id__][title]" placeholder="Title"></div><div class="field"><label for="detail_desc___id__">Detail Description</label><input type="text" id="detail_desc___id__" name="uc_details[__id__][description]" placeholder="Description"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div>'
                    data-container="#details_fields"></i>
            </section>
            <section class="panel">
                <h3 class="section_title">Job Opportunity</h3>
                @php
                    $jobOpportunities = [];
                    if (isset($course['uc_job'])) {
                        if (is_string($course['uc_job'])) {
                            $jobOpportunities = json_decode($course['uc_job'], true) ?: [];
                        } elseif (is_array($course['uc_job'])) {
                            $jobOpportunities = $course['uc_job'];
                        }
                    }
                    if (empty($jobOpportunities)) {
                        $jobOpportunities = [''];
                    }
                @endphp
                @foreach($jobOpportunities as $index => $job)
                <div class="field_group head_field">
                    <div class="field">
                        <label for="job_{{ $index }}">Opportunity {{ $index + 1 }}</label>
                        <input type="text" id="job_{{ $index }}" name="uc_job[]" placeholder="Opportunity" value="{{ $job }}">
                    </div>
                    @if($index > 0)
                    <i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i>
                    @endif
                </div>
                @endforeach
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
            $(document).ready(function() {
                // Handle adding new fields
                $(document).on('click', '.add_field', function() {
                    let field = $(this).data('field');
                    let container = $(this).data('container');
                    
                    // Find the next available index
                    let maxIndex = -1;
                    $(container + ' [name]').each(function() {
                        let name = $(this).attr('name');
                        let matches = name.match(/\[(\d+)\]/g);
                        if (matches) {
                            matches.forEach(match => {
                                let index = parseInt(match.replace(/[\[\]]/g, ''));
                                if (!isNaN(index) && index > maxIndex) {
                                    maxIndex = index;
                                }
                            });
                        }
                    });
                    
                    let newIndex = maxIndex + 1;
                    let newField = field.replace(/__id__/g, newIndex);
                    
                    if (container) {
                        $(container).append(newField);
                    } else {
                        $(this).before(newField);
                    }
                });
                
                // Handle adding new subject blocks
                $(document).on('click', '.add_subject_block', function() {
                    let field = $(this).data('field');
                    let container = $(this).data('container');
                    let index = $(this).data('index');
                    
                    let newField = field.replace(/__id__/g, index);
                    $(container).append(newField);
                    
                    // Update the index for the next block
                    $(this).data('index', index + 1);
                });
                
                // Handle deleting fields
                $(document).on('click', '.delete', function() {
                    $(this).closest('.field_group, .semester_panel, .head_field').remove();
                });
                
                // Initialize any existing fields
                function initializeFields() {
                    $('.field_group, .semester_panel').each(function() {
                        let $this = $(this);
                        if ($this.find('.delete').length === 0) {
                            $this.append('<i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i>');
                        }
                    });
                }
                
                initializeFields();
            });
            
            // Global functions for backward compatibility
            function delete_field(element) {
                $(element).closest('.field_group, .head_field').remove();
            }
            
            function delete_section(element) {
                $(element).closest('.semester_panel').remove();
            }
            
            function add_field(element) {
                let $this = $(element);
                let field = $this.data('field');
                let container = $this.data('container');
                
                if (container) {
                    $(container).append(field);
                } else {
                    $this.before(field);
                }
            }
        </script>
    @endpush
@endsection