@extends('admin.components.layout')

@section('main')
<main>
    @include('admin.components.response')
    <section>
        <h1 class="page_title">Job Openings</h1>
        <p class="page_sub_title">Let's Create a new Job</p>

        <form action="{{ route('web_add_jobs') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="field">
                        <label for="logo">Job Logo</label>
                        <input type="file" id="logo" name="logo" accept="image/*" required>
                        @error('logo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="d-block mb-2">Image Preview</span>
                    <div class="display border rounded p-2 bg-light" style="height: 160px; display: flex; align-items: center; justify-content: center;">
                        <img id="previewLogo" src="" alt="Job Logo" style="max-height: 100%; max-width: 100%; display: none;">
                    </div>
                </div>
            </div>

            <div class="field_group">
                <div class="field">
                    <label for="job_profile">Job Profile</label>
                    <input type="text" id="job_profile" name="job_profile" placeholder="Job Profile" required>
                    @error('job_profile')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field">
                    <label for="company_name">Company Name</label>
                    <input type="text" id="company_name" name="company_name" placeholder="Company Name" required>
                    @error('company_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="field_group">
                <div class="field">
                    <label for="company_email">Company Email ID</label>
                    <input type="email" id="company_email" name="company_email" placeholder="Company Email ID" required>
                    @error('company_email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field">
                    <label for="company_phone">Company Phone Number</label>
                    <input type="tel" id="company_phone" name="company_phone" placeholder="Company Phone Number" required>
                    @error('company_phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="field">
                <label for="job_experience">Job Experience</label>
                <input type="text" id="job_experience" name="job_experience" placeholder="Job Experience" required>
                @error('job_experience')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="field mt-3">
                <label for="job_editor">Job Details</label>
                <textarea id="job_editor" name="job_detail"></textarea>
                @error('job_detail')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
            </div>
        </form>
    </section>
</main>
@endsection

@push('script')
<script src="https://cdn.tiny.cloud/1/d6ksyujmpkg2dehwqzrxyipe7inihpc5j9nhn40gt6cqs7kl/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#job_editor',
        plugins: 'link lists',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link',
        link_default_target: '_blank',
        height: 300,
        menubar: false,
        branding: false
    });

    // Live preview for image
    document.getElementById('logo').addEventListener('change', function () {
        const file = this.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById('previewLogo');
                img.src = e.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
