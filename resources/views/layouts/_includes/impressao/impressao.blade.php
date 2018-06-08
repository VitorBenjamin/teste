<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Relátorio Geral - {{$solicitacao->cliente->nome}}</title>
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
	<div id="footer">
		<img src="{{ asset('images/rodape.jpg') }}" alt="" class="img-rodape">
	</div>
	<div class="container">
		<div class="top-left">Solicitante : {{ $solicitacao->user->nome }}</div>
	</div>
	<div class="divTable" style="width: 100%;">
		<div class="divTableBody">
			<div class="divTableRow" style="background-color: #fff !important">
				<div class="divTableCell2">{{ $solicitacao->origem_despesa }}</div>
				<div class="divTableCell2"><strong>Cliente:</strong> {{$solicitacao->cliente == null ? 'Mosello Lima' : $solicitacao->cliente->nome }} - Km R$ {{ $solicitacao->cliente->valor_km }}</div>
				<div class="divTableCell2"><strong>Solicitante:</strong> {{$solicitacao->solicitante == null ? 'Desconhecido' : $solicitacao->solicitante->nome }}</div>
			</div>
		</div>
	</div>
	<div class="divTable" style="width: 100%; margin-bottom: 50px;">
		<div class="divTableBody">
			<div class="divTableRow" style="background-color: #fff !important">
				<div class="divTableCell2"><strong>N° de Processo: </strong>{{$solicitacao->processo == null ? 'Sem Processo' : $solicitacao->processo->codigo }}</div>
				<div class="divTableCell2"><strong>Área :</strong> {{$solicitacao->area_atuacao->tipo}}</div>
				<div class="divTableCell2"><strong>Contrato:</strong> {{ $solicitacao->contrato ? $solicitacao->contrato : 'Desconhecido'}}</div>
			</div>
		</div>
	</div>
	<h3>Listagem - {{$solicitacao->tipo}} - {{$solicitacao->codigo}}</h3>
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
				<div class="divTableCell-red" style="width: 50px;">&nbsp;{{$l['data']}}</div>
				<div class="divTableCell-red" style="width: 30px;">&nbsp;{{$l['codigo']}}</div>
				<div class="divTableCell-red">&nbsp;{{$l['descricao']}}</div>
				<div class="divTableCell-red" style="width: 55px;">&nbsp;R$ -{{number_format($l['valor'], 2, ',', '.')}}</div>
			</div>
			@else
			<div class="divTableRow" style="background-color: #fff !important">
				<div class="divTableCell" style="width: 50px;">&nbsp;{{$l['data']}}</div>
				<div class="divTableCell" style="width: 30px;">&nbsp;{{$l['codigo']}}</div>
				<div class="divTableCell">&nbsp;{{$l['descricao']}}</div>
				<div class="divTableCell" style="width: 55px;">&nbsp;R$ {{number_format($l['valor'], 2, ',', '.')}}</div>
			</div>
			@endif
			@endforeach
		</div>
	</div>
	<div style="float:right;">
		<p style="font-size:10px; margin: 2;" >
			Total Estornos R$ {{number_format($estornos, 2, ',', '.')}} <br>
			Total Geral R$ {{number_format($geral, 2, ',', '.')}} <br>
		</p>
		<h4 style="margin: 2;">
			Total Final R$ {{number_format($total, 2, ',', '.')}}
		</h4>
	</div>
	@foreach ($lista as $key => $li)
	@if ($li['exibir'] && !$li['estornado'] && $li['img'])
	<div class="page-break"></div>
	<table class="table2">
		<caption>
			Comprovantes - {{$solicitacao->tipo}} - {{$solicitacao->codigo}}
		</caption>
		<thead>
			<tr>
				<th scope="col">DATA</th>
				{{-- <th scope="col">CÓDIGO</th> --}}
				<th scope="col">DESCRIÇÃO</th>
				<th scope="col">VALORES</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					{{$li['data']}}
				</td>
				{{-- <td>
					{{$solicitacao->codigo}}
				</td> --}}
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
	@if($solicitacao->tipo == "GUIA")
	<div class="page-break"></div>
	<table class="table2">
		<caption>
			Comprovantes - {{$solicitacao->tipo}} - {{$solicitacao->codigo}}
		</caption>
		<thead>
			<tr>
				<th scope="col">DATA</th>
				{{-- <th scope="col">CÓDIGO</th> --}}
				<th scope="col">DESCRIÇÃO</th>
				<th scope="col">VALORES</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					{{$li['data']}}
				</td>
				{{-- <td>
					{{$solicitacao->codigo}}
				</td> --}}
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