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
	<form id="form_validation" action="{{ route('solicitacao.getSolicitacao')}}" method="POST">
		{{ csrf_field() }}
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							Área de Busca das Solicitação								
						</h2>
					</div>
					<div class="body">
						<div class="col-md-1">
							<div class="form-line">
								<label class="form-label label4">Codigo</label>
								<input type="text" id="codigo" name="codigo" class="form-control codigo" autocomplete="off" placeholder="" />
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-md-3">
								<label id="label" for="cliente" class="label2">Cliente</label>
								<select id="cliente" name="clientes_id" class="selectpicker form-control show-tick" data-size="5" data-live-search="true" required>
									<option value="">SELECIONE</option>
									@foreach ($clientes as $cliente)
									<option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-3">
								<label for="advogado">Advogados</label>
								<select id="advogado" name="advogados_id" class="selectpicker form-control show-tick" data-size="5" data-live-search="true" required>
									<option value="">SELECIONE</option>
									@foreach ($advogados as $ad)
									<option value="{{ $ad->id }}">{{ $ad->nome }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<label for="area_atuacoes">Área de Atendimento</label>
								<select id="area_atuacoes" name="area_atuacoes_id" class="form-control show-tick" data-live-search="true">
									<option value="">SELECIONE</option>
									@foreach ($areas as $area)
									<option value="{{ $area->id }}">{{ $area->tipo }}</option>
									@endforeach
								</select>
							</div>

							<div class="col-md-2" style="margin-top: 20px">
								<button class="btn bg-green waves-effect">
									<i class="material-icons">send</i>
									<span>BUSCAR SOLICITAÇÔES</span> 
								</button>
							</div> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
@endsection