<!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm ">
            <ul class="navbar-nav theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="{{ env('APP_URL')}}">
                        <img src="{{ asset('images/logo.png') }}" class="navbar-logo" alt="logo">
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ env('APP_URL')}}">
                        <img src="{{ asset('images/logo-nome.png') }}" height="46px"  style="margin-top: 10px;margin-left: -15px;" id="logodesk">
                    </a>                    
                </li>
                <li class="nav-item toggle-sidebar">
                    <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"></a>
                </li>
            </ul>

        </header>
    </div>
    <!--  END NAVBAR  -->
    