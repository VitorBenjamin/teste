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
	<!-- INCIO CABEÇALHO PADRAO -->
	@include('layouts._includes.cabecalho._cabecalho_analise')

	<!-- FIM CABEÇALHO PADRAO -->

	<!-- LISTAGEM DOS PRODUTOS  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTAGEM DOS PRODUTOS
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped nowrap table-hover dataTable table-simples">
						<thead>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Descrição</th>
								<th>Quantidade</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Descrição</th>
								<th>Quantidade</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach ($solicitacao->compra as $compra)
							<tr>
								<td></td>
								<td>{{date('d/m/y',strtotime($compra->data_compra))}}</td>
								<td>{{$compra->descricao}}</td>
								<td>{{$compra->quantidade}}</td>									
							</tr>
							@endforeach														
						</tbody>
					</table>
				</div>

			</div>
		</div> 												
	</div>
	<!-- FIM LISTAGEM DOS PRODUTOS -->
	<!-- LISTAGEM DA GUIA  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<div class="row">
						<div class="col-sm-3">
							<h2>
								LISTAGEM DAS GUIAS
							</h2>
						</div>
						<div class="col-sm-offset-7 col-sm-1">
							<a name="add" id="add" class="btn bg-green waves-effect">
								<i class="material-icons">add</i>
								<span>ADD MAIS</span> 
							</a>
						</div>
					</div>
				</div>
				<form action="{{ route('compra.addCotacao',$solicitacao->id)}}" method="POST">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="body">
						<div id="dynamic_field">
							<div class="row clearfix">
								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="data_cotacao">Data</label>
											<input id="data_cotacao" type="text" value="" name="data_cotacao[]" class="datepicker form-control" placeholder="Escolha uma Data" required />
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<div class="form-line">
											<label for="descricao">Descrição</label>
											<input id="descricao" type="text" value="" name="descricao[]" class="form-control" placeholder="Descrição do produto" required />										
										</div>
									</div>
								</div>

								<div class="col-md-1">
									<div class="form-group">
										<div class="form-line">
											<label for="quantidade">Qtd.</label>
											<input type="text" value="" name="quantidade[]" class="form-control" placeholder="Qtd." required />
										</div>
									</div>								
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<div class="form-line">
											<label style="margin-bottom: 17px;" for="anexo_comprovante">Envie um Arquivo (jpeg,bmp,png)</label>
											<input type="file" name="anexo_comprovante[]" id="anexo_comprovante" required />

										</div>
									</div>
								</div>
								
							</div> 
						</div>
						<div class="row clearfix">
							<div class="col-md-12" style="margin-top: 20px">
								<button class="btn btn-block bg-green waves-effect">
									<i class="material-icons">send</i>
									<span>CADASTRAR SOLICITAÇÃO</span> 
								</button>
							</div>
						</div>

					</div>
				</form>
			</div>
		</div> 												
	</div>
	<!-- FIM LISTAGEM DA ANTECIPAÇÃO -->
</section>
@endsection