@php
    $page_title = 'Post Admission Support';
@endphp

@push('css')
<style>
 
    .title {
        text-align: center;
        color: orange;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .services-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 20px;
    }

    .service-card {
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        width: 300px;
        padding: 20px;
        position: relative;
    }

    .service-card:nth-child(1) {
        background-color: #eef9f4;
    }
    .service-card:nth-child(2) {
        background-color: #f0fdf4;
    }
    .service-card:nth-child(3) {
        background-color: #fef8e4;
    }
    .service-card:nth-child(4) {
        background-color: #fcf0e4;
    }
    .service-card:nth-child(5) {
        background-color: #f0f8fc;
    }
    .service-card:nth-child(6) {
        background-color: #f5f8f2;
    }
    .service-card:nth-child(7) {
        background-color: #f8f0fc;
    }
    .service-card:nth-child(8) {
        background-color: #eef4ff;
    }

    .service-number {
        background-color: #5394f3;
        color: white;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: -15px;
        left: -15px;
        font-size: 18px;
        font-weight: bold;
    }

    .service-title {
        color: #333;
        margin: 10px 0;
    }

    .service-description {
        color: #666;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .service-extra {
        color: #5394f3;
        font-weight: bold;
    }

    .service-button {
        background-color: #5394f3;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
        display: inline-block;
    }

    .service-button:hover {
        background-color: #5394f3;
    }

    .contact-section {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin: 40px 20px;
        padding: 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .contact-info {
        flex: 1;
        padding-right: 20px;
    }

    .contact-info h2 {
        color: #333;
        font-size: 24px;
    }

    .contact-info p {
        color: #666;
        margin: 10px 0;
    }

    .contact-info .btn-call {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        display: inline-block;
        margin-top: 10px;
        text-decoration: none;
    }

    .contact-info .btn-call:hover {
        background-color: #0056b3;
    }

    .contact-info .visit-us {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .contact-info .visit-us a {
        color: #007bff;
        text-decoration: none;
    }

    .contact-info .visit-us a:hover {
        text-decoration: underline;
    }

    .contact-info .address {
        margin-top: 20px;
        display: flex;
        align-items: center;
    }

    .contact-info .address img {
        margin-right: 10px;
    }

    .contact-image {
        flex: 1;
    }

    .contact-image img {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .contact-section {
            display: block;
        }
        .contact-info .address {
            display: block;
        }
</style>
@endpush

@extends('user.info.layout')
@section('main_section')
<main>
    <h1 class="title">Post Admission Services</h1>
    <div class="services-container">
        <div class="service-card">
            <div class="service-number">1</div>
            <h2 class="service-title">College Vihar Placement Support</h2>
            <p class="service-description">Advance Webinars, Networking Sessions With Decision Makers, Live projects & sessions, Placement assistance.</p>
            <button class="service-button">Know More</button>
        </div>
        <div class="service-card">
            <div class="service-number">2</div>
            <h2 class="service-title">Exclusive CV Alumni Community</h2>
            <p class="service-description">A platform designed exclusively for you to connect with 1 Lakh+ students and enjoy features like Placement Support, Mentorship, Events by Industry Scholars and so much more...</p>
            <a href="/community" class="service-button">Join Community</a>
        </div>
        <div class="service-card">
            <div class="service-number">3</div>
            <h2 class="service-title">College Vihar Telegram Community</h2>
            <p class="service-description">An inter-college community of College Vihar students across India. Connect with students and share educational resources, notes and much more. See You Inside.</p>
            <p class="service-extra">*Share Knowledge<br>*Grow Together</p>
        </div>
        <div class="service-card">
            <div class="service-number">4</div>
            <h2 class="service-title">Sample Papers & Notes</h2>
            <p class="service-description">We offer you solved question papers of the last 5 years & notes for your self-study in addition to the e-content provided by the university.</p>
        </div>
        <div class="service-card">
            <div class="service-number">5</div>
            <h2 class="service-title">Student Support Team</h2>
            <p class="service-description">Student Support is available 7 days a week. Learners have a...</p>
        </div>
        <div class="service-card">
            <div class="service-number">6</div>
            <h2 class="service-title">Convocation / Degree Award Process</h2>
            <p class="service-description">Once you clear all your exams and assignments, our team would assist in the timely...</p>
        </div>
        <div class="service-card">
            <div class="service-number">7</div>
            <h2 class="service-title">Life Long Friend For Career</h2>
            <p class="service-description">Life Long Friend For Career Advise & Guidance + Telling you What your other batchmates doing with this...</p>
        </div>
        <div class="service-card">
            <div class="service-number">8</div>
            <h2 class="service-title">CV BaseCamp</h2>
            <p class="service-description">Fun-Packed, informative, and career building workshops sessions by industry professionals and...</p>
        </div>
    </div>

    <div class="contact-section">
        <div class="contact-info">
            <h2>Call doesn't feel enough <a href="#" style="color: #007bff;">Visit Us</a></h2>
            <p>At Collegevihar, it is our constant endeavour to provide great customer experience. In case you require assistance, we have created multiple ways to reach out to us.</p>
            <a href="tel:+1234567890" class="btn-call">Call Now</a>
            <div class="visit-us">
                <a href="https://www.google.com/maps" target="_blank">Visit Us: Monday-Friday(9 AM to 5 PM) </a>
            </div>
            <div class="address">
                <img src="{{ asset('path/to/icon.png') }}" alt="Direction Icon">
                <p>Lohia Kia Sales Noida
                    H-215, Sector 63 Rd, H Block, Sector 63, Noida, Uttar Pradesh 201301</p>
            </div>
        </div>
        <div class="contact-image">
            <img src="{{ asset('path/to/vihar3.png') }}" alt="Office Image">
        </div>
    </div>
</main>
@endsection
