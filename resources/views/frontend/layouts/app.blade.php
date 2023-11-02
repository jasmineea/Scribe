<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keyword" content="{{ setting('meta_keyword') }}">

    @include('frontend.includes.meta')

    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
    <link rel="icon" type="image/ico" href="{{asset('img/favicon.png')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('before-styles')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}?v={{env('ASSET_VERSION')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/owl.carousel.min.css')}}?v={{env('ASSET_VERSION')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/owl.theme.default.min.css')}}?v={{env('ASSET_VERSION')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/responsive.css')}}?v={{env('ASSET_VERSION')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/nice-alert.css')}}">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
	<script type="text/javascript" src="{{asset('js/script.js')}}?v={{env('ASSET_VERSION')}}"></script>
    <script type="text/javascript" src="{{asset('js/owl.carousel.min.js')}}?v={{env('ASSET_VERSION')}}"></script>

	<script type="text/javascript" src="{{asset('js/countries.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/nice-alert.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
    <link rel="preload" as="font" href="{{asset('fonts/Lexi-Regular.ttf')}}" type="font/ttf" crossorigin="anonymous">
    <link rel="preload" as="font" href="{{asset('fonts/Rose-Regular.ttf')}}" type="font/ttf" crossorigin="anonymous">
    <link rel="preload" as="font" href="{{asset('fonts/elaineregular.ttf')}}" type="font/ttf" crossorigin="anonymous">
    <link rel="preload" as="font" href="{{asset('fonts/henryregular.ttf')}}" type="font/ttf" crossorigin="anonymous">
    <link rel="preload" as="font" href="{{asset('fonts/morganregular.ttf')}}" type="font/ttf" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js" integrity="sha512-oVbWSv2O4y1UzvExJMHaHcaib4wsBMS5tEP3/YkMP6GmkwRJAa79Jwsv+Y/w7w2Vb/98/Xhvck10LyJweB8Jsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<!-- <link rel="stylesheet" type="text/css" href="{{asset('build/assets/app-frontend-f67f5c8c.css')}}"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/shepherd.js/7.1.2/css/shepherd.css" integrity="sha512-3j1rWrVQKFkf7HvtwfKf1rct2n3jaPFcW2ovsk+vcMt+gxISB0wI0NOBWFnzlGymjK2PLPgyMd/aLmhFxciBGQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/shepherd.js/7.1.2/js/shepherd.min.js" integrity="sha512-Sy962BupVURsOoUAJWvZMJOurIl3F8ijnbO1Mx+t8cytaDCjK5TixnayZm3c8v0KSsn9AlTiy+wIL7zQlp1YKA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="{{asset('js/custom.js')}}?v={{rand(0,1000)}}"></script>
    @stack('after-styles')

    <x-google-analytics />

</head>

<body>

    @include('frontend.includes.header')
    @auth
        @include('frontend.includes.sidebar')
    @endif


    <main>
        @include('frontend.includes.flash-message')
        @yield('content')
    </main>

    {{-- @include('frontend.includes.footer') --}}

</body>

<!-- Scripts -->
<script>
    function per_credit_price(amount=0){
        console.log(amount);
        var per_credit_price={{setting('card_written_pricing_less_then_equal_to_100')}};
        
        if(amount <= 100){
            per_credit_price={{setting('card_written_pricing_less_then_equal_to_100')}};
        } else if (500 >= amount && amount > 100){
            per_credit_price={{setting('card_written_pricing_101_to_500')}};
        } else if (1000 >= amount && amount > 500){
            per_credit_price={{setting('card_written_pricing_501_to_1000')}};
        } else if (2000 >= amount && amount > 1000){
            per_credit_price={{setting('card_written_pricing_1001_to_2000')}};
        } else if (amount > 2000){
            per_credit_price={{setting('card_written_pricing_greater_2000')}};
        }else{   
            per_credit_price={{setting('card_written_pricing_less_then_equal_to_100')}};
        }
        
        console.log(per_credit_price);
        return per_credit_price;
    }
</script>
@stack('before-scripts')


@stack('after-scripts')

</html>