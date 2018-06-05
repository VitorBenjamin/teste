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
                                <i style="color: #bb7408" class="material-icons">build</i> <span class="hidden-xs"> ABERTO </span> <span class="badge">{{count($abertas->solicitacao)}}</span>
                            </a>
                        </li>
                        {{-- <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#andamento">
                                <i style="color: #30b1b1" class="material-icons">hourglass_empty</i> <span class="hidden-xs"> ANDAMENTO </span> <span class="badge">{{count($andamentos->solicitacao)}}</span>
                            </a>
                        </li> --}}
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
                        <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#recorrente">
                                <i style="color: #30b1b1" class="material-icons">hourglass_empty</i> <span class="hidden-xs"> RECORRENTE </span> <span class="badge">{{count($recorrentes->solicitacao)}}</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- LISTAGEM DAS SOLICITAÇÕES EM ABERTO -->
                        <div id="aberto" class="tab-pane fade in active" role="tabpanel">
                            <h1 class="visible-xs" style="text-align: center"> ABERTO </h1>
                            <table id="aberto" class="table table-bordered table-striped table-hover dataTable dashboard">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Codigo</th>
                                        <th>Data</th>
                                        <th>Área</th>
                                        <th>Dr(ª)</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Solicitante</th>
                                        <th style="min-width:70px">Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($abertas->solicitacao as $aberto)

                                    <tr>
                                        <td></td>
                                        <td>{{ $aberto->codigo }}</td>
                                        <td>{{ date('d/m/Y',strtotime($aberto->created_at)) }}</td>
                                        <td>{{ $aberto->area_atuacao->tipo}}</td>
                                        <td>{{ $aberto->user->nome}}</td>
                                        <td class="quebra-texto">{{ $aberto->cliente == null ? 'MOSELLO LIMA' : $aberto->cliente->nome }}</td>
                                        <td>{{ $aberto->tipo }}</td>
                                        <td>{{ $aberto->solicitante == null ? 'ADVOGADO' : $aberto->solicitante->nome}}</td>
                                        <td>{{ 'R$ '.number_format($aberto->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($aberto->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $aberto->tipo).'.analisar', $aberto->id)}}" class="btn bg-blue-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="VISUALIZAR {{$aberto->tipo}}">
                                                    <i class="material-icons">search</i>
                                                </a>
                                                <a style="margin:0px 5px" href="{{ route('solicitacao.aprovar',$aberto->id) }}" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="APROVAR {{$aberto->tipo}}">
                                                    <i class="material-icons">done_all</i>
                                                    <!-- <span class="hidden-xs">ADD</span> -->
                                                </a>
                                                <a href="{{ route('solicitacao.reprovar',$aberto->id) }}" class="btn bg-red btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="REPROVAR {{$aberto->tipo}}">
                                                    <i class="material-icons">cancel</i>
                                                </a>
                                                <!-- <span data-toggle="modal" data-target="#modalDevolver">
                                                    <a class="btn bg-amber btn-circle waves-effect waves-circle waves-float" data-placement="top" title="DEVOLVER {{$aberto->tipo}}" data-toggle="tooltip">
                                                        <i class="material-icons">report_problem</i>
                                                    </a>
                                                </span> -->
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
                            <h1 class="visible-xs" style="text-align: center"> APROVADAS </h1>
                            <table id="aprovado" class="table dt-responsive table-bordered table-striped table-hover dataTable dashboard">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Codigo</th>
                                        <th>Data</th>
                                        <th>Área</th>
                                        <th>Dr(ª)</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Solicitante</th>
                                        <th style="min-width:70px">Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aprovadas->solicitacao as $aprovado)
                                    <tr>
                                        <td></td>
                                        <td>{{ $aprovado->codigo }}</td>
                                        <td>{{ date('d/m/Y',strtotime($aprovado->created_at)) }}</td>
                                        <td>{{ $aprovado->area_atuacao->tipo}}</td>
                                        <td class="quebra-texto">{{ $aprovado->user->nome }}</td>
                                        <td class="quebra-texto">{{ $aprovado->cliente == null ? 'MOSELLO LIMA' : $aprovado->cliente->nome }}</td>
                                        <td>{{ $aprovado->tipo }}</td>
                                        <td>{{ $aprovado->solicitante == null ? 'ADVOGADO' : $aprovado->solicitante->nome}}</td>
                                        <td>{{ 'R$ '.number_format($aprovado->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <a href="{{ route(strtolower($aprovado->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $aprovado->tipo).'.analisar', $aprovado->id)}}" class="btn bg-blue-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="VISUALIZAR {{$aprovado->tipo}}">
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
                            <h1 class="visible-xs" style="text-align: center"> REPROVADAS </h1>
                            <table id="reprovado" class="table dt-responsive table-bordered table-striped table-hover dataTable dashboard" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Codigo</th>
                                        <th>Data</th>
                                        <th>Área</th>
                                        <th>Dr(ª)</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Solicitante</th>
                                        <th style="min-width:70px">Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reprovados->solicitacao as $reprovado)
                                    
                                    <tr>
                                        <td></td>
                                        <td>{{ $reprovado->codigo }}</td>
                                        <td>{{ date('d/m/Y',strtotime($reprovado->created_at)) }}</td>
                                        <td>{{ $reprovado->area_atuacao->tipo}}</td>
                                        <td class="quebra-texto">{{ $reprovado->user->nome }}</td>
                                        <td class="quebra-texto">{{ $reprovado->cliente == null ? 'MOSELLO LIMA' : $reprovado->cliente->nome }}</td>
                                        <td>{{ $reprovado->tipo }}</td>
                                        <td>{{ $reprovado->solicitante == null ? 'ADVOGADO' : $reprovado->solicitante->nome}}</td>
                                        <td>{{ 'R$ '.number_format($reprovado->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <a href="{{ route(strtolower($reprovado->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $reprovado->tipo).'.analisar', $reprovado->id)}}" class="btn bg-blue-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="VISUALIZAR {{$reprovado->tipo}}">
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
                            <h1 class="visible-xs" style="text-align: center"> DEVOLVIDAS </h1>
                            <table id="devolvido" class="table dt-responsive table-bordered table-striped table-hover dataTable dashboard" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Codigo</th>
                                        <th>Data</th>
                                        <th>Área</th>
                                        <th>Dr(ª)</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Solicitante</th>
                                        <th style="min-width:70px">Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($devolvidas->solicitacao as $devolvida)

                                    <tr>
                                        <td></td>
                                        <td>{{ $devolvida->codigo }}</td>
                                        <td>{{ date('d/m/Y',strtotime($devolvida->created_at)) }}</td>
                                        <td>{{ $devolvida->area_atuacao->tipo}}</td>
                                        <td class="quebra-texto">{{ $devolvida->user->nome }}</td>
                                        <td class="quebra-texto">{{ $devolvida->cliente == null ? 'MOSELLO LIMA' : $devolvida->cliente->nome }}</td>
                                        <td>{{ $devolvida->tipo }}</td>
                                        <td>{{ $devolvida->solicitante == null ? 'ADVOGADO' : $devolvida->solicitante->nome}}</td>
                                        <td>{{ 'R$ '.number_format($devolvida->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($devolvida->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $devolvida->tipo).'.analisar', $devolvida->id)}}" class="btn bg-blue-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="VISUALIZAR {{$devolvida->tipo}}">
                                                    <i class="material-icons">search</i>
                                                </a>
                                                @if($devolvida->users_id == auth()->user()->id)
                                                <a href="{{ route('solicitacao.aprovar',$devolvida->id) }}" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="APROVAR {{$devolvida->tipo}}">
                                                    <i class="material-icons">done_all</i>
                                                    <!-- <span class="hidden-xs">ADD</span> -->
                                                </a>
                                                <a href="{{ route('solicitacao.reprovar',$devolvida->id) }}" class="btn bg-red btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="REPROVAR {{$devolvida->tipo}}">
                                                    <i class="material-icons">cancel</i>
                                                </a>
                                                @endif
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
                            <h1 class="visible-xs" style="text-align: center"> RECORRENTES </h1>
                            <table id="recorrente" class="table dt-responsive table-bordered table-striped table-hover dataTable dashboard" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Codigo</th>
                                        <th>Data</th>
                                        <th>Área</th>
                                        <th>Dr(ª)</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Solicitante</th>
                                        <th style="min-width:70px">Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recorrentes->solicitacao as $recorrente)

                                    <tr>
                                        <td></td>
                                        <td>{{ $recorrente->codigo }}</td>
                                        <td>{{ date('d/m/Y',strtotime($recorrente->created_at)) }}</td>
                                        <td>{{ $recorrente->area_atuacao->tipo}}</td>
                                        <td class="quebra-texto">{{ $recorrente->user->nome }}</td>
                                        <td class="quebra-texto">{{ $recorrente->cliente == null ? 'MOSELLO LIMA' : $recorrente->cliente->nome }}</td>
                                        <td>{{ $recorrente->tipo }}</td>
                                        <td>{{ $recorrente->solicitante == null ? 'ADVOGADO' : $recorrente->solicitante->nome}}</td>
                                        <td>{{ 'R$ '.number_format($recorrente->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                @if($recorrente->users_id != auth()->user()->id)
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($recorrente->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $recorrente->tipo).'.analisar', $recorrente->id)}}" class="btn bg-blue-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="VISUALIZAR {{$recorrente->tipo}}">
                                                    <i class="material-icons">search</i>
                                                </a>
                                                @else
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($recorrente->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $recorrente->tipo).'.editar', $recorrente->id)}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="EDITAR {{$recorrente->tipo}}">
                                                    <i class="material-icons">mode_edit</i>
                                                </a>
                                                @endif
                                                <a href="{{ route('solicitacao.aprovar',$recorrente->id) }}" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="APROVAR {{$recorrente->tipo}}">
                                                    <i class="material-icons">done_all</i>
                                                    <!-- <span class="hidden-xs">ADD</span> -->
                                                </a>
                                                <a href="{{ route('solicitacao.reprovar',$recorrente->id) }}" class="btn bg-red btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="REPROVAR {{$recorrente->tipo}}">
                                                    <i class="material-icons">cancel</i>
                                                </a>                                                
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
</section>
@endsection