@extends('layouts.app')

@section('content')
<section class="content">
    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>
    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">playlist_add_check</i>
                </div>
                <div class="content">
                    <div class="text">NEW TASKS</div>
                    <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"> <a href="mailto:joe@example.com?subject=feedback" "email me">email me</a></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">help</i>
                </div>
                <div class="content">
                    <div class="text">NEW TICKETS</div>
                    <div class="number count-to" data-from="0" data-to="300" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">forum</i>
                </div>
                <div class="content">
                    <div class="text">NEW COMMENTS</div>
                    <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person_add</i>
                </div>
                <div class="content">
                    <div class="text">NEW VISITORS</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- #END# Widgets -->
    <!-- Tabs With Icon Title -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Listagem Das Solicitações
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:void(0);">Action</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Another action</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Something else here</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active sais-tab"><a href="" data-toggle="tab" role="tab" data-target="#aberto"><i class="material-icons">build</i>  ABERTO</a></li>
                        <li class="azed-tab"><a href="" data-toggle="tab" role="tab" data-target="#andamento"><i class="material-icons">hourglass_empty</i>ANDAMENTO</a></li>
                        <li class="azed-tab"><a href="" data-toggle="tab" role="tab" data-target="#aprovado"><i class="material-icons">done_all</i>APROVADO</a></li>
                        <li class="azed-tab"><a href="" data-toggle="tab" role="tab" data-target="#reprovado"><i class="material-icons">highlight_off</i>REPROVADO</a></li>
                        <li class="azed-tab"><a href="" data-toggle="tab" role="tab" data-target="#devolvido"><i class="material-icons">restore_page</i> DEVOLVIDO</a></li>
                        
                        
                    </ul>

                    <div class="tab-content">

                        <!-- LISTAGEM DAS SOLICITAÇÕES EM ABERTO -->
                        <div id="aberto" class="tab-pane fade in active" role="tabpanel">
                            <table id="aberto" class="table table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Codigo</th>
                                        <th>Urgência</th>
                                        <th>Tipo</th>
                                        <th>Origem Despesa</th>
                                        <th>Contrato</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($abertas->solicitacao as $aberto)
                                    <tr>
                                        <td></td>
                                        <td>{{ $aberto->id }}</td>
                                        <td>{{ $aberto->codigo }}</td>
                                        <td>{{ $aberto->urgencia == 1 ? 'SIM' : 'NÃO' }}</td> 
                                        <td>{{ $aberto->tipo }}</td>
                                        <td>{{ $aberto->origem_despesa }}</td>
                                        <td>{{ $aberto->contrato }}</td>
                                        <td>
                                            <div class="icon-button-demo" >
                                                <a href="{{ route('reembolso.editarDespesa', $aberto->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float"><i class="material-icons">settings</i></a>

                                                <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('reembolso.deletarDespesa', $aberto->id)}}"><i class="material-icons">delete_sweep</i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                                     
                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM ABERTO -->

                        <!-- LISTAGEM DAS SOLICITAÇÕES EM ANDAMENTO -->
                        <div id="andamento" class="tab-pane fade in" role="tabpanel">
                            <table id="andamento" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Codigo</th>
                                        <th>Urgência</th>
                                        <th>Tipo</th>
                                        <th>Origem Despesa</th>
                                        <th>Contrato</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($andamentos->solicitacao as $andamento)
                                    <tr>
                                        <td></td>
                                        <td>{{ $andamento->id }}</td>
                                        <td>{{ $andamento->codigo }}</td>
                                        <td>{{ $andamento->urgencia == 1 ? 'SIM' : 'NÃO' }}</td> 
                                        <td>{{ $andamento->tipo }}</td>
                                        <td>{{ $andamento->origem_despesa }}</td>
                                        <td>{{ $andamento->contrato }}</td>
                                        <td>
                                            <div class="icon-button-demo" >
                                                <a href="{{ route('reembolso.editarDespesa', $andamento->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float"><i class="material-icons">settings</i></a>

                                                <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('reembolso.deletarDespesa', $andamento->id)}}"><i class="material-icons">delete_sweep</i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                                     
                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM ANDAMENTO -->

                        <!-- LISTAGEM DAS SOLICITAÇÕES EM APROVADAS -->
                        <div id="aprovada" class="tab-pane fade in" role="tabpanel">
                            <table id="aprovada" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Codigo</th>
                                        <th>Urgência</th>
                                        <th>Tipo</th>
                                        <th>Origem Despesa</th>
                                        <th>Contrato</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aprovadas->solicitacao as $aprovada)
                                    <tr>
                                        <td></td>
                                        <td>{{ $aprovada->id }}</td>
                                        <td>{{ $aprovada->codigo }}</td>
                                        <td>{{ $aprovada->urgencia == 1 ? 'SIM' : 'NÃO' }}</td> 
                                        <td>{{ $aprovada->tipo }}</td>
                                        <td>{{ $aprovada->origem_despesa }}</td>
                                        <td>{{ $aprovada->contrato }}</td>
                                        <td>
                                            <div class="icon-button-demo" >
                                                <a href="{{ route('reembolso.editarDespesa', $aprovada->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float"><i class="material-icons">settings</i></a>

                                                <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('reembolso.deletarDespesa', $aprovada->id)}}"><i class="material-icons">delete_sweep</i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                                     
                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM APROVADAS -->

                        <!-- LISTAGEM DAS SOLICITAÇÕES EM REPROVADO -->
                        <div id="reprovado" class="tab-pane fade in" role="tabpanel">
                            <table id="reprovado" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Codigo</th>
                                        <th>Urgência</th>
                                        <th>Tipo</th>
                                        <th>Origem Despesa</th>
                                        <th>Contrato</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reprovados->solicitacao as $reprovado)
                                    <tr>
                                        <td></td>
                                        <td>{{ $reprovado->id}}</td>
                                        <td>{{ $reprovado->codigo }}</td>
                                        <td>{{ $reprovado->urgencia == 1 ? 'SIM' : 'NÃO' }}</td> 
                                        <td>{{ $reprovado->tipo }}</td>
                                        <td>{{ $reprovado->origem_despesa }}</td>
                                        <td>{{ $reprovado->contrato }}</td>
                                        <td>
                                            <div class="icon-button-demo" >
                                                <a href="{{ route('reembolso.editarDespesa', $reprovado->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float"><i class="material-icons">settings</i></a>

                                                <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('reembolso.deletarDespesa', $reprovado->id)}}"><i class="material-icons">delete_sweep</i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                                     
                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM REPROVADO --> 
                        
                        <!-- LISTAGEM DAS SOLICITAÇÕES EM DEVOLVIDO -->
                        <div id="devolvido" class="tab-pane fade in" role="tabpanel">
                            <table id="devolvido" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>id</th>
                                        <th>Codigo</th>
                                        <th>Urgência</th>
                                        <th>Tipo</th>
                                        <th>Origem Despesa</th>
                                        <th>Contrato</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($devolvidas->solicitacao as $devolvida)
                                    <tr>
                                        <td></td>
                                        <td>{{ $devolvida->id }}</td>
                                        <td>{{ $devolvida->codigo }}</td>
                                        <td>{{ $devolvida->urgencia == 1 ? 'SIM' : 'NÃO' }}</td> 
                                        <td>{{ $devolvida->tipo }}</td>
                                        <td>{{ $devolvida->origem_despesa }}</td>
                                        <td>{{ $devolvida->contrato }}</td>
                                        <td>
                                            <div class="icon-button-demo" >
                                                <a href="{{ route('reembolso.editarDespesa', $devolvida->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float"><i class="material-icons">settings</i></a>

                                                <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('reembolso.deletarDespesa', $devolvida->id)}}"><i class="material-icons">delete_sweep</i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                                     
                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM DEVOLVIDO -->

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- #END# Tabs With Icon Title -->
</section>
@endsection