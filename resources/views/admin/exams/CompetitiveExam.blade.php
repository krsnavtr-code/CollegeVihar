@extends('admin.components.layout')
@section('main')
    <main>
        @include('admin.components.response')
        <div class="container1">
            <div>
                <h1 class="page_title">Competitive Exams</h1>
                <p class="page_sub_title">Let's Create a new Competitive Exam</p>
            </div>
            <form action="/admin/competitive-exam/add" method="post" enctype="multipart/form-data" onsubmit="tinymce.triggerSave();">
                @csrf
                <section class="panel">
                    <div class="field_group">
                        <div class="field">
                            <label for="exam_type" style="font-size: 18px">Exam Type</label>
                            <select id="exam_type" name="exam_type" required>
                                <option >Please Select </option>
                                <option value="Banking">Banking</option>
                                <option value="SSC">SSC</option>
                                <option value="teaching">Teaching</option>
                                <option value="police">POLICE</option>
                                <option value="railway">RAILWAY</option>
                                <option value="civil">CIVIL SERVICES</option>
                            </select>
                        </div>

                         <!-- Name of the Exam Section -->
                         <div class="field">
                            <label for="exam_name" style="font-size: 18px">Name of the Exam</label>
                            <div id="exam-name-container" class="horizontal-group">
                                <div class="url-input">
                                    <span>https://collegevihar.com/competitive-exam/</span>
                                    <span id="exam_type_fixed"></span>
                                    <input type="hidden" id="fixed_part" name="fixed_part" value="https://collegevihar.com/competitive-exam/">
                                    <input type="hidden" id="exam_type_hidden" name="exam_type_hidden">
                                    <input type="text" id="dynamic_part" name="exam_urls[]" placeholder="Additional Details" required>
                                </div>
                            </div>
                        </div>

                        <!-- Exam Opening and Closing Dates Section -->
                        <div class="field">
                            <label style="font-size: 18px">Exam Dates</label>
                            <div class="horizontal-group">
                                <div class="field">
                                    <label for="exam_opening_date" style="font-size: 16px">Opening Date</label>
                                    <input type="date" id="exam_opening_date" name="exam_opening_date" required>
                                </div>
                                <div class="field">
                                    <label for="exam_closing_date" style="font-size: 16px">Closing Date</label>
                                    <input type="date" id="exam_closing_date" name="exam_closing_date" required>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label for="exam_info" style="font-size: 18px">Exam Info</label>
                            <textarea id="exam_info_editor" name="exam_info" style="height: 400px; width: 100%;" required></textarea>
                        </div>

                        <!-- Questions & Answers Section -->
                        <div class="field">
                            <label for="questions_answers" style="font-size: 18px">Questions & Answers</label>
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
                            <label for="mock_test" style="font-size: 18px">Mock Test</label>
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
                            <label for="videos" style="font-size: 18px">Videos</label>
                            <div id="video-container">
                                <div class="horizontal-group">
                                    <input type="url" name="videos[]" placeholder="Video URL" required>
                                    <input type="url" name="thumbnails[]" placeholder="Thumbnail URL" required>
                                    <button type="button" class="add-item">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label for="competitiveexam_editor" style="font-size: 18px">Exam Syllabus</label>
                            <textarea id="competitiveexam_editor" name="exam_syllabus" style="height: 400px; width: 100%;" required></textarea>
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
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
    </script>
@endpush
