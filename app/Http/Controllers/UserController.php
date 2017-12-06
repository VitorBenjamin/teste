<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\User;
use App\AreaAtuacao; 
use App\Unidade; 
use App\Limite;


class UserController extends Controller
{


	public function index()
	{
		
		if (Auth::user()->hasRole(config('constantes.user_advogado'))) {

			$dash = redirect()->route('user.advogadoDash');
		} elseif (Auth::user()->hasRole(config('constantes.user_coordenador'))) {
			
			$dash = redirect()->route('user.coordenadorDash');
		} elseif (Auth::user()->hasRole(config('constantes.user_financeiro'))) {
			
			$dash = redirect()->route('user.financeiroDash');
		} elseif (Auth::user()->hasRole(config('constantes.user_administrativo'))) {
			
			$dash = redirect()->route('user.administrativoDash');
		}
		
		if(\Session::has('flash_message')){

			\Session::flash('flash_message',[
				'msg'=>\Session::get('flash_message')['msg'],
				'class'=>"alert bg-green alert-dismissible"

			]);
		}
		return $dash;
	}

	public function getAll()
	{
		$role = config('constantes.user_coordenador');
		$users = Role::with('user')->where('name', $role)->first();
		//
		return view('advogado.listagem',compact('users'));
	}

	public function edit($id)
	{
		$user = User::where('id',$id)->with('limites','area_atuacao','unidades')->first();
		foreach ($user->limites as $limite) {
			$limites[] = $limite->area_atuacoes_id;
			foreach ($limite->unidades as $unidade) {
				$limite_unidades[] = $unidade->id;
			}
		}
		
		$areas = AreaAtuacao::all(); 
		$unidades = Unidade::all(); 
		return view('advogado.editar',compact('user','areas','limites','limite_unidades','unidades'));
	}

	public function atualizar(Request $request,$id)
	{
		if ($request->password != "") {
			Validator::make($request->all(), [
				'password' => 'confirmed|min:6',
				'password-confirm' => 'required_if:password,!=,',
			])->validate();
		}
		
		$data = [
			'nome' => $request->nome,
			'email' => $request->email,
			'codigo' => 000,
			'cpf' => $request->cpf,
			'telefone' => $request->telefone ,
			'area_atuacoes_id' => $request->area_atuacoes_id,
			'unidades_id' => $request->unidades_id,
		];

		$user = User::where('id',$id)->update($data);
		$user->forceFill([
			'password' => bcrypt($password),
			'remember_token' => Str::random(60),
		])->save();
	}
	

	public function advogadoDash()
	{
		$repo = new SolicitacaoRepository();
		
		$abertas = $repo->getSolicitacaoAdvogado(config('constantes.status_aberto'));
		$abertasEtapa2 = $repo->getSolicitacaoAdvogado(config('constantes.status_aberto_etapa2'));

		if ($abertasEtapa2 !=null) {
			$abertas=$this->pushSolicitacao($abertas,$abertasEtapa2);
		}

		$andamentos = $repo->getSolicitacaoAdvogado(config('constantes.status_andamento'));
		$andamentos2 = $repo->getSolicitacaoAdvogado(config('constantes.status_andamento_etapa2'));
		if ($andamentos !=null) {
			$andamentos=$this->pushSolicitacao($andamentos,$andamentos2);
		}
		$recorrente = $repo->getSolicitacaoAdvogado(config('constantes.status_recorrente'));
		$andamento_recorrente = $repo->getSolicitacaoAdvogado(config('constantes.status_andamento_recorrente'));

		if ($recorrente !=null) {
			$andamentos=$this->pushSolicitacao($andamentos,$recorrente);
		}
		if ($andamento_recorrente !=null) {
			$andamentos=$this->pushSolicitacao($andamentos,$andamento_recorrente);
		}

		$aprovadas = $repo->getSolicitacaoAdvogado(config('constantes.status_aprovado'));
		$finalizadas = $repo->getSolicitacaoAdvogado(config('constantes.status_finalizado'));	
		$reprovados = $repo->getSolicitacaoAdvogado(config('constantes.status_reprovado'));
		$devolvidas = $repo->getSolicitacaoAdvogado(config('constantes.status_devolvido'));
		$devolvidas_etapa2 = $repo->getSolicitacaoAdvogado(config('constantes.status_devolvido_etapa2'));
		if ($devolvidas_etapa2 !=null) {
			$devolvidas=$this->pushSolicitacao($devolvidas,$devolvidas_etapa2);
		}
		return view('dashboard.advogado',compact('abertas','andamentos','aprovadas','reprovados','devolvidas','finalizadas'));
	}

	public function pushSolicitacao($solicitacoes,$pushSolici)
	{
		foreach ($pushSolici->solicitacao as $key => $value) {

			$solicitacoes->solicitacao->push($value);
		}
		return $solicitacoes;
	}

