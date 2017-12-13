<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidade;

class UnidadeController extends Controller
{
    public function getUnidades(Request $search){

        $unidades = Unidade::where('localidade','like','%'.$search->q.'%')
        ->select('id','localidade')
        ->get();
        //$unidades = Unidade::all('id','localidade');

        // dd($unidades);
        return response()->json(array("unidades" => $unidades));
    }

    //buscando todas as informações dos clientes e enviando para a view de listagem das clientes
    public function getAll(){

        $unidades = Unidade::orderBy('id')->get();
        //dd($clientes);
        return view('unidade.listagem',compact('unidades'));
    }

    //Cadatra uma unidade e redireciona novamente para um tela de cadastro
    public function salvar(Request $request){

        $unidade = Unidade::create($request->all());

        \Session::flash('flash_message',[
            'msg'=>"Cadastro da Unidade ".$unidade->localidade." realizado com sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);

        return redirect()->route('unidade.getAll');
    }

    //Atualiza uma unidade e redireciona para a tela de listagem de unidades
    public function atualizar(Request $request,$id){
        $unidade = Unidade::find($id);
        $unidade->update($request->all());

        \Session::flash('flash_message',[
            'msg'=>"Unidade " .$unidade->localidade. " atualizado com sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        return redirect()->route('unidade.getAll');    	
    }

    //Deleta ou Não uma unidade e redireciona para a tela de listagem de unidades
    public function deletar($id){
        $unidade = Unidade::find($id);
        if(!$Unidade->deletarUnidade()){
            \Session::flash('flash_message',[
                'msg'=>"Registro não pode ser deletado!!!",
                'class'=>"alert-danger"
            ]);
            return redirect()->route('Unidade.index');
        }
        $unidade->delete();

        \Session::flash('flash_message',[
            'msg'=>"Unidade apagada com sucesso!!!",
            'class'=>"alert-danger"
        ]);
        return redirect()->route('unidade.index');    	
    }
}
