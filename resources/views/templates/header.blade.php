<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$pageName}}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="copyright" content="{{$web->siteName}} is a registered trademark of Meritinfos LLC">
    <meta name="title" content="{{$pageName}}">
    <meta name="description" content="{{$pageName}}">
    <meta name="robots" content="index,follow">
    <meta name="author" content="Meritinfos LLC">
    <meta name="keywords" content="{{$web->siteTag}}"/>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{$web->url}}">
    <meta property="og:title" content="{{$pageName}}">
    <meta property="og:description" content="{{$web->siteDescription}}">
    <meta property="og:image" content="{{ asset('home/images/'.$web->favicon) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{$web->url}}">
    <meta property="twitter:title" content="{{$pageName}}">
    <meta property="twitter:description" content="{{$web->siteDescription}}">
    <meta property="twitter:image" content="{{ asset('home/images/'.$web->favicon) }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('home/images/'.$web->favicon) }}">
    <link rel="stylesheet" href="{{ asset('home/vendor/nice-select/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('home/vendor/owl-carousel/css/owl.theme.default.css') }}">
    <link rel="stylesheet" href="{{ asset('home/vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('home/css/style.css') }}">
</head>

<body>

    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <div id="main-wrapper">

        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="navigation">
                            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                <a class="navbar-brand" href="index"><img src="{{ asset('home/images/'.$web->logo) }}" alt=""></a>
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                    <ul class="navbar-nav">

                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('index')}}">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('price')}}">Price</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('wallet')}}">Wallet</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Company
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{url('about')}}">About us</a>
                                                <a class="dropdown-item" href="{{url('team')}}">Team</a>
                                                <a class="dropdown-item" href="blog">Blog</a>
                                                <a class="dropdown-item" href="{{url('career')}}">Career</a>
                                            </div>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Support
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{url('contact')}}">Contact us</a>
                                                <a class="dropdown-item" href="{{url('help')}}">Help Desk</a>
                                                <a class="dropdown-item" href="{{url('faq')}}">FAQ</a>
                                            </div>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Account
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{url('register')}}">Register</a>
                                                <a class="dropdown-item" href="{{url('login')}}">Login</a>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="dashboard">Dashboard</a>
                                        </li>

                                    </ul>
                                </div>

                                <div class="signin-btn">
                                    <a class="btn btn-primary" href="{{url('login')}}">Sign in</a>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
