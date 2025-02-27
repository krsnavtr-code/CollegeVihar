
@php
    $page_title = 'Job Opening Verification';
@endphp

@push('css')
    <style>

        .container-otp {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .container-otp h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .container-otp p {
            margin-bottom: 15px;
        }

        .container-otp input[type="number"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .container-otp input[type="submit"] {
            background: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .container-otp input[type="submit"]:hover {
            background: #0056b3;
        }

        .container-otp .time {
            margin: 15px 0;
            font-size: 16px;
            color: #888;
        }

        .container-otp button {
            background: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .container-otp button:hover {
            background: #218838;
        }

        .container-otp #message_error {
            color: red;
            margin-top: 10px;
        }

        .container-otp #message_success {
            color: green;
            margin-top: 10px;
        }
    </style>
@endpush
@extends('user.info.layout')
@section('main_section')

<main>
         <div class="container-otp">
        <h2>OTP Verification</h2>
        <p>Please enter the OTP sent to your email</p>
        <form method="post" id="verificationForm">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" id="id" name="id" value="{{ $id }}">

            <input type="number" name="otp" placeholder="Enter OTP" required>
            <br>
            <input type="submit" value="Verify">
        </form>
        <p class="time"></p>
        <button id="resendOtpVerification">Resend Verification OTP</button>
        <p id="message_error"></p>
        <p id="message_success"></p>
    </div>
</main>
@endsection

@push('script')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#verificationForm').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var id = $('#id').val(); // Get the value of the hidden input field


                $.ajax({
                    url: "{{ route('verifiedOtp') }}",
                    type: "POST",
                    data: formData,
                    success: function(res) {
                        if (res.success) {
                            alert(res.msg);
                            window.open("/employment-details/" + id, "_self"); // Append the id to the URL                        } else {
                            $('#message_error').text(res.msg);
                            setTimeout(() => {
                                $('#message_error').text('');
                            }, 3000);
                        }
                    }
                });
            });

            $('#resendOtpVerification').click(function() {
                $(this).text('Wait...');
                var userMail = @json($email);

                $.ajax({
                    url: "{{ route('resendOtp') }}",
                    type: "GET",
                    data: { email: userMail },
                    success: function(res) {
                        $('#resendOtpVerification').text('Resend Verification OTP');
                        if (res.success) {
                            timer();
                            $('#message_success').text(res.msg);
                            setTimeout(() => {
                                $('#message_success').text('');
                            }, 3000);
                        } else {
                            $('#message_error').text(res.msg);
                            setTimeout(() => {
                                $('#message_error').text('');
                            }, 3000);
                        }
                    }
                });
            });
        });

        function timer() {
            var seconds = 30;
            var minutes = 1;

            var timer = setInterval(() => {
                if (minutes < 0) {
                    $('.time').text('');
                    clearInterval(timer);
                } else {
                    let tempMinutes = minutes.toString().length > 1 ? minutes : '0' + minutes;
                    let tempSeconds = seconds.toString().length > 1 ? seconds : '0' + seconds;

                    $('.time').text(tempMinutes + ':' + tempSeconds);
                }

                if (seconds <= 0) {
                    minutes--;
                    seconds = 59;
                }

                seconds--;
            }, 1000);
        }

        timer();
    </script>
@endpush
