<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Unidade;
use App\Solicitante;
use App\Telefone;
use App\Cidade;
use App\Estado;

class ClienteController extends Controller
{

    public function index(Request $request)
    {
        //dd($request->all());
        foreach ($request->all() as $c) {
            $data = [
                'nome' => $c['nome'],
                'cnpj' => $c['cnpj'],
            ];
            if ($c['endereco']) {
                $data['logradouro'] = $c['endereco'];
            }
            if ($c['cidade']) {
                $cidade = Cidade::where('nome',$c['cidade'])->first();
                if ($cidade == null) {
                    $cidade = Cidade::create(['nome' => $c['cidade']]);
                }

                $data['cidades_id'] = $cidade->id;
            }
            if ($c['estado']) {
                $estado = Estado::where('nome',$c['estado'])->first();
                if($estado == null){
                    $estado = Estado::create(['nome' => $c['estado']]);
                }
                $data['estados_id'] = $estado->id;
            }
            if ($c['cep']) {
                $data['cep'] = $c['cep'];
            }
            if ($c['valordokm']) {
                $data['valor_km'] = $c['valordokm'];
            }else{
                $data['valor_km'] = 1;
            }
            $cliente = Cliente::create($data);
            
            if ($c['telefonedaempresa']) {
                $telefonedaempresa = Telefone::create(['numero' => $c['telefonedaempresa']]);
                $cliente->telefones()->attach($telefonedaempresa);
            }
            for ($i=1; $i <= 8; $i++) { 
                $data = null;
                if ($c['nomedocontato'.$i]) {
                    $data = [
                        'nome' => $c['nomedocontato'.$i],
                        'clientes_id' => $cliente->id,
                    ];
                    if ($c['telefonedocontato'.$i]) {
                        $data['telefone'] = $c['telefonedocontato'.$i];
                    }
                    if ($c['emaildocontato'.$i]) {
                        $data['email'] = $c['emaildocontato'.$i];
                    }
                    
                    $solicitante = Solicitante::create($data);
                }
            }
        }
        return "DEU CERTO";
    }
    public function getCliente(Request $search){

        $clientes = Cliente::where('nome','like','%'.$search->q.'%')
        ->select('id','nome') 
        ->get();

        return response()->json(array("clientes" => $clientes));
    }

    //buscando todas as informações dos clientes e enviando para a view de listagem das clientes
    public function getAll(){

        $clientes = Cliente::orderBy('id')->get();
        $unidades = Unidade::all('id','localidade');
        //dd($clientes);
        return view('cliente.listagem',compact('clientes','unidades'));
    }

    //Retorna a View de cadastro da cliente
    public function cadastrar(){
        $unidades = Unidade::all('id','localidade');
        return view('cliente.cadastrar',compact('unidades'));	
    }

    //Cadatra um cliente e redireciona novamente para um tela de cadastro
    public function salvar(Request $request){
        $cliente = Cliente::create($request->all());

        \Session::flash('flash_message',[
            'msg'=>"Cadastro da ".$cliente->nome." realizado com sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"

        ]);

        return redirect()->route('cliente.getAll');
    }

    //Retorna a View de edição da cliente
    public function editar($id){
        $cliente = Cliente::find($id);
        $unidades = Unidade::all('id','localidade');
        if(!$cliente){
            \Session::flash('flash_message',[
                'msg'=>"Não existe esse Cliente cadastrado!!! Deseja cadastrar um novo Cliente?",
                'class'=>"alert-danger"
            ]);
            return redirect()->route('cliente.cadastrar');
        }
        return view('cliente.editar',compact('cliente','unidades'));
    }

    //Atualiza um cliente e redireciona para a tela de listagem de clientes
    public function atualizar(Request $request,$id){
        $cliente = Cliente::find($id);
        $cliente->update($request->all());

        \Session::flash('flash_message',[
            'msg'=>"Cliente (" .$cliente->nome. ") atualizado com sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        return redirect()->route('cliente.getAll');    	
    }

    //Deleta ou Não um cliente e redireciona para a tela de listagem de clientes
    public function deletar($id){
        $cliente = Cliente::find($id);
    		// if(!$cliente->deletarCliente()){
    		// 	\Session::flash('flash_message',[
    		// 'msg'=>"Registro não pode ser deletado!!!",
    		// 'class'=>"alert-danger"
    		// ]);
    		// return redirect()->route('cliente.index');
    	 	// }
        $cliente->delete();

        \Session::flash('flash_message',[
            'msg'=>"Cliente apagado com sucesso!!!",
            'class'=>"alert-danger"
        ]);
        return redirect()->route('cliente.index');    	
    }
}
