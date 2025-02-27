@php
    $page_title = 'Drives';
@endphp

@push('css')
<style>
.job-update {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 2rem;
    text-align: center;
    max-width: 800px;
    margin: 2rem auto;
    padding: 1rem;
}

.banner {
    width: 100%;
    height: auto;
}

.job-details {
    padding: 1rem;
}

.job-details h2 {
    font-size: 1.5rem;
    margin: 1rem 0;
}

.job-details p {
    text-align: left;
    font-size: 1rem;
    margin: 1rem 0;
}

.apply-button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 4px;
    text-transform: uppercase;
    margin-top: 1rem;
    display: inline-block;
}

.apply-button:hover {
    background-color: #218838;
}

.apply-now-red {
    background-color: red;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 4px;
    text-transform: uppercase;
    margin-top: 1rem;
    display: inline-block;
}

.apply-now-red:hover {
    background-color: darkred;
}
.section-title {
    color: purple;
    font-size: 1.25rem;
    margin-top: 1.5rem;
}

.responsibilities, .skills {
    text-align: left;
    margin: 1rem 0;
    padding-left: 1.5rem;
}

.responsibilities li, .skills li {
    margin: 0.5rem 0;
}

</style>
@endpush

@extends('user.info.layout')
@section('main_section')
    <main>
        <section class="job-update">
            <img width="1120" height="628" src="https://job4freshers.co.in/wp-content/uploads/2023….997.webp?ezimgfmt=rs:948x532/rscb2/ngcb2/notWebP" alt="Unlimit Off Campus Drive" class="banner">
            <div class="job-details">
                <h2>Unlimit Off Campus 2024 | Apply Now!</h2>
                <button class="apply-button">Apply Now</button>
                <p style="font-size: 15px;">Unlimit Off Campus Recruitment has announced a job notification for the post of <strong>Web Developer</strong> for the <strong> India</strong> locations. Both Bachelor's and Master's degree candidates can apply for off-campus placements with Unlimit.</p>
                <button class="apply-now-red">Apply Now</button>

                <h3 class="section-title">Eligibility Criteria for Unlimit Off Campus Drive 2024</h3>
                <h4>Job Responsibilities:</h4>
                <ul class="responsibilities">
                    <li>Developing new user-facing features using React.js</li>
                    <li>Building reusable components and front-end libraries for future use</li>
                    <li>Translating designs and wireframes into high-quality code</li>
                    <li>Optimizing components for maximum performance across a vast array of web-capable devices and browsers</li>
                </ul>
            </div>
        </section>

    </main>
    @endsection