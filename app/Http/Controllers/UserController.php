<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\User;
use App\Dados;
use App\AreaAtuacao; 
use App\Unidade; 
use App\Limite;
use App\Cliente;


class UserController extends Controller
{

	// public function createDados(Request $request)
	// {
	// 	$users = User::where('created_at','>','2018-01-31')->get();

	// 	foreach ($users as $u) {
	// 		$u->attachRole('ADVOGADO');
	// 	}
	// 	dd($request->all());
	// 	foreach ($request->all() as $val) {
	// 		//dd($val);
	// 		$dados = Dados::create([
	// 			'rg' => $val['rg'],
	// 			'data_nascimento' => $val['data_nascimento'],
	// 			'endereco' => $val['endereco'],
	// 			'cidade' => $val['cidade'],
	// 			'estado' => $val['cidade'],
	// 			'cep' => $val['cep'],
	// 			'telefone' => $val['telefone'],
	// 			'estado_civil' => $val['estado_civil'],
	// 			'funcao' => $val['funcao'],
	// 			'dados_bancarios' => $val['dados_bancarios'],
	// 			'viagem' => $val['viagem'],
	// 		]);
	// 		$user = User::create([
	// 			'nome' => $val['nome'],
	// 			'email' => $val['email'],
	// 			'password' => bcrypt('123456789'),
	// 			'codigo' => 000,
	// 			'cpf' => $val['cpf'],
	// 			'telefone' => $val['telefone'] ,
	// 			'area_atuacoes_id' => 1,
	// 			'unidades_id' => $val['unidade'],
	// 			'dados_id' => $dados->id,
	// 		]);
	// 	}
	// 	return respose('tudo beleza');
	// }
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
				'class'=>\Session::get('flash_message')['class']

			]);
		}
		return $dash;
	}

	public function getAll()
	{
		$role = config('constantes.user_advogado');
		$users = Role::with('user')
		->orWhere('name', config('constantes.user_advogado'))
		->orWhere('name', config('constantes.user_coordenador'))
		->orWhere('name', config('constantes.user_financeiro'))
		->orWhere('name', config('constantes.user_administrativo'))
		->get();
		//dd($users);
		return view('advogado.listagem',compact('users'));
	}
	public function ativarOrDesativar($id)
	{
		$user = User::find($id);
		if ($user->ativo) {
			$user->ativo = false;
			$user->save();
			\Session::flash('flash_message',[
				'msg'=>"Usuário Desativado com Sucesso",
				'class'=>"alert bg-green alert-dismissible"
			]);
		} else {
			$user->ativo = true;
			$user->save();
			\Session::flash('flash_message',[
				'msg'=>"Usuário Ativado com Sucesso",
				'class'=>"alert bg-green alert-dismissible"
			]);
		}
		return redirect()->back();
	}

	public function edit($id)
	{
		$user = User::where('id',$id)->with('limites','area_atuacao','unidades')->first();
		$clientes = Cliente::all(); 
		$advogados = Role::with(['user' => function ($q)
		{
			$q->orderBy('nome');
			
		}])->where('name',config('constantes.user_advogado'))->first();
		$areas = AreaAtuacao::all(); 
		$unidades = Unidade::all(); 
		return view('advogado.editar',compact('user','areas','limites','advogados','clientes','unidades'));
	}
	public function editarPerfil()
	{
		$user = User::where('id',auth()->user()->id)
		->select('nome','email')
		->first();
		return view('advogado.perfil',compact('user'));

	}
	public function atualizarPerfil(Request $request)
	{
		$messages = [
			'password.confirmed' => 'Confirme a senha no campo auxiliar',
			'password.min' => 'Tamanho miníno de 6 digitos',
		];
		if ($request->password != "") {
			Validator::make($request->all(), [
				'password' => 'confirmed|min:6',
				'password-confirm' => 'required_if:password,!=,',
			],$messages)->validate();
		}
		auth()->user()->nome = $request->nome;
		auth()->user()->email = $request->email;
		auth()->user()->save();

		if (auth()->user()->dados_id == null) {
			$dados_old = Dados::create($dados);
			auth()->user()->dados_id = $dados_old->id;
			auth()->user()->save();
		} else {
			$dados_old = Dados::find(auth()->user()->dados_id);

			$dados_old->update(
				[
					'rg' => $request->rg,
					'data_inicial' => date('Y-m-d', strtotime($request->data_inicial)),
					'data_nascimento' => date('Y-m-d', strtotime($request->data_nascimento)),
					'endereco' => $request->endereco,
					'cidade' => $request->cidade,
					'estado' => $request->cidade,
					'cep' => $request->cep,
					'telefone' => $request->telefone,
					'estado_civil' => $request->estado_civil,
					'funcao' => $request->funcao,
					'dados_bancarios' => $request->dados_bancarios,
					'viagem' => $request->viagem,
				]);
			auth()->user()->save();
		}
		if ($request->password != "") {
			auth()->user()->forceFill([
				'password' => bcrypt($request->password),
				'remember_token' => Str::random(60),
			])->save();
		}
		\Session::flash('flash_message',[
			'msg'=>"Seus Dados foram Atualizados com Sucesso",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->route('user.editarPerfil');
	}
	public function atualizar(Request $request,$id)
	{
		$messages = [
			'password.confirmed' => 'Confirme a senha no campo auxiliar',
			'password.min' => 'Tamanho miníno de 6 digitos',
		];
		if ($request->password != "") {
			Validator::make($request->all(), [
				'password' => 'confirmed|min:6',
				'password-confirm' => 'required_if:password,!=,',
			],$messages)->validate();
		}
		$user = User::where('id',$id)->first();
		$data = [
			'nome' => $request->nome,
			'email' => $request->email,
			'codigo' => 000,
			'cpf' => $request->cpf,
			'telefone' => $request->telefone ,
			'area_atuacoes_id' => $request->area_atuacoes_id,
			'dados_id' => $user->dados_id,
			'unidades_id' => $request->unidades_id,
		];
		$dados = [
			'rg' => $request->rg,
			'data_inicial' => date('Y-m-d', strtotime($request->data_inicial)),
			'data_nascimento' => date('Y-m-d', strtotime($request->data_nascimento)),
			'endereco' => $request->endereco,
			'cidade' => $request->cidade,
			'estado' => $request->cidade,
			'cep' => $request->cep,
			'telefone' => $request->telefone,
			'estado_civil' => $request->estado_civil,
			'funcao' => $request->funcao,
			'dados_bancarios' => $request->dados_bancarios,
			'viagem' => $request->viagem,
		];
		if ($user->dados_id == null) {
			$dados_old = Dados::create($dados);

			$data = [
				'dados_id' => $dados_old->id,
			];
		} else {
			$dados_old = Dados::find($user->dados_id);

			$dados_old->update($dados);
		}
		
		if ($user->hasRole('COORDENADOR')) {
			//$user->users()->detach();
			//$user->clientes()->detach();
			$user->users()->sync($request->get('advogados'));
			$user->clientes()->sync($request->get('clientes'));
		}
		
		$user->update($data);
		if ($request->password != "") {
			$user->forceFill([
				'password' => bcrypt($request->password),
				'remember_token' => Str::random(60),
			])->save();
		}

		\Session::flash('flash_message',[
			'msg'=>"Dr(ª) ".$user->nome." Atualizado com Sucesso",
			'class'=>"alert bg-green alert-dismissible"
		]);

		return redirect()->route('user.editar',$user->id);
	}

	public function deletarLimite($user,$limite_id)
	{
		$user = User::find($user);
		$limite = Limite::find($limite_id);
		$user->limites()->detach($limite_id);
		$limite->unidades()->detach();
		$limite->delete();

		\Session::flash('flash_message',[
			'msg'=>"Limite Removido com Sucesso",
			'class'=>"alert bg-green alert-dismissible"

		]);

		return redirect()->route('user.editar',$user->id);
	}
	public function addLimite(Request $request,$id)
	{
		$user = User::find($id);
		$limite = Limite::create([
			'de' => $request->de,
			'ate' => $request->ate,
			'area_atuacoes_id' => $request->area_atuacoes_id,
		]);
		$limite->unidades()->sync($request->get('unidades_limite'));
		$user->limites()->attach($limite->id);
		\Session::flash('flash_message',[
			'msg'=>"Limite Adicionado com Sucesso",
			'class'=>"alert bg-green alert-dismissible"

		]);

		return redirect()->route('user.editar',$id);
	}
	public function atualizarLimite(Request $request,$id)
	{	
		//dd($request->all());
		$limite = Limite::find($id);
		$limite->unidades()->detach();
		$limite->update($request->all());
		
		$limite->unidades()->sync($request->get('unidades_limite'));

		\Session::flash('flash_message',[
			'msg'=>"Limite Atualizado com Sucesso",
			'class'=>"alert bg-green alert-dismissible"

		]);

		return redirect()->route('user.editar',$limite->users[0]->id);
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
		if ($andamentos2 !=null) {
			$andamentos=$this->pushSolicitacao($andamentos,$andamentos2);
		}
		$andamentos_adm = $repo->getSolicitacaoAdvogado(config('constantes.status_andamento_administrativo'));
		if ($andamentos_adm !=null) {
			$andamentos=$this->pushSolicitacao($andamentos,$andamentos_adm);
		}
		$recorrente = $repo->getSolicitacaoAdvogado(config('constantes.status_recorrente'));
		$andamento_recorrente = $repo->getSolicitacaoAdvogado(config('constantes.status_andamento_recorrente'));

		if ($recorrente !=null) {
			$andamentos=$this->pushSolicitacao($andamentos,$recorrente);
		}
		if ($andamento_recorrente !=null) {
			$andamentos=$this->pushSolicitacao($andamentos,$andamento_recorrente);
		}
		
		$recorrente_financeiro = $repo->getSolicitacaoAdvogado(config('constantes.status_recorrente_financeiro'));
		if ($recorrente_financeiro !=null) {
			$andamentos=$this->pushSolicitacao($andamentos,$recorrente_financeiro);
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

		/* INICIO ADVOGADO */
		$abertas = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento'));

		$andamentos_etapa2 = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento_etapa2'));

		if ($andamentos_etapa2 !=null) {
			$abertas=$this->pushSolicitacao($abertas,$andamentos_etapa2);
		}
		$aprovadas = $repo->getSolicitacaoCoordenador(config('constantes.status_aprovado'));

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
		$devolvida_etapa2 = $repo->getSolicitacaoCoordenador(config('constantes.status_devolvido_etapa2'));
		if ($devolvida_etapa2 !=null) {
			$devolvidas = $this->pushSolicitacao($devolvidas,$devolvida_etapa2);			
		}
		$recorrentes = $repo->getSolicitacaoAdvogado(config('constantes.status_recorrente'));

		$andamento_recorrente = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento_recorrente'));

		if ($andamento_recorrente !=null) {
			$recorrentes = $this->pushSolicitacao($recorrentes,$andamento_recorrente);			
		}
		/* FIM ADVOGADO */
		return view('dashboard.coordenador',compact('abertas','aprovadas','reprovados','devolvidas','recorrentes'));
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
		// $andamento_recorrente = $repo->getSolicitacaoAdministrativo(config('constantes.status_andamento_recorrente'));
		// if ($andamento_recorrente !=null) {
		// 	$abertas= $this->pushSolicitacao($abertas,$andamento_recorrente);
		// }
		
		$devolvidas = $repo->getSolicitacaoAdministrativo(config('constantes.status_devolvido_financeiro'));
		$recorrentes_devolvidas = $repo->getSolicitacaoAdministrativo(config('constantes.status_recorrente'));
		if ($devolvidas !=null) {
			$devolvidas= $this->pushSolicitacao($devolvidas,$recorrentes_devolvidas);
		}

		$recorrente_financeiro = $repo->getSolicitacaoAdministrativo(config('constantes.status_recorrente_financeiro'));		
		$recorrentes = $repo->getSolicitacaoAdministrativo(config('constantes.status_aprovado_recorrente'));
		if ($recorrente_financeiro !=null) {
			$recorrentes= $this->pushSolicitacao($recorrentes,$recorrente_financeiro);
		}
		return view('dashboard.administrativo',compact('abertas','devolvidas','recorrentes'));

	}

}
