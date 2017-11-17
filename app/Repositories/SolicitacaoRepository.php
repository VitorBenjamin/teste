<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Despesa;
use App\Processo;
use App\Translado;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;
use App\Status;

class SolicitacaoRepository
{

    public function __construct()
    {

    }
    public function create($request,$tipo)
    {

        $data = self::montaData($request);
        $data['codigo'] = random_int(100, 99999);
        $data['tipo'] = $tipo;
        //dd($request->processo);
        if ($request->processo != "") 
        {
            //dd($request->processo, ' asdadasdasdas');
            $processo = Processo::where('id',$request->processo)->first();
            if ($processo != "") 
            {

                $data['processos_id'] = $processo->id;
            }
        }
        $solicitacao = Solicitacao::create($data);

        $status = Status::where('descricao',config('constantes.status_aberto'))->first();
        $solicitacao->status()->attach($status);

        return $solicitacao;
    }

    private function montaData($data)
    {

        $dados = [   

            'urgente' => $data->urgente,
            'origem_despesa' => $data->origem_despesa,
            'contrato' => $data->contrato,
            'area_atuacoes_id'=>$data->area_atuacoes_id,
            'clientes_id' => $data->clientes_id,
            'solicitantes_id' => $data->solicitantes_id,
            'unidades_id' => auth()->user()->unidades_id,
            'users_id' => auth()->user()->id,
        ];
        return $dados;
    }

    public function getSolicitacaoFinanceiro($status)
    {
        //  $status = Status::with(['solicitacao' => function($q){
        //     $q->select('id','codigo', 'urgente', 'tipo', 'origem_despesa', 'contrato')->take(10);
        //  }])->where('descricao',$status)->first();

        $status = Status::with(['solicitacao' => function($q)
        {
            $q->orderBy('created_at');
        }])->where('descricao',$status)->first();

        $solicitacoes = $this->valorTotalAdvogado($status);
        return $solicitacoes;
    }

    public function getSolicitacaoAdvogado($status)
    {
        //  $status = Status::with(['solicitacao' => function($q){
        //     $q->select('id','codigo', 'urgente', 'tipo', 'origem_despesa', 'contrato')->take(10);
        //  }])->where('descricao',$status)->first();

        $status = Status::with(['solicitacao' => function($q)
        {
            $q->where('users_id',auth()->user()->id)->orderBy('created_at');
        }])->where('descricao',$status)->first();

        $solicitacoes = $this->valorTotalAdvogado($status);
        return $solicitacoes;
    }
    
    public function getSolicitacaoCoordenador($status)
    {
        $area_id = array();
        $limites = auth()->user()->limites;
        foreach ($limites as $limite) 
        {

            array_push($area_id,$limite->area_atuacoes_id);

        }
        //dd($area_id);
        $status = Status::with(['solicitacao' => function($q) use ($area_id)
        {           
            //array_push($area_id,$limites->id);
            //$q->with('area_atuacoes_id');
            if (!empty($area_id)) {
                $q->whereIn('area_atuacoes_id', $area_id);
            }            
        }])->where('descricao',$status)->first();
        
        $solicitacoes = $this->valorTotalCoordenador($status,$limites);
        //dd($status);
        return $solicitacoes;
    }

    public function update($request,$id)
    {
        $data = self::montaData($request);

        if ($request->processo != "") {
            $processo = Processo::where('codigo',$request->processo)->first();

            if ($processo != "") 
            {

                $data['processos_id'] = $processo->id;
            }
        }

        $solicitacao = Solicitacao::where('id',$id)->update($data);

        return $solicitacao;
    }

    public function getRange($total, $limites, $s)
    {

        foreach ($limites as $limite) 
        {
            //dd($limite->unidades);

            if ($s->area_atuacoes_id == $limite->area_atuacoes_id) 
            {
                $unidades = $limite->unidades;
                //dd($limites);
                if ($unidades !=null)
                {
                    if (!$unidades->contains('id',$s->unidades_id)) {
                        return false;
                    }

                    if ($total >= $limite->de && $total <= $limite->ate) 
                    {

                        return true;

                    }else {
                        return false;
                    }
                }
            }
        }
    }
    public function valorTotalCoordenador($solicitacoes, $limites)
    {
       //dd(is_array($solicitacoes));
        if (!empty($solicitacoes->solicitacao)) 
        {
            foreach ($solicitacoes->solicitacao  as $key => $s) 
            {
                $temp = 0;
                if ($s->tipo=="REEMBOLSO") 
                {
                    $temp = $this->totalReembolso($s);
                    if ($this->getRange($temp,$limites,$s) ) 
                    {
                        $s['total']=$this->totalReembolso($s);
                    }else{
                        unset($solicitacoes->solicitacao[$key]);
                    }                    
                }
                if ($s->tipo=="VIAGEM") 
                {
                    $temp = $this->totalViagem($s);
                    if ($this->getRange($temp,$limites,$s) ) 
                    {
                        $s['total']=$this->totalViagem($s);
                    }else {
                        unset($solicitacoes->solicitacao[$key]);
                    } 

                }
                if ($s->tipo=="GUIA") 
                {
                    $temp = $this->totalGuia($s);
                    if ($this->getRange($temp,$limites,$s) ) 
                    {
                        $s['total']=$this->totalGuia($s);
                    }else {
                        unset($solicitacoes->solicitacao[$key]);
                    } 
                }
                if ($s->tipo=="COMPRA") 
                {
                    $temp = $this->totalCompra($s);
                    if ($this->getRange($temp,$limites,$s) ) 
                    {
                        $s['total']=$this->totalCompra($s);
                    }else {
                        unset($solicitacoes->solicitacao[$key]);
                    } 
                }
                if ($s->tipo=="ANTECIPAÇÃO") 
                {
                    $temp = $this->totalAntecipacao($s);
                    if ($this->getRange($temp,$limites,$s) ) 
                    {
                        $s['total']=$this->totalAntecipacao($s);
                    }else {
                        unset($solicitacoes->solicitacao[$key]);
                    } 
                }           
            }
        }
        return $solicitacoes;

    }

