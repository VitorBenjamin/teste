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
						Listagem Das Solicitações
					</h2>
				</div>
				<div class="body">
					<ul class="nav nav-tabs" role="tablist">
						<li class="active sais-tab">
							<a href="" data-toggle="tab" role="tab" data-target="#ativos">
								<i style="color: #0cbc1a" class="material-icons">how_to_reg</i> ATIVOS
							</a>
						</li>
						<li class="azed-tab">
							<a href="" data-toggle="tab" role="tab" data-target="#inativos">
								<i style="color: #ff5304" class="material-icons">not_interested</i> ATIVOS
							</a>
						</li>
					</ul>
					<div class="tab-content">
						<!-- LISTAGEM DAS SOLICITAÇÕES EM ATIVOS -->
						<div id="ativos" class="tab-pane fade in active" role="tabpanel">
							<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
								<thead>
									<tr>
										<th></th>
										<th>Nome</th>
										<th>Função</th>
										<th>Area</th>
										<th>Email</th>
										<th>Telefone</th>
										<th>Ações</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th></th>
										<th>Nome</th>
										<th>Função</th>
										<th>Area</th>
										<th>Email</th>
										<th>Telefone</th>
										<th>Ações</th>
									</tr>
								</tfoot>
								<tbody>
									@foreach ($ativos as $user)
									@foreach ($user->user as $user)
									<tr>
										<td></td>
										<td>{{$user->nome}}</td>
										<td>{{$user->roles[0]->display_name}}</td>
										<td>{{$user->area_atuacao->tipo}}</td>
										<td>{{$user->email}}</td>
										<td>{{$user->telefone}}</td>
										<td class="acoesTD">
											<div class="icon-button-demo" >
												<!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
												<a href="{{ route('user.editar', $user->id)}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="EDITAR {{$user->nome}}">
													<i class="material-icons">edit</i>
												</a>
												@if ($user->ativo)
												<a href="{{ route('user.ativarOrDesativar', $user->id)}}" class="btn bg-red btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="DESATIVAR {{$user->nome}}">
													<i class="material-icons">not_interested</i>
												</a>
												@else
												<a href="{{ route('user.ativarOrDesativar', $user->id)}}" class="btn bg-green btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="ATIVAR {{$user->nome}}">
													<i class="material-icons">check_circle</i>
												</a>
												@endif
											</div>
										</td>
									</tr>		
									@endforeach				
									@endforeach														
								</tbody>
							</table>
						</div>
						<!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM ABERTO -->

						<!-- LISTAGEM DAS SOLICITAÇÕES EM INATIVOS -->
						<div id="inativos" class="tab-pane fade in" role="tabpanel">
							<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
								<thead>
									<tr>
										<th></th>
										<th>Nome</th>
										<th>Função</th>
										<th>Area</th>
										<th>Email</th>
										<th>Telefone</th>
										<th>Ações</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th></th>
										<th>Nome</th>
										<th>Função</th>
										<th>Area</th>
										<th>Email</th>
										<th>Telefone</th>
										<th>Ações</th>
									</tr>
								</tfoot>
								<tbody>
									@foreach ($inativos as $user)
									@foreach ($user->user as $user)
									<tr>
										<td></td>
										<td>{{$user->nome}}</td>
										<td>{{$user->roles[0]->name}}</td>
										<td>{{$user->area_atuacao->tipo}}</td>
										<td>{{$user->email}}</td>
										<td>{{$user->telefone}}</td>
										<td class="acoesTD">
											<div class="icon-button-demo" >
												<!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
												<a href="{{ route('user.editar', $user->id)}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="EDITAR {{$user->nome}}">
													<i class="material-icons">edit</i>
												</a>
												@if ($user->ativo)
												<a href="{{ route('user.ativarOrDesativar', $user->id)}}" class="btn bg-red btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="DESATIVAR {{$user->nome}}">
													<i class="material-icons">not_interested</i>
												</a>
												@else
												<a href="{{ route('user.ativarOrDesativar', $user->id)}}" class="btn bg-green btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="ATIVAR {{$user->nome}}">
													<i class="material-icons">check_circle</i>
												</a>
												@endif
											</div>
										</td>
									</tr>		
									@endforeach				
									@endforeach														
								</tbody>
							</table>
						</div>
						<!-- FIM DA LISTAGEM DAS SOLICITAÇÕES EM ABERTO -->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection