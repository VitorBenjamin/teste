@extends('layouts.app')
@section('content')

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
						Gerar Relátorio
					</h2>
					<br>
				</div>
				<div class="body">
					<form action="{{ route('relatorio.previa')}}" method="GET">
						{{ csrf_field() }}
						<div class="row clearfix">							
							<div class="col-md-4">
								<label for="clientes_id">Cliente</label>
								<select id="clientes_id" name="clientes_id" class="form-control show-tick" data-live-search="true" required>
									@foreach ($clientes as $cliente)
									<option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_final">De</label>
										<input disabled type="text" name="data_final" value="{{date('d-m-Y',strtotime($data_inicial))}}" class="datepicker form-control" placeholder="Escolha uma Data" required/>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_final">Até</label>
										<input type="text" name="data_final" value="" class="datepicker form-control" placeholder="Escolha uma Data" required/>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<button style="margin: 20px auto" class="btn btn-info">
									<i class="material-icons">send</i>
									<span>GERAR RELATÓRIO</span>
								</button>
							</div>
						</div>					
					</form>
				</div>
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
								<i style="color: #bb7408" class="material-icons">build</i> EM ABERTO <span class="badge">{{count($relatorios_abertos)}}</span>
							</a>
						</li>
						<li class="azed-tab">
							<a href="" data-toggle="tab" role="tab" data-target="#finalizada">
								<i style="color: #3ecc1b" class="material-icons">done_all</i> FINALIZADOS <span class="badge">{{count($relatorios)}}</span>
							</a>
						</li>
					</ul>
					<div class="tab-content">
						<!-- LISTAGEM DAS SOLICITAÇÕES EM ABERTO -->
						<div id="aberto" class="tab-pane fade in active" role="tabpanel">
							<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
								<thead>
									<tr>
										<th></th>
										<th class="uk-date-column">DATA</th>
										<th>CLIENTE</th>
										<th>COORDENADOR</th>
										<th>AÇÕES</th>
									</tr>
								</thead>
								<tbody style="font-size: 13px;">
									@foreach ($relatorios_abertos as $relatorio)
									<tr>
										<td></td>
										<td>{{date('d/m/Y',strtotime($relatorio->data))}}</td>
										<td>{{$relatorio->cliente->nome}}</td>
										<td>{{$relatorio->user->nome}}</td>
										<td class="acoesTD">
											<div class="icon-button-demo" >
												<a href="{{ route('relatorio.editar', $relatorio->id)}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="EDITAR RELÁTORIO"><i class="material-icons">mode_edit</i></a>
												<a href="{{ route('relatorio.deletar', $relatorio->id)}}" style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="EXCLUIR RELÁTORIO"><i class="material-icons">delete_sweep</i></a>
											</div>
										</td>
									</tr>
									@endforeach                                
								</tbody>
							</table>
						</div>
						<!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM ABERTO -->

						<!-- LISTAGEM DAS SOLICITAÇÕES EM APROVADAS -->
						<div id="finalizada" class="tab-pane fade in" role="tabpanel">
							<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
								<thead>
									<tr>
										<th></th>
										<th class="uk-date-column">DATA</th>
										<th>CLIENTE</th>
										<th>COORDENADOR</th>
										<th>AÇÕES</th>
									</tr>
								</thead>
								<tbody style="font-size: 13px;">
									@foreach ($relatorios as $relatorio)
									<tr>
										<td></td>
										<td>{{date('d/m/Y',strtotime($relatorio->data))}}</td>
										<td>{{$relatorio->cliente->nome}}</td>
										<td>{{$relatorio->user->nome}}</td>
										<td class="acoesTD">
											<div class="icon-button-demo" >
												<a href="{{ route('relatorio.visualizar', $relatorio->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float"><i class="material-icons">settings</i></a>
											</div>
										</td>
									</tr>
									@endforeach                                
								</tbody>
							</table>
						</div>
						<!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM APROVADAS -->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection