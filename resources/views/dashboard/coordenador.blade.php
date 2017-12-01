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
                </div>
                <div class="body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active sais-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#aberto">
                                <i style="color: #bb7408" class="material-icons">build</i> ABERTO <span class="badge">{{count($abertas->solicitacao)}}</span>
                            </a>
                        </li>
                        <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#aprovado">
                                <i style="color: #3ecc1b" class="material-icons">done_all</i> APROVADO <span class="badge">{{count($aprovadas->solicitacao)}}</span>
                            </a>
                        </li>
                        <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#reprovado">
                                <i style="color: #ff0000" class="material-icons">highlight_off</i> REPROVADO <span class="badge">{{count($reprovados->solicitacao)}}</span>
                            </a>
                        </li>
                        <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#devolvido">
                                <i style="color: #deb422" class="material-icons">restore_page</i> DEVOLVIDO <span class="badge">{{count($devolvidas->solicitacao)}}</span>
                            </a>
                        </li>
                        <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#recorrente">
                                <i style="color: #30b1b1" class="material-icons">hourglass_empty</i> RECORRENTE <span class="badge">{{count($recorrentes->solicitacao)}}</span>
                            </a>
                        </li>
                        <li class="sais-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#meus">
                                <i style="color: #00c6f3" class="material-icons">person_pin</i> MINHAS <span class="badge">{{count($meus->solicitacao)}}</span>
                            </a>
                        </li>
                        <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#finalizado">
                                <i style="color: #0db174" class="material-icons">thumb_up</i> <span class="hidden-xs"> FINALIZADO </span> <span class="badge">{{count($finalizadas->solicitacao)}}</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- LISTAGEM DAS SOLICITAÇÕES EM ABERTO -->
                        <div id="aberto" class="tab-pane fade in active" role="tabpanel">
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
                                        <td>{{ date('d-m-y',strtotime($aberto->created_at)) }}</td>
                                        <!-- <td>{{ $aberto->urgencia == 1 ? 'SIM' : 'NÃO' }}</td> -->
                                        <td>{{ $aberto->cliente == null ? 'MOSELLO LIMA' : $aberto->cliente->nome }}</td>
                                        <td>{{ $aberto->tipo }}</td>
                                        <td>{{ $aberto->solicitante->nome }}</td>
                                        <td>R$ {{ $aberto->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($aberto->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $aberto->tipo).'.analisar', $aberto->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="VISUALIZAR {{$aberto->tipo}}">
                                                    <i class="material-icons">search</i>
                                                </a>
                                                <a href="{{ route('solicitacao.aprovar',$aberto->id) }}" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="APROVAR {{$aberto->tipo}}">
                                                    <i class="material-icons">done_all</i>
                                                    <!-- <span class="hidden-xs">ADD</span> -->
                                                </a>
                                                <a href="{{ route('solicitacao.reprovar',$aberto->id) }}" class="btn bg-red btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="REPROVAR {{$aberto->tipo}}">
                                                    <i class="material-icons">cancel</i>
                                                </a>
                                                <a href="{{ route('solicitacao.devolver',$aberto->id) }}" class="btn bg-amber btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="DEVOLVER {{$aberto->tipo}}">
                                                    <i class="material-icons">report_problem</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                                     
                                    
                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM ABERTO -->
                        
                        <!-- LISTAGEM DAS SOLICITAÇÕES EM APROVADAS -->
                        <div id="aprovado" class="tab-pane fade in" role="tabpanel">
                            <table id="aprovado" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example">
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
                                        <td>{{ date('d-m-y',strtotime($aprovado->created_at)) }}</td>
                                        <td>{{ $aprovado->cliente == null ? 'MOSELLO LIMA' : $aprovado->cliente->nome }}</td>
                                        <td>{{ $aprovado->tipo }}</td>
                                        <td>{{ $aprovado->solicitante->nome }}</td>
                                        <td>R$ {{ $aprovado->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <a href="{{ route(strtolower($aprovado->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $aprovado->tipo).'.analisar', $aprovado->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">search</i>
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
                                        <td>{{ date('d-m-y',strtotime($reprovado->created_at)) }}</td>
                                        <td>{{ $reprovado->cliente == null ? 'MOSELLO LIMA' : $reprovado->cliente->nome }}</td>
                                        <td>{{ $reprovado->tipo }}</td>
                                        <td>{{ $reprovado->solicitante->nome }}</td>
                                        <td>R$ {{ $reprovado->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <a href="{{ route(strtolower($reprovado->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $reprovado->tipo).'.analisar', $reprovado->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">search</i>
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
                                        <td>{{ date('d-m-y',strtotime($devolvida->created_at)) }}</td>
                                        <td>{{ $devolvida->cliente == null ? 'MOSELLO LIMA' : $devolvida->cliente->nome }}</td>
                                        <td>{{ $devolvida->tipo }}</td>
                                        <td>{{ $devolvida->solicitante->nome }}</td>
                                        <td>R$ {{ $devolvida->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($devolvida->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $devolvida->tipo).'.analisar', $devolvida->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">search</i>
                                                </a>
                                                <a href="{{ route('solicitacao.aprovar',$devolvida->id) }}" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">done_all</i>
                                                    <!-- <span class="hidden-xs">ADD</span> -->
                                                </a>
                                                <a href="{{ route('solicitacao.reprovar',$devolvida->id) }}" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">cancel</i>
                                                </a>
                                                <a href="{{ route('solicitacao.devolver',$devolvida->id) }}" class="btn bg-amber btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">report_problem</i>
                                                </a>                                                
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                                     

                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM DEVOLVIDO -->
                        
                        <!-- LISTAGEM DAS SOLICITAÇÕES EM ANDAMENTO -->
                        <div id="recorrente" class="tab-pane fade in" role="tabpanel">
                            <table id="recorrente" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
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
                                    @foreach ($recorrentes->solicitacao as $recorrente)

                                    <tr>
                                        <td></td>
                                        <td>{{ $recorrente->id }}</td>
                                        <td>{{ date('d-m-y',strtotime($recorrente->created_at)) }}</td>
                                        <td>{{ $recorrente->cliente == null ? 'MOSELLO LIMA' : $recorrente->cliente->nome }}</td>
                                        <td>{{ $recorrente->tipo }}</td>
                                        <td>{{ $recorrente->solicitante->nome }}</td>
                                        <td>R$ {{ $recorrente->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($recorrente->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $recorrente->tipo).'.analisar', $recorrente->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">search</i>
                                                </a>
                                                <a href="{{ route('solicitacao.aprovar',$recorrente->id) }}" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">done_all</i>
                                                    <!-- <span class="hidden-xs">ADD</span> -->
                                                </a>
                                                <a href="{{ route('solicitacao.reprovar',$recorrente->id) }}" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">cancel</i>
                                                </a>
                                                <a href="{{ route('solicitacao.devolver',$recorrente->id) }}" class="btn bg-amber btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">report_problem</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                                                                         
                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM recorrente -->

                        <!-- LISTAGEM DAS SOLICITAÇÕES DO COORDENADOR -->
                        <div id="meus" class="tab-pane fade in" role="tabpanel">
                            <table id="meus" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
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
                                    @foreach ($meus->solicitacao as $meu)

                                    <tr>
                                        <td></td>
                                        <td>{{ $meu->id }}</td>
                                        <td>{{ date('d-m-y',strtotime($meu->created_at)) }}</td>
                                        <td>{{ $meu->cliente == null ? 'MOSELLO LIMA' : $meu->cliente->nome }}</td>
                                        <td>{{ $meu->tipo }}</td>
                                        <td>{{ $meu->solicitante->nome }}</td>
                                        <td>R$ {{ $meu->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($meu->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $meu->tipo).'.editar', $meu->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">settings</i>
                                                </a>
                                                <a style="margin-left: 10px" href="{{ route('solicitacao.aprovar',$meu->id) }}" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">done_all</i>
                                                    <!-- <span class="hidden-xs">ADD</span> -->
                                                </a>
                                                @if($meu->status[0]->descricao =="COORDENADOR-ABERTO")
                                                <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float js-sweetalert" data-id="{{$meu->id}}">
                                                    <i class="material-icons">delete_sweep</i>
                                                </a>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                                                                         
                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM recorrente -->

                        <!-- LISTAGEM DAS SOLICITAÇÕES EM FINALIZADAS -->
                        <div id="finalizado" class="tab-pane fade in" role="tabpanel">
                            <h1 class="visible-xs" style="text-align: center"> FINALIZADAS </h1>
                            <table id="finalizado" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
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
                                    @foreach ($finalizadas->solicitacao as $finalizado)

                                    <tr>
                                        <td></td>
                                        <td>{{ $finalizado->id }}</td>
                                        <td>{{ date('d/m/y',strtotime($finalizado->created_at)) }}</td>
                                        <td>{{ $finalizado->cliente == null ? 'MOSELLO LIMA' : $finalizado->cliente->nome }}</td>
                                        <td>{{ $finalizado->tipo }}</td>
                                        <td>{{ $finalizado->solicitante->nome }}</td>
                                        <td>R$ {{ $finalizado->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($finalizado->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $finalizado->tipo).'.analisar', $finalizado->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">search</i>
                                                </a>                                           
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                                     

                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM REPROVADO -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Tabs With Icon Title -->
</section>
@endsection