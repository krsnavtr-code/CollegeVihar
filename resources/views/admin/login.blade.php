<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        .login {
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('/images/user_bg.jpg') no-repeat center center/cover;
            height: 100vh;
            position: relative;
        }

        #admin_form {
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 3rem 2rem;
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <main class="login">
        <form action="/admin/login" method="post" id="admin_form">
            <h1> Admin Login </h1>
            <input class="p-3 rounded-3 border-0" type="text" placeholder="User-Name" name="username" required>
            @csrf
            <div class="position-relative">
                <input id="passcode" class="d-flex w-100 p-3 rounded-3 border-0" type="password" placeholder="Pass-Code" name="passcode" required>
                <button type="button" class="btn btn-light rounded-circle position-absolute top-50 end-0 translate-middle" id="togglePassword">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            @if(Session::has('error'))
            <p class="error">{{Session::get('error')}}</p>
            @endif
            <button type="submit" class="btn btn-primary p-3" id="login-btn">
                <i class="fa-solid fa-user"></i>
                Login
            </button>
        </form>

    </main>
    <script src="/js/utils.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#togglePassword').on('click', function() {
                var passwordField = $('#passcode');
                var passwordFieldType = passwordField.attr('type');

                // Toggle between text and password field type
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
</body>

</html>