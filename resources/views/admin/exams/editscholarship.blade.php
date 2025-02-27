@extends('admin.components.layout')
@push('css')
<style>
    .container1 {
        background-color: #fff;
        padding: 20px 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
    }

    .page_title {
        font-weight: 700;
        margin-bottom: 10px;
        color: #333;
        text-align: center;
    }

    .page_sub_title {
        margin-bottom: 30px;
        color: #777;
        text-align: center;
    }

    .field_group {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .field {
        flex: 1 1 45%;
        margin-bottom: 20px;
    }

    .field.cflex {
        display: flex;
        flex-direction: column;
    }

    .horizontal-group {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .url-input {
        display: flex;
        align-items: center;
        background-color: #e0f7e0;
        padding: 10px;
        border: 1px solid #ccc;
        font-weight: bold;
        color: #333;
        flex: 1;
    }

    .url-input input {
        flex: 1;
        border: none;
        background: transparent;
        padding-left: 5px;
        font-weight: normal;
        color: #333;
    }

    .add-item,
    .remove-item {
        padding: 5px 10px;
        font-size: 18px;
        cursor: pointer;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
    }

    .remove-item {
        background-color: #dc3545;
    }
</style>
@endpush

@section('main')
<main>
    @include('admin.components.response')
    <div class="container1">
        <div>
            <h1 class="page_title">Edit Scholarship Exam</h1>
            <p class="page_sub_title">Update Scholarship Exam Details</p>
        </div>
        <form action="{{ route('scholarship-exam.update', $exam->id) }}" method="post" enctype="multipart/form-data" onsubmit="tinymce.triggerSave();">
            @csrf
            <section class="panel">
                <div class="field_group">
                    <div class="field">
                        <label for="scholarship_type">Scholarship Type</label>
                        <select id="scholarship_type" name="scholarship_type" required>
                            <option value="">Please Select </option>
                            <option value="indian" {{ $exam->scholarship_type == 'indian' ? 'selected' : '' }}>Indian Scholarships</option>
                            <option value="international" {{ $exam->scholarship_type == 'international' ? 'selected' : '' }}>International Scholarships</option>
                            <option value="research" {{ $exam->scholarship_type == 'research' ? 'selected' : '' }}>Research Scholarships</option>
                            <option value="minority" {{ $exam->scholarship_type == 'minority' ? 'selected' : '' }}>Minority Scholarships</option>
                            <option value="bpl" {{ $exam->scholarship_type == 'bpl' ? 'selected' : '' }}>BPL Scholarships</option>
                            <option value="all" {{ $exam->scholarship_type == 'all' ? 'selected' : '' }}>All Scholarships</option>
                        </select>
                    </div>

                    <!-- Name of the Exam Section -->
                    <div class="field">
                        <label for="exam_name">Name of the Exam</label>
                        <div id="exam-name-container" class="horizontal-group">
                            <div class="url-input">
                                <span>https://collegevihar.com/scholarship-exam/</span>
                                <span id="exam_type_fixed">{{ strtolower($exam->scholarship_type) }}/</span>
                                <input type="hidden" id="fixed_part" name="fixed_part" value="https://collegevihar.com/scholarship-exam/">
                                <input type="hidden" id="scholarship_type_hidden" name="scholarship_type_hidden" value="{{ strtolower($exam->scholarship_type) }}/">
                                @if(is_array($exam->exam_urls))
                                @foreach($exam->exam_urls as $url)
                                <input type="text" id="dynamic_part" name="exam_urls[]" value="{{ str_replace('https://collegevihar.com/scholarship-exam/' . strtolower($exam->scholarship_type) . '/', '', $url) }}" placeholder="Additional Details" required>
                                @endforeach
                                @else
                                <input type="text" id="dynamic_part" name="exam_urls[]" placeholder="Additional Details" required>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label for="scholarship_info">Scholarship Info</label>
                        <textarea id="scholarship_info_editor" name="scholarship_info" style="height: 400px; width: 100%;" required>{{ $exam->scholarship_info }}</textarea>
                    </div>

                    <!-- Questions & Answers Section -->
                    <div class="field">
                        <label for="questions_answers">Questions & Answers</label>
                        <div id="qa-container">
                            @php
                            $questions = json_decode($exam->questions, true);
                            $answers = json_decode($exam->answers, true);
                            @endphp
                            @if(is_array($questions) && is_array($answers))
                            @foreach($questions as $i => $question)
                            <div class="horizontal-group">
                                <textarea name="questions[]" placeholder="Question" required>{{ $question }}</textarea>
                                <textarea name="answers[]" placeholder="Answer" required>{{ $answers[$i] }}</textarea>
                                <button type="button" class="remove-item">Remove</button>
                            </div>
                            @endforeach
                            @else
                            <div class="horizontal-group">
                                <textarea name="questions[]" placeholder="Question" required></textarea>
                                <textarea name="answers[]" placeholder="Answer" required></textarea>
                                <button type="button" class="add-item">Add</button>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Mock Test Section -->
                    <div class="field">
                        <label for="mock_test">Mock Test</label>
                        <div id="mock-test-container">
                            @php
                            $mockTestQuestions = json_decode($exam->mock_test_questions, true);
                            $mockTestAnswers = json_decode($exam->mock_test_answers, true);
                            @endphp
                            @if(is_array($mockTestQuestions) && is_array($mockTestAnswers))
                            @foreach($mockTestQuestions as $i => $question)
                            <div class="horizontal-group">
                                <textarea name="mock_test_questions[]" placeholder="Question" required>{{ $question }}</textarea>
                                <textarea name="mock_test_answers[]" placeholder="Answer" required>{{ $mockTestAnswers[$i] }}</textarea>
                                <button type="button" class="remove-item">Remove</button>
                            </div>
                            @endforeach
                            @else
                            <div class="horizontal-group">
                                <textarea name="mock_test_questions[]" placeholder="Question" required></textarea>
                                <textarea name="mock_test_answers[]" placeholder="Answer" required></textarea>
                                <button type="button" class="add-item">Add</button>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- ISE DEBUG KARNA HAI -->
                    <!-- Videos Section -->
                    <div class="field">
                        <label for="videos">Videos</label>
                        <div id="video-container">
                            @if(is_array($exam->videos))
                            {{--
                            @foreach($exam->videos as $video)
                            <div class="horizontal-group">
                                <input type="url" name="videos[]" placeholder="Video URL" value="{{ $video['video_url'] }}" required>
                            <input type="url" name="thumbnails[]" placeholder="Thumbnail URL" value="{{ $video['thumbnail_url'] }}" required>
                            <button type="button" class="remove-item">Remove</button>
                        </div>
                        @endforeach
                        @else
                        --}}
                        <div class="horizontal-group">
                            <input type="url" name="videos[]" placeholder="Video URL" required>
                            <input type="url" name="thumbnails[]" placeholder="Thumbnail URL" required>
                            <button type="button" class="add-item">Add</button>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="field">
                    <label for="scholarshipexam_editor">Scholarship Syllabus</label>
                    <textarea id="scholarshipexam_editor" name="scholarship_syllabus" style="height: 400px; width: 100%;" required>{{ $exam->scholarship_syllabus }}</textarea>
                </div>

                <div class="text-end p-4">
                    <button type="submit" class="btn btn-primary btn-lg">Edit Scholarship</button>
                </div>
    </div>
    </section>
    </form>
    </div>
</main>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var addButtonListeners = function() {
            document.querySelectorAll('.add-item').forEach(function(button) {
                button.removeEventListener('click', addItem);
                button.addEventListener('click', addItem);
            });

            document.querySelectorAll('.remove-item').forEach(function(button) {
                button.removeEventListener('click', removeItem);
                button.addEventListener('click', removeItem);
            });
        };

        var addItem = function() {
            var container = this.parentElement.parentElement;
            var newItem = document.createElement('div');
            newItem.className = 'horizontal-group';
            if (container.id === 'qa-container') {
                newItem.innerHTML = '<textarea name="questions[]" placeholder="Question" required></textarea>' +
                    '<textarea name="answers[]" placeholder="Answer" required></textarea>' +
                    '<button type="button" class="remove-item">Remove</button>';
            } else if (container.id === 'mock-test-container') {
                newItem.innerHTML = '<textarea name="mock_test_questions[]" placeholder="Question" required></textarea>' +
                    '<textarea name="mock_test_answers[]" placeholder="Answer" required></textarea>' +
                    '<button type="button" class="remove-item">Remove</button>';
            } else if (container.id === 'video-container') {
                newItem.innerHTML = '<input type="url" name="videos[]" placeholder="Video URL" required>' +
                    '<input type="url" name="thumbnails[]" placeholder="Thumbnail URL" required>' +
                    '<button type="button" class="remove-item">Remove</button>';
            }
            newItem.querySelector('.remove-item').addEventListener('click', removeItem);
            container.appendChild(newItem);
            addButtonListeners();
        };

        var removeItem = function() {
            var container = this.parentElement.parentElement;
            container.removeChild(this.parentElement);
        };

        document.getElementById('scholarship_type').addEventListener('change', function() {
            var scholarshipType = this.value.toLowerCase();
            document.getElementById('exam_type_fixed').textContent = scholarshipType + '/';
            document.getElementById('scholarship_type_hidden').value = scholarshipType + '/';
        });

        addButtonListeners();
    });
</script>
<script src="https://cdn.tiny.cloud/1/d6ksyujmpkg2dehwqzrxyipe7inihpc5j9nhn40gt6cqs7kl/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#scholarshipexam_editor, #scholarship_info_editor',
        plugins: 'link',
        link_default_target: '_blank',
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }
    });
</script>
@endpush