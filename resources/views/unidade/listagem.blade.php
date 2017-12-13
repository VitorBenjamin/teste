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
						Listagem das Unidades do Sistema
						<!-- <small>Different sizes and widths</small> -->
					</h2>
					<br>
					<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
						<a data-toggle="modal" data-target="#addUnidade" class="btn bg-light-green waves-effect" role="button">
							<i class="material-icons">exposure_plus_1</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>UNIDADE</span>
						</a>
					</div>
				</div>
				<div class="modal fade" id="addUnidade" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="defaultModalLabel">ADICIONAR NOVA UNIDADE</h4>
							</div>
							<div class="modal-body">
								<form action="{{ route('unidade.salvar')}}" method="POST">
									{{ csrf_field() }}
									<div class="row clearfix">							
										<div class="col-md-5">
											<div class="form-group{{ $errors->has('localidade') ? ' has-error' : '' }}">
												<div class="form-line">
													<label for="localidade">Localidade da Unidade *</label>
													<input id="localidade" type="text" class="form-control" name="localidade" value="" required>
												</div>
												@if ($errors->has('localidade'))
												<span class="help-block">
													<strong>{{ $errors->first('localidade') }}</strong>
												</span>
												@endif
											</div>
										</div>
									</div> 
									<div class="modal-footer">
										<div class="form-group">
											<button class="btn btn-info">
												<i class="material-icons">send</i>
												<span>CRIAR UNIDADE</span>
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
								<th>Nome</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th>Nome</th>
								<th>Ações</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach ($unidades as $unidade)
							<tr>
								<td></td>
								<td>{{$unidade->localidade}}</td>
								<td class="acoesTD">
									<div class="icon-button-demo" >
										<a data-toggle="modal" data-target="#atualizar{{$unidade->id}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float">
											<i class="material-icons">edit</i>
										</a>									
									</div>
								</td>
							</tr>
							<div class="modal fade" id="atualizar{{$unidade->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="defaultModalLabel">EDITAR UNIDADE</h4>
										</div>
										<div class="modal-body">
											<form action="{{ route('unidade.atualizar',$unidade->id)}}" method="POST">
												{{ csrf_field() }}
												{{ method_field('PUT') }}
												<div class="row clearfix">							
													<div class="col-md-5">
														<div class="form-group{{ $errors->has('localidade') ? ' has-error' : '' }}">
															<div class="form-line">
																<label for="localidade">Localidade da Unidade *</label>
																<input id="localidade" type="text" class="form-control" name="localidade" value="{{$unidade->localidade}}" required>
															</div>
															@if ($errors->has('localidade'))
															<span class="help-block">
																<strong>{{ $errors->first('localidade') }}</strong>
															</span>
															@endif
														</div>
													</div>
												</div> 
												<div class="modal-footer">
													<div class="form-group">
														<button class="btn btn-info">
															<i class="material-icons">update</i>
															<span>ATUALIZAR UNIDADE</span>
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