<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <!-- <img src="{{url('images/user.png')}}" width="48" height="48" alt="User" /> -->
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{auth()->user()->nome}}
                </div>
                <div class="email">
                    {{auth()->user()->email}}
                </div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ route('user.editarPerfil') }}"><i class="material-icons">edit</i>Editar. Perfil</a></li>
                        @role(['ADMINISTRATIVO','FINANCEIRO','GOD','COORDENADOR'])
                        <li><a href="{{ route('user.getAll') }}"><i class="material-icons">list</i>Listar. Colaboradores</a></li>
                        <li><a href="{{ route('solicitacao.getSolicitacaoView') }}"><i class="material-icons">search</i>Buscar. Solicitação</a></li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="{{ route('registerAdvogado') }}"><i class="material-icons">sd_storage</i>Cadastrar Advogado</a></li>
                        <li><a href="{{ route('registerCoordenador') }}"><i class="material-icons">sd_storage</i>Cadastrar Coordenador</a></li>
                        <li><a href="{{ route('registerFinanceiro') }}"><i class="material-icons">sd_storage</i>Cadastrar Financeiro</a></li>
                        <li role="seperator" class="divider"></li>
                        @endrole
                        <!-- <li role="seperator" class="divider"></li> -->
                        <!-- <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li> -->
                        <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="material-icons">input</i>Sair</a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
        <!-- #User Info -->

        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">Menu Principal</li>
                <li class="active">
                    @role(['COORDENADOR','FINANCEIRO','ADMINISTRATIVO'])
                    <a href="{{url('/')}}">
                        <i class="material-icons" style="color: #607d8b">dashboard</i>
                        <span>Dashboard Advogado</span>
                        <span class="badge" style="color: #fff">{{getChamados()}}</span>
                    </a>
                    @endrole
                    <a href="{{url('/advogado-dashboard')}}">
                        <i class="material-icons" style="color: #017bb6">dashboard</i>
                        <span>Meu Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('reembolso.cadastrar')}}">
                        <i class="material-icons" style="color: #66a216">account_balance_wallet</i>
                        <span>Solicitar Reembolso</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('compra.cadastrar')}}">
                        <i class="material-icons" style="color: #009688">add_shopping_cart</i>
                        <span>Solicitar Compra</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('viagem.cadastrar')}}">
                        <i class="material-icons" style="color: #ffc107">flight_takeoff</i>
                        <span>Solicitar Viagem</span>
                    </a>
                </li>  

                <li>
                    <a href="{{route('antecipacao.cadastrar')}}">
                        <i class="material-icons" style="color: #03a9f4">chat_bubble_outline</i>
                        <span>Solicitar Antecipação</span>
                    </a>
                </li>  

                <li>
                    <a href="{{route('guia.cadastrar')}}">
                        <i class="material-icons" style="color: #795548">content_paste</i>
                        <span>Solicitar Guia</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- #Menu -->

        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2017 {{ HTML::link('http://agenciavilaca.com.br', 'Protótipo | Agência Vilaca') }}
            </div>
            <div class="version">
                <b>Version: </b> 1.0
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>
