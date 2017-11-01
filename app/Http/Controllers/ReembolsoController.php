<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Despesa;
use App\Translado;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;
use App\Status;


class ReembolsoController extends Controller
{
    //Buscando todas as informações das solicitacao e enviando para a view de listagem das solicitacao
    public function index()
    {
    	
    	$solicitacao = Solicitacao::orderBy('localidade');
    	return view('reembolso.index',compact('solicitacao'));
    }


    //Retorna a View de cadastro da unidade
    public function cadastrar()
    {
    	$clientes = Cliente::all('id','nome');
    	$areas = AreaAtuacao::all('id','tipo'); 
    	$solicitantes = Solicitante::all('id','nome');
    	return view('reembolso.cadastrar', compact('clientes','areas','solicitantes')); 	
    }

    //Cadatra uma nova Solicitação e redireciona para a tela de edição
    public function salvar(Request $request)
    {
        $solicitacao = Solicitacao::create(
            [   
                'codigo' => 13224,
                'urgente' => $request->urgente,
                'tipo' => 'Reembolso',
                'origem_despesa' => $request->origem_despesa,
                'contrato' => $request->contrato,
                'area_atuacoes_id'=>$request->area_atuacoes_id,
                'clientes_id' => $request->clientes_id,
                'solicitantes_id' => $request->solicitantes_id,
                'users_id' => 1,
            ]
        );        
        
        $status = Status::where('descricao',config('constantes.status_aberto'))->first();
        //$status = Status::where('descricao','ABERTO')->orWhere('descricao' , 'ANDAMENTO')->get();        
        $solicitacao->status()->attach($status);
        \Session::flash('flash_message',[
            'msg'=>"Cadastro do Unidade realizado com sucesso!!!",
            'class'=>"alert-success"
        ]);

        $clientes = Cliente::all('id','nome');
        $areas = AreaAtuacao::all('id','tipo'); 
        $solicitantes = Solicitante::all('id','nome');
        return view('reembolso.editar', compact('clientes','areas','solicitantes'));
    }

    //Adcionar um novo translado a uma solicitação
    public function addTranslado(Request $request,$id)
    {
        $solicitacao = Solicitacao::with('despesa','translado')->where('id',$id)->first();        

        $translado = Translado::create(
            [   
                'data_translado' => $request->data_translado,
                'observacao' => $request->observacao,
                'origem' => $request->origem,
                'destino' => $request->destino,
                'ida_volta' => $request->ida_volta,
                'distancia'=>$request->distancia,
                'solicitacoes_id' => $id,
            ]
        );

        \Session::flash('flash_message',[
            'msg'=>"Cadastro do Translado realizado com sucesso!!!",
            'class'=>"alert-success"
        ]);
        
        $clientes = Cliente::all('id','nome');
        $areas = AreaAtuacao::all('id','tipo'); 
        $solicitantes = Solicitante::all('id','nome');
        
        return redirect()->route('reembolso.editar',$id);
    }

    //Adcionar uma nova despesa a solicitação
    public function addDespesa(Request $request,$id)
    {
        $solicitacao = Solicitacao::with('despesa','translado')->where('id',$id)->first();
        
        $file = $request->file('anexo_comprovante');
        dd($file);
        $extension = $request->anexo_comprovante->extension();
        $path_name = $file->getPathName();
        $file = base64_encode(file_get_contents($path_name));
        $src  = 'data: image/'.$extension.';base64,'.$file;
        $despesa = Despesa::create(
            [   
                'descricao' => $request->descricao,
                'data_despesa' => $request->data_despesa,
                'tipo_comprovante' => $request->tipo_comprovante,
                'valor' => $request->valor,
            //  'mime' => $extension,
                'anexo_comprovante' => $file,
                'solicitacoes_id' => $solicitacao->id,
            ]
        );

        \Session::flash('flash_message',[
            'msg'=>"Cadastro da Despesa realizado com sucesso!!!",
            'class'=>"alert-success"
        ]);
        
        return redirect()->route('reembolso.editar',$id);
    }

