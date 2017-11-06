<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="/mosello-oficial/public/images/user.png" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">John Doe</div>
                <div class="email">user@user.com</div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">Menu Principal</li>
                <li class="active">
                    <a href="/">
                        <i class="material-icons">home</i>
                        <span>DashBoard</span>
                    </a>
                </li>

                <li class="active">
                    <a href="{{route('reembolso.cadastrar')}}">
                        <i class="material-icons">create</i>
                        <span>Solicitar Reembolso</span>
                    </a>
                </li>

                <li class="active">
                    <a href="{{route('compra.cadastrar')}}">
                        <i class="material-icons">create</i>
                        <span>Solicitar Compra</span>
                    </a>
                </li>

                <li class="active">
                    <a href="{{route('viagem.cadastrar')}}">
                        <i class="material-icons">create</i>
                        <span>Solicitar Viagem</span>
                    </a>
                </li>
                

            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2017 {{ HTML::link('http://agenciavilaca.com.br', 'Prototipo | Agencia Vilaca') }}
            </div>
            <div class="version">
                <b>Version: </b> 1.0
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>
