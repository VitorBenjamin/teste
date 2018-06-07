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
	<script src="{{ asset('js/impresao.js') }}"></script>
</head>
<body>	
	<div style="text-align:center" class="head">
		<img src="{{ asset('images/LOGO-01.png') }}" alt="" class="img-topo" style="margin: 10px; 0 50px 0">
	</div>
	<div class="divTable" style="width: 100%; margin:15px 0">
		<div class="divTableBody">
			<div class="divTableRow">
				<div class="divTableCell2">
				</div>
				<div class="divTableCell2" style="text-align:right">
					<h4>Valor Km: {{$solicitacoes[0]->cliente ? 'R$ '.$solicitacoes[0]->cliente->valor_km : 'R$ 1.00' }}</h4>
				</div>
			</div>
		</div>
	</div>
	<div class="divTable" style="width: 100%; margin:15px 0">
		<div class="divTableBody">
			<div class="divTableRow">
				<div class="divTableCell2">
					<h3>RELÁTORIO GERAL {{$solicitacoes[0]->cliente ? $solicitacoes[0]->cliente->nome : 'Mosello Lima' }}</h3>
				</div>
				<div class="divTableCell2" style="text-align:right">
					<h3>
						<?php 
						setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
						date_default_timezone_set('America/Sao_Paulo'); 
						Período: echo strtoupper(strftime('%B de %Y', strtotime($solicitacoes[0]->relatorio->data)));
						?>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<!-- <div>
		<h3>RELÁTORIO GERAL sPeríodo: {{ date('d-m-Y',strtotime($data_inicial)) }} - {{ $solicitacoes[0]->relatorio->data }}</h3>
	</div> -->
	<div class="divTable" style="width: 100%;">
		<div class="divTableHeading">
			<div class="divTableRow">
				<div class="divTableHead">DATA</div>
				<div class="divTableHead">CÓDIGO</div>
				<div class="divTableHead">DESCRIÇÃO</div>
				<div class="divTableHead">VALORES</div>
			</div>
		</div>
		<div class="divTableBody">
			@foreach($lista as $i => $l)
			@if ($l['estornado'])
			<div class="divTableRow" style="background-color: #fff !important">
				<div class="divTableCell-red" style="width: 50px;">{{$l['data']}}</div>
				<div class="divTableCell-red" style="width: 50px;">{{$l['codigo']}}</div>
				<div class="divTableCell-red">{{$l['descricao']}}</div>
				<div class="divTableCell-red" style="width: 50px;">R$ -{{number_format($l['valor'], 2, ',', '.')}}</div>
			</div>
			@else
			<div class="divTableRow" style="background-color: #fff !important">
				<div class="divTableCell"style="width: 50px;">{{$l['data']}}</div>
				<div class="divTableCell"style="width: 30px;">{{$l['codigo']}}</div>
				<div class="divTableCell">{{$l['descricao']}}</div>
				<div class="divTableCell" style="width: 55px;">R$ {{number_format($l['valor'], 2, ',', '.')}}</div>
			</div>
			@endif
			@endforeach
		</div>
	</div>
	<div style="float:right;">
		<p style="font-size:10px; margin: 2px;" >
			Total Estornos R$ {{number_format($estornos, 2, ',', '.')}} <br>
			Total Geral R$ {{number_format($geral, 2, ',', '.')}} <br>
		</p>
		<h4 style="margin: 2px;">
			Total Final R$ {{number_format($total, 2, ',', '.')}}
		</h4>
	</div>
	@foreach ($lista as $k => $li)
	@if ($li['exibir'] && !$li['estornado'] && $li['img'])
	<div class="page-break"></div>
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
	@if($li[tipo] == "GUIA")
	<div class="page-break"></div>
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
		@if ($li['imgC'])
		<img src="{{$li['imgC']}}" alt="" class="img">
		@endif
	</div>
	@endif
	@endif
	@endforeach
</body>
</html>