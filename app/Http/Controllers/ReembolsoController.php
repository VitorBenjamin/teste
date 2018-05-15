<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

use App\Http\Helpers\SolicitacaoHelper;
use App\Http\Requests\SolicitacaoRequest;
use App\Http\Requests\DespesaRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\DespesaRepository;
use App\Repositories\SolicitacaoRepository;
use Illuminate\Support\Facades\Storage;
use App\Despesa;
use App\Processo;
use App\Translado;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;
use App\Status;
use PDF;

class ReembolsoController extends Controller
{
    //Buscando todas as informações das solicitacao e enviando para a view de listagem das solicitacao

    public function index()
    {

    	$solicitacao = Solicitacao::orderBy('localidade');
    	return view('reembolso.index',compact('solicitacao'));
    }

    public function print($id)
    {
        $lista = array();
        $solicitacaoHelper = new SolicitacaoHelper();
        $solicitacao = Solicitacao::find($id);
        $lista = $solicitacaoHelper->reembolsoPrint($solicitacao,$lista);
        usort($lista, function($a, $b) {
            return $a['data'] <=> $b['data'];
        });
        //dd($lista);
        //$pdf = PDF::loadView('layouts._includes.impressao._reembolso',compact('solicitacao','lista'));
        //$pdf::render();
        //return $pdf->download('cliente.pdf');
        //return redirect()->back();
        return view('layouts._includes.impressao._reembolso', compact('solicitacao','lista'));
    }


    //Retorna a View de cadastro da unidade
    public function cadastrar()
    {    	

    	$areas = AreaAtuacao::all('id','tipo'); 
        $processos = Processo::all();
        $clientes = Cliente::all('id','nome');
        $solicitantes = Solicitante::all('id','nome');
        return view('reembolso.cadastrar', compact('areas','processos','solicitantes','clientes')); 	
    }

    //Cadatra uma nova Solicitação e redireciona para a tela de edição
    public function salvar(SolicitacaoRequest $request)
    {   
        $repo = new SolicitacaoRepository();
        $solicitacao = $repo->create($request,config('constantes.tipo_reembolso'));
        
        Session::flash('flash_message',[
            'msg'=>"Cadastro do ".$solicitacao->tipo." Realizado com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);

        return redirect()->route('reembolso.editar', $solicitacao->id);
    }
    
    //Adicionar um novo translado a uma solicitação
    public function addTranslado(Request $request,$id)
    {
        $solicitacao = Solicitacao::with('despesa','translado')->where('id',$id)->first();        

        $translado = Translado::create(
            [   
                'data_translado' => date('Y-m-d', strtotime($request->data_translado)),
                'turno' => $request->turno,
                'observacao' => $request->observacao,
                'origem' => $request->origem,
                'destino' => $request->destino,
                'ida_volta' => $request->ida_volta,
                'distancia'=>$request->distancia,
                'solicitacoes_id' => $id,
            ]
        );

        Session::flash('flash_message',[
            'msg'=>"Cadastro do Translado Realizado com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        
        $clientes = Cliente::all('id','nome');
        $areas = AreaAtuacao::all('id','tipo'); 
        $solicitantes = Solicitante::all('id','nome');
        
        return redirect()->route('reembolso.editar',$id);
    }

    //Adcionar uma nova despesa a solicitação
    public function addDespesa(\App\Http\Requests\DespesaRequest $request,$id)
    {
        $despesa_repo = new DespesaRepository();
        $despesa = $despesa_repo->create($request,$id);
        
        Session::flash('flash_m-essage',[
            'msg'=>"Cadastro da Despesa Realizado com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        
        return redirect()->route('reembolso.editar',$id);
    }

    public function verificarSolicitacao($id)
    {
        $solicitacao = Solicitacao::with(['despesa' => function($q)
        {
            $q->orderBy('data_despesa');
        }],'translado','processo')                        
        ->where('tipo',config('constantes.tipo_reembolso'))
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
            } else {
                return $solicitacaoHelper->verificarStatus($solicitacao);
            }

        } else {
            return $exist;
        }
    }

    //Retorna a View de edição da unidade
    public function editar($soli)
    {
        $solicitacao = $soli;
        //$clientes = Cliente::where('id',$solicitacao->clientes_id)->select('id','nome')->get();
        $areas = AreaAtuacao::all('id','tipo'); 
        //$solicitantes = Solicitante::where('id',$solicitacao->solicitantes_id)->select('id','nome')->get();
        $clientes = Cliente::all('id','nome');
        //$solicitantes = Solicitante::all('id','nome');

        return view('reembolso.editar', compact('solicitacao','clientes','areas'));
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

        Session::flash('flash_message',[
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
        $mime = $request->file('anexo_comprovante')->getClientMimeType();
        if ($request->hasFile('anexo_comprovante') && $mime == "image/jpeg")  {
            $file = Image::make($request->file('anexo_comprovante'));            
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

        Session::flash('flash_message',[
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
        Session::flash('flash_message',[
            'msg'=>"Translado Removido com Sucesso!!!",
            'class'=>"alert bg-red alert-dismissible"
        ]);
        return redirect()->route('reembolso.editar',$s_id);       
    }


    public function analisar($id)
    {

        $solicitacao = Solicitacao::with('despesa','translado','cliente','solicitante','processo','area_atuacao')->where('id',$id)->first();
        //dd($solicitacao);
        if ($solicitacao == null) {
            \Session::flash('flash_message',[
                'msg'=>"Solicitação não cadastrada!",
                'class'=>"alert bg-yellow alert-dismissible"
            ]);
            return redirect()->route('user.index'); 
        }
        return view('reembolso.analiseReembolso', compact('solicitacao'));

    }

    //Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
    public function deletarDespesa($id)
    {

        $despesa = Despesa::find($id);
        $s_id = $despesa->solicitacoes_id;
        if ($despesa->anexo_pdf) {
            Storage::delete('/public/despesas/'. $despesa->anexo_pdf);
        }
        $despesa->delete();
        Session::flash('flash_message',[
            'msg'=>"Despesas Removida com Sucesso!!!",
            'class'=>"alert bg-red alert-dismissible"
        ]);
        return redirect()->route('reembolso.editar',$s_id);       
    }


}