    public function valorTotalAdvogado($solicitacoes)
    {
        foreach ($solicitacoes->solicitacao as $s) {
            if ($s->tipo=="REEMBOLSO") {
                $s['total']=$this->totalReembolso($s);
            }
            if ($s->tipo=="VIAGEM") {
                $s['total']=$this->totalViagem($s);
            }
            if ($s->tipo=="GUIA") {
                $s['total']=$this->totalGuia($s);
            }
            if ($s->tipo=="COMPRA") {
                $s['total']=$this->totalCompra($s);
            }
            if ($s->tipo=="ANTECIPAÇÃO") {
                $s['total']=$this->totalAntecipacao($s);
            }           
        }
        return $solicitacoes;
    }

    public function totalReembolso($reembolso)
    {
        //dd($reembolso);
        $total = 0;
        $km = $reembolso->cliente == null ? config('constantes.km') : $reembolso->cliente->km;
        if ($reembolso->despesa != null ) {
            foreach ($reembolso->despesa as $despesa) {
                $total += $despesa->valor;
            }
        }
        if ($reembolso->translado != null) {

            foreach ($reembolso->translado as $translado) {
                $total += $translado->distancia*$km;
            }
        }
        return $total;
    }

    public function totalGuia($guias)
    {
        $total = 0;
        if ($guias->guia != null ) {
            foreach ($guias->guia as $guia) {
                $total += $guia->valor;
            }
        }
        return $total;
    }

    public function totalCompra($compras)
    {
        $total = 0;
        $menor = 999999;
        if ($compras->compra != null ) {
            foreach ($compras->compra as $compra) {
                foreach ($compra->cotacao as $cotacao) {

                    if ($cotacao->valor<$menor) {

                        $menor = $cotacao->valor;
                    }

                }
                if ($menor != 999999) {

                    $total += $menor;
                }
            }
        }

        return $total;
    }

    public function totalViagem($viagens)
    {
        $total = 0;
        if ($viagens->comprovante != null ) {
            foreach ($viagens->comprovante as $comprovante) {
                $total += $comprovante->custo_passagem;
                $total += $comprovante->custo_hospedagem;
                $total += $comprovante->custo_locacao;
            }
        }
        if ($viagens->reembolso != null) {

            $total += $this->totalReembolso($viagens->reembolso);
        }
        return $total;
    }

    public function totalAntecipacao($antecipacoes)
    {
        $total = 0;
        if ($antecipacoes->antecipacao != null ) {
            foreach ($antecipacoes->antecipacao as $antecipacao) {
                $total += $antecipacao->valor_solicitado;
            }
        }
        return $total;
    }

    public function andamento($id)
    {
        $aberto = Status::where('descricao',config('constantes.status_aberto'))->first();
        $andamento = Status::where('descricao',config('constantes.status_andamento'))->first();
        $solicitacao = Solicitacao::find($id);      
        $solicitacao->status()->detach($aberto);
        $solicitacao->status()->attach($andamento);
        return redirect()->route('solicitacao.index');

    }

    public function deletar(Request $request)
    {
        //echo "asdasdasdasdasd";
        $solicitacao = Solicitacao::where('id',$request->id)->with('status')->first();
        foreach ($solicitacao->status as $status) {

            if ($status->descricao == config('constantes.status_aberto')) {

                $tipo = $solicitacao->tipo;
                if ($solicitacao->delete()) {
                    \Session::flash('flash_message',[
                        'msg'=> $tipo. "Removido com Sucesso!!!",
                        'class'=>"alert bg-red alert-dismissible"
                    ]);
                    return route('solicitacao.index');
                }
            }else {

                \Session::flash('flash_message',[
                    'msg'=>"Solicitação não pode ser removida.",
                    'class'=>"alert bg-red alert-dismissible"

                ]);

                return redirect()->route('solicitacao.index');
            }   
        }
        return route('solicitacao.index');
    }

}