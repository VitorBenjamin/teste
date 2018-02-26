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
                            <a href="" data-toggle="tab" role="tab" data-target="#devolvido">
                                <i style="color: #deb422" class="material-icons">restore_page</i> DEVOLVIDO <span class="badge">{{count($devolvidas->solicitacao)}}</span>
                            </a>
                        </li>
                        <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#recorrente">
                                <i style="color: #30b1b1" class="material-icons">hourglass_empty</i> RECORRENTE <span class="badge">{{count($recorrentes->solicitacao)}}</span>
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
                                        <!-- <th>ID</th> -->
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
                                        <!-- <td>{{ $aberto->id }}</td> -->
                                        <td>{{ date('d/m/Y',strtotime($aberto->created_at)) }}</td>
                                        <!-- <td>{{ $aberto->urgencia == 1 ? 'SIM' : 'NÃO' }}</td> -->
                                        <td>{{ $aberto->cliente == null ? 'MOSELLO LIMA' : $aberto->cliente->nome }}</td>
                                        <td>{{ $aberto->tipo }}</td>
                                        <td>{{ $aberto->solicitante == null ? 'NÃO CONSTA' : $aberto->solicitante->nome }}</td>
                                        <td>{{ 'R$ '.number_format($aberto->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($aberto->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $aberto->tipo).'.analisar', $aberto->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">search</i>
                                                </a>
                                                <!-- <a href="{{ route('solicitacao.finalizar',$aberto->id) }}" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">done_all</i>
                                                </a>
                                                <a href="{{ route('solicitacao.devolver',$aberto->id) }}" class="btn bg-amber btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">report_problem</i>
                                                </a> -->
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                    
                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM ABERTO -->
                        
                        <!-- LISTAGEM DAS SOLICITAÇÕES EM DEVOLVIDO -->
                        <div id="devolvido" class="tab-pane fade in" role="tabpanel">
                            <table id="devolvido" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <!-- <th>ID</th> -->
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
                                        <!-- <td>{{ $devolvida->id }}</td> -->
                                        <td>{{ date('d/m/Y',strtotime($devolvida->created_at)) }}</td>
                                        <td>{{ $devolvida->cliente == null ? 'MOSELLO LIMA' : $devolvida->cliente->nome }}</td>
                                        <td>{{ $devolvida->tipo }}</td>
                                        <td>{{ $devolvida->solicitante == null ? 'NÃO CONSTA' : $devolvida->solicitante->nome }}</td>
                                        <td>{{ 'R$ '.number_format($devolvida->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <a href="{{ route(strtolower($devolvida->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $devolvida->tipo).'.analisar', $devolvida->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">search</i>
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
                                        <!-- <th>ID</th> -->
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
                                        <!-- <td>{{ $recorrente->id }}</td> -->
                                        <td>{{ date('d/m/Y',strtotime($recorrente->created_at)) }}</td>
                                        <td>{{ $recorrente->cliente == null ? 'MOSELLO LIMA' : $recorrente->cliente->nome }}</td>
                                        <td>{{ $recorrente->tipo }}</td>
                                        <td>{{ $recorrente->solicitante == null ? 'NÃO CONSTA' : $recorrente->solicitante->nome }}</td>
                                        <td>{{ 'R$ '.number_format($recorrente->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($recorrente->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $recorrente->tipo).'.analisar', $recorrente->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">search</i>
                                                </a>
                                                <!-- <a href="{{ route('solicitacao.finalizar',$recorrente->id) }}" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">done_all</i>
                                                </a>
                                                <a href="{{ route('solicitacao.devolver',$recorrente->id) }}" class="btn bg-amber btn-circle waves-effect waves-circle waves-float">
                                                    <i class="material-icons">report_problem</i>
                                                </a> -->
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach                                                                                         
                                </tbody>
                            </table>
                        </div>
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM recorrente -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Tabs With Icon Title -->
</section>
@endsection