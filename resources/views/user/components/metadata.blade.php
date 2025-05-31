<!-- browser support meta tags -->
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="canonical" href="{{ url()->current() }}" />
<!-- Developer Attribute -->
<meta author=" Parth Pathak" />
<meta designer="MOHD. Akbar, Ashish Sharma" />
<meta developer="Ashish Sharma, Parth Pathak" />
<!-- search engine support meta tags -->
@foreach (Request::get('metadata') as $meta)
{!! $meta !!}
@endforeach
@stack('meta')
<!-- html page icons -->
<link rel="icon" href="/images/web assets/logo_mini.jpeg" type="image/png" />
<link rel="apple-touch-icon" href="/images/web assets/logo_mini.jpeg" />
<!-- Main Stylesheets -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" />
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
<link rel="stylesheet" href="{{ url('/css/utils.php') }}">
<link rel="stylesheet" href="{{ url('/css/filter.css') }}">


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="{{ url('/js/filter.js') }}"></script>
<!-- <script src="{{ asset('js/main.js') }}"></script> -->
