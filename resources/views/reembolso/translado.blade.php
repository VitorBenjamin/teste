@extends('layouts.app')

@section('content')

<section class="content">
	<div class="block-header">
		<h2>Atualização da Despesa</h2>
	</div>
	<form action="{{ route('reembolso.atualizarTranslado',$translado->id)}}" method="POST">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<div class="body">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>
								Atualize os Dados Com Atenção
							</h2>
						</div>

						<div class="body">
							<div class="row clearfix">
								<div class="col-sm-2">
									<div class="form-group">
										<div class="form-line">
											<label for="data_translado">Data</label>
											<input type="text" value="{{$translado->data_translado}}" name="data_translado" class="datepicker form-control" placeholder="Escolha uma Data"/>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<label for="turno">Turno</label>
									<select id="turno" name="turno" class="form-control show-tick" data-live-search="true">
										@if($translado->turno == "MATUTINO")
										<option value="{{$translado->turno}}">{{$translado->turno}}</option>
										<option value="">SELECIONE</option>											
										<option value="VESPERTINO">VESPERTINO</option>
										@else
										<option value="{{$translado->turno}}">{{$translado->turno}}</option>
										<option value="">SELECIONE</option>											
										<option value="MATUTINO">MATUTINO</option>
										@endif						
									</select>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="origem">Origem</label>
											<input type="text" value="{{$translado->origem}}" name="origem" class="form-control" placeholder=""/>										
										</div>
									</div>
								</div>

								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="destino">Destino</label>
											<input type="text" value="{{$translado->destino}}" name="destino" class="form-control" placeholder=""/>
										</div>
									</div>								
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<div>
											<fieldset>
												<legend>Ida / Volta</legend>
											</fieldset>
											@if ($translado->ida_volta == true)
											<input name="ida_volta" value="1" type="radio" id="ida_volta_sim" checked />
											<label style="margin: 17px 5px" for="ida_volta_sim">Sim</label>
											<input name="ida_volta" value="0" type="radio" id="ida_volta_nao" />
											<label style="margin: 17px 5px" for="ida_volta_nao">Não</label>
											@else
											<input name="ida_volta" value="1" type="radio" id="ida_volta_sim" />
											<label style="margin: 17px 5px" for="ida_volta_sim">Sim</label>
											<input name="ida_volta" value="0" type="radio" id="ida_volta_nao" checked />
											<label style="margin: 17px 5px" for="ida_volta_nao">Não</label>
											@endif										
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="distancia">Distância (KM)</label>
											<input type="text" value="{{$translado->distancia}}" name="distancia" class="form-control" placeholder=""/>
										</div>
									</div>								
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<div class="form-line">
											<textarea rows="3" name="observacao" class="form-control no-resize" placeholder="Campo para deixar uma Observação">{{$translado->observacao}}</textarea>
										</div>
									</div>
								</div>								
							</div>
							<div class="form-group">
								<button class="btn btn-info">
									<i class="material-icons">save</i>
									<span>ATUALIZAR TRANSLADO</span> 
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