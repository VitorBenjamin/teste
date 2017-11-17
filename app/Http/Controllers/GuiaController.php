<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SolicitacaoHelper;
use App\Http\Requests\SolicitacaoRequest;
use App\Http\Requests\GuiaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use App\Processo;
use App\Guia;
use App\TipoGuia;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;
use App\Status;

class GuiaController extends Controller
{
    //Retorna a View de cadastro da unidade
	public function cadastrar()
	{
		$areas = AreaAtuacao::all('id','tipo');
		$processos = Processo::all();
		return view('guia.cadastrar', compact('areas','processos'));  	
	}

    //Cadatra uma nova Solicitação e redireciona para a tela de edição
	public function salvar(SolicitacaoRequest $request)
	{   
		$repo = new SolicitacaoRepository();
		$solicitacao = $repo->create($request,config('constantes.tipo_guia'));

		\Session::flash('flash_message',[
			'msg'=>"Cadastro do ".$solicitacao->tipo." Realizado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
			]);

		return redirect()->route('guia.editar', $solicitacao->id);
	}
	public function addGuia(GuiaRequest $request,$id){
		//dd($request->all());

		$today = (string) date("Y-m-d H-i");
		$fileName = $today.'_'.$id.'_'.$request->anexo_pdf->getClientOriginalName();	
		$request->anexo_pdf->storeAs('public/guias',$fileName);
		$guia = Guia::create([
			'data_limite' => $request->data_limite,
			'prioridade' => $request->prioridade,
			'observacao' => $request->observacao,
			'reclamante' => $request->reclamante,
			'perfil_pagamento' => $request->perfil_pagamento,
			'banco' => $request->banco,
			'valor' => $request->valor,
			'anexo_pdf' => $fileName,
			'solicitacoes_id' => $id,
			'tipo_guias_id' => $request->tipo_guias_id,

			]);

		\Session::flash('flash_message',[
			'msg'=>"Guia Cadastrada com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
			]);
		return redirect()->route('guia.editar',$id);
	}
	public function verificarSolicitacao($id)
	{
		$solicitacao = Solicitacao::with('guia')
		->where('tipo',config('constantes.tipo_guia'))
		->where('id',$id)
		->first();
		$solicitacaoHelper = new SolicitacaoHelper();
		$exist = $solicitacaoHelper->solicitacaoExist($solicitacao,config('constantes.tipo_reembolso'));
		if ($exist == "ok") 
		{
			$verificarStatus = $solicitacaoHelper->verificarStatus($solicitacao);
			if ($verificarStatus == "ok") 
			{
				return $this->editar($solicitacao);           
			}else{
				return $solicitacaoHelper->verificarStatus($solicitacao);
			}

		}else{
			return $exist;
		}
	}

	public function analisar($id)
	{

		$solicitacao = Solicitacao::with('guia','cliente','solicitante','processo','area_atuacao')->where('id',$id)->first();
        //dd($solicitacao);

		return view('coordenador.analiseGuia', compact('solicitacao'));

	}

    //Retorna a View de edição da unidade
	public function editar($soli)
	{
		$solicitacao = $soli;		
		// $solicitacao = DB::table('solicitacoes')
		// ->join('guias','solicitacoes.id','guias.solicitacoes_id')
		// ->join('tipo_guias','guia.tipo_guias_id','tipo_guias.id')
		// ->get();
		// dd($solicitacao);
		// foreach ($solicitacao->guia as $guia ) {
		// 	dd($guia->tipoGuia()->first()->id);
		// }
		$cliente = Cliente::where('id',$solicitacao->clientes_id)->select('id','nome')->get();
		$areas = AreaAtuacao::all('id','tipo'); 
		$solicitante = Solicitante::where('id',$solicitacao->solicitantes_id)->select('id','nome')->get();
		$tipo_guia = TipoGuia::all('id','tipo','descricao')->groupBy('tipo');

		return view('guia.editar', compact('solicitacao','cliente','areas','solicitante','tipo_guia'));
	}


	public function editarGuia($id)
	{
		$guia = Guia::find($id);
		$tipo_guia = TipoGuia::all('id','tipo','descricao')->groupBy('tipo');
		
		return view('guia.editarGuia', compact('guia','tipo_guia'));
	}
    //Atualiza uma guia e redireciona para a tela de edição da Solicitação
	public function atualizarGuia(Request $request,$id)
	{   
		$guia = Guia::find($id);

		if ($request->hasFile('anexo_pdf')) {
			$today = (string) date("Y-m-d H-i");
			$fileName = $today.'_'.$id.'_'.$request->anexo_pdf->getClientOriginalName();	
			$request->anexo_pdf->storeAs('public/guias',$fileName);
		}else{
			$fileName = $guia->anexo_pdf;
		}
		$guia->update(
			[   
			'data_limite' => $request->data_limite,
			'prioridade' => $request->prioridade,
			'observacao' => $request->observacao,
			'reclamante' => $request->reclamante,
			'perfil_pagamento' => $request->perfil_pagamento,
			'banco' => $request->banco,
			'anexo_pdf' => $fileName,
			'valor' => $request->valor 
			]
			);

		\Session::flash('flash_message',[
			'msg'=>"Guia Atualizada com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
			]);
		return redirect()->route('guia.editar', $guia->solicitacoes_id);
	}
	//Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
	public function deletarGuia($id)
	{        

		$guia = Guia::find($id);
		$s_id = $guia->solicitacoes_id;
		$guia->delete();
		\Session::flash('flash_message',[
			'msg'=>"Guia Removida com Sucesso!!!",
			'class'=>"alert bg-red alert-dismissible"
			]);
		return redirect()->route('guia.editar',$s_id);       
	}
    //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
	public function atualizarCabecalho(Request $request,$id)
	{   
		$repo = new SolicitacaoRepository();
		$solicitacao = $repo->update($request,$id);

		\Session::flash('flash_message',[
			'msg'=>"Solicitação Atualizada com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
			]);
		return redirect()->route('guia.editar',$id);
	}
}
