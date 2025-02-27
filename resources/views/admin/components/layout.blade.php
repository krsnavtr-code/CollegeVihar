<!DOCTYPE html>
<html lang="en" data-scroll="no-scroll">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <link rel="stylesheet" href="/css/utils.php">
    <link rel="stylesheet" href="/css/my-admin.css">
    @stack('css')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                @include('admin.components.sidebar')
            </div>
            <div class="col-lg-9 col-md-8 py-4">
                @yield('main')


            </div>
        </div>
    </div>
    <script src="/js/utils.js"></script>
    @stack('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>