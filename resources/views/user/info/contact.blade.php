@php
$page_title = 'Contact Us';
@endphp

@push('css')

@endpush

@extends('user.info.layout')

@section('main')
<main>
    <section class="container">
        <div class="row m-3">
            <div class="col-md-6 p-2">
                <h2 class="display-6">Contact Us</h2>
                <h6 class="font-mono"> Head Office:</h6>
                <h5><span class="blue">College</span><span class="red me-2">VIHAR</span> </h5>
                <address>Plot No. 63, Sector 64 Rd, B Block, Sector 63,<br /> Noida, Uttar Pradesh. Pin- 201301 </address>
                <div class="d-flex align-items-baseline gap-2">
                    <h6> Email Us:</h6>
                    <a href="mailto:info@collegevihar.com"> info@collegevihar.com </a>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <h6> Mobile No:</h6>
                    <a href="tel:9990999561">+91 9266585858</a>
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <form action="" class="card row gap-2 py-3 m-sm-0 m-1 bg-blue">
                    <div class="flex">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" class="form-control validate" value="{{ old('name') }}" placeholder="Enter Your Full Name " required>
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" name="email" class="form-control validate" value="{{ old('email') }}" placeholder="Enter Your email Address" required>
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="phone" class="form-control validate" value="{{ old('phone') }}" placeholder="Enter Your Phone number " required>
                    </div>
                    <div class="flex">
                        <i class="fa-solid fa-pencil-alt"></i>
                        <textarea name="message" class="form-control validate" placeholder="Enter Your Message"></textarea>
                    </div>
                    <div class="flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit <i class="fa fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection