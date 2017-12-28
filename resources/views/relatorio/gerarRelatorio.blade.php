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
					<form action="{{ route('relatorio.gerar')}}" method="GET">
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
							<div class="col-md-4">
								<div class="form-group">
									<div class="form-line">
										<label for="data_final">Data do Relatório</label>
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
						Relátorio Gerados
					</h2>
					<br>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped table-hover dataTable exportacao-simples">
						<thead>
							<tr>
								<th class="uk-date-column">DATA</th>
								<th>CLIENTE</th>
								<th>COORDENADOR</th>
							</tr>
						</thead>
						<tbody style="font-size: 13px;">
							@foreach ($relatorios as $relatorio)
							<tr>
								<td>{{$relatorio->data}}</td>
								<td>{{$relatorio->cliente->nome}}</td>
								<td>{{$relatorio->user->nome}}</td>
							</tr>
							@endforeach                                
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection