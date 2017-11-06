@extends('layouts.app')

@section('content')
<script type="text/javascript">
	var urlClientes = "{{route('cliente.getCliente')}}";

	var urlSoli = "{{route('solicitante.getSolicitante')}}";
</script>
<section class="content">
	<div class="block-header">
		<h2>Solicitação de Compra</h2>
	</div>
	<form id="form_validation" action="{{ route('compra.salvar')}}" method="POST">
		{{ csrf_field() }}
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							Cabeçalho Padrão							
						</h2>
					</div>
					@include('layouts._includes.cabecalho._cabecalho')

				</div>
			</div>
		</div>
		<!-- FIM CABEÇALHO PADRAO -->			
	</form>
</section>
@endsection