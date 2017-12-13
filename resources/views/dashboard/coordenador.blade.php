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
                        <li class="azed-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#recorrente">
                                <i style="color: #30b1b1" class="material-icons">hourglass_empty</i> <span class="hidden-xs"> RECORRENTE </span> <span class="badge">{{count($recorrentes->solicitacao)}}</span>
                            </a>
                        </li>
                        <li class="sais-tab">
                            <a href="" data-toggle="tab" role="tab" data-target="#meus">
                                <i style="color: #00c6f3" class="material-icons">person_pin</i> <span class="hidden-xs"> MINHAS </span> <span class="badge">{{count($meus->solicitacao)}}</span>
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
                            <h1 class="visible-xs" style="text-align: center"> ABERTO </h1>
                            <table id="aberto" class="table table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                        <th></th>
                                        {{-- <th>ID</th> --}}
                                        <th>Data</th>
                                        <th>Dr(ª)</th>
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
                                        {{-- <td>{{ $aberto->id }}</td> --}}
                                        <td>{{ date('d-m-y',strtotime($aberto->created_at)) }}</td>
                                        <td>{{ $aberto->user->nome}}</td>
                                        <td class="quebra-texto">{{ $aberto->cliente == null ? 'MOSELLO LIMA' : $aberto->cliente->nome }}</td>
                                        <td>{{ $aberto->tipo }}</td>
                                        <td>{{ $aberto->solicitante->nome }}</td>
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

                        <!-- LISTAGEM DAS SOLICITAÇÕES EM ANDAMENTO -->
                        <div id="andamento" class="tab-pane fade in" role="tabpanel">
                            <h1 class="visible-xs" style="text-align: center"> ANDAMENTO </h1>
                            <table id="andamento" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        {{-- <th>ID</th> --}}
                                        <th>Data</th>
                                        <th>Dr(ª)</th>
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
                                        {{-- <td>{{ $andamento->id }}</td> --}}
                                        <td>{{ date('d-m-y',strtotime($andamento->created_at)) }}</td>
                                        <td class="quebra-texto">{{ $andamento->user->nome }}</td>
                                        <td class="quebra-texto">{{ $andamento->cliente == null ? 'MOSELLO LIMA' : $andamento->cliente->nome }}</td>
                                        <td>{{ $andamento->tipo }}</td>
                                        <td>{{ $andamento->solicitante->nome }}</td>
                                        <td>{{ 'R$ '.number_format($andamento->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($andamento->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $andamento->tipo).'.analisar', $andamento->id)}}" class="btn bg-blue-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="VISUALIZAR {{$andamento->tipo}}">
                                                    <i class="material-icons">search</i>
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
                            <h1 class="visible-xs" style="text-align: center"> APROVADAS </h1>
                            <table id="aprovado" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                        <th></th>
                                        {{-- <th>ID</th> --}}
                                        <th>Data</th>
                                        <th>Dr(ª)</th>
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
                                        {{-- <td>{{ $aprovado->id }}</td> --}}
                                        <td>{{ date('d-m-y',strtotime($aprovado->created_at)) }}</td>
                                        <td class="quebra-texto">{{ $aprovado->user->nome }}</td>
                                        <td class="quebra-texto">{{ $aprovado->cliente == null ? 'MOSELLO LIMA' : $aprovado->cliente->nome }}</td>
                                        <td>{{ $aprovado->tipo }}</td>
                                        <td>{{ $aprovado->solicitante->nome }}</td>
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
                            <table id="reprovado" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        {{-- <th>ID</th> --}}
                                        <th>Data</th>
                                        <th>Dr(ª)</th>
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
                                        {{-- <td>{{ $reprovado->id }}</td> --}}
                                        <td>{{ date('d-m-y',strtotime($reprovado->created_at)) }}</td>
                                        <td class="quebra-texto">{{ $reprovado->user->nome }}</td>
                                        <td class="quebra-texto">{{ $reprovado->cliente == null ? 'MOSELLO LIMA' : $reprovado->cliente->nome }}</td>
                                        <td>{{ $reprovado->tipo }}</td>
                                        <td>{{ $reprovado->solicitante->nome }}</td>
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
                            <table id="devolvido" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        {{-- <th>ID</th> --}}
                                        <th>Data</th>
                                        <th>Dr(ª)</th>
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
                                        {{-- <td>{{ $devolvida->id }}</td> --}}
                                        <td>{{ date('d-m-y',strtotime($devolvida->created_at)) }}</td>
                                        <td class="quebra-texto">{{ $devolvida->user->nome }}</td>
                                        <td class="quebra-texto">{{ $devolvida->cliente == null ? 'MOSELLO LIMA' : $devolvida->cliente->nome }}</td>
                                        <td>{{ $devolvida->tipo }}</td>
                                        <td>{{ $devolvida->solicitante->nome }}</td>
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
                            <table id="recorrente" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        {{-- <th>ID</th> --}}
                                        <th>Data</th>
                                        <th>Dr(ª)</th>
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
                                        {{-- <td>{{ $recorrente->id }}</td> --}}
                                        <td>{{ date('d/m/Y',strtotime($recorrente->created_at)) }}</td>
                                        <td class="quebra-texto">{{ $recorrente->user->nome }}</td>
                                        <td class="quebra-texto">{{ $recorrente->cliente == null ? 'MOSELLO LIMA' : $recorrente->cliente->nome }}</td>
                                        <td>{{ $recorrente->tipo }}</td>
                                        <td>{{ $recorrente->solicitante->nome }}</td>
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

                        <!-- LISTAGEM DAS SOLICITAÇÕES DO COORDENADOR -->
                        <div id="meus" class="tab-pane fade in" role="tabpanel">
                            <h1 class="visible-xs" style="text-align: center"> MINHAS </h1>
                            <table id="meus" class="table dt-responsive table-bordered table-striped table-hover dataTable js-basic-example" cellspacing="0" width="100%">
                                <thead> 
                                    <tr>
                                        <th></th>
                                        {{-- <th>ID</th> --}}
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
                                        {{-- <td>{{ $meu->id }}</td> --}}
                                        <td>{{ date('d-m-y',strtotime($meu->created_at)) }}</td>
                                        <td class="quebra-texto">{{ $meu->cliente == null ? 'MOSELLO LIMA' : $meu->cliente->nome }}</td>
                                        <td>{{ $meu->tipo }}</td>
                                        <td>{{ $meu->solicitante->nome }}</td>
                                        <td>{{ 'R$ '.number_format($meu->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($meu->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $meu->tipo).'.editar', $meu->id)}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="EDITAR {{$meu->tipo}}">
                                                    <i class="material-icons">mode_edit</i>
                                                </a>
                                                <a style="margin-left: 10px" href="{{ route('solicitacao.aprovar',$meu->id) }}" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="ENVIAR {{$meu->tipo}}">
                                                    <i class="material-icons">done_all</i>
                                                    <!-- <span class="hidden-xs">ADD</span> -->
                                                </a>
                                                @if($meu->status[0]->descricao =="COORDENADOR-ABERTO")
                                                <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float js-sweetalert" data-id="{{$meu->id}}" data-toggle="tooltip" data-placement="top" title="EXCLUIR {{$meu->tipo}}">
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
                                        {{-- <th>ID</th> --}}
                                        <th>Data</th>
                                        <th>Dr(ª)</th>
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
                                        {{-- <td>{{ $finalizado->id }}</td>                     --}}
                                        <td>{{ date('d/m/y',strtotime($finalizado->created_at)) }}</td>
                                        <td class="quebra-texto">{{ $finalizado->user->nome }}</td>
                                        <td class="quebra-texto">{{ $finalizado->cliente == null ? 'MOSELLO LIMA' : $finalizado->cliente->nome }}</td>
                                        <td>{{ $finalizado->tipo }}</td>
                                        <td>{{ $finalizado->solicitante->nome }}</td>
                                        <td>R$ {{ $finalizado->total }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($finalizado->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $finalizado->tipo).'.analisar', $finalizado->id)}}" class="btn bg-blue-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="VISUALIZAR {{$finalizado->tipo}}">
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