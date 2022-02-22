<nav class="navbar navbar-expand-lg bg-primary">
    <button
        class="navbar-toggler ml-auto custom-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown"
        aria-expanded="false"
        aria-label="Toggle navigation"
    ><span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
       
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            
            @if(Auth::user()->is_root || array_intersect([
            'propostas',
            'contratos'
            ], Auth::user()->roles()) || in_array('propostas', Auth::user()->roles()))
            <li class="nav-item dropdown {{ Request::is('propostas*') || Request::is('propostas*') ? 'active' : '' }}">
                <a class="nav-link dropdown-toggle " role="button" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i  class="fas fa-list mr-1 float-left d-none d-xl-block"></i> Propostas
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="width: 200px;">
                
                    @if(Auth::user()->is_root || in_array('propostas', Auth::user()->roles()))
                        <a  class="dropdown-item m-0 {{ Request::is('propostas*') ? 'active' : '' }}"  href="{{ route('propostas.index') }}">
                            <i class="fas fa-file-pdf mr-1 float-left d-none d-xl-block" style="width:20px;"></i> Elaborar
                        </a>
                    @endif   

                    @if(Auth::user()->is_root || in_array('contratos', Auth::user()->roles()))
                        <a  class="dropdown-item m-0 {{ Request::is('contratos*') ? 'active' : '' }}"  href="{{ route('proposta.contratos') }}">
                            <i class="fas fa-hands-helping mr-1 float-left d-none d-xl-block" style="width:20px;"></i> Contratos
                        </a>
                    @endif   
                </div>
            </li>
            @endif

           

            @if(Auth::user()->is_root || array_intersect([
            'config/usuarios',
            'config/categoria',
            'config/titulacao',
            'config/instituicao',
            'config/sexo'
            ], Auth::user()->roles()) || in_array('config', Auth::user()->roles()))
            <li class="nav-item dropdown {{ Request::is('config*') || Request::is('config*') ? 'ativo' : '' }}">
                <a class="nav-link dropdown-toggle" role="button" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cogs mr-1 float-left d-none d-xl-block"></i> Config.
                </a> 
                    @if(Auth::user()->is_root || in_array('config/instituicao', Auth::user()->roles()))
                        <a class="dropdown-item {{ Request::is('config/instituicao*') ? 'active' : '' }}" href="{{ route('instituicao.index') }}">
                            <i class="fas fa-users mr-1 float-left d-none d-xl-block" style="width:20px;"></i> Instituição
                        </a>
                    @endif
                    @if(Auth::user()->is_root || in_array('config/sexo', Auth::user()->roles()))
                        <a class="dropdown-item {{ Request::is('config/sexo*') ? 'active' : '' }}" href="{{ route('sexo.index') }}">
                            <i class="fas fa-users mr-1 float-left d-none d-xl-block" style="width:20px;"></i> Sexo
                        </a>
                    @endif
                    @if(Auth::user()->is_root || in_array('config/titulacao', Auth::user()->roles()))
                        <a class="dropdown-item {{ Request::is('config/titulacao*') ? 'active' : '' }}" href="{{ route('titulacao.index') }}">
                            <i class="fas fa-users mr-1 float-left d-none d-xl-block" style="width:20px;"></i> Titulação
                        </a>
                    @endif
                    @if(Auth::user()->is_root || in_array('config/categoria', Auth::user()->roles()))
                        <a class="dropdown-item {{ Request::is('config/categoria*') ? 'active' : '' }}" href="{{ route('categoria.index') }}">
                            <i class="fas fa-users mr-1 float-left d-none d-xl-block" style="width:20px;"></i> Categoria
                        </a>
                    @endif
                    @if(Auth::user()->is_root || in_array('config/usuario', Auth::user()->roles()))
                        <a class="dropdown-item {{ Request::is('config/usuario*') ? 'active' : '' }}" href="{{ route('usuario.index') }}">
                            <i class="fas fa-users mr-1 float-left d-none d-xl-block" style="width:20px;"></i> Usuários
                        </a>
                    @endif
                </div>
            </li>
            @endif
        </ul>
       
        
        <ul class="navbar-nav">
            <li class="nav-item dropdown"  style="color: aliceblue">
                <a class="nav-link dropdown-toggle" style="color: aliceblue" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user mr-1 float-left d-none d-xl-block "></i> {{ explode(' ', Auth::user()->nome)[0] }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item " href="">
                        <i class="fas fa-user-circle mr-1 float-left d-none d-xl-block" style="width:20px;"></i> Perfil
                    </a>
                    <a
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="dropdown-item"
                        href="{{ route('logout') }}"
                    ><i class="fas fa-sign-out-alt mr-1 float-left d-none d-xl-block" style="width:20px;"></i> Sair</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
</nav>