@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <div>
        <h1 class="page_title">Edit Job Opening</h1>
        <p class="page_sub_title">Update the details of the job</p>
    </div>
    <form action="{{ route('web_update_job', $job->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="field">
                    <label for="logo">Job Logo</label>
                    <input type="file" id="logo" name="logo" required>
                </div>
            </div>
            <div class="col-lg-6">
                <span>Upload a new image to change the logo</span>
                <label for="logo">
                    <div class="display">
                        <img src="{{ asset('storage/' . $job->logo) }}" alt="Current Job Logo" width="100">
                    </div>
                </label>
            </div>
        </div>
        <div class="field_group">
            <div class="field">
                <label for="job_profile"> Job Profile </label>
                <input type="text" id="job_profile" name="job_profile" placeholder="Job Profile" value="{{ $job->job_profile }}" required>
            </div>
            <div class="field">
                <label for="company_name">Company Name</label>
                <input type="text" id="company_name" name="company_name" placeholder="Company Name" value="{{ $job->company_name }}" required>
            </div>
        </div>
        <div class="field_group">
            <div class="field">
                <label for="company_email">Company Email ID</label>
                <input type="email" id="company_email" name="company_email" placeholder="Company Email ID" value="{{ $job->company_email }}" required>
            </div>
            <div class="field">
                <label for="company_phone">Company Phone Number</label>
                <input type="tel" id="company_phone" name="company_phone" placeholder="Company Phone Number" value="{{ $job->company_phone }}" required>
            </div>
        </div>
        <div class="field">
            <label for="job_experience">Job Experience</label>
            <input type="text" id="job_experience" name="job_experience" placeholder="Job Experience" value="{{ $job->job_experience }}" required>
            <label for="job_editor">Job Details</label>
            <textarea id="job_editor" name="job_detail" style="height: 400px">{{ $job->job_detail }}</textarea>
        </div>
        <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">Update</button>
        </div>
    </form>
</main>
@endsection
@push('script')
<script src="https://cdn.tiny.cloud/1/d6ksyujmpkg2dehwqzrxyipe7inihpc5j9nhn40gt6cqs7kl/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#job_editor',
        plugins: 'link',
        link_default_target: '_blank'
    });
</script>
@endpush