<?php

namespace App\Http\Controllers;
use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use App\Despesa;
use App\Processo;
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
    	$areas = AreaAtuacao::all('id','tipo'); 
    	return view('reembolso.cadastrar', compact('areas')); 	
    }

    //Cadatra uma nova Solicitação e redireciona para a tela de edição
    public function salvar(SolicitacaoRequest $request)
    {   
        $repo = new SolicitacaoRepository();
        $solicitacao = $repo->create($request,config('constantes.tipo_reembolso'));
        
        \Session::flash('flash_message',[
            'msg'=>"Cadastro do ".$solicitacao->tipo." Realizado com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);

        return redirect()->route('reembolso.editar', $solicitacao->id);
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
        return redirect()->route('reembolso.editar',$id);
    }

    //Adicionar um novo translado a uma solicitação
    public function addTranslado(Request $request,$id)
    {
        $solicitacao = Solicitacao::with('despesa','translado')->where('id',$id)->first();        

        $translado = Translado::create(
            [   
                'data_translado' => $request->data_translado,
                'turno' => $request->turno,
                'observacao' => $request->observacao,
                'origem' => $request->origem,
                'destino' => $request->destino,
                'ida_volta' => $request->ida_volta,
                'distancia'=>$request->distancia,
                'solicitacoes_id' => $id,
            ]
        );

        \Session::flash('flash_message',[
            'msg'=>"Cadastro do Translado Realizado com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
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
        
        // $file = $request->file('anexo_comprovante');
        // dd($file);
        // $extension = $request->anexo_comprovante->extension();
        // $path_name = $file->getPathName();
        // $file = base64_encode(file_get_contents($path_name));
        // $src  = 'data: image/'.$extension.';base64,'.$file;

        $file = Image::make($request->file('anexo_comprovante'))->resize(300, 200)->save('file.jpg');

        $img_64 = (string) $file->encode('data-url');
        $despesa = Despesa::create(
            [   
                'descricao' => $request->descricao,
                'data_despesa' => $request->data_despesa,
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
        
        return redirect()->route('reembolso.editar',$id);
    }

    //Retorna a View de edição da unidade
    public function editar($id)
    {

        $solicitacao = Solicitacao::with('despesa','translado','processo')->where('id',$id)->first();
        if(!$solicitacao){
            \Session::flash('flash_message',[
                'msg'=>"Não Existe essa Solicitacao Cadastrada!!! Deseja Cadastrar uma Nova Solicitação?",
                'class'=>"alert-danger"
            ]);
            return redirect()->route('reembolso.cadastrar');            
        }
        $cliente = Cliente::where('id',$solicitacao->clientes_id)->select('id','nome')->get();
        $areas = AreaAtuacao::all('id','tipo'); 
        $solicitante = Solicitante::where('id',$solicitacao->solicitantes_id)->select('id','nome')->get();

        return view('reembolso.editar', compact('solicitacao','cliente','areas','solicitante'));
    }

    //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
    public function editarTranslado($id)
    {   
        $translado = Translado::find($id);

        return view('reembolso.translado', compact('translado'));
    }
    
    //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
    public function atualizarTranslado(Request $request,$id)
    {   
        $translado = Translado::find($id);

        $translado->update($request->all());
        
        \Session::flash('flash_message',[
            'msg'=>"Translado Atualizado com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        return redirect()->route('reembolso.editar',$translado->solicitacoes_id);
    }
   
    //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
    public function editarDespesa($id)
    {   
        $despesa = Despesa::find($id);

        return view('reembolso.despesa', compact('despesa'));
    }

    //Atualiza uma Despesa e redireciona para a tela de edição da Solicitação
    public function atualizarDespesa(Request $request,$id)
    {   
        $despesa = Despesa::find($id);
        if ($request->hasFile('anexo_comprovante')) {
            $file = Image::make($request->file('anexo_comprovante'))->resize(800, 600)->save('comprovante.jpg');            
            $img_64 = (string) $file->encode('data-url');
        }else{
            $img_64 = $despesa->anexo_comprovante;
        }

        $despesa->update(
            [   
                'descricao' => $request->descricao,
                'data_despesa' => $request->data_despesa,
                'tipo_comprovante' => $request->tipo_comprovante,
                'valor' => $request->valor,
                'anexo_comprovante' => $img_64,
            ]
        );
        
        \Session::flash('flash_message',[
            'msg'=>"Despesa Atualizada com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        return redirect()->route('reembolso.editar', $despesa->solicitacoes_id);
    }

    
    //Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
    public function deletarTranslado($id)
    {        

        $translado = Translado::find($id);
        $s_id = $translado->solicitacoes_id;
        $translado->delete();
        \Session::flash('flash_message',[
            'msg'=>"Translado Removido com Sucesso!!!",
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
            'msg'=>"Despesas Removida com Sucesso!!!",
            'class'=>"alert-danger"
        ]);
        return redirect()->route('reembolso.editar',$s_id);       
    }

    //Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
    public function deletar($id)
    {
        $reembolso = Solicitacao::find($id);
        $reembolso->delete();

        \Session::flash('flash_message',[
            'msg'=>"Reembolso Removido com Sucesso!!!",
            'class'=>"alert-danger"
        ]);
        return redirect()->route('reembolso.index');    	
    }
}