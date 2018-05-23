<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Junity\Hashids\Facades\Hashids;
use App\User;
use App\Dados;
use App\AreaAtuacao; 
use App\Unidade; 
use App\Role;
use App\Limite;
use App\Cliente;

class RegisterController extends Controller
{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationFormAdvogado()
    {
        $areas = AreaAtuacao::all();
        $unidades = Unidade::all();

        return view('auth.register', compact('areas','unidades'));
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationFormCoordenador()
    {
        $areas = AreaAtuacao::all(); 
        $unidades = Unidade::all(); 
        $clientes = Cliente::all(); 
        $advogados = Role::with(['user' => function ($q)
        {
           $q->orderBy('nome');
       }])->where('name',config('constantes.user_advogado'))->first();
        return view('auth.registerCoordenador', compact('areas','unidades','clientes','advogados'));
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationFormFinanceiro()
    {
        $areas = AreaAtuacao::all(); 
        $unidades = Unidade::all(); 

        return view('auth.registerFinanceiro', compact('areas','unidades'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        $role = Role::where('name',$request->role)->first();
        $user->attachRole($role);

        $user->administrativo = $request->funcao ? 1 : 0;
        $user->save();
        if ($request->role == config('constantes.user_coordenador')) {
            $this->setLimite($user,$request);
            $this->setCliente($user,$request);
            $this->setAdvogado($user,$request);
        } 

        \Session::flash('flash_message',[
            'msg'=> "Dr(a) ".$user->nome." Cadastrado com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        return redirect()->route('user.editar', $user->id);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'cpf' => 'required',
            'telefone' => 'required' ,
            'area_atuacoes_id' => 'required',
            'unidades_id' => 'required',
        ]);
    }

    public function setAdvogado($user,$request)
    {
        $user->users()->sync($request->get('advogados'));        
    }

    public function setCliente($user,$request)
    {
        $user->clientes()->sync($request->get('clientes'));
    }

    public function setLimite($user,$request)
    {
        if (count($request->get('area_atuacoes_limite')) >= 1) {

            foreach ($request->get('area_atuacoes_limite') as $area) {
                $limite = Limite::create([
                    'de' => $request->de,
                    'ate' => $request->ate,
                    'area_atuacoes_id' => $area,
                ]);
                $limite->unidades()->sync($request->get('unidades_limite'));
                $user->limites()->attach($limite->id);
            }
        }else{
            $limite = Limite::create([
                'de' => $request->de,
                'ate' => $request->ate,
                'area_atuacoes_id' => $request->area_atuacoes_limite,
            ]);
            $limite->unidades()->sync($request->get('unidades_limite'));
            $user->limites()->attach($limite->id);
        }
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $dados = Dados::create([
            'rg' => $data['rg'],
            'data_inicial' => $data['data_inicial'] ? date('Y-m-d', strtotime($data['data_inicial'])): null,
            'data_nascimento' => $data['data_nascimento'] ? date('Y-m-d', strtotime($data['data_nascimento'])) : null,
            'endereco' => $data['endereco'],
            'cidade' => $data['cidade'],
            'estado' => $data['cidade'],
            'cep' => $data['cep'],
            'telefone' => $data['telefone'],
            'estado_civil' => $data['estado_civil'],
            'funcao' => $data['funcao'],
            'dados_bancarios' => $data['dados_bancarios'],
            'viagem' => $data['viagem'],
        ]);

        $user = User::create([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'codigo' => 000,
            'cpf' => $data['cpf'],
            'telefone' => $data['telefone'],
            'area_atuacoes_id' => $data['area_atuacoes_id'],
            'dados_id' => $dados->id,
            'unidades_id' => $data['unidades_id'],
        ]);
        $user->codigo = Hashids::encode($user->id);
        $user->save();
        return $user;
    }
}