    //Retorna a View de edição da unidade
    public function editar($id)
    {

        $solicitacao = Solicitacao::with('despesa','translado')->where('id',$id)->first();
        if(!$solicitacao){
            \Session::flash('flash_message',[
                'msg'=>"Não existe essa Unidade cadastrada!!! Deseja cadastrar uma nova Unidade?",
                'class'=>"alert-danger"
            ]);
            return redirect()->route('reembolso.cadastrar');            
        }
        $clientes = Cliente::all('id','nome');
        $areas = AreaAtuacao::all('id','tipo'); 
        $solicitantes = Solicitante::all('id','nome');

        return view('reembolso.editar', compact('solicitacao','clientes','areas','solicitantes'));
    }



    //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
    public function editarTranslado($id)
    {   
        Solicitacao::find($id)->update($request->all());
        $solicitacao = Solicitacao::with('despesa','translado')->where('id',$id)->first();

        \Session::flash('flash_message',[
            'msg'=>"Unidade atualizado com sucesso!!!",
            'class'=>"alert-success"
        ]);
        return redirect()->route('reembolso.editar',$id);
    }
    //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
    public function editarDespesa($id)
    {   
        $despesa = Despesa::find($id);
        $extension = $despesa->anexo_comprovante;
        $file = $despesa->anexo_comprovante;
        $src  = 'data: image/jpeg;base64,'.$file;

        return view('reembolso.despesa', compact('despesa','src'));
    }

    //Atualiza uma Despesa e redireciona para a tela de edição da Solicitação
    public function atualizarDespesa(Request $request,$id)
    {   
        $despesa = Despesa::find($id);
        //dd($request->hasFile('anexo_comprovante'));
        if ($request->hasFile('anexo_comprovante')) {

            $file = $request->file('anexo_comprovante');
            $extension = $request->anexo_comprovante->extension();
            $path_name = $file->getPathName();
            $file = base64_encode(file_get_contents($path_name));
            //$src  = 'data: image/'.$extension.';base64,'.$file;
        }else{
            $file = $despesa->anexo_comprovante;
        }
        ini_set('memory_limit', '256M');
        Despesa::where('id',$id)->update(
            [   
                'descricao' => $request->descricao,
                'data_despesa' => $request->data_despesa,
                'tipo_comprovante' => $request->tipo_comprovante,
                'valor' => $request->valor,
              //'mime' => $extension,
                'anexo_comprovante' => $file,
            ]
        );
        
        
        \Session::flash('flash_message',[
            'msg'=>"Despesa atualizada com sucesso!!!",
            'class'=>"alert-success"
        ]);
        return redirect()->route('reembolso.editar', $despesa->solicitacoes_id);
    }

    //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
    public function atualizar(Request $request,$id)
    {   
        Solicitacao::find($id)->update($request->all());

        \Session::flash('flash_message',[
            'msg'=>"Solicitação atualizada com sucesso!!!",
            'class'=>"alert-success"
        ]);
        return redirect()->route('reembolso.editar',$id);
    }

    //Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
    public function deletarTranslado($id)
    {        

        $translado = Translado::find($id);
        //dd($translado);
        $s_id = $translado->solicitacoes_id;
        $translado->delete();
        \Session::flash('flash_message',[
            'msg'=>"Translado removido com sucesso!!!",
            'class'=>"alert-danger"
        ]);
        return redirect()->route('reembolso.editar',$s_id);       
    }

    //Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
    public function deletarDespesa($id)
    {

        $despesa = Despesa::find($id);
        $s_id = $despesa->solicitacoes_id;
        $despesa->delete();
        \Session::flash('flash_message',[
            'msg'=>"Despesas removida com sucesso!!!",
            'class'=>"alert-danger"
        ]);
        return redirect()->route('reembolso.editar',$s_id);       
    }

    //Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
    public function deletar($id)
    {

        $unidade = Solicitacao::find($id);
        $unidade->delete();

        \Session::flash('flash_message',[
            'msg'=>"Reembolso removido com sucesso!!!",
            'class'=>"alert-danger"
        ]);
        return redirect()->route('reembolso.index');    	
    }
}