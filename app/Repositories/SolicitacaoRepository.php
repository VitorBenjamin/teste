<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Junity\Hashids\Facades\Hashids;
use App\Despesa;
use App\Processo;
use App\Hospedagem;
use App\Locacao;
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
        //$data['codigo'] = random_int(100, 99999);
        $data['tipo'] = $tipo;
        if ($request->processo != "") 
        {
            $processo = Processo::where('codigo',$request->processo)->first();
            if ($processo != "") 
            {

                $data['processos_id'] = $processo->id;
            }else{
                $processo = Processo::create([
                    'codigo' => $request->processo,
                    'clientes_id' => $request->clientes_id,
                ]);
                $data['processos_id'] = $processo->id;
            }
        }

        $solicitacao = Solicitacao::create($data);
        $solicitacao->codigo = Hashids::encode($solicitacao->id);
        $solicitacao->save();
        $status = Status::where('descricao',config('constantes.status_aberto'))->first();
        $solicitacao->status()->attach($status);

        return $solicitacao;
    }

    private function montaData($data)
    {
        $id = DB::table('clientes')->select('id')->where('nome','MOSELLO LIMA')->first();
        if ($data->origem_despesa == "CLIENTE") {

            $dados = [   
                'urgente' => $data->urgente,
                'origem_despesa' => $data->origem_despesa,
                'contrato' => $data->contrato == null ? null : $data->contrato,
                'area_atuacoes_id'=>$data->area_atuacoes_id,
                'clientes_id' => $data->clientes_id == null ? $id->id : $data->clientes_id,
                'solicitantes_id' => $data->solicitantes_id == null ? null : $data->solicitantes_id,
                'unidades_id' => auth()->user()->unidades_id,
                'users_id' => auth()->user()->id,
                'role' => auth()->user()->roles()->first()->name,
            ];
        }else{
            $dados = [   
                'urgente' => $data->urgente,
                'origem_despesa' => $data->origem_despesa,
                'contrato' => null,
                'area_atuacoes_id'=>$data->area_atuacoes_id,
                'clientes_id' => $id->id,
                'solicitantes_id' => null,
                'unidades_id' => auth()->user()->unidades_id,
                'users_id' => auth()->user()->id,
                'role' => auth()->user()->roles()->first()->name,
            ];
        }
        return $dados;
    }

    public function getSolicitacaoFinanceiro($statu)
    {
        //  $status = Status::with(['solicitacao' => function($q){
        //     $q->select('id','codigo', 'urgente', 'tipo', 'origem_despesa', 'contrato')->take(10);
        //  }])->where('descricao',$status)->first();

        $status = Status::with(['solicitacao' => function($q) use ($statu)
        {
            if ($statu == config('constantes.status_aprovado') || $statu == config('constantes.status_recorrente')) {
                $q
                ->where('tipo','<>','VIAGEM')
                ->where('tipo','<>','COMPRA')
                ->orderBy('created_at');
            }elseif ($statu == "FINALIZADO") {
                $q
                ->take(20)
                ->orderBy('created_at');
            }else{
                $q->orderBy('created_at');
            }

        }])->where('descricao',$statu)->first();

        $solicitacoes = $this->valorTotalAdvogado($status);
        return $solicitacoes;
    }
    public function getSolicitacaoAdministrativo($statu)
    {
        $status = Status::with(['solicitacao' => function($q) use ($statu)
        {
            if ($statu == "FINALIZADO") 
            {
                $q
                ->take(20)
                ->where('tipo','=','VIAGEM')
                ->orWhere('tipo','=','COMPRA')
                ->orderBy('created_at');
            }else{
                $q
                ->where('tipo','=','VIAGEM')
                ->orWhere('tipo','=','COMPRA')
                ->orderBy('created_at');
            }
        }])->where('descricao',$statu)->first();

        $solicitacoes = $this->valorTotalAdvogado($status);
        return $solicitacoes;
    }

    public function getSolicitacaoAdvogado($status)
    {
        $status = Status::with(['solicitacao' => function($q)
        {
            $q->where('users_id',auth()->user()->id)->orderBy('created_at');
        }])->where('descricao',$status)->first();

        $solicitacoes = $this->valorTotalAdvogado($status);
        return $solicitacoes;
    }

    public function getSolicitacaoCoordenador($statu)
    {
        $area_id = array();
        $advogados = array();
        $clientes = array();
        $limites = auth()->user()->limites;

        foreach ($limites as $limite) 
        {
            array_push($area_id,$limite->area_atuacoes_id);
        }
        foreach (auth()->user()->clientes as $cliente) 
        {
            array_push($clientes,$cliente->id);
        }
        foreach (auth()->user()->users as $advogado) 
        {
            array_push($advogados,$advogado->id);
        }
        if ($statu == "FINALIZADO") 
        {
            $take = "take(30)";
        }else{
            $take = "take(999)";
        }
        if (!empty($area_id)) 
        {
            $status = Status::with(['solicitacao' => function($q) use ($area_id,$advogados,$clientes,$statu)
            {     
                if ($statu == "FINALIZADO") 
                {
                    $q
                    ->take(20)
                    ->whereIn('area_atuacoes_id', $area_id)
                    ->whereIn('users_id', $advogados)
                    ->whereIn('clientes_id', $clientes)
                    ->where('users_id','<>',auth()->user()->id)
                    ->where('role','<>',"ADMINISTRATIVO");
                }else{
                    $q
                    ->whereIn('area_atuacoes_id', $area_id)
                    ->whereIn('users_id', $advogados)
                    ->whereIn('clientes_id', $clientes)
                    ->where('users_id','<>',auth()->user()->id)
                    ->where('role','<>',"ADMINISTRATIVO");
                }      
            }])->where('descricao',$statu)->first();
        }else {
            $status = Status::with('solicitacao')->where('descricao',$status)->first();
        }
        $solicitacoes = $this->valorTotalCoordenador($status,$limites);

        /* INICIO ADMINISTRATIVO */
        if (auth()->user()->diretor) {
            $status2 = Status::with(['solicitacao' => function($q)
            {           
                $q->where('role',"ADMINISTRATIVO");

            }])->where('descricao',$statu)->first();

            $solicitacoes2 = $this->valorTotalAdvogado($status2);
            $solicitacoes = $this->pushSolicitacao($solicitacoes,$solicitacoes2);
        }elseif (auth()->user()->diretor_fina) {
            $status2 = Status::with(['solicitacao' => function($q)
            {           
                $q->where('role',"FINANCEIRO");

            }])->where('descricao',$statu)->first();
            //dd($status2);
            $solicitacoes2 = $this->valorTotalAdvogado($status2);
            $solicitacoes = $this->pushSolicitacao($solicitacoes,$solicitacoes2);
        }
        /* FIM ADMINISTRATIVO */
        return $solicitacoes;
    }
    public function pushSolicitacao($solicitacoes,$pushSolici)
    {
        foreach ($pushSolici->solicitacao as $value) {
            $solicitacoes->solicitacao->push($value);
        }
        return $solicitacoes;
    }
    public function getSolicitacaoDiretor($status)
    {

        $status = Status::with(['solicitacao' => function($q) use ($area_id,$advogados,$clientes)
        {           
            $q->where('role',"ADMINISTRATIVO");

        }])->where('descricao',$status)->first();

        $solicitacoes = $this->valorTotalAdvogado($status);
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
            }else{
                $processo = Processo::create([
                    'codigo' => $request->processo,
                    'clientes_id' => $request->clientes_id,
                ]);
                $data['processos_id'] = $processo->id;
            }
        }else{
            $data['processos_id'] = null;  
        }

        $solicitacao = Solicitacao::where('id',$id)->update($data);
        return $solicitacao;
    }

    // public function notification()
    // {
    //     //$role = config('constantes.user_advogado');
    //     $users = Role::with('user')
    //     ->where('name', config('constantes.user_coordenador'))
    //     ->get();

    //     $cordenadores = User::where('');
    // }
    public function getRange($total, $limites, $s)
    {
        $area_id = array();

        foreach ($limites as $limite) 
        {

            array_push($area_id,$limite->area_atuacoes_id);

        }

        foreach ($limites as $limite) 
        {
            if (empty($area_id)) 
            {
            //dd($limite);
                if ($total >= $limite->de && $total <= $limite->ate) 
                {

                    return true;

                }else {
                    return false;
                }
            }else{

                if ($s->area_atuacoes_id == $limite->area_atuacoes_id) 
                {
                    $unidades = $limite->unidades;

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

    }
    public function getUnidadeLimites($total, $limites, $s)
    {
        $area_id = array();

        foreach ($limites as $limite) 
        {

            array_push($area_id,$limite->area_atuacoes_id);

        }

        foreach ($limites as $limite) 
        {
            if (empty($area_id)) 
            {
                if ($total <= $limite->ate) 
                {

                    return true;

                }else {
                    return false;
                }
            }else{

                if ($s->area_atuacoes_id == $limite->area_atuacoes_id) 
                {
                    $unidades = $limite->unidades;

                    if ($unidades !=null)
                    {
                        if (!$unidades->contains('id',$s->unidades_id)) {
                            return false;
                        }

                        if ($total <= $limite->ate) 
                        {

                            return true;

                        }else {
                            return false;
                        }
                    }
                }
            }
        }

    }
    public function verificaLimite($s, $limites)
    {
        $temp = 0;
        if ($s->tipo=="REEMBOLSO") 
        {
            $temp = $this->totalReembolso($s);
            if ($this->getUnidadeLimites($temp,$limites,$s) ) 
            {
                return true;
            }                    
        }elseif ($s->tipo=="VIAGEM") 
        {
            $temp = $this->totalViagem($s);
            if ($this->getUnidadeLimites($temp,$limites,$s) ) 
            {
                return true;
            } 

        }elseif($s->tipo=="GUIA") 
        {
            $temp = $this->totalGuia($s);
            if ($this->getUnidadeLimites($temp,$limites,$s) ) 
            {
                return true;
            } 
        }elseif ($s->tipo=="COMPRA") 
        {
            $temp = $this->totalCompra($s);
            if ($this->getUnidadeLimites($temp,$limites,$s) ) 
            {
                return true;
            } 
        }elseif ($s->tipo=="ANTECIPAÇÃO") 
        {
            $temp = $this->totalAntecipacao($s);
            if ($this->getUnidadeLimites($temp,$limites,$s) ) 
            {
                return true;
            } 
        }else {
            return false;
        }

    }
    public function valorTotalCoordenador($solicitacoes, $limites)
    {
        //dd(is_array($solicitacoes));
        //dd($solicitacoes);
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
        //dd($solicitacoes->solicitacao);

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
    public function valorTotal($solicitacoes)
    {
        //dd($solicitacoes);

        foreach ($solicitacoes as $s) {
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
        $km = $reembolso->cliente == null ? config('constantes.km') : $reembolso->cliente->valor_km;
        if ($reembolso->despesa != null ) {
            foreach ($reembolso->despesa as $despesa) {
                $total += $despesa->valor;
            }
        }
        if ($reembolso->translado != null) {

            foreach ($reembolso->translado as $translado) {
                $translado['valor'] = $translado->distancia*$km;
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
        if ($compras->compra != null ) {
            foreach ($compras->compra as $compra) {
                if (count($compra->cotacao) >0) {
                    $menor = $compra->cotacao[0]->valor;

                    foreach ($compra->cotacao as $cotacao) {

                        if ($cotacao->valor<$menor) {
                            $menor = $cotacao->valor;
                        }
                    }
                    $total += $menor;
                }
            }
        }

        return $total;
    }

    public function totalViagem($viagens)
    {
        $total = 0;
        foreach ($viagens->viagem as $viagem) 
        {   
            //dd($viagem->locacoes);
            //dd(Hospedagem::find($viagem->hospedagens_id));
            $total += $viagem->valor;
            if ($viagem->locacoes) {
                $total += $viagem->locacoes->valor;
            }
            if ($viagem->hospedagens) {
                $total += $viagem->hospedagens->custo_hospedagem;
            }

            // if ($viagem->viagens_comprovantes_id != null ) {
            //     $total += $viagem->comprovante->custo_passagem;
            //     $total += $viagem->comprovante->custo_hospedagem;
            //     $total += $viagem->comprovante->custo_locacao;
            // }
            $viagem['total']=$total;
        }

        $total += $this->totalViagemDespesa($viagens);
        return $total;
    }

    public function totalViagemDespesa($viagens)
    {
        $total = 0;
        if (!empty($viagens->despesa)) {
            foreach ($viagens->despesa as $despesa) {
                $total += $despesa->valor;
            }
        }
        return $total;
    }

    public function totalAntecipacao($antecipacoes)
    {
        $total = 0;
        //$solicitadd($antecipacoes);
        if ($antecipacoes->antecipacao != null ) {
            foreach ($antecipacoes->antecipacao as $antecipacao) {
                $total += $antecipacao->valor;
            }
        }
        foreach ($antecipacoes->despesa as $despesa) {
            $total += $despesa->valor;
        }
        return $total;
    }

    // public function andamento($id)
    // {
    //     $aberto = Status::where('descricao',config('constantes.status_aberto'))->first();
    //     $andamento = Status::where('descricao',config('constantes.status_andamento'))->first();
    //     $solicitacao = Solicitacao::find($id);      
    //     $solicitacao->status()->detach($aberto);
    //     $solicitacao->status()->attach($andamento);
    //     return redirect()->route('solicitacao.index');
    // }

    public function deletar(Request $request)
    {

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