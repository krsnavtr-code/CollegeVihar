<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100%;
        }

        .login {
            background: url('/images/user_bg.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        #admin_form {
            background: rgba(255, 255, 255, 0.9);
            padding: 2.5rem 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px;
        }

        #admin_form h1 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #555;
            cursor: pointer;
        }

        .error {
            color: red;
            font-size: 0.875rem;
            margin-top: -10px;
            margin-bottom: 10px;
            text-align: center;
        }

        #login-btn {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <main class="login">
        <form action="/admin/login" method="post" id="admin_form">
            <h1>Admin Login</h1>
            @csrf

            <div class="mb-3">
                <input class="form-control form-control-lg" type="text" name="username" placeholder="Username" required>
            </div>

            <div class="mb-3 position-relative">
                <input id="passcode" class="form-control form-control-lg" type="password" name="passcode" placeholder="Password" required>
                <button type="button" class="toggle-password" id="togglePassword">
                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                </button>
            </div>

            @if(Session::has('error'))
            <p class="error">{{ Session::get('error') }}</p>
            @endif

            <button type="submit" class="btn btn-primary w-100 py-2" id="login-btn">
                <i class="fa-solid fa-right-to-bracket me-2"></i>Login
            </button>
        </form>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#togglePassword').on('click', function () {
            const passField = $('#passcode');
            const icon = $('#eyeIcon');
            const type = passField.attr('type') === 'password' ? 'text' : 'password';
            passField.attr('type', type);
            icon.toggleClass('fa-eye fa-eye-slash');
        });
    </script>
</body>

</html>
