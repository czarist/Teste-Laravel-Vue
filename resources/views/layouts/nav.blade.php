<nav class="navbar navbar-expand-lg bg-secondary">
    <a class="navbar-brand" style="color: white;">
        <img src="{{ asset('#') }}" alt="">
    </a>
    <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            @if(Auth::user()->root || in_array('custos', Auth::user()->roles()))
            <li class="nav-item dropdown {{ Request::is('custos') || Request::is('custos*') ? 'ativo' : '' }}">
                <a class="nav-link dropdown-toggle" role="button" id="navbarDropdownMenuLink" style="cursor: pointer;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mr-1 float-left d-none d-xl-block fas fa-hands-helping"></i> Custos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @if(Auth::user()->root || in_array('custos', Auth::user()->roles()) )
                        <a class="dropdown-item  {{ Request::is('custos') ? 'active' : '' }}" href="{{ route('custos.index') }}"><i class="mr-1 float-left d-none d-xl-block fas fa-hands-helping"></i> Custos </a>
                    @endif

                    @if(Auth::user()->root || in_array('custos/aprovados', Auth::user()->roles()) )
                        <a class="dropdown-item  {{ Request::is('custos/aprovados') ? 'active' : '' }}" href="{{ route('custos.aprovados') }}"><i class="mr-1 float-left d-none d-xl-block fas fa-check"></i> Aprovados </a>
                    @endif

                    @if(Auth::user()->root || in_array('custos/apagar', Auth::user()->roles()) )
                        <a class="dropdown-item  {{ Request::is('custos/apagar') ? 'active' : '' }}" href="{{ route('custos.Apagar') }}"><i class="mr-1 float-left d-none d-xl-block fas fa-file-invoice-dollar"></i> A Pagar </a>
                    @endif

                    @if(Auth::user()->root || in_array('custos/finalizados', Auth::user()->roles()) )
                        <a class="dropdown-item  {{ Request::is('custos/finalizados') ? 'active' : '' }}" href="{{ route('custos.finalizados') }}"><i class="mr-1 float-left d-none d-xl-block fas fa-flag-checkered "></i> Finalizados </a>
                    @endif

                    @if(Auth::user()->root || in_array('custos/relatorios/relatorios', Auth::user()->roles()) )
                        <a class="dropdown-item  {{ Request::is('custos/relatorios/relatorios') ? 'active' : '' }}" href="{{ route('custos.relatorios.relatorios') }}"><i class="mr-1 float-left d-none d-xl-block fas fa-file-excel"></i> Relatórios </a>
                    @endif
                </div>
            </li>
            @endif
            @if(Auth::user()->root || array_intersect([
            'admin/usuarios',
            'admin/associados',
            'admin/instituicao',
            'admin/titulacao',
            'admin/sexo',
            ], Auth::user()->roles()) || in_array('admin', Auth::user()->roles()))
            <li class="nav-item dropdown {{ Request::is('admin*') || Request::is('admin*') ? 'ativo' : '' }}">
                <a class="nav-link dropdown-toggle" role="button" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;">
                    <i class="mr-1 float-left d-none d-xl-block fas fa-cogs"></i> Area Administrativa
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

                    @if(Auth::user()->root || in_array('admin/usuarios', Auth::user()->roles()))
                    <a class="dropdown-item {{ Request::is('admin/usuarios*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                        <i class="mr-1 float-left d-none d-xl-block fas fa-hands-helping" style="width:20px;"></i> Usuários
                    </a>
                    @endif
                </div>
            </li>
            @endif
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mr-1 float-left d-none d-xl-block fas fa-user"></i> {{ Auth::user()->nome }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item " href="{{ route('senha') }}"><i class="mr-1 float-left d-none d-xl-block fas fa-key"></i> Senha</a>
                    <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item" href="{{ route('logout') }}"><i class="mr-1 float-left d-none d-xl-block fas fa-sign-out-alt"></i> Sair</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>
