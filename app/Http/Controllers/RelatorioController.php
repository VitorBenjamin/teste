<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use App\Relatorio;
use App\Cliente;
use App\Solicitacao;

class RelatorioController extends Controller
{

	public function relatorio()
	{
		$clientes = Cliente::all('id','nome');

		return view('relatorio.gerarRelatorio', compact('clientes'));
	}
	public function gerarRelatorio(Request $request)
	{
		//dd($request->all());
		$cliente = Cliente::find($request->cliente_id);
		$ultimo_relatorio = Relatorio::orderBy('id', 'desc')
		->select('data')
		->first();
		//dd($ultimo_relatorio);
		if ($ultimo_relatorio==null) {
			$solicitacoes= Solicitacao::where('clientes_id',$request->clientes_id)
			->where('data_finalizado','<=',date('Y-m-d', strtotime($request->data_final)))
			->get();
		}else{
			$solicitacoes = Solicitacao::where('clientes_id',$request->clientes_id)
			->whereBetween('data_finalizado',array($ultimo_relatorio,date('Y-m-d', strtotime($request->data_final))))
			->get();
		}
		//dd($solicitacoes);
		
		$repo = new SolicitacaoRepository();
		$solicitacoes = $repo->valorTotal($solicitacoes);
		//dd($solicitacoes);


		return view('relatorio.relatorio', compact('solicitacoes'));
	}
}
