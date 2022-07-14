<div class="sidebar-wrapper sidebar-theme">
    <!--  Início do Menu  -->
    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image"></figure>
            <div class="user-info">
                <img src="{{ asset('images/90x90.jpg') }}" alt="avatar">
                <h6 class="">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h6><br>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">

            <li class="menu">
                <a href="{{ env('APP_URL') }}" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-airplay">
                            <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1">
                            </path>
                            <polygon points="12 15 17 21 7 21 12 15"></polygon>
                        </svg>
                        <span>Home</span>
                    </div>
                </a>
            </li>
            @if (Auth::user()->is_root ||
                array_intersect(
                    [
                        'admin/coordenador',
                        'admin/coordenador/nacional',
                        'admin/usuarios',
                        'admin/associado',
                        'admin/instituicao',
                        'admin/titulacao',
                        'admin/sexo',
                        'admin/pagamento',
                        'admin/indicacao',
                        'admin/dashboard',
                        'admin/validar-presenca',
                        'admin/validar-apresentacao-expocom',
                        'admin/lista-trabalho-expocom',
                    ],
                    Auth::user()->roles()) ||
                in_array('admin', Auth::user()->roles()))
                <li class="menu">
                    <a href="#submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-airplay">
                                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1">
                                </path>
                                <polygon points="12 15 17 21 7 21 12 15"></polygon>
                            </svg>
                            <span> Área Administrativa</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="submenu" data-parent="#accordionExample">

                        @if (Auth::user()->is_root || in_array('admin/usuarios', Auth::user()->roles()))
                            <li> <a href="{{ route('usuarios.index') }}"> Usuários </a> </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::user()->is_root ||
                array_intersect(['financeiro/relatorios'], Auth::user()->roles()) ||
                in_array('financeiro', Auth::user()->roles()))
                <li class="menu">
                    <a href="#submenu3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-airplay">
                                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1">
                                </path>
                                <polygon points="12 15 17 21 7 21 12 15"></polygon>
                            </svg>
                            <span> Financeiro</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="submenu3" data-parent="#accordionExample">
                        @if (Auth::user()->is_root || in_array('financeiro/relatorios', Auth::user()->roles()))
                            <li> <a href="{{ route('financeiro.relatorios.index') }}"> Relatórios </a> </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::user()->is_root ||
                array_intersect(['fornecedores/listagem'], Auth::user()->roles()) ||
                in_array('fornecedores', Auth::user()->roles()))
                <li class="menu">
                    <a href="#submenu4" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay">
                                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1">
                                </path>
                                <polygon points="12 15 17 21 7 21 12 15"></polygon>
                            </svg>
                            <span> Fornecedores</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="submenu4" data-parent="#accordionExample">
                        @if (Auth::user()->is_root || in_array('fornecedores/listagem', Auth::user()->roles()))
                            <li> <a href="{{ route('fornecedores.index') }}"> Listagem </a> </li>
                        @endif
                    </ul>
                </li>
            @endif


            <li class="menu">
                <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-file">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                        <span> Área do Úsuario</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="submenu2" data-parent="#accordionExample">
                    <li>
                        <a href="{{ route('perfil') }}"> Editar Dados </a>
                    </li>

                </ul>
            </li>

            <h6 style="color:black; z-index:999;" class="text-center mt-1">Dúvidas sobre o sistema? <br>
                suporte@kirc.com.br</h6><br>

        </ul>
    </nav>
</div>
