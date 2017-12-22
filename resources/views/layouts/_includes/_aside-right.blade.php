<section>
    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#skins" data-toggle="tab">CADASTROS</a></li>
            <li role="presentation"><a href="#settings" data-toggle="tab">RELATÓRIOS</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                <ul class="demo-choose-skin menuDireito">
                    <a href="{{ route('cliente.getAll') }}"><li><i class="material-icons">list</i><span>Listar Clientes</span></li></a>
                    <a href="{{ route('solicitante.getAll') }}"><li><i class="material-icons">list</i><span>Listar Solicitante</span></li></a>
                    <a href="{{ route('unidade.getAll') }}"><li><i class="material-icons">list</i><span>Listar Unidades</span></li></a>
                    <a href="{{ route('processo.getAll') }}"><li><i class="material-icons">list</i><span>Listar Processos</span></li></a>
                </ul>

            </div>
            <div role="tabpanel" class="tab-pane fade" id="settings">
                <ul class="demo-choose-skin menuDireito">
                    <a href="{{ route('relatorio.buscar') }}"><li><i class="material-icons">list</i><span>Buscar Relatório</span></li></a>
<!--                     <a href="{{ route('relatorio.gerar') }}"><li><i class="material-icons">list</i><span>Listar Solicitante</span></li></a>
 -->                </ul>
                <!-- <ul class="demo-choose-skin menuDireito">
                    <a href="{{ route('cliente.getAll') }}"><li><i class="material-icons">list</i><span>Listar Clientes</span></li></a>
                    <a href="{{ route('unidade.getAll') }}"><li><i class="material-icons">list</i><span>Listar Unidades</span></li></a>
                    <a href="{{ route('processo.getAll') }}"><li><i class="material-icons">list</i><span>Listar Processos</span></li></a>
                </ul> -->
            </div>
        </div>
    </aside>
    <!-- #END# Right Sidebar -->
</section>