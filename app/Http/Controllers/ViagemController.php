<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SolicitacaoHelper;
use Illuminate\Http\Request;
use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Repositories\SolicitacaoRepository;
use App\Repositories\DespesaRepository;
use App\Processo;
use App\Viagem;
use App\Locacao;
use App\Hospedagem;
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
        $despesa_repo = new DespesaRepository();
        $despesa = $despesa_repo->create($request,$id);
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
        //$solicitantes = Solicitante::all('id','nome');
        return view('viagem.editar', compact('solicitacao','clientes','areas'));
    }
    public function editarViagem($id)
    {
        $viagem = Viagem::find($id);
        
        return view('viagem.editarViagem', compact('viagem'));
    }

    //Atualiza uma viagem e redireciona para a tela de edição da Solicitação
    public function atualizarViagem(Request $request,$id)
    {   
        //dd($request->all());
        $viagem = Viagem::find($id);
        $data = null;
        if ($request->data_volta) {
            $data = date('Y-m-d', strtotime($request->data_volta));
        }
        $viagem->update([
            'observacao' => $request->observacao,
            'origem' => $request->origem,
            'destino' => $request->destino, 
            'data_ida' => date('Y-m-d', strtotime($request->data_ida)),
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

        //dd(date('Y-m-d', strtotime($request->data_volta)));
        $data = null;
        if ($request->data_volta) {
            $data = date('Y-m-d', strtotime($request->data_volta)); 
        }
        Viagem::create(
            [
                'observacao' => $request->observacao,
                'origem' => $request->origem,
                'destino' => $request->destino, 
                'data_ida' => date('Y-m-d', strtotime($request->data_ida)),
                'data_volta' => $data, 
                'locacao' => $request->locacao,
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

    public function addCotacao(Request $request,$id)
    {
        //dd($request->all());
        $viagem = Viagem::find($request->viagem_id);
        if ($request->data_cotacao_passagem) {
            $viagem->valor = $request->custo_passagem;
            $viagem->data_cotacao = date('Y-m-d', strtotime($request->data_cotacao_passagem));
            $viagem->observacao_comprovante = $request->observacao_passagem;
            $viagem->save();
        }
        if ($request->custo_hospedagem) {
            $data2 = [
                'data_cotacao' => date('Y-m-d', strtotime($request->data_cotacao_hospedagem)),
                'observacao' => $request->observacao_hospedagem,
                'custo_hospedagem' => $request->custo_hospedagem,
                'viagens_id' => $request->viagem_id,
            ];

            if ($viagem->hospedagens) {
                $hospedagem = $viagem->hospedagens;
                $hospedagem->update($data2);
            }else{
                $hospedagem = Hospedagem::create($data2);
                $viagem->update(['hospedagens_id' => $hospedagem->id]);
            }
            
        }
        if ($request->custo_locacao) {
            $data3 = [
                'data_cotacao' => date('Y-m-d', strtotime($request->data_cotacao_locacao)),
                'observacao' => $request->observacao_locacao,
                'valor' => $request->custo_locacao,
                'viagens_id' => $request->viagem_id,
            ];
            if ($viagem->locacoes) {
                $locacao = $viagem->locacoes;
                $locacao->update($data3);
            }else{
                $locacao = Locacao::create($data3);
                $viagem->update(['locacoes_id' => $locacao->id]);
            }
            
        }
        \Session::flash('flash_message',[
            'msg'=>"Cotações Adiciondas com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        $solicitacao = Solicitacao::find($id);
        return redirect()->route(strtolower($solicitacao->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $solicitacao->tipo).'.analisar', $solicitacao->id);
    }

    public function addComprovante(Request $request,$id)
    {
        $viagem = Viagem::find($request->viagem_id);
        if ($request->file('anexo_passagem')) {
            $mime = $request->file('anexo_passagem')->getClientMimeType();
            $data = [
                'valor' => $request->custo_passagem,
                'data_compra' => date('Y-m-d', strtotime($request->data_compra)),
                'observacao_comprovante' => $request->oberservacao,
            ];
            if ($mime == "image/jpeg" || $mime == "image/png") {
                $file = Image::make($request->file('anexo_passagem'));
                $anexo_passagem = (string) $file->encode('data-url');
                $data['anexo_passagem'] = $anexo_passagem;
                $viagem->update($data);
            }elseif ($mime == "application/pdf") {
                $today = (string) date("Y-m-d");
                $fileName = $today.'_'.$id.'_'.$request->anexo_passagem->getClientOriginalName();    
                $request->anexo_passagem->storeAs('public/viagem',$fileName);
                $data['anexo_pdf'] = $fileName;
                $viagem->update($data);
            }else{
                Session::flash('flash_message',[
                    'msg'=>"Arquivo não suportado!!!",
                    'class'=>"alert bg-orange alert-dismissible"
                ]);
                return redirect()->back();
            }
        } else {
            $anexo_passagem = null;
        }
        
        if ($viagem->hospedagens && $request->file('anexo_hospedagem')) {
            $mime = $request->file('anexo_hospedagem')->getClientMimeType();
            $data2 = [
                'data_compra' => date('Y-m-d', strtotime($request->data_hospedagem)),
                'observacao' => $request->observacao_hospedagem,
                'custo_hospedagem' => $request->custo_hospedagem,
                'viagens_id' => $request->viagem_id,
            ];
            if ($mime == "image/jpeg" || $mime == "image/png") {
                $file = Image::make($request->file('anexo_hospedagem'));
                $anexo_hospedagem = (string) $file->encode('data-url');
                $data2['anexo_hospedagem']=$anexo_hospedagem;
                $hospedagem = Hospedagem::create($data2);
                $viagem->update(['hospedagens_id' => $hospedagem->id]);
            } elseif ($mime == "application/pdf") {
                $today = (string) date("Y-m-d");
                $fileName = $today.'_'.$id.'_'.$request->anexo_hospedagem->getClientOriginalName();    
                $request->anexo_hospedagem->storeAs('public/hospedagem',$fileName);
                $data2['anexo_pdf'] = $fileName;
                $hospedagem = Hospedagem::create($data2);
                $viagem->update(['hospedagens_id' => $hospedagem->id]);
            }else{
                Session::flash('flash_message',[
                    'msg'=>"Arquivo não suportado!!!",
                    'class'=>"alert bg-orange alert-dismissible"
                ]);
                return redirect()->back();
            }
        }

        if ($request->file('anexo_locacao')) {
            $mime = $request->file('anexo_locacao')->getClientMimeType();
            $data3 = [
                'data_compra' => date('Y-m-d', strtotime($request->data_hospedagem)),
                'observacao' => $request->observacao_hospedagem,
                'custo_hospedagem' => $request->custo_hospedagem,
                'viagens_id' => $request->viagem_id,
            ];
            if ($mime == "image/jpeg" || $mime == "image/png") {
                $file = Image::make($request->file('anexo_locacao'));
                $anexo_locacao = (string) $file->encode('data-url');
                $data3['anexo_locacao']=$anexo_locacao;
                $locacao = Locacao::create($data3);
                $viagem->update(['locacoes_id' => $locacao->id]);
            } elseif ($mime == "application/pdf") {
                $today = (string) date("Y-m-d");
                $fileName = $today.'_'.$id.'_'.$request->anexo_locacao->getClientOriginalName();    
                $request->anexo_locacao->storeAs('public/locacao',$fileName);
                $data3['anexo_pdf'] = $fileName;
                $locacao = Locacao::create($data3);
                $viagem->update(['locacoes_id' => $locacao->id]);
            }else{
                Session::flash('flash_message',[
                    'msg'=>"Arquivo não suportado!!!",
                    'class'=>"alert bg-orange alert-dismissible"
                ]);
                return redirect()->back();
            }
        }

        $solicitacao = Solicitacao::find($id);
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
