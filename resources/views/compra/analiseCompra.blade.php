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
</section>
@endsection