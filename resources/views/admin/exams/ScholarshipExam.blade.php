@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <div class="container1">
        <h1 class="page_title">Scholarship Exams</h1>
        <p class="page_sub_title">Let's Create a new Scholarship Exam</p>

        <form action="/admin/scholarship-exam/add" method="POST" enctype="multipart/form-data" onsubmit="tinymce.triggerSave();">
            @csrf
            <section class="panel">
                <div class="field_group">

                    <!-- Scholarship Type -->
                    <div class="field">
                        <label for="scholarship_type">Scholarship Type</label>
                        <select id="scholarship_type" name="scholarship_type" required>
                            <option value="">Please Select</option>
                            <option value="indian">Indian Scholarships</option>
                            <option value="international">International Scholarships</option>
                            <option value="research">Research Scholarships</option>
                            <option value="minority">Minority Scholarships</option>
                            <option value="bpl">BPL Scholarships</option>
                            <option value="all">All Scholarships</option>
                        </select>
                    </div>

                    <!-- Scholarship URL -->
                    <div class="field">
                        <label for="exam_name">Name of the Scholarship</label>
                        <div id="exam-name-container" class="horizontal-group url-input">
                            <span>https://collegevihar.com/scholarship-exam/</span>
                            <span id="exam_type_fixed"></span>
                            <input type="hidden" id="fixed_part" name="fixed_part" value="https://collegevihar.com/scholarship-exam/">
                            <input type="hidden" id="scholarship_type_hidden" name="scholarship_type_hidden">
                            <input type="text" id="dynamic_part" name="exam_urls[]" placeholder="additional-details" required>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="field">
                        <label for="scholarship_info_editor">Scholarship Info</label>
                        <textarea id="scholarship_info_editor" name="scholarship_info" required></textarea>
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

                    <!-- Syllabus -->
                    <div class="field">
                        <label for="scholarshipexam_editor">Scholarship Syllabus</label>
                        <textarea id="scholarshipexam_editor" name="scholarship_syllabus" required></textarea>
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
        selector: '#scholarshipexam_editor, #scholarship_info_editor',
        plugins: 'link',
        link_default_target: '_blank',
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const addItem = function () {
            const container = this.closest('.horizontal-group').parentElement;
            let html = '';

            if (container.id === 'qa-container') {
                html = `<div class="horizontal-group">
                    <textarea name="questions[]" placeholder="Question" required></textarea>
                    <textarea name="answers[]" placeholder="Answer" required></textarea>
                    <button type="button" class="remove-item">Remove</button>
                </div>`;
            } else if (container.id === 'mock-test-container') {
                html = `<div class="horizontal-group">
                    <textarea name="mock_test_questions[]" placeholder="Question" required></textarea>
                    <textarea name="mock_test_answers[]" placeholder="Answer" required></textarea>
                    <button type="button" class="remove-item">Remove</button>
                </div>`;
            } else if (container.id === 'video-container') {
                html = `<div class="horizontal-group">
                    <input type="url" name="videos[]" placeholder="Video URL" required>
                    <input type="url" name="thumbnails[]" placeholder="Thumbnail URL" required>
                    <button type="button" class="remove-item">Remove</button>
                </div>`;
            }

            container.insertAdjacentHTML('beforeend', html);
            bindRemoveEvents();
        };

        const removeItem = function () {
            this.closest('.horizontal-group').remove();
        };

        const bindAddEvents = () => {
            document.querySelectorAll('.add-item').forEach(btn => {
                btn.removeEventListener('click', addItem);
                btn.addEventListener('click', addItem);
            });
        };

        const bindRemoveEvents = () => {
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.removeEventListener('click', removeItem);
                btn.addEventListener('click', removeItem);
            });
        };

        document.getElementById('scholarship_type').addEventListener('change', function () {
            const val = this.value.toLowerCase();
            document.getElementById('exam_type_fixed').textContent = val + '/';
            document.getElementById('scholarship_type_hidden').value = val + '/';
        });

        bindAddEvents();
    });
</script>
@endpush
