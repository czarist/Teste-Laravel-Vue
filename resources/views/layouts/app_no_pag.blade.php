<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico')}}"/>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />


    @yield('styles')

    <style>
        .layout-px-spacing {
            min-height: calc(100vh - 140px)!important;
        }

    </style>
    
</head>
<body class="sidebar-noneoverflow">

    @auth
        @include('layouts.nav_vertical')
    @endauth

    <div id="app">
         @auth
            @include('layouts.nav')
        @endauth
        
        <!--  BEGIN MAIN CONTAINER  -->
        <div class="main-container" id="container">

            <div class="overlay"></div>
            <div class="search-overlay"></div>

            
            <!--  BEGIN CONTENT PART  -->
            <div id="content" class="main-content">
                <div class="layout-px-spacing">
                    <div class="row layout-top-spacing">
                    
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
                            @yield('content')
                        </div>
                    </div>
                </div>

                <div class="footer-wrapper">
                    <div class="footer-section f-section-1">
                        <p class="">Intercom {{ date('Y') }}</p>
                    </div>

                    <div class="footer-section f-section-2">
                        <p class=""> Um sistema de <a href="http://kirc.com.br">KIRC</a> - Digitalize sua Ideia </p>
                    </div>
                </div>
                    
            </div>
            <!-- END MAIN CONTAINER -->
        </div>

    </div>
           
    <script src="{{ url('/js/app.js') }}"></script>
    <script src="{{ asset('/js/common.min.js') }}" ></script>
    @yield('scripts')
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>

</body>
</html>
