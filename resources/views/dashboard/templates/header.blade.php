
<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
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
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('home/images/'.$web->favicon) }}">
    <!-- Bootstrap css -->
    <link href="{{ asset('dashboard/assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />

    <!-- Style css -->
    <link href="{{ asset('dashboard/assets/css/style.css') }}" rel="stylesheet" />

    <!-- Dark css -->
    <link href="{{ asset('dashboard/assets/css/dark.css') }}" rel="stylesheet" />

    <!-- Skins css -->
    <link href="{{ asset('dashboard/assets/css/skins.css') }}" rel="stylesheet" />

    <!-- Animate css -->
    <link href="{{ asset('dashboard/assets/css/animated.css') }}" rel="stylesheet" />

    <!--Sidemenu css -->
    <!--<link id="theme" href="{{ asset('dashboard/assets/css/closed-sidemenu.css') }}" rel="stylesheet">-->
    <link id="theme" href="{{ asset('dashboard/assets/css/sidemenu4.css') }}" rel="stylesheet">

    <!-- P-scroll bar css-->
    <link href="{{ asset('dashboard/assets/plugins/p-scrollbar/p-scrollbar.css') }}" rel="stylesheet" />

    <!---Icons css-->
    <link href="{{ asset('dashboard/assets/plugins/web-fonts/icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/plugins/web-fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet" />

    <!-- Switcher css -->
    <link href="{{ asset('dashboard/assets/switcher/css/switcher.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/switcher/demo.css') }}" rel="stylesheet">


    <!-- INTERNAL CSS START -->
    <!-- Morris Charts css -->
    <link href="{{ asset('dashboard/assets/plugins/morris/morris.css') }}" rel="stylesheet" />

    <!--Sumoselect css-->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/sumoselect/sumoselect.css')}}">
    <!-- Data table css -->
    <link href="{{ asset('dashboard/assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

    <link href="{{ asset('dashboard/bootstrap-pincode-input.css')}}" rel="stylesheet">
    <!--Daterangepicker css-->
    <link href="{{ asset('dashboard/assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <!-- File Uploads css-->
    <link href="{{ asset('dashboard/assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
    <!-- INTERNAL CSS END -->

	<link href="{{ asset('dashboard/assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
    @include('templates.noti_css')
    <style>
        .break-text {
            word-wrap: break-word;
        }
    </style>
</head>

<body class="app sidebar-mini light-mode light-sidebar">
<!---Global-loader-->
<div id="global-loader" >
    <img src="{{asset('dashboard/loader2.gif')}}" alt="loader">
</div>

