<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SolicitacaoHelper;
use Illuminate\Http\Request;
use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Repositories\SolicitacaoRepository;
use App\Processo;
use App\Viagem;
use App\ViagemComprovante;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;
use App\Status;
use App\Despesa;

class ViagemController extends Controller
{


    //Retorna a View de cadastro da unidade
    public function cadastrar()
    {
        $areas = AreaAtuacao::all('id','tipo');
        $processos = Processo::all();
        $clientes = Cliente::all('id','nome');
        $solicitantes = Solicitante::all('id','nome');
        return view('viagem.cadastrar', compact('areas','processos','solicitantes','clientes'));
    }

    //Cadatra uma nova Solicitação e redireciona para a tela de edição
    public function salvar(SolicitacaoRequest $request)
    {   
        $repo = new SolicitacaoRepository();
        $solicitacao = $repo->create($request,config('constantes.tipo_viagem'));

        \Session::flash('flash_message',[
            'msg'=>"Cadastro da ".$solicitacao->tipo." Realizada com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);

        return redirect()->route('viagem.editar', $solicitacao->id);
    }

    public function analisar($id)
    {

        $solicitacao = Solicitacao::with('viagem','cliente','solicitante','processo','area_atuacao')->where('id',$id)->first();
        //dd($solicitacao);

        return view('viagem.analiseViagem', compact('solicitacao'));

    }


    public function verificarSolicitacao($id)
    {
        $solicitacao = Solicitacao::with('viagem')
        ->where('tipo',config('constantes.tipo_viagem'))
        ->where('id',$id)
        ->first();
        $solicitacaoHelper = new SolicitacaoHelper();
        $exist = $solicitacaoHelper->solicitacaoExist($solicitacao,config('constantes.tipo_viagem'));
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
        
        return redirect()->route('viagem.editar',$id);
    }
    //Retorna a View de edição da unidade
    public function editar($soli)
    {
        $solicitacao = $soli;
        
        //$cliente = Cliente::where('id',$solicitacao->clientes_id)->select('id','nome')->get();
        $areas = AreaAtuacao::all('id','tipo'); 
        //$solicitante = Solicitante::where('id',$solicitacao->solicitantes_id)->select('id','nome')->get();
        $clientes = Cliente::all('id','nome');
        $solicitantes = Solicitante::all('id','nome');
        return view('viagem.editar', compact('solicitacao','clientes','areas','solicitantes'));
    }

    //Atualiza uma viagem e redireciona para a tela de edição da Solicitação
    public function atualizarViagem(Request $request,$id)
    {   
        //dd($request->all());
        $viagem = Viagem::find($id);
        $data = null;
        if ($request->data_volta) {
            $data = date('Y-m-d H:m:s', strtotime($request->data_volta));
        }
        $viagem->update([
            'observacao' => $request->observacao,
            'origem' => $request->origem,
            'destino' => $request->destino, 
            'data_ida' => date('Y-m-d H:m:s', strtotime($request->data_ida)),
            'data_volta' => $data, 
            'locacao' => $request->locacao,
            'hospedagem' => $request->hospedagem,
            'bagagem' => $request->bagagem, 
            'kg' => $request->kg,
        ]);

        //dd($viagem);
        \Session::flash('flash_message',[
            'msg'=>"Viagem Atualizada com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        return redirect()->route('viagem.editar', $viagem->solicitacoes_id);
    }
    public function addViagem(Request $request,$id){

        //dd(date('Y-m-d H:m:s', strtotime($request->data_volta)));
        $data = null;
        if ($request->data_volta) {
            $data = date('Y-m-d H:m:s', strtotime($request->data_volta)); 
        }
        Viagem::create(
            [
                'observacao' => $request->observacao,
                'origem' => $request->origem,
                'destino' => $request->destino, 
                'data_ida' => date('Y-m-d H:m:s', strtotime($request->data_ida)),
                'data_volta' => $data, 
                'hospedagem' => $request->hospedagem,
                'bagagem' => $request->bagagem, 
                'kg' => $request->kg,
                'solicitacoes_id' => $id,                

            ]
        );
        \Session::flash('flash_message',[
            'msg'=>"Viagem Cadastrada com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        return redirect()->route('viagem.editar',$id);
    }
    //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
    
    public function editarDespesa($id)
    {   
        $despesa = Despesa::find($id);

        return view('viagem.despesa', compact('despesa'));
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
        return redirect()->route('viagem.editar', $despesa->solicitacoes_id);
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
        return redirect()->route('viagem.editar',$s_id);       
    }

    public function addComprovante(Request $request,$id)
    {
        //dd($request->all());
        if ($request->file('anexo_passagem')) {
            $file = Image::make($request->file('anexo_passagem'))->resize(1200, 600);
            $anexo_passagem = (string) $file->encode('data-url');

        } else {
            $anexo_passagem = null;
        }

        if ($request->file('anexo_hospedagem')) {
            $file = Image::make($request->file('anexo_hospedagem'))->resize(1200, 600);
            $anexo_hospedagem = (string) $file->encode('data-url');
        } else {
            $anexo_hospedagem = null;
        }
        
        
        if ($request->file('anexo_locacao')) {
            $file = Image::make($request->file('anexo_locacao'))->resize(1200, 600);
            $anexo_locacao = (string) $file->encode('data-url');
        } else {
            $anexo_locacao = null;
        }


        $comprovante = ViagemComprovante::create([
            'observacao' => $request->observacao,
            'data_compra' => $request->data_compra,
            'custo_passagem' => $request->custo_passagem,
            'custo_hospedagem' => $request->custo_hospedagem,
            'custo_locacao' => $request->custo_locacao,
            'anexo_passagem' => $anexo_passagem,
            'anexo_hospedagem' => $anexo_hospedagem,
            'anexo_locacao' => $anexo_locacao,
        ]);

        $viagem = Viagem::find($request->viagem_id);
        //dd($comprovante->id);
        $solicitacao = Solicitacao::find($id);
        $viagem->update(['viagens_comprovantes_id' => $comprovante->id]);        
        return redirect()->route(strtolower($solicitacao->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $solicitacao->tipo).'.analisar', $solicitacao->id);
    }

    //Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
    public function deletarViagem($id)
    {        

        $viagem = Viagem::find($id);
        $s_id = $viagem->solicitacoes_id;
        $viagem->delete();
        \Session::flash('flash_message',[
            'msg'=>"Viagem Removida com Sucesso!!!",
            'class'=>"alert bg-red alert-dismissible"
        ]);
        return redirect()->route('viagem.editar',$s_id);       
    }
    
    //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
    public function atualizarCabecalho(Request $request,$id)
    {   
        $repo = new SolicitacaoRepository();
        $solicitacao = $repo->update($request,$id);

        \Session::flash('flash_message',[
            'msg'=>"Solicitação Atualizada com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        return redirect()->route('viagem.editar',$id);
    }

}
