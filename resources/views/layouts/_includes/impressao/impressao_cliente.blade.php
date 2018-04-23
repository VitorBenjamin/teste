<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Relátorio Geral - {{$solicitacoes[0]->cliente->nome}}</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

	
	<link rel="stylesheet" href="{{ asset('css/impressao.css') }}">
	<script src="{{ asset('js/jquery-latest.js') }}"></script>
	<script src="{{ asset('js/jquery.tablesorter.min.js') }}"></script>
</head>
<body>
	@foreach ($lista as $li)
	<table class="table2">
		<caption>
			Relátorio Geral - {{$solicitacoes[0]->cliente->nome}}
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
					{{$li['data']}}
				</td>
				<td>
					{{$li['codigo']}}
				</td>
				<td>{{$li['descricao']}}</td>
				<td>R$ {{$li['valor']}}</td>
			</tr>
		</tbody>
	</table>
	<div style="text-align:center">
		@if ($li['img'])
		<img src="{{$li['img']}}" alt="" class="img">
		@endif
	</div>
	<div class="page-break"></div>
	@endforeach
</body>
</html>