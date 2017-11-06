@extends('layouts.app')
@section('content')
<script type="text/javascript">
	var urlClientes = "{{route('cliente.getCliente')}}";

	var urlSoli = "{{route('solicitante.getSolicitante')}}";
</script>
<section class="content">
	<div class="block-header">
		<h2>Dados da Solicitação</h2>			
	</div>
	<!-- COMEÇO CABEÇALHO PADRÃO -->
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
					<h2>Dados da Compra</h2>
				</div>
				<form action="{{ route('compra.atualizar',$solicitacao->id)}}" method="POST">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					@include('layouts._includes.cabecalho._cabecalho-editar')
				</form>
			</div>
		</div>
	</div>

	<!-- SESSÃO PRODUTO -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						Adicione um produto a sua solicitação
					</h2>
				</div>
				<div class="body">
					<form action="{{ route('viagem.addViagem',$solicitacao->id)}}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}

						<div class="row clearfix">
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="origem">Destino Ida</label>
										<input type="text" value="" name="origem" class="form-control" placeholder="Descrição do produto"/>										
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_ida">Data Ida</label>
										<input type="text" value="" name="data_ida" class="datepicker form-control" placeholder="Escolha uma Data"/>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="destino">Destino Volta</label>
										<input type="text" value="" name="destino" class="form-control" placeholder="Descrição do produto"/>										
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_volta">Data Volta</label>
										<input type="text" value="" name="data_volta" class="datepicker form-control" placeholder="Escolha uma Data"/>
									</div>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<fieldset>
										<legend>Locação</legend>
									</fieldset>
									<input name="locacao" value="1" type="radio" id="simL" />
									<label style="margin: 15px 15px 0px 0px" for="simL">Sim</label>
									<input name="locacao" value="0" type="radio" id="naoL" />
									<label style="margin: 15px 15px 0px 0px" for="naoL">Não</label>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<fieldset>
										<legend>Hospedagem</legend>
									</fieldset>
									<input name="hospedagem" value="1" type="radio" id="simH" />
									<label style="margin: 15px 15px 0px 0px" for="simH">Sim</label>
									<input name="hospedagem" value="0" type="radio" id="naoH" />
									<label style="margin: 15px 15px 0px 0px" for="naoH">Não</label>
								</div>
							</div>
							
						</div>
						<div class="row clearfix">
							<div class="col-md-2">
								<div class="form-group">
									<fieldset>
										<legend>Bagagem</legend>
									</fieldset>
									<input name="bagagem" value="1" type="radio" id="simB" />
									<label style="margin: 15px 15px 0px 0px" for="simB">Sim</label>
									<input name="bagagem" value="0" type="radio" id="naoB" />
									<label style="margin: 15px 15px 0px 0px" for="naoB">Não</label>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="kg">Kg</label>
										<input type="text" value="" name="kg" class="form-control" placeholder="Kilos"/>
									</div>
								</div>								
							</div>
							<div class="col-md-2" style="margin-top: 20px">
								<button class="btn btn-primary btn-lg waves-effect">
									<i class="material-icons">save</i>
									<span>ADD VIAGEM</span> 
								</button>
							</div>
							
						</div>
						
					</div>
				</form>	
			</div>			
		</div>			
	</div>
</div>
</section>
@endsection