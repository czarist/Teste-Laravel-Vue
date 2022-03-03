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
    @yield('styles')

    <style>
        .layout-px-spacing {
            min-height: calc(100vh - 140px)!important;
        }

    </style>
    
</head>
<body class="sidebar-noneoverflow">

    <div id="app">      
        <!--  BEGIN MAIN CONTAINER  -->
        <div class="main-container d-flex justify-content-center" id="container" style="max-width: 100% !important;">

            <div class="overlay"></div>
            <div class="search-overlay"></div>

            
            <!--  BEGIN CONTENT PART  -->
            <div id="" class="">
                <div class="layout-px-spacing">
                    <div class="row layout-top-spacing">
                    
                            @yield('content')
                    </div>
                </div>

                <div class="footer-wrapper">
                    <div class="footer-section f-section-1">
                        <p class="">Intercom 2022</p>
                    </div>

                    <div class="footer-section f-section-2">
                        <p class=""> Um sistema de <a href="https://www.mercuriotecnologia.com.br">Mercúrio Tecnologia</a> - Digitalize sua Ideia </p>
                    </div>
                </div>
                    
            </div>
            <!-- END MAIN CONTAINER -->
        </div>

    </div>
           
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/js/common.min.js') }}" ></script>
    @yield('scripts')
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script  type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
    <script  type="text/javascript" src="{{ asset('js/ajax.js') }}"></script>

    {{-- Pagseguro --}}
    <script  type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    {{-- <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script> --}}

</body>
</html>
