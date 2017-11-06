@extends('layouts.app')

@section('content')

<section class="content">
	<div class="block-header">
		<h2>Atualização do Translado</h2>
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
									<select id="turno" name="turno" class="form-control show-tick">
										<option value="VESPERTINO" {{ $translado->turno == "VESPERTINO" ? 'selected' : '' }}>VESPERTINO</option>
										<option value="MATUTINO" {{ $translado->turno == "MATUTINO" ? 'selected' : '' }}>MATUTINO</option>	
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
												<legend style="margin: 0">Ida / Volta</legend>
											</fieldset>
											@if ($translado->ida_volta == true)
											<input name="ida_volta" value="1" type="radio" id="ida_volta_sim" checked />
											<label style="margin: 17px 5px 0px 0px" for="ida_volta_sim">Sim</label>
											<input name="ida_volta" value="0" type="radio" id="ida_volta_nao" />
											<label style="margin: 17px 5px 0px 0px" for="ida_volta_nao">Não</label>
											@else
											<input name="ida_volta" value="1" type="radio" id="ida_volta_sim" />
											<label style="margin: 17px 5px 0px 0px" for="ida_volta_sim">Sim</label>
											<input name="ida_volta" value="0" type="radio" id="ida_volta_nao" checked />
											<label style="margin: 17px 5px 0px 0px" for="ida_volta_nao">Não</label>
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
							</div>
							<div class="row clearfix">
								<div class="col-md-4">
									<div class="form-group">
										<div class="form-line">
											<label for="observacao">Obeservação</label>
											<textarea rows="1" name="observacao" class="form-control no-resize" placeholder="Deixa uma Breve Observação">{{$translado->observacao}}</textarea>
										</div>
									</div>
								</div>	
								<div class="col-md-2">
									<button class="btn bg-green waves-effect" style="margin-top: 20px">
										<i class="material-icons">update</i>
										<span>ATUALIZAR TRANSLADO</span> 
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
@endsection