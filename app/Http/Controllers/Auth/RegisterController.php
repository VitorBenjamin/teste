<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\AreaAtuacao; 
use App\Unidade; 
use App\Role;
use App\Limite;

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

        return view('auth.registerCoordenador', compact('areas','unidades'));
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
        //dd($request->all());
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $this->attachRole($user,$request);
        

        if ($request->role == config('constantes.user_coordenador')) {
            $this->setLimite($user,$request);
        }
        
            \Session::flash('flash_message',[
                'msg'=> "Dr(a) ".$user->nome." Cadastrado com Sucesso!!!",
                'class'=>"alert bg-green alert-dismissible"
            ]);
        return redirect($this->redirectPath());
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

    public function setLimite($user,$request)
    {

        $limite = Limite::create([
            'de' => $request->de,
            'ate' => $request->ate,
            'area_atuacoes_id' => $request->area_atuacoes_limite,
        ]);
        $limite->unidades()->sync($request->get('unidades_limite'));
        var_dump('asdadadadadasdadadasd');
        $user->limites()->attach($limite->id);
    }

    public function attachRole($user,$request)
    {
        if ($request->role == config('constantes.user_advogado')) 
        {
            $role = Role::where('name',config('constantes.user_advogado'))->first();
            $user->attachRole($role);
        }
        if ($request->role == config('constantes.user_coordenador')) {
            $role = Role::where('name',config('constantes.user_coordenador'))->first();
            $user->attachRole($role);
        }
        if ($request->role == config('constantes.user_financeiro')) {
            $role = Role::where('name',config('constantes.user_financeiro'))->first();
            $user->attachRole($role);
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
        return User::create([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'codigo' => 000,
            'cpf' => $data['cpf'],
            'telefone' => $data['telefone'] ,
            'area_atuacoes_id' => $data['area_atuacoes_id'],
            'unidades_id' => $data['unidades_id'],
        ]);
    }
}
