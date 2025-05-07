<!DOCTYPE html>
<html lang="en" data-scroll="no-scroll">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CV Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <link rel="stylesheet" href="/css/utils.php">
    <link rel="stylesheet" href="/css/my-admin.css">
    @stack('css')


    <style>
        /* Sidebar ko fixed height aur scrollable banane ke liye */
        .sidebar-container {
            padding-bottom: 50px;
            height: 100vh; 
            overflow-y: auto; 
            position: fixed; 
            left: 0;
            max-width: 300px;
        }
        /* Sidebar ke scrollbar ko beautiful banane ke liye */
        .sidebar-container::-webkit-scrollbar {
            width: 7px; 
        }

        .sidebar-container::-webkit-scrollbar-track {
            background: #0C73B8; 
            border-radius: 10px; 
        }

        .sidebar-container::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #EE4130, #EE4130); 
            border-radius: 10px;
        }

        .sidebar-container::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #EE4130, #EE4130); 
        }

        /* Content ko sidebar ke side me adjust karne ke liye */
        .main-content {
            margin-left: 300px;
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row p-4">
            <div class="col-lg-3 col-md-4 sidebar-container">
                @include('admin.components.sidebar')
            </div>
            <div class="col-lg-9 col-md-8 py-4 main-content">
                @yield('main')


            </div>
        </div>
    </div>
    <!-- jQuery first, then Bootstrap Bundle, then utils.js, then page scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/utils.js"></script>
    @stack('script')
</body>

</html>