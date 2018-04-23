<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Relátorio  - {{$solicitacao->tipo}}</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

	
	<link rel="stylesheet" href="{{ asset('css/impressao.css') }}">
	<script src="{{ asset('js/jquery-latest.js') }}"></script>
	<script src="{{ asset('js/jquery.tablesorter.min.js') }}"></script>
</head>
<body>
	<div style="text-align:center" class="">
		<img src="{{ asset('images/logo.svg') }}" alt="" class="img-topo" style="margin: 10px; 0 50px 0">
	</div>
	<div class="container">
		<div class="top-left">Solicitante : {{ $solicitacao->user->nome }}</div>
	</div>
	<div style="text-align:justify">
		<p class="cabecalho">
			Despesa: {{ $solicitacao->origem_despesa }} 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Cliente: {{$solicitacao->cliente == null ? 'Mosello Lima' : $solicitacao->cliente->nome }}
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Solicitante: {{$solicitacao->solicitante == null ? 'Desconhecido' : $solicitacao->solicitante->nome }}
			<br>
			N° de Processo: {{$solicitacao->processo == null ? 'Sem Processo' : $solicitacao->processo->codigo }}
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Área de Atendi..: {{$solicitacao->area_atuacao->tipo}}
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Contrato: {{ $solicitacao->contrato ? $solicitacao->contrato : 'Desconhecido'}}
		</p>
	</div>
	<table  class="table">
		<caption>
			Relátorio Geral - {{$solicitacao->tipo}}
		</caption>
		<thead>
			<tr>
				<th scope="col">DATA</th>
				<th scope="col">CÓDIGO</th>
				<th scope="col">DESCRIÇÃO</th>
				<th scope="col">VALORES</th>
			</tr>
		</thead>
		<tbody>
			@foreach($lista as $l)
			<tr>
				<td>
					{{$l['data']}}
				</td>
				<td>
					{{$solicitacao->codigo}}
				</td>
				<td>{{$l['descricao']}}</td>
				<td>R$ {{$l['valor']}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@foreach ($lista as $li)
	<div class="page-break"></div>
	<table class="table2">
		<caption>
			Comprovantes - {{$solicitacao->tipo}} - {{$solicitacao->codigo}}
		</caption>
		<thead>
			<tr>
				<th scope="col">DATA</th>
				<th scope="col">CÓDIGO</th>
				<th scope="col">DESCRIÇÃO</th>
				<th scope="col">VALORES</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					{{$l['data']}}
				</td>
				<td>
					{{$solicitacao->codigo}}
				</td>
				<td>{{$l['descricao']}}</td>
				<td>R$ {{$l['valor']}}</td>
			</tr>
		</tbody>
	</table>
	<div style="text-align:center">
		@if ($li['img'])
		<img src="{{$li['img']}}" alt="" class="img">
		@endif
	</div>
	@endforeach
</body>
</html>