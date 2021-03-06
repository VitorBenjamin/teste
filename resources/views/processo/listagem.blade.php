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
						Listagem dos Processos do Sistema
						<!-- <small>Different sizes and widths</small> -->
					</h2>
					<br>
					<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
						<a data-toggle="modal" data-target="#addProcesso" class="btn bg-light-green waves-effect" role="button">
							<i class="material-icons">exposure_plus_1</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>PROCESSO</span>
						</a>
					</div>
				</div>
				<div class="modal fade" id="addProcesso" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="defaultModalLabel">ADICIONAR NOVO PROCESSO</h4>
							</div>
							<div class="modal-body">
								<form action="{{ route('processo.salvar')}}" method="POST">
									{{ csrf_field() }}
									<div class="row clearfix">							
										<div class="col-md-6">
											<div class="form-group{{ $errors->has('codigo') ? ' has-error' : '' }}">
												<div class="form-line">
													<label for="codigo">Codigo do Processo *</label>
													<input id="codigo" type="text" class="form-control" name="codigo" value="" required>
												</div>
												@if ($errors->has('codigo'))
												<span class="help-block">
													<strong>{{ $errors->first('codigo') }}</strong>
												</span>
												@endif
											</div>
										</div>
										<div class="col-md-6">
											<label for="cliente">Cliente</label>
											<select id="cliente" name="clientes_id" class="form-control show-tick" data-live-search="true" data-size="7" required>
												@foreach ($clientes as $cliente)
												<option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
												@endforeach
											</select>
										</div>
									</div> 
									<div class="modal-footer">
										<div class="form-group">
											<button class="btn btn-info">
												<i class="material-icons">send</i>
												<span>CRIAR PROCESSO</span>
											</button>
										</div>
										<!-- <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button> -->
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
						<thead>
							<tr>
								<th></th>
								<th>Codigo</th>
								<th>Cliente</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th>Codigo</th>
								<th>Cliente</th>
								<th>Ações</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach ($processos as $processo)
							<tr>
								<td></td>
								<td>{{$processo->codigo}}</td>
								<td>{{$processo->cliente->nome}}</td>
								<td class="acoesTD">
									<div class="icon-button-demo" >
										<a data-toggle="modal" data-target="#atualizar{{$processo->id}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float">
											<i class="material-icons">edit</i>
										</a>									
									</div>
								</td>
							</tr>
							<div class="modal fade" id="atualizar{{$processo->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="defaultModalLabel">EDITAR PROCESSO</h4>
										</div>
										<div class="modal-body">
											<form action="{{ route('processo.atualizar',$processo->id)}}" method="POST">
												{{ csrf_field() }}
												{{ method_field('PUT') }}
												<div class="row clearfix">							
													<div class="col-md-6">
														<div class="form-group{{ $errors->has('codigo') ? ' has-error' : '' }}">
															<div class="form-line">
																<label for="codigo">Número do Processo *</label>
																<input id="codigo" type="text" class="form-control" name="codigo" value="{{$processo->codigo}}" required>
															</div>
															@if ($errors->has('codigo'))
															<span class="help-block">
																<strong>{{ $errors->first('codigo') }}</strong>
															</span>
															@endif
														</div>
													</div>
													<div class="col-md-6">
														<label for="cliente">Cliente</label>
														<select id="cliente" name="clientes_id" class="form-control show-tick" data-live-search="true" required>
															@foreach ($clientes as $cliente)
															<option value="{{ $cliente->id }}" {{$processo->clientes_id == $cliente->id ? 'selected' : '' }} >{{ $cliente->nome }}</option>
															@endforeach
														</select>
													</div>
												</div> 
												<div class="modal-footer">
													<div class="form-group">
														<button class="btn btn-info">
															<i class="material-icons">update</i>
															<span>ATUALIZAR PROCESSO</span>
														</button>
													</div>
													<!-- <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button> -->
													<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
												</div>
											</form>
										</div>

									</div>
								</div>
							</div>					
							@endforeach														
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection