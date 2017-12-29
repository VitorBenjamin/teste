<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use App\Relatorio;
use App\Cliente;
use App\Solicitacao;
use App\Hospedagem;
use App\Locacao;
use App\Despesa;
use App\Translado;
use App\Viagem;
use App\Guia;
use App\Antecipacao;

class RelatorioController extends Controller
{

	public function relatorio()
	{
		$clientes = Cliente::all('id','nome');
		$relatorios = Relatorio::all();

		return view('relatorio.gerarRelatorio', compact('clientes','relatorios'));
	}
	public function extornar(Request $request)
	{
		//dd($request->all());
		foreach ($request->desativar as $i) {
			$partes = explode("-",$i);
			//dd($partes);
			$gasto = $partes[1]::find($partes[0]);
			
			//dd($gasto);
			if ($gasto->estornado == 1) {
				//dd('1');
				$gasto->estornado = 0;
				$gasto->save();
			} else {
				//dd('2');
				$gasto->estornado = 1;
				$gasto->save();
			}
		}

		\Session::flash('flash_message',[
			'msg'=>"Relátorio Alterado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);

		return redirect()->back();
	}
	public function gerarRelatorio(Request $request)
	{
		//dd($request->all());
		//$teste = "Cliente";
		//dd($teste::find(1));
		$cliente = Cliente::find($request->clientes_id);
		//dd($request->all());
		$ultimo_relatorio = Relatorio::orderBy('id', 'desc')
		->where('clientes_id',$request->clientes_id)
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


		return view('relatorio.relatorio', compact('solicitacoes','cliente'));
	}
}
