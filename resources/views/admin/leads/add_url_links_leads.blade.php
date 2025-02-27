@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    @if (session('success'))
    <div class="response success">
        <p class=" aic"><i class="fa-solid fa-check icon"></i> {{ session('success') }} </p>
    </div>
    @endif
    @if (session('error'))
    <div class="response error">
        <p class=" aic"><i class="fa-solid fa-bug icon"></i> {{ session('error') }} </p>
    </div>
    @endif

    <form action="/admin/lead/create-add-url-links" method="post">
        @csrf
        <h2 class="page_title">Add URL Links Leads </h2>
        <section class="panel">
            <div class="field">
                <label for="">Agent Name</label>
                <input type="text" name="agent_name" placeholder="Agent Name" required>
            </div>

            <div class="field_group">
                <div class="field">
                    <label for="social_media_1">Social Media Link 1</label>
                    <input type="url" name="social_media_1" placeholder="Social Media Link 1" required>
                </div>
                <div class="field">
                    <label for="social_media_2">Social Media Link 2</label>
                    <input type="url" name="social_media_2" placeholder="Social Media Link 2" required>
                </div>
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="social_media_3">Social Media Link 3</label>
                    <input type="url" name="social_media_3" placeholder="Social Media Link 3" required>
                </div>
                <div class="field">
                    <label for="social_media_4">Social Media Link 4</label>
                    <input type="url" name="social_media_4" placeholder="Social Media Link 4" required>
                </div>
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="job_opening">Job Opening Link</label>
                    <input type="url" name="job_opening" placeholder="Job Opening Link" required>
                </div>
            </div>

            @for ($i = 1; $i <= 5; $i++)
                <div class="field_group">
                <div class="field">
                    <label for="linkedin_profile_{{ $i * 2 - 1 }}">LinkedIn Profile Link {{ $i * 2 - 1 }}</label>
                    <input type="url" name="linkedin_profile_{{ $i * 2 - 1 }}" placeholder="LinkedIn Profile Link {{ $i * 2 - 1 }}" required>
                </div>
                <div class="field">
                    <label for="linkedin_profile_{{ $i * 2 }}">LinkedIn Profile Link {{ $i * 2 }}</label>
                    <input type="url" name="linkedin_profile_{{ $i * 2 }}" placeholder="LinkedIn Profile Link {{ $i * 2 }}" required>
                </div>
                </div>
                @endfor
        </section>
        <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">add Lead</button>
        </div>
    </form>
</main>
@endsection