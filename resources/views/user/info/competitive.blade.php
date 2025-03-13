@php
    $page_title = 'Competitive Exam';
@endphp

@push('css')
<style>
    
.exam-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
   
}

.exam-item {
    flex: 1 1 calc(33.333% - 20px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    background-color: #fff;
    margin-bottom: 20px;
}

.exam-item img {
    max-width: 100%;
    height: auto;
}

.exam-item h3 {
    margin: 15px 0;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #00A2E8;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 10px;
}

.btn:hover {
    background-color: #00796b;
}

@media (max-width: 991px) { /* Tablets, larger phones landscape */
    .exam-item {
        flex: 1 1 calc(50% - 20px);
    }
}

@media (max-width: 767px) { /* Smaller tablets, large phones */
    .exam-item {
        flex: 1 1 100%;
    }
}

@media (max-width: 479px) { /* Small phones */
    .exam-item {
        flex: 1 1 100%;
    }
}

/* High resolution displays */
@media only screen and (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) { 
    /* Adjust image quality or size for high-res displays if needed */
}
</style>
@endpush

@extends('user.info.layout')
@section('main_section')
<main>
    <div class="container">
        <h1 style="text-align: center;">Excel in Competitive Exams</h1>
        <p style="font-size: 16px;">
           Our platform offers comprehensive online study materials, smart class video tutorials, test papers, and AI assignments to empower aspiring candidates for
           various competitive exams such as SSC, Banking, Railway, Civil Services, and many others. We recognize the significance of bridging the gap between traditional
           education and the dynamic requirements of competitive exams, ensuring that our resources are tailored to meet the evolving needs outlined in the National 
           Education Policy 2020. Prepare with Edubull to excel in your competitive exams and embark on a successful career journey.
        </p>

        <h1 style="text-align: center;">Popular Exams</h1>
        <div class="exam-grid">

            <div class="exam-item">
                <img src="https://www.edubull.com/images/police-thumb.jpg" alt="Police">
                <h3>POLICE</h3>
                <a href="{{ url('/competitive-details','Police') }}" class="btn">Exam Info</a>
                {{-- <a href="https://youtu.be/yDahPvYYxbU?si=D0hIxZlWJ8ZNshTg" class="btn" target="_blank">Latest Videos</a> --}}
            </div>

            <div class="exam-item">
                <img src="https://www.edubull.com/images/railway-thumb.jpg" alt="Railway">
                <h3>RAILWAY</h3>
                <a href="{{ url('/competitive-details','Railway') }}" class="btn">Exam Info</a>
                {{-- <a href="https://youtu.be/yDahPvYYxbU?si=D0hIxZlWJ8ZNshTg" class="btn" target="_blank">Latest Videos</a> --}}
            </div>
            
            <div class="exam-item">
                <img src="https://www.edubull.com/images/civil-services-thumb.jpg" alt="Civil Services">
                <h3>CIVIL SERVICES</h3>
                <a href="{{ url('/competitive-details','Civil') }}" class="btn">Exam Info</a>
                {{-- <a href="https://youtu.be/yDahPvYYxbU?si=D0hIxZlWJ8ZNshTg" class="btn" target="_blank">Latest Videos</a> --}}
            </div>
            <div class="exam-item">
                <img src="https://www.edubull.com/images/banking-icon.jpg" alt="Banking">
                <h3>BANKING</h3>
                <a href="{{ url('/competitive-details','Banking') }}" class="btn">Exam Info</a>
                {{-- <a href="https://youtu.be/yDahPvYYxbU?si=D0hIxZlWJ8ZNshTg" class="btn" target="_blank">Latest Videos</a> --}}
            </div>
            <div class="exam-item">
                <img src="https://www.edubull.com/images/teaching-thumb.jpg" alt="Teaching">
                <h3>TEACHING</h3>
                <a href="{{ url('/competitive-details','Teaching') }}" class="btn">Exam Info</a>
                {{-- <a href="https://youtu.be/yDahPvYYxbU?si=D0hIxZlWJ8ZNshTg" class="btn" target="_blank">Latest Videos</a> --}}
            </div>
            <div class="exam-item">
                <img src="https://www.edubull.com/images/ssc-thumb.jpg" alt="SSC">
                <h3>SSC</h3>
                <a href="{{ url('/competitive-details','SSC') }}" class="btn">Exam Info</a>
                {{-- <a href="https://youtu.be/yDahPvYYxbU?si=D0hIxZlWJ8ZNshTg" class="btn" target="_blank">Latest Videos</a> --}}
            </div>
        </div>
    </div>
</main>
@endsection