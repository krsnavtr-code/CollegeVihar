@extends('admin.components.layout')
@section('title', 'Add University Details - CV Admin')

<style>
    /* Form sections */
    .section-form {
        margin-bottom: 2.5rem;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        border: 1px solid #e0e0e0;
    }
    
    /* Section headers */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #eaeaea;
    }
    
    .section-header h3 {
        margin: 0;
        color: #2c3e50;
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    /* Buttons */
    .btn-save, .btn.btn-sm.btn-primary {
        padding: 0.5rem 1.25rem;
        background: #4a90e2;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .btn-save:hover, .btn.btn-sm.btn-primary:hover {
        background: #357abd;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .btn-save:disabled, .btn.btn-sm.btn-primary:disabled {
        background: #cccccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
        opacity: 0.7;
    }
    
    /* Form fields */
    .field {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .field label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #333;
        font-size: 0.95rem;
    }
    
    .field-wrapper {
        position: relative;
        width: 100%;
    }
    
    .field textarea {
        width: 100%;
        min-height: 120px;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        resize: none;
        overflow: hidden;
        font-family: inherit;
        font-size: 14px;
        line-height: 1.5;
        transition: all 0.2s;
    }
    
    .field textarea:focus {
        outline: none;
        border-color: #4a90e2;
        box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
    }
    
    /* Remove field button */
    .remove-field {
        position: absolute;
        right: 10px;
        top: 10px;
        background: #ff4444;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 0;
        opacity: 0.8;
        transition: all 0.2s;
    }
    
    .remove-field:hover {
        opacity: 1;
        background: #cc0000;
        transform: scale(1.1);
    }
    
    /* Alert messages */
    .alert {
        padding: 12px 16px;
        margin-bottom: 1.5rem;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    /* Panel styling */
    .panel {
        background: white;
        border-radius: 6px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    
    .section_title {
        margin-top: 0;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #eee;
        color: #444;
        font-size: 1.1rem;
    }
    
    /* Loading spinner */
    .fa-spinner {
        margin-right: 6px;
    }
    
    .alert {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 4px;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .alert ul {
        margin: 0;
        padding-left: 1.5rem;
    }
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f9f9f9;
    }

    main {
        padding: 2rem;
        max-width: 1000px;
        margin: auto;
    }

    .panel {
        background: #fff;
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .section_title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }

    .field,
    .field_group {
        margin-bottom: 1rem;
    }

    .field label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    input[type="text"],
    input[type="file"],
    textarea,
    select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #5a67d8;
        outline: none;
    }

    .field_group {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .cflex {
        display: flex;
        flex-direction: column;
    }

    .aie {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .img_label {
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
    }

    .img_label img {
        height: 50px;
        width: 50px;
        object-fit: cover;
        border-radius: 6px;
        background-color: #eee;
    }

    .add_field {
        color: #4a5568;
        font-size: 1.1rem;
        cursor: pointer;
        display: inline-block;
        margin-top: 10px;
    }

    .add_field:hover {
        color: #2b6cb0;
    }

    button[type="submit"] {
        padding: 0.75rem 1.5rem;
        background: #4a90e2;
        color: #fff;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    button[type="submit"]:hover {
        background: #357ac9;
    }

    @media (max-width: 768px) {
        .field_group {
            flex-direction: column;
        }

        .aie {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    input[type="file"] {
        padding: 10px;
        background-color: #f0f0f0;
    }

    input[type="checkbox"] {
        transform: scale(1.3);
        margin-right: 0.5rem;
    }

    .field input:invalid {
        border-color: #e53e3e;
    }

    .field input:valid {
        border-color: #48bb78;
    }
</style>


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
                    <h3 class="section_title">Info: {{ $university['univ_name'] }}</h3>
                    <div class="text-right" style="margin: 1rem 0;">
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
                    <div class="text-right mt-2">
                        <button type="button" class="btn btn-sm btn-primary add-description-field">
                            <i class="fa-solid fa-plus"></i> Add Another Paragraph
                        </button>
                    </div>
                </section>
            </form>


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
                    <h3 class="section_title">Facts: {{ $university['univ_name'] }}</h3>
                    <div class="text-right" style="margin: 1rem 0;">
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
                <section class="panel">
                    <h3 class="section_title">Advantages: {{ $university['univ_name'] }}</h3>
                    <div class="text-right" style="margin: 1rem 0;">
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
                <section class="panel">
                    <h3 class="section_title">Industry-Ready Programs for Enhanced Career Readiness: {{ $university['univ_name'] }}</h3>
                    <div class="text-right" style="margin: 1rem 0;">
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
                <div class="section-header">
                    <h3>Career Guidance</h3>
                </div>
                @if(session('section') === 'career-guidance')
                    <div class="alert alert-success">
                        {{ session('message', 'Career guidance updated successfully!') }}
                    </div>
                @endif
                <section class="panel">
                    <h3 class="section_title">Career Guidance: {{ $university['univ_name'] }}</h3>
                    <div class="text-right" style="margin: 1rem 0;">
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
                    <div class="field">
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
            }
            
            $(document).ready(function() {
                // Initialize auto-grow for existing textareas
                $('textarea').each(function() {
                    auto_grow(this);
                });
                
                // Handle adding new description fields
                $(document).on('click', '.add-description-field', function(e) {
                    e.preventDefault();
                    addDescriptionField();
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