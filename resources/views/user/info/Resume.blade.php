@php
    $page_title = 'Professional Resume Help';
@endphp

@push('css')
<style>
    main {
    padding: 20px;
    background-color: #f8f9fa;
}

/* Benefit styles */
.benefit-container {
    background-color: #ffffff;
    padding: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    text-align: center;
}

.benefit-header {
    font-size: 24px;
    color: #000;
    margin-bottom: 40px;
}

.benefit-subtext {
    font-size: 16px;
    color: #999;
    margin-top: 20px;
}

.benefit-metrics {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.metric {
    width: 120px;
    height: 120px;
    line-height: 1.5;
    border: 1px solid #e0e0e0;
    border-radius: 50%;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    font-size: 16px;
    color: #000;
}

.metric span {
    display: block;
    font-size: 11px;
    color: #666;
    margin-top: 5px;
}

/* Feature section styling */
.feature-section {
    background-color: #5394f3;
    padding: 20px;
    color: #ffffff;
    text-align: center;
}

.feature {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    font-size: 17px;
}

.feature svg {
    margin-right: 10px;
}

/* How it works section */
.how-it-works-container {
    padding: 20px;
    text-align: center;
}

.how-it-works-header {
    font-size: 24px;
    color: #ff0000;
    margin-bottom: 20px;
}

.steps-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.step {
    text-align: center;
    padding: 10px;
    max-width: 250px;
}

.step-icon {
    width: 80px;
    height: 80px;
    background-color: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
}

.step-title {
    font-size: 18px;
    color: #000;
    margin-bottom: 10px;
}

.step-description {
    font-size: 14px;
    color: #666;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .benefit-metrics, .steps-container {
        flex-direction: column;
        align-items: center;
    }
    .feature {
        flex-direction: column;
        text-align: center;
    }
}

@media (max-width: 768px) {
    .metric {
        width: 100px;
        height: 100px;
        font-size: 14px;
    }
    .benefit-header, .how-it-works-header {
        font-size: 20px;
    }
    .feature {
        font-size: 15px;
    }
}

@media (max-width: 480px) {
    .metric {
        width:100px;
        height: 100px;
        font-size: 12px;
    }
    .benefit-header, .how-it-works-header {
        font-size: 18px;
    }
    .feature {
        font-size: 14px;
    }
}

</style>
@endpush

@extends('user.info.layout')

@section('main_section')
<main>
    <!-- Benefits Section -->
    <div class="benefit-container">
        <div class="benefit-header">How our customers are getting benefitted?</div>
        <div class="benefit-metrics">
            <div class="metric">
                <div>1L</div>
                <span>Got shortlisted after using this service*</span>
            </div>
            <div class="metric">
                <div>85%</div>
                <span>More recruiters show interest on Naukri created resumes*</span>
            </div>
            <div class="metric">
                <div>95%</div>
                <span>Customers satisfaction rate</span>
            </div>
        </div>
        <div class="benefit-subtext">
            *The figure has been calculated till 1st Jul '24. Next update will be done soon.
        </div>
    </div>

    <!-- Features Section -->
    <div class="feature-section">
        <div class="feature">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" class="me-1 resource_margin" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"></path>
            </svg>
            In-house team of experts with over 10 years of experience
        </div>
        <div class="feature">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" class="me-1 resource_margin" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"></path>
            </svg>
            Visually appealing Resume format
        </div>
        <div class="feature">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" class="me-1 resource_margin" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"></path>
            </svg>
            Over 95% satisfaction rate
        </div>
        <div class="feature">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" class="me-1 resource_margin" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"></path>
            </svg>
            Multiple detailed telephonic consultations with Resume Writer
        </div>
        <div class="feature">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" class="me-1 resource_margin" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"></path>
            </svg>
            First draft in 8 working days
        </div>
        <div class="feature">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" class="me-1 resource_margin" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"></path>
            </svg>
            Free Cover Letter customised to highlight your accomplishments and suit your job search
        </div>
    </div>

    {{--  <!-- Resume Builder Section -->
    <div class="resume-builder-container">
        <div class="resume-builder-header">Create Your Resume with Our Builder</div>
        <div class="resume-builder-description">
            Use our easy-to-use resume builder to create a professional resume in minutes. Choose from various templates and customize your content to stand out to employers.
        </div>
        <a href="/resume-builder" class="btn btn-primary">Start Building Your Resume</a>
    </div> --}}

    <!-- How it works section -->

    <div class="how-it-works-container">
        <div class="how-it-works-header">How it works?</div>
        <div class="steps-container">
            <div class="step">
                <div class="step-icon">
                    <img src="/path/to/icon1.png" alt="Step 1">
                </div>
                <div class="step-title">STEP 1</div>
                <div class="step-description">
                    Resume writer gets assigned and calls you to discuss your expectations & asks for relevant visuals*
                </div>
            </div>
            <div class="step">
                <div class="step-icon">
                    <img src="/path/to/icon2.png" alt="Step 2">
                </div>
                <div class="step-title">STEP 2</div>
                <div class="step-description">
                    You receive a mail asking for relevant visuals to be sent
                </div>
            </div>
            <div class="step">
                <div class="step-icon">
                    <img src="/path/to/icon3.png" alt="Step 3">
                </div>
                <div class="step-title">STEP 3</div>
                <div class="step-description">
                    You receive the first draft, give feedback and resume writer send you the updated resume
                </div>
            </div>
            <div class="step">
                <div class="step-icon">
                    <img src="/path/to/icon4.png" alt="Step 4">
                </div>
                <div class="step-title">STEP 4</div>
                <div class="step-description">
                    You approve resume draft and your resume is sent for activation of other paid services if any
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
