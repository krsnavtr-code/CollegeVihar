@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <div class="container1">
        <h1 class="page_title">Competitive Exams</h1>
        <p class="page_sub_title">Let's Create a new Competitive Exam</p>

        <form action="/admin/competitive-exam/add" method="POST" enctype="multipart/form-data" onsubmit="tinymce.triggerSave();">
            @csrf
            <section class="panel">
                <div class="field_group">

                    <!-- Exam Type -->
                    <div class="field">
                        <label for="exam_type">Exam Type</label>
                        <select id="exam_type" name="exam_type" required>
                            <option value="">Please Select</option>
                            <option value="Banking">Banking</option>
                            <option value="SSC">SSC</option>
                            <option value="teaching">Teaching</option>
                            <option value="police">POLICE</option>
                            <option value="railway">RAILWAY</option>
                            <option value="civil">CIVIL SERVICES</option>
                        </select>
                    </div>

                    <!-- Exam Name -->
                    <div class="field">
                        <label for="exam_name">Name of the Exam</label>
                        <div class="horizontal-group url-input">
                            <span>https://collegevihar.com/competitive-exam/</span>
                            <span id="exam_type_fixed"></span>
                            <input type="hidden" id="fixed_part" name="fixed_part" value="https://collegevihar.com/competitive-exam/">
                            <input type="hidden" id="exam_type_hidden" name="exam_type_hidden">
                            <input type="text" id="dynamic_part" name="exam_urls[]" placeholder="exam-name-slug" required>
                        </div>
                    </div>

                    <!-- Exam Dates -->
                    <div class="field">
                        <label>Exam Dates</label>
                        <div class="horizontal-group">
                            <div class="field">
                                <label for="exam_opening_date">Opening Date</label>
                                <input type="date" id="exam_opening_date" name="exam_opening_date" required>
                            </div>
                            <div class="field">
                                <label for="exam_closing_date">Closing Date</label>
                                <input type="date" id="exam_closing_date" name="exam_closing_date" required>
                            </div>
                        </div>
                    </div>

                    <!-- Exam Info -->
                    <div class="field">
                        <label for="exam_info_editor">Exam Info</label>
                        <textarea id="exam_info_editor" name="exam_info" required></textarea>
                    </div>

                    <!-- Questions & Answers -->
                    <div class="field">
                        <label>Questions & Answers</label>
                        <div id="qa-container">
                            <div class="horizontal-group">
                                <textarea name="questions[]" placeholder="Question" required></textarea>
                                <textarea name="answers[]" placeholder="Answer" required></textarea>
                                <button type="button" class="add-item">Add</button>
                            </div>
                        </div>
                    </div>

                    <!-- Mock Test -->
                    <div class="field">
                        <label>Mock Test</label>
                        <div id="mock-test-container">
                            <div class="horizontal-group">
                                <textarea name="mock_test_questions[]" placeholder="Question" required></textarea>
                                <textarea name="mock_test_answers[]" placeholder="Answer" required></textarea>
                                <button type="button" class="add-item">Add</button>
                            </div>
                        </div>
                    </div>

                    <!-- Videos -->
                    <div class="field">
                        <label>Videos</label>
                        <div id="video-container">
                            <div class="horizontal-group">
                                <input type="url" name="videos[]" placeholder="Video URL" required>
                                <input type="url" name="thumbnails[]" placeholder="Thumbnail URL" required>
                                <button type="button" class="add-item">Add</button>
                            </div>
                        </div>
                    </div>

                    <!-- Exam Syllabus -->
                    <div class="field">
                        <label for="competitiveexam_editor">Exam Syllabus</label>
                        <textarea id="competitiveexam_editor" name="exam_syllabus" required></textarea>
                    </div>

                    <div class="field text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </section>
        </form>
    </div>
</main>
@endsection

@push('script')
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

    document.addEventListener('DOMContentLoaded', function () {
        const addButtonListeners = () => {
            document.querySelectorAll('.add-item').forEach(button => {
                button.onclick = function () {
                    const parent = this.closest('div');
                    const container = parent.parentElement;

                    let html = '';
                    if (container.id === 'qa-container') {
                        html = `
                            <div class="horizontal-group">
                                <textarea name="questions[]" placeholder="Question" required></textarea>
                                <textarea name="answers[]" placeholder="Answer" required></textarea>
                                <button type="button" class="remove-item">Remove</button>
                            </div>`;
                    } else if (container.id === 'mock-test-container') {
                        html = `
                            <div class="horizontal-group">
                                <textarea name="mock_test_questions[]" placeholder="Question" required></textarea>
                                <textarea name="mock_test_answers[]" placeholder="Answer" required></textarea>
                                <button type="button" class="remove-item">Remove</button>
                            </div>`;
                    } else if (container.id === 'video-container') {
                        html = `
                            <div class="horizontal-group">
                                <input type="url" name="videos[]" placeholder="Video URL" required>
                                <input type="url" name="thumbnails[]" placeholder="Thumbnail URL" required>
                                <button type="button" class="remove-item">Remove</button>
                            </div>`;
                    }

                    container.insertAdjacentHTML('beforeend', html);
                    addRemoveListeners();
                }
            });
        };

        const addRemoveListeners = () => {
            document.querySelectorAll('.remove-item').forEach(button => {
                button.onclick = function () {
                    this.closest('.horizontal-group').remove();
                }
            });
        };

        document.getElementById('exam_type').addEventListener('change', function () {
            const type = this.value.toLowerCase();
            document.getElementById('exam_type_fixed').textContent = type + '/';
            document.getElementById('exam_type_hidden').value = type + '/';
        });

        addButtonListeners();
        addRemoveListeners();
    });
</script>
@endpush
