<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SolicitacaoHelper;
use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use App\Processo;
use App\Antecipacao;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;
use App\Status;

class AntecipacaoController extends Controller
{
    //Retorna a View de cadastro da unidade
	public function cadastrar()
	{
		$areas = AreaAtuacao::all('id','tipo');
		$processos = Processo::all();
		return view('antecipacao.cadastrar', compact('areas','processos')); 
	}

    //Cadatra uma nova Solicitação e redireciona para a tela de edição
	public function salvar(SolicitacaoRequest $request)
	{   
		$repo = new SolicitacaoRepository();
		$solicitacao = $repo->create($request,config('constantes.tipo_antecipacao'));

		\Session::flash('flash_message',[
			'msg'=>"Cadastro do ".$solicitacao->tipo." Realizado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);

		return redirect()->route('antecipacao.editar', $solicitacao->id);
	}
	

	public function veriicarSolicitacao($id)
	{
		$solicitacao = Solicitacao::with('antecipacao')
		->where('tipo',config('constantes.tipo_antecipacao'))
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

		$solicitacao = Solicitacao::with('antecipacao','cliente','solicitante','processo','area_atuacao')->where('id',$id)->first();
        //dd($solicitacao);

		return view('coordenador.analiseAntecipacao', compact('solicitacao'));

	}

    //Retorna a View de edição da unidade
	public function editar($soli)
	{
		$solicitacao = $soli;
		$cliente = Cliente::where('id',$solicitacao->clientes_id)->select('id','nome')->get();
		$areas = AreaAtuacao::all('id','tipo'); 
		$solicitante = Solicitante::where('id',$solicitacao->solicitantes_id)->select('id','nome')->get();

		return view('antecipacao.editar', compact('solicitacao','cliente','areas','solicitante'));
	}

    //Atualiza uma antecipacao e redireciona para a tela de edição da Solicitação
	public function atualizarAntecipacao(Request $request,$id)
	{   
		$antecipacao = Antecipacao::find($id);

		$antecipacao->update(
			[   
				'data_recebimento' => $request->data_recebimento,
				'descricao' => $request->descricao,
				'valor_solicitado' => $request->valor_solicitado,                
			]
		);

		\Session::flash('flash_message',[
			'msg'=>"antecipacao Atualizada com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->route('antecipacao.editar', $antecipacao->solicitacoes_id);
	}
	public function addAntecipacao(Request $request,$id){
		
		Antecipacao::create([
			'data_recebimento' => $request->data_recebimento,
			'descricao' => $request->descricao,
			'valor_solicitado' => $request->valor_solicitado,
			'solicitacoes_id' => $id,
		]);
		\Session::flash('flash_message',[
			'msg'=>"Produto Cadastrado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->route('antecipacao.editar',$id);
	}
	//Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
	public function deletarAntecipacao($id)
	{        

		$antecipacao = Antecipacao::find($id);
		$s_id = $antecipacao->solicitacoes_id;
		$antecipacao->delete();
		\Session::flash('flash_message',[
			'msg'=>"Antecipação Removida com Sucesso!!!",
			'class'=>"alert bg-red alert-dismissible"
		]);
		return redirect()->route('antecipacao.editar',$s_id);       
	}
    //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
	public function atualizar(Request $request,$id)
	{   
		$repo = new SolicitacaoRepository();
		$solicitacao = $repo->update($request,$id);

		\Session::flash('flash_message',[
			'msg'=>"Solicitação Atualizada com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->route('antecipacao.editar',$id);
	}
}
