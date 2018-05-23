@extends('layouts.app')
@section('content')
<script type="text/javascript">
	var urlDeletar = "{{route('solicitacao.deletarAdmin')}}";
</script>
<section class="content">
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="header">
				@if(Session::has('flash_message'))
				<div align="center" class="{{ Session::get('flash_message')['class'] }}" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
						<a style="margin-bottom: 10px;" href="{{ route('solicitacao.getSolicitacaoView')}}" class="btn bg-grey waves-effect" role="button">
							<i class="material-icons">keyboard_backspace</i>
							<span>VOLTAR</span>
						</a> 
						<br>Resultado....								
					</h2>
				</div>
				<div class="body">
					<div class="row clearfix">
						<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
							<thead>
								<tr> 
									<th></th>
									<th>Codigo</th>
									<th>Data</th>
									<th>Dr°</th>
									<th>Cliente</th>
									<th>Tipo</th>
									<th>Solicitante</th>
									<th>Ações</th>
								</tr>
							</thead>
							<tbody>
								@if ($solicitacoes)
								@foreach ($solicitacoes as $solicitacao)
								<tr>
									<td></td>
									<td>{{ $solicitacao->codigo }}</td>
									<td>{{ date('d/m/Y',strtotime($solicitacao->created_at)) }}</td>
									<td>{{ $solicitacao->user->nome }}</td>
									<td>{{ $solicitacao->cliente == null ? 'MOSELLO LIMA' : $solicitacao->cliente->nome }}</td>
									<td>{{ $solicitacao->tipo }}</td>
									<td>{{ $solicitacao->solicitacaocitante == null ? 'ADVOGADO' : $solicitacao->solicitacaocitante->nome }}</td>
									<td class="acoesTD">
										<div class="icon-button-demo" >
											
											<!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
											<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float js-sweetalert deleteAdmin" data-id="{{$solicitacao->id}}" data-toggle="tooltip" data-placement="top" title="EXCLUIR {{$solicitacao->tipo}}">
												<i class="material-icons">delete_sweep</i>
											</a>
											<a href="{{ route(strtolower($solicitacao->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $solicitacao->tipo).'.analisar', $solicitacao->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="VISUALIZAR {{$solicitacao->tipo}}">
												<i class="material-icons">search</i>
											</a>
										</div>
									</td>
								</tr>
								@endforeach 
								@elseif ($solicitacao)
								<tr>
									<td></td>
									<td>{{ $solicitacao->codigo }}</td>
									<td>{{ $solicitacao->user->nome }}</td>
									<td>{{ $solicitacao->cliente == null ? 'MOSELLO LIMA' : $solicitacao->cliente->nome }}</td>
									<td>{{ $solicitacao->tipo }}</td>
									<td>{{ $solicitacao->solicitacaocitante == null ? 'ADVOGADO' : $solicitacao->solicitacaocitante->nome}}</td>
									<td class="acoesTD">
										<div class="icon-button-demo" >
											<!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
											<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float js-sweetalert deleteAdmin" data-id="{{$solicitacao->id}}" data-toggle="tooltip" data-placement="top" title="EXCLUIR {{$solicitacao->tipo}}">
												<i class="material-icons">delete_sweep</i>
											</a>
											<a href="{{ route(strtolower($solicitacao->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $solicitacao->tipo).'.analisar', $solicitacao->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="VISUALIZAR {{$solicitacao->tipo}}">
												<i class="material-icons">search</i>
											</a>
										</div>
									</td>
								</tr>
								@endif                                                 
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection