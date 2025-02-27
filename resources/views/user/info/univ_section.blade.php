
@php
    $page_title = 'Add University Details';
@endphp

@push('css')
 <style>

.page_title {
            text-align: center;
            margin: 20px 0;
        }
        .panel {
            background: #f9f9f9;
            padding: 20px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .section_title {
            margin-bottom: 10px;
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }
        .field_group {
            display: flex;
            justify-content: space-between;
        }
        .field {
            flex: 1;
            margin-right: 10px;
        }
        .field:last-child {
            margin-right: 0;
        }
        .field label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .field input,
        .field select {
            width: 80%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .courses {
            display: flex;
            flex-wrap: wrap;
        }
        .courses .col-12 {
            flex: 1 0 100%;
            max-width: 100%;
        }
        .courses .col-s-6 {
            flex: 1 0 50%;
            max-width: 50%;
        }
        .courses .col-m-4 {
            flex: 1 0 33.33%;
            max-width: 33.33%;
        }
        .courses .col-l-3 {
            flex: 1 0 25%;
            max-width: 25%;
        }
        .courses .field {
            margin: 10px;
        } */
       
    .button-container {
        width: 100%;
        background: #f9f9f9;
        padding: 10px 0;
        box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: center;
        margin-top: 40px; 
}
 button[type="submit"] {
        background-color: #007bff;
        color: #fff;
        padding: 14px 90px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        margin-left: 611px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-bottom: 30px;
}

button[type="submit"]:hover {
    background-color: #0056b3;
} 
     .scrollable-section {
        max-height: 400px;
        overflow-y: auto;
        margin-bottom: 60px;
    }

</style>
@endpush

@extends('user.info.layout')
@section('main_section')
    <main>
        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif
        <form action="{{ route('add.university') }}" method="post">
            @csrf
            <h2 class="page_title">Add University Details</h2>
            <section class="panel">
                <h3 class="section_title left">University Details</h3>
                <div class="field_group">
                    <div class="field cflex">
                        <label for="">University Name <i class="text">( Full Name )</i></label>
                        <input type="text" placeholder="University Name" name="univ_name" value="{{ old('univ_name') }}">
                        @error('univ_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field cflex">
                        <label for="">University Url</label>
                        <input type="text" placeholder="University Url" name="univ_url" value="{{ old('univ_url') }}">
                        @error('univ_url')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="field_group">
                    <div class="field cflex">
                        <label for="">University Payout <i class="text">( In Months )</i></label>
                        <input type="number" placeholder="0" min="0" name="univ_payout" value="{{ old('univ_payout') }}">
                        @error('univ_payout')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                    <div class="field cflex">
                        <label for="">University Type</label>
                        <select name="univ_type" id="">
                            <option value="" selected disabled>--- Please Select ---</option>
                            <option value="offline" {{ old('univ_type') == 'offline' ? 'selected' : '' }}>offline</option>
                            <option value="online" {{ old('univ_type') == 'online' ? 'selected' : '' }}>online</option>
                        </select>
                        @error('univ_type')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">University Person Details</h3>
                <div class="field cflex">
                    <label for="">Connected Person Name</label>
                    <input type="test" placeholder="Person Name" name="univ_person" value="{{ old('univ_person') }}">
                    @error('univ_person')
                    <span class="error">{{ $message }}</span>
                @enderror
                </div>
                <div class="field_group">
                    <div class="field cflex">
                        <label for="">Connected Person Email</label>
                        <input type="email" placeholder="Person Email" name="univ_person_email" value="{{ old('univ_person_email') }}">
                        @error('univ_person_email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                    <div class="field cflex">
                        <label for="">Connected Person Contact</label>
                        <input type="text" placeholder="Person Contact" name="univ_person_phone" value="{{ old('univ_person_phone') }}" pattern="\d{10}" maxlength="10" 
                        title="Phone number should be 10 digits only" required>
                    </div>
                    @error('univ_person_phone')
                    <span class="error">{{ $message }}</span>
                @enderror
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">UG Courses</h3>
                <div class="courses row">
                    @foreach ($courses as $i => $course)
                        @if ($course['course_type'] == 'UG')
                            <div class="col-12 col-s-6 col-m-4 col-l-3">
                                <div class="field" title="{{ $course['course_name'] }}">
                                    <input type="checkbox" value="{{ $course['id'] }}"
                                        data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                                        id="f{{ $i }}" onchange="add_commision_field(this,{{ $course['id'] }})">
                                    <label for="f{{ $i }}">{{ $course['course_short_name'] }}</label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">PG Courses</h3>
                <div class="courses row">
                    @foreach ($courses as $i => $course)
                        @if ($course['course_type'] == 'PG')
                            <div class="col-12 col-s-6 col-m-4 col-l-3">
                                <div class="field" title="{{ $course['course_name'] }}">
                                    <input type="checkbox" value="{{ $course['id'] }}"
                                        data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                                        id="f{{ $i }}"
                                        onchange="add_commision_field(this,{{ $course['id'] }})">
                                    <label for="f{{ $i }}">{{ $course['course_short_name'] }}</label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">DIPLOMA Courses</h3>
                <div class="courses row">
                    @foreach ($courses as $i => $course)
                        @if ($course['course_type'] == 'DIPLOMA')
                            <div class="col-12 col-s-6 col-m-4 col-l-3">
                                <div class="field" title="{{ $course['course_name'] }}">
                                    <input type="checkbox" value="{{ $course['id'] }}"
                                        data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                                        id="f{{ $i }}"
                                        onchange="add_commision_field(this,{{ $course['id'] }})">
                                    <label for="f{{ $i }}">{{ $course['course_short_name'] }}</label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">CERTIFICATION Courses</h3>
                <div class="courses row">
                    @foreach ($courses as $i => $course)
                        @if ($course['course_type'] == 'CERTIFICATION')
                        <div class="col-12 col-s-6 col-m-4 col-l-3">
                            <div class="field" title="{{ $course['course_name'] }}">
                                <input type="checkbox" value="{{ $course['id'] }}"
                                    data-course="{{ $course['course_name'] . ' (' . $course['course_short_name'] . ')' }}"
                                    id="f{{ $i }}" onchange="add_commision_field(this,{{ $course['id'] }})">
                                <label for="f{{ $i }}">{{ $course['course_short_name'] }}</label>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">Commision</h3>
                <section id="courses" class="scrollable-section"></section>
            </section>
            <div class="button-container">                
                <button type="submit">Add University</button>
            </div>
        </form>
    </main>
    @endsection

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
                    `<div class="field_group cflex head_field" id="field${no}" data-linked="${link}"><h6>${course}</h6><div class="field_group"><div class="field cflex"><input type="hidden" name="course[${no}][id]" value="${no}"><input type="text" name="course[${no}][fee]" placeholder="Fees"></div><div class="field cflex"><input type="text" name="course[${no}][commision]" placeholder="Commision"></div><i class="icon delete fa-solid fa-trash" onclick="delete_field(this)"></i></div></div>`;
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