<div class="page">
    <div class="page-main">
        <!--aside open-->
        <div class="app-sidebar app-sidebar2">
            <div class="app-sidebar__logo">
                <a class="header-brand" href="{{url('account/dashboard')}}">
                    <img src="{{ asset('home/images/'.$web->logo) }}" class="header-brand-img desktop-lgo" alt="Dashtic logo">
                    <img src="{{ asset('home/images/'.$web->logo) }}" class="header-brand-img dark-logo" alt="Dashtic logo">
                    <img src="{{ asset('home/images/'.$web->favicon) }}" class="header-brand-img mobile-logo" alt="Dashtic logo">
                    <img src="{{ asset('home/images/'.$web->favicon) }}" class="header-brand-img darkmobile-logo" alt="Dashtic logo">
                </a>
            </div>
        </div>
        <aside class="app-sidebar app-sidebar3">
            <div class="app-sidebar__user">
                <div class="dropdown user-pro-body text-center">
                    <div class="user-pic">
                        @if($user->isUploaded==1)
                            <img alt="User Avatar" class="avatar-xl rounded-circle mb-1" src="{{asset('user/photos/'.$user->photo)}}" style="width:40px;height:40px;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{$user->name}}&rounded=true&background=random" alt="img"
                                 class="avatar-xl rounded-circle mb-1">
                        @endif
                    </div>
                    <div class="user-info">
                        <h5 class=" mb-1 font-weight-bold">{{$user->name}}</h5>
                        <span class="text-muted app-sidebar__user-name text-sm">Id: <b>{{$user->userRef}}</b></span>
                    </div>
                </div>
            </div>
            <ul class="side-menu">
                <li class="slide" data-placement="right" data-toggle="tooltip" title="Overview">
                    <a class="side-menu__item"  href="{{url('account/dashboard')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 20 20">
                            <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2zM3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
                            <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.945 11.945 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0z"/>
                        </svg>
                        <span class="side-menu__label" >Dashboard</span></a>
                </li>
                <br>
                <li class="slide" data-placement="right" data-toggle="tooltip" title="Transactions">
                    <a class="side-menu__item"   href="{{url('account/transactions')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-ui-checks" viewBox="0 0 20 20">
                            <path d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708l-2 2zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708l-2 2zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                        <span class="side-menu__label">Transactions</span></a>
                </li><br>
                <li class="slide" data-placement="right" data-toggle="tooltip" title="Beneficiary">
                    <a class="side-menu__item"  href="{{url('account/beneficiary')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 20 20">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                        </svg>
                        <span class="side-menu__label">Beneficiary</span></a>
                </li><br>

                <li class="slide" data-placement="right" data-toggle="tooltip" title="Trades">
                    <a class="side-menu__item"  href="{{url('account/escrows')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-currency-exchange" viewBox="0 0 20 20">
                            <path d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z"/>
                        </svg>
                        <span class="side-menu__label">Trades</span></a>
                </li><br>
                <li class="slide" data-placement="right" data-toggle="tooltip" title="Loans">
                    <a class="side-menu__item"  href="{{url('account/transfers')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-bank" viewBox="0 0 20 20">
                            <path d="M8 .95 14.61 4h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.379l.5 2A.5.5 0 0 1 15.5 17H.5a.5.5 0 0 1-.485-.621l.5-2A.5.5 0 0 1 1 14V7H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 4h.89L8 .95zM3.776 4h8.447L8 2.05 3.776 4zM2 7v7h1V7H2zm2 0v7h2.5V7H4zm3.5 0v7h1V7h-1zm2 0v7H12V7H9.5zM13 7v7h1V7h-1zm2-1V5H1v1h14zm-.39 9H1.39l-.25 1h13.72l-.25-1z"/>
                        </svg>
                        <span class="side-menu__label">Loans</span>
                    </a>
                </li><br>
                <li class="slide" data-placement="right" data-toggle="tooltip" title="Referrals">
                    <a class="side-menu__item"  href="{{url('account/referrals')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-link" viewBox="0 0 20 20">
                            <path d="M6.354 5.5H4a3 3 0 0 0 0 6h3a3 3 0 0 0 2.83-4H9c-.086 0-.17.01-.25.031A2 2 0 0 1 7 10.5H4a2 2 0 1 1 0-4h1.535c.218-.376.495-.714.82-1z"/>
                            <path d="M9 5.5a3 3 0 0 0-2.83 4h1.098A2 2 0 0 1 9 6.5h3a2 2 0 1 1 0 4h-1.535a4.02 4.02 0 0 1-.82 1H12a3 3 0 1 0 0-6H9z"/>
                        </svg>
                        <span class="side-menu__label">Referrals</span>
                    </a>
                </li><br>
                <li class="slide" data-placement="right" data-toggle="tooltip" title="Activities">
                    <a class="side-menu__item"  href="{{url('account/activities')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-spreadsheet" viewBox="0 0 20 20">
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v4h10V2a1 1 0 0 0-1-1H4zm9 6h-3v2h3V7zm0 3h-3v2h3v-2zm0 3h-3v2h2a1 1 0 0 0 1-1v-1zm-4 2v-2H6v2h3zm-4 0v-2H3v1a1 1 0 0 0 1 1h1zm-2-3h2v-2H3v2zm0-3h2V7H3v2zm3-2v2h3V7H6zm3 3H6v2h3v-2z"/>
                        </svg>
                        <span class="side-menu__label">Activities</span>
                    </a>
                </li><br>
                <li class="slide" data-placement="right" data-toggle="tooltip" title="Settings">
                    <a class="side-menu__item"  href="{{url('account/settings')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-gear-wide" viewBox="0 0 20 20">
                            <path d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434L8.932.727zM8 12.997a4.998 4.998 0 1 1 0-9.995 4.998 4.998 0 0 1 0 9.996z"/>
                        </svg>
                        <span class="side-menu__label">Settings</span></a>
                </li><br>
                <li class="slide" data-placement="right" data-toggle="tooltip" title="Wallets">
                    <a class="side-menu__item"  href="{{url('account/account_wallet')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 20 20">
                            <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                        </svg>
                        <span class="side-menu__label">Wallet</span></a>
                </li><br>
                <li class="slide" data-placement="right" data-toggle="tooltip" title="Support">
                    <a class="side-menu__item"  href="{{url('account/more')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-puzzle-fill" viewBox="0 0 20 20">
                            <path d="M3.112 3.645A1.5 1.5 0 0 1 4.605 2H7a.5.5 0 0 1 .5.5v.382c0 .696-.497 1.182-.872 1.469a.459.459 0 0 0-.115.118.113.113 0 0 0-.012.025L6.5 4.5v.003l.003.01c.004.01.014.028.036.053a.86.86 0 0 0 .27.194C7.09 4.9 7.51 5 8 5c.492 0 .912-.1 1.19-.24a.86.86 0 0 0 .271-.194.213.213 0 0 0 .036-.054l.003-.01v-.008a.112.112 0 0 0-.012-.025.459.459 0 0 0-.115-.118c-.375-.287-.872-.773-.872-1.469V2.5A.5.5 0 0 1 9 2h2.395a1.5 1.5 0 0 1 1.493 1.645L12.645 6.5h.237c.195 0 .42-.147.675-.48.21-.274.528-.52.943-.52.568 0 .947.447 1.154.862C15.877 6.807 16 7.387 16 8s-.123 1.193-.346 1.638c-.207.415-.586.862-1.154.862-.415 0-.733-.246-.943-.52-.255-.333-.48-.48-.675-.48h-.237l.243 2.855A1.5 1.5 0 0 1 11.395 14H9a.5.5 0 0 1-.5-.5v-.382c0-.696.497-1.182.872-1.469a.459.459 0 0 0 .115-.118.113.113 0 0 0 .012-.025L9.5 11.5v-.003l-.003-.01a.214.214 0 0 0-.036-.053.859.859 0 0 0-.27-.194C8.91 11.1 8.49 11 8 11c-.491 0-.912.1-1.19.24a.859.859 0 0 0-.271.194.214.214 0 0 0-.036.054l-.003.01v.002l.001.006a.113.113 0 0 0 .012.025c.016.027.05.068.115.118.375.287.872.773.872 1.469v.382a.5.5 0 0 1-.5.5H4.605a1.5 1.5 0 0 1-1.493-1.645L3.356 9.5h-.238c-.195 0-.42.147-.675.48-.21.274-.528.52-.943.52-.568 0-.947-.447-1.154-.862C.123 9.193 0 8.613 0 8s.123-1.193.346-1.638C.553 5.947.932 5.5 1.5 5.5c.415 0 .733.246.943.52.255.333.48.48.675.48h.238l-.244-2.855z"/>
                        </svg>
                        <span class="side-menu__label">Support</span></a>
                </li><br>
                <li class="slide" data-placement="right" data-toggle="tooltip" title="Logout">
                    <a class="side-menu__item"  href="{{url('account/logout')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-power" viewBox="0 0 20 20">
                            <path d="M7.5 1v7h1V1h-1z"/>
                            <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>
                        </svg>
                        <span class="side-menu__label">Logout</span></a>
                </li>
            </ul>

        </aside>
        <!--aside closed-->

        <div class="app-content main-content">
            <div class="side-app">

                <!--app header-->
                <div class="app-header header top-header">
                    <div class="container-fluid">
                        <div class="d-flex">
                            <a class="header-brand" href="{{url('account/dashboard')}}">
                                <img src="{{asset('home/images/'.$web->logo)}}" class="header-brand-img desktop-lgo" >
                                <img src="{{asset('home/images/'.$web->logo)}}" class="header-brand-img dark-logo" >
                                <img src="{{asset('home/images/'.$web->favicon)}}" class="header-brand-img mobile-logo">
                                <img src="{{asset('home/images/'.$web->favicon)}}" class="header-brand-img darkmobile-logo" >
                            </a>
                            <div class="dropdown side-nav">
                                <div class="app-sidebar__toggle" data-toggle="sidebar">
                                    <a class="open-toggle" href="#">
                                        <svg class="header-icon mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                    </a>
                                    <a class="close-toggle" href="#">
                                        <svg class="header-icon mt-1" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg>
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex order-lg-2 ml-auto">

                                <div class="dropdown   header-fullscreen pl-5" >
                                    <a  class="nav-link icon full-screen-link p-0"  id="fullscreen-button">
                                        <svg class="header-icon" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><path d="M7,14 L5,14 L5,19 L10,19 L10,17 L7,17 L7,14 Z M5,10 L7,10 L7,7 L10,7 L10,5 L5,5 L5,10 Z M17,17 L14,17 L14,19 L19,19 L19,14 L17,14 L17,17 Z M14,5 L14,7 L17,7 L17,10 L19,10 L19,5 L14,5 Z"></path></svg>
                                    </a>
                                </div>
                                <div class="dropdown profile-dropdown">
                                    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
										<span>
                                             @if($user->isUploaded==1)
                                                <img alt="User Avatar" class="avatar avatar-md brround" src="{{asset('user/photos/'.$user->photo)}}" style="width:40px;height:40px;">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{$user->name}}&rounded=true&background=random" alt="img"
                                                     class="avatar avatar-md brround">
                                            @endif
										</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated">
                                        <div class="text-center">
                                            <a href="#" class="dropdown-item text-center user pb-0 font-weight-bold">{{$user->name}}</a>
                                            <span class="text-center user-semi-title">{{$user->userRef}}</span>
                                            <div class="dropdown-divider"></div>
                                        </div>
                                        <a class="dropdown-item d-flex" href="{{url('account/profile')}}">
                                            <svg class="header-icon mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                                                <path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 16c-2.69 0-5.77 1.28-6 2h12c-.2-.71-3.3-2-6-2z" opacity=".3"/><circle cx="12" cy="8" opacity=".3" r="2"/><path d="M12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H6zm6-6c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/>
                                            </svg>
                                            <div class="mt-1">Profile</div>
                                        </a>
                                        <a class="dropdown-item d-flex" href="{{url('account/settings')}}">
                                            <svg class="header-icon mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                                                <path opacity=".3" d="M19.28,8.6 L18.58,7.39 L17.31,7.9 L16.25,8.33 L15.34,7.63 C14.95,7.33 14.54,7.09 14.11,6.92 L13.05,6.49 L12.89,5.36 L12.7,4 L11.3,4 L11.11,5.35 L10.95,6.48 L9.89,6.92 C9.48,7.09 9.07,7.33 8.64,7.65 L7.74,8.33 L6.69,7.91 L5.42,7.39 L4.72,8.6 L5.8,9.44 L6.69,10.14 L6.55,11.27 C6.52,11.57 6.5,11.8 6.5,12 C6.5,12.2 6.52,12.43 6.55,12.73 L6.69,13.86 L5.8,14.56 L4.72,15.4 L5.42,16.61 L6.69,16.1 L7.75,15.67 L8.66,16.37 C9.05,16.67 9.46,16.91 9.89,17.08 L10.95,17.51 L11.11,18.64 L11.3,20 L12.69,20 L12.88,18.65 L13.04,17.52 L14.1,17.09 C14.51,16.92 14.92,16.68 15.35,16.36 L16.25,15.68 L17.29,16.1 L18.56,16.61 L19.26,15.4 L18.18,14.56 L17.29,13.86 L17.43,12.73 C17.47,12.42 17.48,12.21 17.48,12 C17.48,11.79 17.46,11.57 17.43,11.27 L17.29,10.14 L18.18,9.44 L19.28,8.6 Z M12,16 C9.79,16 8,14.21 8,12 C8,9.79 9.79,8 12,8 C14.21,8 16,9.79 16,12 C16,14.21 14.21,16 12,16 Z"></path>
                                                <path d="M19.43,12.98 C19.47,12.66 19.5,12.34 19.5,12 C19.5,11.66 19.47,11.34 19.43,11.02 L21.54,9.37 C21.73,9.22 21.78,8.95 21.66,8.73 L19.66,5.27 C19.57,5.11 19.4,5.02 19.22,5.02 C19.16,5.02 19.1,5.03 19.05,5.05 L16.56,6.05 C16.04,5.65 15.48,5.32 14.87,5.07 L14.49,2.42 C14.46,2.18 14.25,2 14,2 L10,2 C9.75,2 9.54,2.18 9.51,2.42 L9.13,5.07 C8.52,5.32 7.96,5.66 7.44,6.05 L4.95,5.05 C4.89,5.03 4.83,5.02 4.77,5.02 C4.6,5.02 4.43,5.11 4.34,5.27 L2.34,8.73 C2.21,8.95 2.27,9.22 2.46,9.37 L4.57,11.02 C4.53,11.34 4.5,11.67 4.5,12 C4.5,12.33 4.53,12.66 4.57,12.98 L2.46,14.63 C2.27,14.78 2.22,15.05 2.34,15.27 L4.34,18.73 C4.43,18.89 4.6,18.98 4.78,18.98 C4.84,18.98 4.9,18.97 4.95,18.95 L7.44,17.95 C7.96,18.35 8.52,18.68 9.13,18.93 L9.51,21.58 C9.54,21.82 9.75,22 10,22 L14,22 C14.25,22 14.46,21.82 14.49,21.58 L14.87,18.93 C15.48,18.68 16.04,18.34 16.56,17.95 L19.05,18.95 C19.11,18.97 19.17,18.98 19.23,18.98 C19.4,18.98 19.57,18.89 19.66,18.73 L21.66,15.27 C21.78,15.05 21.73,14.78 21.54,14.63 L19.43,12.98 Z M17.45,11.27 C17.49,11.58 17.5,11.79 17.5,12 C17.5,12.21 17.48,12.43 17.45,12.73 L17.31,13.86 L18.2,14.56 L19.28,15.4 L18.58,16.61 L17.31,16.1 L16.27,15.68 L15.37,16.36 C14.94,16.68 14.53,16.92 14.12,17.09 L13.06,17.52 L12.9,18.65 L12.7,20 L11.3,20 L11.11,18.65 L10.95,17.52 L9.89,17.09 C9.46,16.91 9.06,16.68 8.66,16.38 L7.75,15.68 L6.69,16.11 L5.42,16.62 L4.72,15.41 L5.8,14.57 L6.69,13.87 L6.55,12.74 C6.52,12.43 6.5,12.2 6.5,12 C6.5,11.8 6.52,11.57 6.55,11.27 L6.69,10.14 L5.8,9.44 L4.72,8.6 L5.42,7.39 L6.69,7.9 L7.73,8.32 L8.63,7.64 C9.06,7.32 9.47,7.08 9.88,6.91 L10.94,6.48 L11.1,5.35 L11.3,4 L12.69,4 L12.88,5.35 L13.04,6.48 L14.1,6.91 C14.53,7.09 14.93,7.32 15.33,7.62 L16.24,8.32 L17.3,7.89 L18.57,7.38 L19.27,8.59 L18.2,9.44 L17.31,10.14 L17.45,11.27 Z M12,8 C9.79,8 8,9.79 8,12 C8,14.21 9.79,16 12,16 C14.21,16 16,14.21 16,12 C16,9.79 14.21,8 12,8 Z M12,14 C10.9,14 10,13.1 10,12 C10,10.9 10.9,10 12,10 C13.1,10 14,10.9 14,12 C14,13.1 13.1,14 12,14 Z"	></path>
                                            </svg>
                                            <div class="mt-1">Settings</div>
                                        </a>
                                        <a class="dropdown-item d-flex" href="{{url('account/logout')}}">
                                            <svg class="header-icon mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                                                <path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M6 20h12V10H6v10zm2-6h3v-3h2v3h3v2h-3v3h-2v-3H8v-2z" opacity=".3"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM8.9 6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2H8.9V6zM18 20H6V10h12v10zm-7-1h2v-3h3v-2h-3v-3h-2v3H8v2h3z"/>
                                            </svg>
                                            <div class="mt-1">Sign Out</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/app header-->
                <!--Page header-->
                <div class="page-header">
                    <div class="page-leftheader">
                        <h4 class="page-title">{{$pageName}}</h4>
                    </div>
                    <div class="page-rightheader ml-auto d-lg-flex">
                        <div class="ml-5 mb-0 row">
                            <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#buy_sell"
                            style="margin-right:2px;">
                                Buy/Sell
                            </button>
                            <button class="btn btn-dark btn-md" data-toggle="modal" data-target="#send_receive">
                                Send/Receive
                            </button>
                        </div>
                    </div>
                </div>
                <!--End Page header-->
