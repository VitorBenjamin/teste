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
                            <table id="aberto" class="table table-bordered table-striped table-hover dataTable dashboard-adv">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Codigo</th>
                                        <th>Data</th>
                                        <th>Área</th>
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
                                        <!-- <td> {{ $aberto->urgencia == 1 ? 'SIM' : 'NÃO' }} </td> -->
                                        <td>{{ $aberto->area_atuacao->tipo}}</td>
                                        <td class="quebra-texto">{{ $aberto->cliente == null ? 'MOSELLO LIMA' : $aberto->cliente->nome }}</td>
                                        <td>{{ $aberto->tipo }}</td>
                                        <td>{{ $aberto->solicitante == null ? 'ADVOGADO' : $aberto->solicitante->nome}}</td>
                                        <td>{{ 'R$ '.number_format($aberto->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($aberto->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $aberto->tipo).'.editar', $aberto->id)}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="EDITAR {{$aberto->tipo}}">
                                                    <i class="material-icons">mode_edit</i>
                                                </a>
                                                <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float js-sweetalert" data-id="{{$aberto->id}}" data-toggle="tooltip" data-placement="top" title="EXCLUIR {{$aberto->tipo}}">
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
                            <table id="andamento" class="table dt-responsive table-bordered table-striped table-hover dataTable dashboard-adv" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Codigo</th>
                                        <th>Data</th>
                                        <th>Área</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Solicitante</th>
                                        <th style="min-width:70px">Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($andamentos->solicitacao as $andamento)
                                    
                                    <tr>
                                        <td></td>
                                        <td>{{ $andamento->codigo }}</td>
                                        <td>{{ date('d/m/Y',strtotime($andamento->created_at)) }}</td>
                                        <td>{{ $andamento->area_atuacao->tipo}}</td>
                                        <td class="quebra-texto">{{ $andamento->cliente == null ? 'MOSELLO LIMA' : $andamento->cliente->nome }}</td>
                                        <td>{{ $andamento->tipo }}</td>
                                        <td>{{ $andamento->solicitante == null ? 'ADVOGADO' : $andamento->solicitante->nome}}</td>
                                        <td>{{ 'R$ '.number_format($andamento->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
                                                <a href="{{ route(strtolower($andamento->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $andamento->tipo).'.analisar', $andamento->id)}}" class="btn bg-blue-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="VISUALIZAR {{$andamento->tipo}}">
                                                    <i class="material-icons">search</i>
                                                </a>
                                                <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float js-sweetalert" data-id="{{$andamento->id}}" data-toggle="tooltip" data-placement="top" title="EXCLUIR {{$andamento->tipo}}">
                                                    <i class="material-icons">delete_sweep</i>
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
                            <table id="aprovado" class="table dt-responsive table-bordered table-striped table-hover dataTable dashboard-adv" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Codigo</th>
                                        <th>Data</th>
                                        <th>Área</th>
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
                                        <td class="quebra-texto">{{ $aprovado->cliente == null ? 'MOSELLO LIMA' : $aprovado->cliente->nome }}</td>
                                        <td>{{ $aprovado->tipo }}</td>
                                        <td>{{ $aprovado->solicitante == null ? 'ADVOGADO' : $aprovado->solicitante->nome}}</td>
                                        <td>{{ 'R$ '.number_format($aprovado->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
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
                            <h1 class="visible-xs" style="text-align: center"> REPROVADO </h1>
                            <table id="reprovado" class="table dt-responsive table-bordered table-striped table-hover dataTable dashboard-adv" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Codigo</th>
                                        <th>Data</th>
                                        <th>Área</th>
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
                                        <td class="quebra-texto">{{ $reprovado->cliente == null ? 'MOSELLO LIMA' : $reprovado->cliente->nome }}</td>
                                        <td>{{ $reprovado->tipo }}</td>
                                        <td>{{ $reprovado->solicitante == null ? 'ADVOGADO' : $reprovado->solicitante->nome}}</td>
                                        <td>{{ 'R$ '.number_format($reprovado->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
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
                            <h1 class="visible-xs" style="text-align: center"> DEVOLVIDO </h1>
                            <table id="devolvido" class="table dt-responsive table-bordered table-striped table-hover dataTable dashboard-adv">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Codigo</th>
                                        <th>Data</th>
                                        <th>Área</th>
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
                                        <td class="quebra-texto">{{ $devolvida->cliente == null ? 'MOSELLO LIMA' : $devolvida->cliente->nome }}</td>
                                        <td>{{ $devolvida->tipo }}</td>
                                        <td>{{ $devolvida->solicitante == null ? 'ADVOGADO' : $devolvida->solicitante->nome}}</td>
                                        <td>{{ 'R$ '.number_format($devolvida->total, 2, ',', '.') }}</td>
                                        <td class="acoesTD">
                                            <div class="icon-button-demo" >
                                                <!-- REDIRECIONAMENTO DINÂMICO POR PARAMÊTRO -->
                                                <a href="{{ route(strtolower($devolvida->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $devolvida->tipo).'.editar', $devolvida->id)}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="EDITAR {{$devolvida->tipo}}">
                                                    <i class="material-icons">mode_edit</i>
                                                </a>
                                                <a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float js-sweetalert" data-id="{{$devolvida->id}}" data-toggle="tooltip" data-placement="top" title="EXCLUIR {{$devolvida->tipo}}">
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

                        <!-- LISTAGEM DAS SOLICITAÇÕES EM FINALIZADOS -->
                        <div id="finalizado" class="tab-pane fade in" role="tabpanel">
                            <h1 class="visible-xs" style="text-align: center"> FINALIZADAS </h1>
                            <table id="finalizado" class="table dt-responsive table-bordered table-striped table-hover dataTable dashboard-adv" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Codigo</th>
                                        <th>Data</th>
                                        <th>Área</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Solicitante</th>
                                        <th style="min-width:70px">Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($finalizadas->solicitacao as $finalizado)                                    
                                    <tr>
                                        <td></td>
                                        <td>{{ $finalizado->codigo }}</td>
                                        <td>{{ date('d/m/Y',strtotime($finalizado->created_at)) }}</td>
                                        <td>{{ $finalizado->area_atuacao->tipo}}</td>
                                        <td class="quebra-texto">{{ $finalizado->cliente == null ? 'MOSELLO LIMA' : $finalizado->cliente->nome }}</td>
                                        <td>{{ $finalizado->tipo }}</td>
                                        <td>{{ $finalizado->solicitante == null ? 'ADVOGADO' : $finalizado->solicitante->nome}}</td>
                                        <td>{{ 'R$ '.number_format($finalizado->total, 2, ',', '.') }}</td>
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
                        <!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM FINALIZADOS -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Tabs With Icon Title -->
</section>
@endsection

@push('scripts')
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.4.3/js/ajax-bootstrap-select.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/dataTables.bootstrap.min.js') !!}
{!! Html::script('https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js')!!}
<!-- {!! Html::script('https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js') !!}
{!! Html::script('https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.34/pdfmake.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.34/vfs_fonts.js') !!}
{!! Html::script('https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js') !!}
{!! Html::script('https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js') !!} -->
@endpush