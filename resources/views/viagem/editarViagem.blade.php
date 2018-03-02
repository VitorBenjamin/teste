@extends('layouts.app')
@section('content')
<section class="content">
	<div class="block-header">
		<h2>Editar Viagem</h2>			
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
	<form action="{{ route('viagem.atualizarViagem',$viagem->id)}}" method="POST">
		{{ csrf_field() }}
		{{ method_field('PUT') }}			
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							Preencha os campos abaixo com atenção
						</h2>
					</div>
					<div class="body">
						<div class="row clearfix">
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="origem">Origem</label>
										<input type="text" value="{{$viagem->origem}}" name="origem" class="form-control" placeholder="Cidade de Origem" required />										
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_ida">Data Ida</label>
										<input type="text" value="{{$viagem->data_ida}}" name="data_ida" class="datepicker form-control" placeholder="Data Obrigatória" required/>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="destino">Destino</label>
										<input type="text" value="{{$viagem->destino}}" name="destino" class="form-control" placeholder="Cidade de Destino" required/>										
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_volta">Data Volta</label>
										<input type="text" value="{{$viagem->data_volta}}" name="data_volta" class="datepicker form-control" placeholder="Data Opcional"/>
									</div>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<fieldset>
										<legend style="margin: 0">Locação de Carro</legend>
									</fieldset>
									<input name="locacao" value="1" type="radio" id="simL" {{$viagem->locacao == 1 ? 'checked' : ''}}/>
									<label style="margin: 15px 15px 0px 0px" for="simL">Sim</label>
									<input name="locacao" value="0" type="radio" id="naoL" {{$viagem->locacao == 0 ? 'checked' : ''}} />
									<label style="margin: 15px 15px 0px 0px" for="naoL">Não</label>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<fieldset>
										<legend style="margin: 0">Hospedagem</legend>
									</fieldset>
									<input name="hospedagem" value="1" type="radio" id="simH" {{$viagem->hospedagem == 1 ? 'checked' : ''}}/>
									<label style="margin: 15px 15px 0px 0px" for="simH">Sim</label>
									<input name="hospedagem" value="0" type="radio" id="naoH" {{$viagem->hospedagem == 0 ? 'checked' : ''}} />
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
									<input name="bagagem" value="1" type="radio" id="simB" {{$viagem->bagagem == 1 ? 'checked' : ''}}/>
									<label style="margin: 15px 15px 0px 0px" for="simB">Sim</label>
									<input name="bagagem" value="0" type="radio" id="naoB" {{$viagem->bagagem == 0 ? 'checked' : ''}}/>
									<label style="margin: 15px 15px 0px 0px" for="naoB">Não</label>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="kg">Kg</label>
										<input type="text" value="{{$viagem->kg}}" name="kg" class="form-control" placeholder="Kilos"/>
									</div>
								</div>								
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="form-line">
										<label for="observacao">Observação</label>
										<input type="text" value="{{$viagem->observacao}}" name="observacao" class="form-control" placeholder="Obs.."/>
									</div>
								</div>								
							</div>
						</div>
						<div class="form-group">
							<button class="btn btn-info">
								<i class="material-icons">save</i>
								<span>ATUALIZAR DESPESA</span> 
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
@endsection