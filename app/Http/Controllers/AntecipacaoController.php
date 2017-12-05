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
		$clientes = Cliente::all('id','nome');
		$solicitantes = Solicitante::all('id','nome');
		return view('antecipacao.cadastrar', compact('areas','processos','solicitantes','clientes'));
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
	

	public function verificarSolicitacao($id)
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

	public function addComprovante(Request $request,$id)
	{
		$file = Image::make($request->file('anexo_comprovante'))->resize(1200, 600);
		$img_64 = (string) $file->encode('data-url');
		$antecipacao = Antecipacao::find($request->antecipacao_id);

		$antecipacao->update(['anexo_comprovante' => $img_64]);

		\Session::flash('flash_message',[
			'msg'=>"Comprovante da Antecipação Cadastrado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->route('antecipacao.analisar',$id);

	}

	//Adcionar uma nova despesa a solicitação
	public function addDespesa(Request $request,$id)
	{
		$solicitacao = Solicitacao::find($id);

		$file = Image::make($request->file('anexo_comprovante'))->resize(1200, 600);
		$img_64 = (string) $file->encode('data-url');
		$despesa = Despesa::create(
			[   
				'descricao' => $request->descricao,
				'data_despesa' => date('Y-m-d', strtotime($request->data_despesa)),
				'tipo_comprovante' => $request->tipo_comprovante,
				'valor' => $request->valor,
				'anexo_comprovante' => $img_64,
				'solicitacoes_id' => $solicitacao->id,
			]
		);

		\Session::flash('flash_message',[
			'msg'=>"Cadastro da Despesa Realizado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);

		return redirect()->route('antecipacao.editar',$id);
	}
	public function editarDespesa($id)
	{   
		$despesa = Despesa::find($id);

		return view('antecipacao.despesa', compact('despesa'));
	}

    //Atualiza uma Despesa e redireciona para a tela de edição da Solicitação
	public function atualizarDespesa(Request $request,$id)
	{   
		$despesa = Despesa::find($id);
		if ($request->hasFile('anexo_comprovante')) {
			$file = Image::make($request->file('anexo_comprovante'))->resize(1200, 600);            
			$img_64 = (string) $file->encode('data-url');
		}else{
			$img_64 = $despesa->anexo_comprovante;
		}

		$despesa->update(
			[   
				'descricao' => $request->descricao,
				'data_despesa' => date('Y-m-d', strtotime($request->data_despesa)),
				'tipo_comprovante' => $request->tipo_comprovante,
				'valor' => $request->valor,
				'anexo_comprovante' => $img_64,
			]
		);

		\Session::flash('flash_message',[
			'msg'=>"Despesa Atualizada com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->route('antecipacao.editar', $despesa->solicitacoes_id);
	}
    //Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
	public function deletarDespesa($id)
	{

		$despesa = Despesa::find($id);
		$s_id = $despesa->solicitacoes_id;
		$despesa->delete();
		\Session::flash('flash_message',[
			'msg'=>"Despesas Removida com Sucesso!!!",
			'class'=>"alert bg-red alert-dismissible"
		]);
		return redirect()->route('antecipacao.editar',$s_id);       
	}
	public function analisar($id)
	{

		$solicitacao = Solicitacao::with('antecipacao','cliente','solicitante','processo','area_atuacao')->where('id',$id)->first();
        //dd($solicitacao);

		return view('antecipacao.analiseAntecipacao', compact('solicitacao'));

	}

    //Retorna a View de edição da unidade
	public function editar($soli)
	{
		$solicitacao = $soli;
		$areas = AreaAtuacao::all('id','tipo'); 
		$clientes = Cliente::all('id','nome');
		$solicitantes = Solicitante::all('id','nome');

		return view('antecipacao.editar', compact('solicitacao','clientes','areas','solicitantes'));
	}

    //Atualiza uma antecipacao e redireciona para a tela de edição da Solicitação
	public function atualizarAntecipacao(Request $request,$id)
	{   
		$antecipacao = Antecipacao::find($id);

		$antecipacao->update(
			[   
				'data_recebimento' => date('Y-m-d', strtotime($request->data_recebimento)),
				'descricao' => $request->descricao,
				'valor' => $request->valor,                
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
			'data_recebimento' => date('Y-m-d', strtotime($request->data_recebimento)),
			'descricao' => $request->descricao,
			'valor' => $request->valor,
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
