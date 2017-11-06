@extends('layouts.app')

@section('content')


<section class="content">
	<div class="block-header">
		<h2>Atualização da Despesa</h2>
	</div>
	<form action="{{ route('reembolso.atualizarDespesa',$despesa->id)}}" method="POST" enctype="multipart/form-data">
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
								<div class="col-sm-2">
									<div class="form-group">
										<div class="form-line">
											<label for="data_despesa">Data</label>
											<input type="text" name="data_despesa" value="{{$despesa->data_despesa}}" class="datepicker form-control" placeholder="Escolha uma Data"/>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<label for="tipo_comprovante">Comprovante</label>
									<select id="tipo_comprovante" name="tipo_comprovante" class="form-control show-tick">
										<option value="{{$despesa->tipo_comprovante}}">{{$despesa->tipo_comprovante}}</option>
										<option value="">SELECIONE</option>
										<option value="HOSPEDAGEM">HOSPEDAGEM</option>
										<option value="ALIMENTAÇÂO">ALIMENTAÇÃo</option>
										<option value="TRANSPORTE">TRANSPORTE</option>

									</select>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<div class="form-line">
											<label for="descricao">Descrição</label>
											<input type="text" name="descricao" value="{{$despesa->descricao}}" class="form-control" placeholder=""/>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="valor">Valor</label>
											<input type="text" id="valor" name="valor" value="{{$despesa->valor}}" class="form-control" placeholder=""/>
										</div>
									</div>								
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="form-line">
											<label for="anexo_comprovante">Envie um Arquivo</label>
											<input type="file" name="anexo_comprovante" id="anexo_comprovante" />
											<button type="reset" id="pseudoCancel">
												Cancel
											</button>
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
							<div class="container">
								<div class="row">
									<div class="col-md-offset-1 col-md-10">
										<!--Colocar a imagem-->  
										<a href="{{$despesa->anexo_comprovante}}" download="COMPROVANTE {{$despesa->tipo_comprovante}} {{$despesa->data_despesa}} ">
											<img border="0" src="{{$despesa->anexo_comprovante}}" alt="Comprovante Despesa" width="200" height="200">
										</a>
									</div>  
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- FIM SESSÃO DESPESA -->
	</form>
</section>

@endsection