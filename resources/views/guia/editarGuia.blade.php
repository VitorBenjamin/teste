@extends('layouts.app')

@section('content')


<section class="content">
	<div class="block-header">
		<h2>Atualização da Guia</h2>
	</div>
	<form action="{{ route('guia.atualizarGuia',$guia->id)}}" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<div class="body">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>
								Atualize os dados com atenção
							</h2>
						</div>

						<div class="body">
							<div class="row clearfix">
								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="data_limite">Data</label>
											<input type="text" value="{{$guia->data_limite}}" name="data_limite" class="datepicker form-control" placeholder="Escolha uma Data" required />
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<div class="form-line">
											<label for="reclamante">Reclamante</label>
											<input type="text" value="{{$guia->reclamante}}" name="reclamante" class="form-control" placeholder="Nome do Reclamante" required/>
										</div>
									</div>
								</div>

								<div class="col-md-2">
									<label for="perfil_pagamento">Perfil Pagamento</label>
									<select id="perfil_pagamento" name="perfil_pagamento" class="form-control show-tick" required>
										<option value="BOLETO">BOLETO</option>										
										<option value="DAF">DAF</option>
										<option value="DMA">DAM</option>
										<option value="GRU">GRU</option>
										<option value="GFIP">GFIP</option>
									</select>
								</div>

								<div class="col-md-3">
									<label for="banco">Banco</label>
									<select id="banco" name="banco" class="form-control show-tick" required>
										<option value="BANCO DO BRASIL">BANCO DO BRASIL</option>										
										<option value="ITAU">ITAU</option>
										<option value="BRADESCO">BRADESCO</option>								
									</select>
								</div>

								<div class="col-md-2">
									<div class="form-group">
										<fieldset>
											<legend style="margin: 0">Prioridade</legend>
										</fieldset>
										<input name="prioridade" value="1" type="radio" id="simPE" {{$guia->prioridade == 1 ? 'checked' : ''}} />
										<label style="margin: 15px 15px 0px 0px" for="simPE">Sim</label>
										<input name="prioridade" value="0" type="radio" id="naoPE" {{$guia->prioridade == 0 ? 'checked' : ''}} />
										<label style="margin: 15px 15px 0px 0px" for="naoPE">Não</label>
									</div>
								</div>

								<div class="col-md-3">
									<label for="tipo_guias_id">Tipo</label>
									<select id="tipo_guias_id" name="tipo_guias_id" class="form-control show-tick" data-live-search="true" data-size="5" required>
										@foreach($tipo_guia as $grupo => $tipo)
										<optgroup label="{{$grupo}}">
											@foreach($tipo as $desc)
											<option value="{{$desc->id}}">{{$desc->descricao}}</option>
											@endforeach	
										</optgroup>
										@endforeach						
									</select>
								</div>
								<div class="col-md-2">
									<b>Valor</b>
									<div class="input-group">
										<span class="input-group-addon">
											R$
										</span>
										<div class="form-line">
											<input type="text" value="{{$guia->valor}}" name="valor" class="form-control" placeholder="R$." required/>
										</div>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<div class="form-line">
											<label for="anexo_pdf">Alterar PDF</label>
											<input style="margin-top: 10px" type="file" name="anexo_pdf" id="anexo_pdf"/>
										</div>
									</div>								
								</div>
								<div class="form-group">
									<a style="margin-top: 20px" target="_blank" href="{{URL::to('storage/guias/'.$guia->anexo_pdf)}}" class="btn btn-primary waves-effect"><i class="material-icons">file_download</i>EXIBIR PDF</a>
								</div>
								<button class="btn bg-light-green waves-effect" >
									<i class="material-icons">update</i>
									<span>ATUALIZAR GUIA</span> 
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