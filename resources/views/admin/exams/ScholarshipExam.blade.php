@extends('admin.components.layout')
@section('main')
    <main>
        @include('admin.components.response')
        <div class="container1">
            <div>
                <h1 class="page_title">Scholarship Exams</h1>
                <p class="page_sub_title">Let's Create a new Scholarship Exam</p>
            </div>
            <form action="/admin/scholarship-exam/add" method="post" enctype="multipart/form-data" onsubmit="tinymce.triggerSave();">
                @csrf
                <section class="panel">
                    <div class="field_group">
                        <div class="field">
                            <label for="scholarship_type">Scholarship Type</label>
                            <select id="scholarship_type" name="scholarship_type" required>
                                <option>Please Select</option>
                                <option value="indian">Indian Scholarships</option>
                                <option value="international">International Scholarships</option>
                                <option value="research">Research Scholarships</option>
                                <option value="minority">Minority Scholarships</option>
                                <option value="bpl">BPL Scholarships</option>
                                <option value="all">All Scholarships</option>
                            </select>
                        </div>

                        <!-- Name of the Exam Section -->
                        <div class="field">
                            <label for="exam_name">Name of the Scholarship</label>
                            <div id="exam-name-container" class="horizontal-group">
                                <div class="url-input">
                                    <span>https://collegevihar.com/scholarship-exam/</span>
                                    <span id="exam_type_fixed"></span>
                                    <input type="hidden" id="fixed_part" name="fixed_part" value="https://collegevihar.com/scholarship-exam/">
                                    <input type="hidden" id="scholarship_type_hidden" name="scholarship_type_hidden">
                                    <input type="text" id="dynamic_part" name="exam_urls[]" placeholder="Additional Details" required>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label for="scholarship_info">Scholarship Info</label>
                            <textarea id="scholarship_info_editor" name="scholarship_info" style="height: 400px; width: 100%;" required></textarea>
                        </div>

                        <!-- Questions & Answers Section -->
                        <div class="field">
                            <label for="questions_answers">Questions & Answers</label>
                            <div id="qa-container">
                                <div class="horizontal-group">
                                    <textarea name="questions[]" placeholder="Question" required></textarea>
                                    <textarea name="answers[]" placeholder="Answer" required></textarea>
                                    <button type="button" class="add-item">Add</button>
                                </div>
                            </div>
                        </div>

                        <!-- Mock Test Section -->
                        <div class="field">
                            <label for="mock_test">Mock Test</label>
                            <div id="mock-test-container">
                                <div class="horizontal-group">
                                    <textarea name="mock_test_questions[]" placeholder="Question" required></textarea>
                                    <textarea name="mock_test_answers[]" placeholder="Answer" required></textarea>
                                    <button type="button" class="add-item">Add</button>
                                </div>
                            </div>
                        </div>

                        <!-- Videos Section -->
                        <div class="field">
                            <label for="videos">Videos</label>
                            <div id="video-container">
                                <div class="horizontal-group">
                                    <input type="url" name="videos[]" placeholder="Video URL" required>
                                    <input type="url" name="thumbnails[]" placeholder="Thumbnail URL" required>
                                    <button type="button" class="add-item">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label for="scholarshipexam_editor">Scholarship Syllabus</label>
                            <textarea id="scholarshipexam_editor" name="scholarship_syllabus" style="height: 400px; width: 100%;" required></textarea>
                        </div>

                        <div class="field">
                            <button type="submit" class="add-item">Submit</button>
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
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
    </script>
@endpush
