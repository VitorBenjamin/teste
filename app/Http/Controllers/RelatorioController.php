<?php
namespace App\Http\Controllers;

use App\Http\Helpers\SolicitacaoHelper;
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
use DB;
use PDF;

class RelatorioController extends Controller
{
	//Buscando todas as informações das solicitacao e enviando para a view de listagem das solicitacao
	public function relatorioIndividual($id)
	{
		$lista = array();
		$solicitacaoHelper = new SolicitacaoHelper();
		$solicitacao = Solicitacao::find($id);
		$lista = $solicitacaoHelper->impressao($solicitacao,$lista);
		usort($lista, function($a, $b) {
			return $a['data'] <=> $b['data'];
		});
        //dd($lista);
		$nome = $solicitacao->cliente ? $solicitacao->cliente->nome : 'Mosello Lima';
		$pdf = PDF::loadView('layouts._includes.impressao.impressao',compact('solicitacao','lista'));
		return $pdf->stream('Relátorio '.$nome.'.pdf');
		//return view('layouts._includes.impressao.impressao', compact('solicitacao','lista'));
	}
	//Buscando todas as informações das solicitacao e enviando para a view de listagem das solicitacao
	public function relatorioGeral($id)
	{
		$lista = array();
		$solicitacaoHelper = new SolicitacaoHelper();
		$solicitacoes = Solicitacao::where('relatorios_id',$id)->get();
		foreach ($solicitacoes as $s) {
			$lista = $solicitacaoHelper->impressao($s,$lista);
		}
		usort($lista, function($a, $b) {
			return strtotime($a['data']) - strtotime($b['data']);
		});
		//dd($lista);
		//dd($solicitacoes[0]->cliente->nome);
        //$nome = $solicitacao->cliente ? $solicitacao->cliente->nome : 'Mosello Lima';
		$pdf = PDF::loadView('layouts._includes.impressao.impressao_cliente',compact('solicitacoes','lista'));
		return $pdf->stream('Relátorio Geral.pdf');
		//return view('layouts._includes.impressao.impressao', compact('solicitacao','lista'));
	}
	public function listagem()
	{
		$clientes = Cliente::all('id','nome');
		$relatorios_abertos = Relatorio::where('finalizado',false)->orderBy('id','desc')->get();
		$relatorios = Relatorio::where('finalizado',true)->orderBy('id','desc')->get();
		//dd($relatorios);
		// if (count($relatorios) > 0) {
		// 	$data_inicial = $relatorios[0]->data;

		// }else{
		// 	$data_inicial = '2018-01-01';
		// }
		return view('relatorio.listagem', compact('clientes','relatorios','relatorios_abertos'));
	}
	public function getData(Request $data)
	{
		$relatorio = Relatorio::where('finalizado',true)
		->where('clientes_id',$data->data)
		->orderBy('id','desc')->first();
		
		if ($relatorio) {
			
			$data_inicial = $relatorio->data;
		}else{
			$data_inicial = $data_inicial = '2018-01-01';
		}
		//dd($relatorios);
		return response()->json($data_inicial);
	}
	public function extornar(Request $id)
	{
		if ($request->desativar) {
			foreach ($request->desativar as $i) {
				$partes = explode("-",$i);
				$gasto = $partes[1]::find($partes[0]);
				$gasto->estornado = 1;
				$gasto->save();
			}
		}
		if ($request->_desativar) {
			foreach ($request->_desativar as $i) {
				$partes = explode("-",$i);
				$gasto = $partes[1]::find($partes[0]);
				$gasto->estornado = 0;
				$gasto->save();
			}
		}

		\Session::flash('flash_message',[
			'msg'=>"Relátorio Alterado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);

		return redirect()->back();
	}
	public function visualizar($id)
	{
		$exibir = false;
		$relatorio = Relatorio::find($id);
		if (!$relatorio) {
			\Session::flash('flash_message',[
				'msg'=>"Relátorio Inexistente!!!",
				'class'=>"alert bg-red alert-dismissible"
			]);

			return redirect()->route('relatorio.listar');
		} 
		
		$ultimo_relatorio = Relatorio::where('clientes_id',$relatorio->clientes_id)
		->where('id', '<' , $relatorio->id)
		->select('data')
		->first();
		$solicitacoes = Solicitacao::where('relatorios_id',$id)->get();
		$data_inicial = '2018-01-01';
		if ($ultimo_relatorio!=null) {
			$data_inicial = $ultimo_relatorio->data;
		}
		
		return view('relatorio.visualizar', compact('solicitacoes','relatorio','data_inicial','exibir'));
	}
	public function editar($id)
	{
		$exibir = true;
		$relatorio = Relatorio::find($id);
		$ultimo_relatorio = Relatorio::where('clientes_id',$relatorio->clientes_id)
		->where('id', '<' , $relatorio->id)
		->select('data')
		->first();
		$solicitacoes = Solicitacao::where('relatorios_id',$id)->get();
		$data_inicial = '2018-01-01';
		if ($ultimo_relatorio!=null) {
			$data_inicial = $ultimo_relatorio->data;
		}
		return view('relatorio.editar', compact('solicitacoes','relatorio','data_inicial','exibir'));
	}
	public function finalizar($id)
	{
		$relatorio = Relatorio::find($id);
		$relatorio->finalizado = true;
		$relatorio->save();
		$solicitacoes = Solicitacao::where('relatorios_id',$id)->get();

		return redirect()->route('relatorio.visualizar',$id);
	}
	public function previa(Request $request)
	{
		$exibir = true;
		$cliente = Cliente::find($request->clientes_id);
		$ultimo_relatorio = Relatorio::orderBy('id', 'desc')
		->where('clientes_id',$request->clientes_id)
		->select('data')
		->first();

		$data_inicial = $request->data_inicial;
		$data_final = date('Y-m-d', strtotime($request->data_final));
		if ($ultimo_relatorio==null) {
			$solicitacoes= Solicitacao::where('clientes_id',$request->clientes_id)
			->where('data_finalizado','<=',$data_final)
			->get();
		}else{
			$data_inicial = $ultimo_relatorio->data;
			$solicitacoes = Solicitacao::where('clientes_id',$request->clientes_id)
			->whereBetween('data_finalizado', array($data_inicial,$data_final))
			->get();
		}
		//dd($solicitacoes);
		$repo = new SolicitacaoRepository();
		$solicitacoes = $repo->valorTotal($solicitacoes);
		
		return view('relatorio.previa', compact('solicitacoes','cliente' ,'data_inicial','data_final','exibir'));
	}

	public function salvarRelatorio(Request $request)
	{
		//$cliente = Cliente::find($request->clientes_id);
		$ultimo_relatorio = Relatorio::orderBy('id', 'desc')
		->where('clientes_id',$request->clientes_id)
		->select('data')
		->first();

		$relatorio = Relatorio::create([
			'data' => $request->data_final,
			'users_id' => auth()->user()->id,
			'clientes_id' => $request->clientes_id,
		]);
		if ($ultimo_relatorio==null) {
			Solicitacao::where('clientes_id',$request->clientes_id)
			->where('data_finalizado','<=',date('Y-m-d', strtotime($request->data_final)))
			->update(['relatorios_id' => $relatorio->id]);
		}else{
			Solicitacao::where('clientes_id',$request->clientes_id)
			->whereBetween('data_finalizado',array($ultimo_relatorio,date('Y-m-d', strtotime($request->data_final))))
			->update(['relatorios_id' => $relatorio->id]);
		}
		return redirect()->route('relatorio.editar', $relatorio->id);
	}
	public function deletar($id)
	{
		$relatorio = Relatorio::find($id);
		if (!$relatorio) {
			\Session::flash('flash_message',[
				'msg'=>"Relátorio Inexistente!!",
				'class'=>"alert bg-red alert-dismissible"
			]);
			return redirect()->route('relatorio.listar');
		}
		if ($relatorio->finalizado) {
			\Session::flash('flash_message',[
				'msg'=>"Relátorio Finalizado! NÃO E PERMITIDO A SUA EXCLUSÃO!!!",
				'class'=>"alert bg-red alert-dismissible"
			]);
			return redirect()->route('relatorio.listar');
		}
		$solicitacoes = Solicitacao::where('relatorios_id',$id)->get();
		foreach ($solicitacoes as $s) {
			$s->relatorios_id = null;
			$s->save();
		}
		$relatorio->delete();

		\Session::flash('flash_message',[
			'msg'=>"Relátorio deletado com Sucesso!!!",
			'class'=>"alert bg-red alert-dismissible"
		]);
		return redirect()->route('relatorio.listar');
	}
}
