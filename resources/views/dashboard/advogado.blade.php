@extends('layouts.app')

@section('content')

<script type="text/javascript">
    var urlDeletar = "{{route('solicitacao.deletar')}}";
</script>
<section class="content">
    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>
    {{ csrf_field() }}
    
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="header">
                @if(Session::has('flash_message'))
                
                <div align="center" class="{{ Session::get('flash_message')['class'] }}" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ Session::get('flash_message')['msg'] }}
                    
                </div>                              
                @endif
                
            </div>
        </div>
    </div>
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
                        <li class="active sais-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#aberto">
                                <i style="color: #bb7408" class="material-icons">build</i> <span class="hidden-xs"> ABERTO </span> <span class="badge">{{count($abertas->solicitacao)}}</span>
                            </a>
                        </li>
                        <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#andamento">
                                <i style="color: #30b1b1" class="material-icons">hourglass_empty</i> <span class="hidden-xs"> ANDAMENTO </span> <span class="badge">{{count($andamentos->solicitacao)}}</span>
                            </a>
                        </li>
                        <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#aprovado">
                                <i style="color: #3ecc1b" class="material-icons">done_all</i> <span class="hidden-xs"> APROVADO </span> <span class="badge">{{count($aprovadas->solicitacao)}}</span>
                            </a>
                        </li>
                        <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#reprovado">
                                <i style="color: #ff0000" class="material-icons">highlight_off</i> <span class="hidden-xs"> REPROVADO </span> <span class="badge">{{count($reprovados->solicitacao)}}</span>
                            </a>
                        </li>
                        <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#devolvido">
                                <i style="color: #deb422" class="material-icons">restore_page</i> <span class="hidden-xs"> DEVOLVIDO </span> <span class="badge">{{count($devolvidas->solicitacao)}}</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- LISTAGEM DAS SOLICITAÇÕES EM ABERTO -->

                        <div id="aberto" class="tab-pane fade in active" role="tabpanel">
                             <h1 class="visible-xs" style="text-align: center"> ABERTO </h1>
                            <table id="aberto" class="table table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Solicitante</th>
                                        <th>Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($abertas->solicitacao as $aberto)
                                    
                                    <tr>
                                        <td></td>
                                        <td>{{ $aberto->id }}</td>
                                        <td>{{ date('d/m/y',strtotime($aberto->created_at)) }}</td>
                                        <!-- <td>{{ $aberto->urgencia == 1 ? 'SIM' : 'NÃO' }}</td> -->
                                        <td class="teste">{{ $aberto->cliente == null ? 'MOSELLO LIMA' : $aberto->cliente->nome }}</td>
                                        <td>{{ $aberto->tipo }}</td>
                                        <td>{{ $aberto->solicitante->nome }}</td>
                                        <td>R$ {{ $aberto->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($aberto->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $aberto->tipo).'.editar', $aberto->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">settings</i>
                                                </a>
                                                <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float js-sweetalert" data-id="{{$aberto->id}}">
                                                    <i class="material-icons">delete_sweep</i>
                                                </a>
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
                            <h1 class="visible-xs" style="text-align: center"> ANDAMENTO </h1>
                            <table id="andamento" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Solicitante</th>
                                        <th>Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($andamentos->solicitacao as $andamento)
                                    
                                    <tr>
                                        <td></td>
                                        <td>{{ $andamento->id }}</td>
                                        <td>{{ date('d/m/y',strtotime($andamento->created_at)) }}</td>
                                        <td class="teste">{{ $andamento->cliente == null ? 'MOSELLO LIMA' : $andamento->cliente->nome }}</td>
                                        <td>{{ $andamento->tipo }}</td>
                                        <td>{{ $andamento->solicitante->nome }}</td>
                                        <td>R$ {{ $andamento->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($andamento->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $andamento->tipo).'.analisar', $andamento->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">launch</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                                     
                                    
                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM ANDAMENTO -->
                        
                        <!-- LISTAGEM DAS SOLICITAÇÕES EM APROVADAS -->
                        <div id="aprovado" class="tab-pane fade in" role="tabpanel">
                            <h1 class="visible-xs" style="text-align: center"> APROVADO </h1>
                            <table id="aprovado" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Solicitante</th>
                                        <th>Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aprovadas->solicitacao as $aprovado)
                                    
                                    <tr>
                                        <td></td>
                                        <td>{{ $aprovado->id }}</td>
                                        <td>{{ date('d/m/y',strtotime($aprovado->created_at)) }}</td>
                                        <td>{{ $aprovado->cliente == null ? 'MOSELLO LIMA' : $aprovado->cliente->nome }}</td>
                                        <td>{{ $aprovado->tipo }}</td>
                                        <td>{{ $aprovado->solicitante->nome }}</td>
                                        <td>R$ {{ $aprovado->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <a href="{{ route('reembolso.editarDespesa', $aprovado->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">settings</i>
                                                </a>
                                                <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('reembolso.deletarDespesa', $aprovado->id)}}">
                                                    <i class="material-icons">delete_sweep</i>
                                                </a>
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
                            <h1 class="visible-xs" style="text-align: center"> REPROVADO </h1>
                            <table id="reprovado" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Solicitante</th>
                                        <th>Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reprovados->solicitacao as $reprovado)
                                    
                                    <tr>
                                        <td></td>
                                        <td>{{ $reprovado->id }}</td>
                                        <td>{{ date('d/m/y',strtotime($reprovado->created_at)) }}</td>
                                        <td>{{ $reprovado->cliente == null ? 'MOSELLO LIMA' : $reprovado->cliente->nome }}</td>
                                        <td>{{ $reprovado->tipo }}</td>
                                        <td>{{ $reprovado->solicitante->nome }}</td>
                                        <td>R$ {{ $reprovado->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($reprovado->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $reprovado->tipo).'.analisar', $reprovado->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">launch</i>
                                                </a>                                           
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
                            <h1 class="visible-xs" style="text-align: center"> DEVOLVIDO </h1>
                            <table id="devolvido" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Solicitante</th>
                                        <th>Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($devolvidas->solicitacao as $devolvida)
                                    
                                    <tr>
                                        <td></td>
                                        <td>{{ $devolvida->id }}</td>
                                        <td>{{ date('d/m/y',strtotime($devolvida->created_at)) }}</td>
                                        <td>{{ $devolvida->cliente == null ? 'MOSELLO LIMA' : $devolvida->cliente->nome }}</td>
                                        <td>{{ $devolvida->tipo }}</td>
                                        <td>{{ $devolvida->solicitante->nome }}</td>
                                        <td>R$ {{ $devolvida->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                             <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                             <a href="{{ route(strtolower($devolvida->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $devolvida->tipo).'.editar', $devolvida->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                <i class="material-icons">settings</i>
                                            </a>
                                            <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float js-sweetalert" data-id="{{$devolvida->id}}">
                                                <i class="material-icons">delete_sweep</i>
                                            </a>
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