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
		$clientes = Cliente::all('id','nome');
		$solicitantes = Solicitante::all('id','nome');
		return view('guia.cadastrar', compact('areas','processos','solicitantes','clientes'));
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

		$data = [
			'data_limite' => date('Y-m-d', strtotime($request->data_limite)),
			'prioridade' => $request->prioridade,
			'observacao' => $request->observacao,
			'reclamante' => $request->reclamante,
			'perfil_pagamento' => $request->perfil_pagamento,
			'banco' => $request->banco,
			'valor' => $request->valor,
			'solicitacoes_id' => $id,
			'tipo_guias_id' => $request->tipo_guias_id,
		];
		$mime = $request->file('anexo_guia')->getClientMimeType();
		if ($mime == "image/jpeg" || $mime == "image/jpg") {
			$file = Image::make($request->file('anexo_guia'));
			$file->widen(1280, function ($constraint) {
				$constraint->upsize();
			});
			$img_64 = (string) $file->encode('data-url');
			$data['anexo_guia'] = $img_64;
		}else{
			\Session::flash('flash_message',[
				'msg'=>"Arquivo não suportado!!!",
				'class'=>"alert bg-orange alert-dismissible"
			]);
			return redirect()->route('guia.editar',$id);
		}
		$guia = Guia::create($data);

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
		// $solicitacao = Solicitacao::with('guia')
		// ->where('tipo',config('constantes.tipo_guia'))
		// ->where('id',$id)
		// ->first();
		$solicitacao = Solicitacao::with(['guia' => function($q){
			$q->with(['tipoGuia'])->select('id','prioridade','observacao','reclamante','perfil_pagamento','banco','valor','tipo_guias_id','solicitacoes_id')->get();
		}])->where('tipo',config('constantes.tipo_guia'))
		->where('id',$id)
		->first();
		//dd($solicitacao);
		if (!$solicitacao) {
			\Session::flash('flash_message',[
				'msg'=>"Solicitação não cadastrada!",
				'class'=>"alert bg-yellow alert-dismissible"
			]);
			return redirect()->route('user.index'); 
		}
		return view('guia.analiseGuia', compact('solicitacao'));

	}
	
    //Retorna a View de edição da unidade
	public function editar($soli)
	{
		$solicitacao = $soli;	
		$areas = AreaAtuacao::all('id','tipo'); 
		$tipo_guia = TipoGuia::all('id','tipo','descricao')->groupBy('tipo');
		$clientes = Cliente::all('id','nome');
		return view('guia.editar', compact('solicitacao','clientes','areas','tipo_guia'));
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
		
		$guia->data_limite = date('Y-m-d', strtotime($request->data_limite));
		$guia->prioridade = $request->prioridade;
		$guia->observacao = $request->observacao;
		$guia->reclamante = $request->reclamante;
		$guia->perfil_pagamento > $request->perfil_pagamento;
		$guia->banco = $request->banco;
		$guia->valor = $request->valor;
		$guia->tipo_guias_id = $request->tipo_guias_id;
		
		if ($request->file('anexo_guia')) {
			$mime = $request->file('anexo_guia')->getClientMimeType();
			if ($mime == "image/jpeg" || $mime == "image/jpg") {
				$file = Image::make($request->file('anexo_guia'));
				$file->widen(1280, function ($constraint) {
					$constraint->upsize();
				});
				$img_64 = (string) $file->encode('data-url');
				$guia->anexo_guia = $img_64;
			}else{

				\Session::flash('flash_message',[
					'msg'=>"Arquivo não suportado!!!",
					'class'=>"alert bg-orange alert-dismissible"
				]);
				return redirect()->back();
			}
		}
		$guia->save();

		\Session::flash('flash_message',[
			'msg'=>"Guia Atualizada com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->route('guia.editar', $guia->solicitacoes_id);
	}
	public function addComprovante(Request $request,$id)
	{
		$guia = Guia::find($id);
		if ($request->file('anexo_comprovante')) {
			$mime = $request->file('anexo_comprovante')->getClientMimeType();
			if ($mime == "image/jpeg" || $mime == "image/jpg") {
				$file = Image::make($request->file('anexo_comprovante'));
				$file->widen(1280, function ($constraint) {
					$constraint->upsize();
				});
				$img_64 = (string) $file->encode('data-url');
				$guia->anexo_comprovante = $img_64;
			}else{

				\Session::flash('flash_message',[
					'msg'=>"Arquivo não suportado!!!",
					'class'=>"alert bg-orange alert-dismissible"
				]);
				return redirect()->back();
			}
		}
		$guia->data_comprovante = date('Y-m-d',strtotime($request->data_comprovante));
		$guia->save();

		\Session::flash('flash_message',[
			'msg'=>"Comprovante adicionado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->back();
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
