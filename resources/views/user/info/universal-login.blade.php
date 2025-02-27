@extends('user.info.layout')
@php
$page_title = '';
@endphp

@push('css')
<style>
    .breadcrumb{
        display: none;
    }
    .login-container {
        background-color: #fff;
        padding: 3rem;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 470px;
        margin: 25px auto;
    }

    .login-container h1 {
        color: #007bff;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .login-container label {
        font-weight: bold;
        display: block;
        margin-bottom: 0.5rem;
    }

    .login-container input[type="email"],
    .login-container input[type="text"] {
        width: 100%;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .login-container .separator {
        text-align: center;
        margin: 1rem 0;
        position: relative;
    }

    .login-container .separator::before,
    .login-container .separator::after {
        content: '';
        display: block;
        width: 40%;
        height: 1px;
        background-color: #ccc;
        position: absolute;
        top: 50%;
    }

    .login-container .separator::before {
        left: 0;
    }

    .login-container .separator::after {
        right: 0;
    }

    .login-container .separator span {
        background-color: #fff;
        padding: 0 1rem;
        position: relative;
        z-index: 1;
    }

    .login-container .agreement {
        font-size: 1.4rem;
        color: #666;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .login-container button {
        width: 40%;
        padding: 0.75rem;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 1.0rem;
        cursor: pointer;
    }

    .login-container button:hover {
        background-color: #0056b3;
    }
+6
    /* Styles for the choice buttons */
    .choice-buttons {
        display: flex;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .choice-buttons button {
        width: auto;
        margin: 0 1rem;
    }

    /* Hide forms initially */
    .login-form {
        display: none;
    }
</style>
@endpush


@section('main_section')
<main>
    <div class="login-container">
        <h1>Login</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Choice Buttons -->
        <div class="choice-buttons">
            <button id="emailLoginBtn">Login with Email</button>
            <button id="phoneLoginBtn">Login with Phone</button>
        </div>

        <!-- Email Login Form -->
        <form id="emailLoginForm" class="login-form" action="{{ url('/send-otp-email') }}" method="POST">
            @csrf
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <button type="submit">Send OTP</button>
        </form>

        <!-- Phone Login Form -->
        <form id="phoneLoginForm" class="login-form" action="{{ url('/send-otp-sms') }}" method="POST">
            @csrf
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" placeholder="Phone" value="{{ old('phone') }}"  maxlength="10"  pattern="\d{10}" required>
            <button type="submit">Send OTP</button>
        </form>

        <!-- OTP Verification Form -->
        @if (session('otp_sent'))
            <form action="{{ session('otp_method') == 'email' ? url('/verify-otp-email') : url('/verify-otp-sms') }}" method="POST">
                @csrf
                @if (session('otp_method') == 'email')
                    <input type="hidden" name="email" value="{{ session('temp_email') }}">
                @elseif (session('otp_method') == 'sms')
                    <input type="hidden" name="phone" value="{{ session('temp_phone') }}">
                @endif

                <label for="otp">OTP</label>
                <input type="text" id="otp" name="otp" placeholder="Enter OTP" maxlength="6" pattern="\d{6}"  required>
                <button style="width: -webkit-fill-available;" type="submit">Verify OTP</button>
            </form>

            <!-- Return to Login Button -->
            <form action="{{ url('/return-to-login') }}" method="POST" style="margin-top: 1rem;">
                @csrf
                <button style="width: -webkit-fill-available;" type="submit">Return to Login</button>
            </form>

            @if (session('test_otp'))
                <div class="alert alert-info">
                    <strong>Test OTP:</strong> {{ session('test_otp') }}
                </div>
            @endif
        @endif


</div>
</main>

@push('script')
<script>
        document.getElementById('emailLoginBtn').addEventListener('click', function() {
            document.getElementById('emailLoginForm').style.display = 'block';
            document.getElementById('phoneLoginForm').style.display = 'none';
            document.querySelector('.choice-buttons').style.display = 'none';
        });

        document.getElementById('phoneLoginBtn').addEventListener('click', function() {
            document.getElementById('phoneLoginForm').style.display = 'block';
            document.getElementById('emailLoginForm').style.display = 'none';
            document.querySelector('.choice-buttons').style.display = 'none';
        });

        // Show the appropriate form if there are validation errors
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->has('email') || old('email'))
                document.getElementById('emailLoginForm').style.display = 'block';
                document.querySelector('.choice-buttons').style.display = 'none';
            @elseif ($errors->has('phone') || old('phone'))
                document.getElementById('phoneLoginForm').style.display = 'block';
                document.querySelector('.choice-buttons').style.display = 'none';
            @endif

            // If OTP sent, hide choice buttons and login forms
            @if (session('otp_sent'))
                document.querySelector('.choice-buttons').style.display = 'none';
                document.getElementById('emailLoginForm').style.display = 'none';
                document.getElementById('phoneLoginForm').style.display = 'none';
            @else
                // Ensure that the choice buttons are visible if OTP is not sent
                document.querySelector('.choice-buttons').style.display = 'flex';
            @endif
        });
</script>
@endpush
@endsection
