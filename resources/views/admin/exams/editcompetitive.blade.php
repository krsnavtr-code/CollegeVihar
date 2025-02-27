@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <div class="container1">
        <div>
            <h1 class="page_title">Edit Competitive Exam</h1>
            <p class="page_sub_title">Update Competitive Exam Details</p>
        </div>
        <form action="{{ route('competitive-exam.update', $exam->id) }}" method="post" enctype="multipart/form-data" onsubmit="tinymce.triggerSave();">
            @csrf
            <section class="panel">
                <div class="field_group">
                    <div class="field">
                        <label for="exam_type">Exam Type</label>
                        <select id="exam_type" name="exam_type" required>
                            <option value="">Please Select </option>
                            <option value="Banking" {{ $exam->exam_type == 'Banking' ? 'selected' : '' }}>Banking</option>
                            <option value="SSC" {{ $exam->exam_type == 'SSC' ? 'selected' : '' }}>SSC</option>
                            <option value="teaching" {{ $exam->exam_type == 'teaching' ? 'selected' : '' }}>Teaching</option>
                            <option value="police" {{ $exam->exam_type == 'police' ? 'selected' : '' }}>POLICE</option>
                            <option value="railway" {{ $exam->exam_type == 'railway' ? 'selected' : '' }}>RAILWAY</option>
                            <option value="civil" {{ $exam->exam_type == 'civil' ? 'selected' : '' }}>CIVIL SERVICES</option>
                        </select>
                    </div>

                    <!-- Name of the Exam Section -->
                    <div class="field">
                        <label for="exam_name">Name of the Exam</label>
                        <div id="exam-name-container" class="horizontal-group">
                            <div class="url-input">
                                <span>https://collegevihar.com/competitive-exam/</span>
                                <span id="exam_type_fixed">{{ strtolower($exam->exam_type) }}/</span>
                                <input type="hidden" id="fixed_part" name="fixed_part" value="https://collegevihar.com/competitive-exam/">
                                <input type="hidden" id="exam_type_hidden" name="exam_type_hidden" value="{{ strtolower($exam->exam_type) }}/">
                                @if(is_array($exam->exam_urls))
                                @foreach($exam->exam_urls as $url)
                                <input type="text" id="dynamic_part" name="exam_urls[]" value="{{ str_replace('https://collegevihar.com/competitive-exam/' . strtolower($exam->exam_type) . '/', '', $url) }}" placeholder="Additional Details" required>
                                @endforeach
                                @else
                                <input type="text" id="dynamic_part" name="exam_urls[]" placeholder="Additional Details" required>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Exam Opening and Closing Dates Section -->
                    <div class="field">
                        <label>Exam Dates</label>
                        <div class="horizontal-group">
                            <div class="field">
                                <label for="exam_opening_date" style="font-size: 16px">Opening Date</label>
                                <input type="date" id="exam_opening_date" name="exam_opening_date" value="{{ $exam->exam_opening_date }}" required>
                            </div>
                            <div class="field">
                                <label for="exam_closing_date" style="font-size: 16px">Closing Date</label>
                                <input type="date" id="exam_closing_date" name="exam_closing_date" value="{{ $exam->exam_closing_date }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label for="exam_info">Exam Info</label>
                        <textarea id="exam_info_editor" name="exam_info" style="height: 400px; width: 100%;" required>{{ $exam->exam_info }}</textarea>
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

                    <!-- Videos Section -->
                    <div class="field">
                        <label for="videos">Videos</label>
                        <div id="video-container">
                            @if(is_array($exam->videos))
                            @foreach($exam->videos as $video)
                            <div class="horizontal-group">
                                
                                <button type="button" class="btn btn-danger">Remove</button>
                            </div>
                            @endforeach
                            @else
                            <div class="horizontal-group">
                                <input type="url" name="videos[]" placeholder="Video URL" required>
                                <input type="url" name="thumbnails[]" placeholder="Thumbnail URL" required>
                                <button type="button" class="btn btn-primary">Add</button>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="field">
                        <label for="competitiveexam_editor">Exam Syllabus</label>
                        <textarea id="competitiveexam_editor" name="exam_syllabus" required>{{ $exam->exam_syllabus }}</textarea>
                    </div>

                    <div class="text-end p-4">
                        <button type="submit" class="btn btn-primary btn-lg">Edit Competitive Exam</button>
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

        document.getElementById('exam_type').addEventListener('change', function() {
            var examType = this.value.toLowerCase();
            document.getElementById('exam_type_fixed').textContent = examType + '/';
            document.getElementById('exam_type_hidden').value = examType + '/';
        });

        addButtonListeners();
    });
</script>
<script src="https://cdn.tiny.cloud/1/d6ksyujmpkg2dehwqzrxyipe7inihpc5j9nhn40gt6cqs7kl/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#competitiveexam_editor, #exam_info_editor',
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