	public function coordenadorDash()
	{
		$repo = new SolicitacaoRepository();

		$abertas = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento'));

		$andamentos = $repo->getSolicitacaoAdvogado(config('constantes.status_andamento'));
		
		$andamentos_etapa2 = $repo->getSolicitacaoAdvogado(config('constantes.status_andamento_etapa2'));
		
		if ($andamentos_etapa2 !=null) {
			$andamentos=$this->pushSolicitacao($andamentos,$andamentos_etapa2);
		}
		$aprovadas = $repo->getSolicitacaoCoordenador(config('constantes.status_aprovado'));

		$coordenador_aprovado = $repo->getSolicitacaoAdvogado(config('constantes.status_aprovado'));
		if ($coordenador_aprovado !=null) {
			$aprovadas = $this->pushSolicitacao($aprovadas,$coordenador_aprovado);			
		}
		$coordenador_aprovado2 = $repo->getSolicitacaoAdvogado(config('constantes.status_aprovado_etapa2'));
		if ($coordenador_aprovado2 !=null) {
			$aprovadas = $this->pushSolicitacao($aprovadas,$coordenador_aprovado2);			
		}

		$aprovado_etapa2 = $repo->getSolicitacaoCoordenador(config('constantes.status_aprovado_etapa2'));
		if ($aprovado_etapa2 !=null) {
			$aprovadas = $this->pushSolicitacao($aprovadas,$aprovado_etapa2);			
		}
		$aprovadas_recorrente = $repo->getSolicitacaoCoordenador(config('constantes.status_aprovado_recorrente'));
		
		if ($aprovadas_recorrente !=null) {
			$aprovadas =$this->pushSolicitacao($aprovadas,$aprovadas_recorrente);			
		}
		$reprovados = $repo->getSolicitacaoCoordenador(config('constantes.status_reprovado'));		
		$devolvidas = $repo->getSolicitacaoCoordenador(config('constantes.status_devolvido'));

		$recorrentes = $repo->getSolicitacaoAdvogado(config('constantes.status_recorrente'));

		$andamento_recorrente = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento_recorrente'));
		
		if ($andamento_recorrente !=null) {
			$recorrentes = $this->pushSolicitacao($recorrentes,$andamento_recorrente);			
		}
		
		$meus = $repo->getSolicitacaoAdvogado(config('constantes.status_aberto'));
		$meus_etapa2 = $repo->getSolicitacaoAdvogado(config('constantes.status_aberto_etapa2'));
		if ($meus_etapa2 !=null) {
			$meus = $this->pushSolicitacao($meus,$meus_etapa2);			
		}
		$finalizadas = $repo->getSolicitacaoCoordenador(config('constantes.status_finalizado'));
		$finalizadas_meu =$repo->getSolicitacaoAdvogado(config('constantes.status_finalizado'));
		if ($finalizadas_meu !=null) {
			$finalizadas = $this->pushSolicitacao($recorrentes,$finalizadas_meu);			
		}
		return view('dashboard.coordenador',compact('abertas','andamentos','aprovadas','reprovados','devolvidas','recorrentes','finalizadas','meus'));
	}
	public function financeiroDash()
	{
		$repo = new SolicitacaoRepository();

		$abertas = $repo->getSolicitacaoFinanceiro(config('constantes.status_aprovado'));
		$aprovado_etapa2 = $repo->getSolicitacaoFinanceiro(config('constantes.status_aprovado_etapa2'));
		if ($aprovado_etapa2 !=null) {
			$abertas = $this->pushSolicitacao($abertas,$aprovado_etapa2);			
		}
		$andamento = $repo->getSolicitacaoFinanceiro(config('constantes.status_andamento_financeiro'));
		if ($andamento !=null) {
			$abertas= $this->pushSolicitacao($abertas,$andamento);
		}
		$finalizadas = $repo->getSolicitacaoFinanceiro(config('constantes.status_finalizado'));
		$devolvidas = $repo->getSolicitacaoFinanceiro(config('constantes.status_devolvido_financeiro'));

		$recorrentes_devolvidas = $repo->getSolicitacaoFinanceiro(config('constantes.status_recorrente'));
		if ($devolvidas !=null) {
			$devolvidas= $this->pushSolicitacao($devolvidas,$recorrentes_devolvidas);
		}
		$recorrentes = $repo->getSolicitacaoFinanceiro(config('constantes.status_aprovado_recorrente'));

		return view('dashboard.financeiro',compact('abertas','finalizadas','devolvidas','recorrentes'));

	}
	public function administrativoDash()
	{
		$repo = new SolicitacaoRepository();

		$abertas = $repo->getSolicitacaoAdministrativo(config('constantes.status_aprovado'));

		$andamento = $repo->getSolicitacaoAdministrativo(config('constantes.status_andamento_administrativo'));
		if ($andamento !=null) {
			$abertas= $this->pushSolicitacao($abertas,$andamento);
		}
		$devolvidas = $repo->getSolicitacaoAdministrativo(config('constantes.status_devolvido_financeiro'));
		$recorrentes_devolvidas = $repo->getSolicitacaoAdministrativo(config('constantes.status_recorrente'));
		if ($devolvidas !=null) {
			$devolvidas= $this->pushSolicitacao($devolvidas,$recorrentes_devolvidas);
		}
		$recorrentes = $repo->getSolicitacaoAdministrativo(config('constantes.status_aprovado_recorrente'));

		return view('dashboard.administrativo',compact('abertas','devolvidas','recorrentes'));

	}

}
