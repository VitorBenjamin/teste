<?php
namespace App\Http\Helpers;

use App\Despesa;
use App\Processo;
use App\Translado;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;
use App\Status;

class SolicitacaoHelper
{

    public function __construct()
    {

    }

    public function verificarStatus($solicitacao)
    {

        foreach ($solicitacao->status as $status) {
            if ($status->descricao == config('constantes.status_aberto') || $status->descricao == config('constantes.status_aberto_etapa2') || $status->descricao == config('constantes.status_recorrente') || $status->descricao == config('constantes.status_devolvido') || $status->descricao == config('constantes.status_devolvido_etapa2')) {
                if ($solicitacao->users_id == auth()->user()->id) {
                    return "ok";
                }else{
                    \Session::flash('flash_message',[
                        'msg'=>"Você não tem permissão para editar essa Solicitação.",
                        'class'=>"alert bg-orange alert-dismissible"

                    ]);
                    return redirect()->route('user.index');
                }
                
            }else {

                \Session::flash('flash_message',[
                    'msg'=>"Solicitação em Andamento. Aguarde um Parecer da Coordenação ",
                    'class'=>"alert bg-orange alert-dismissible"

                ]);

                return redirect()->route('user.index');
            }   
        }
    }

    public  function solicitacaoExist($solicitacao, $tipo)
    {

        if(!$solicitacao){
            \Session::flash('flash_message',[
                'msg'=>"Não Existe essa Solicitacao Cadastrada!!! Deseja Cadastrar uma Nova Solicitação?",
                'class'=>"alert bg-red alert-dismissible"
            ]);
            return redirect()->route(strtolower($tipo).'.cadastrar');            
        }else{
            return "ok";
        }
    }
    public function impressao($s,$lista)
    {
        if ($s->tipo=="REEMBOLSO") {

            return $this->reembolsoPrint($s,$lista);
        }elseif ($s->tipo=="VIAGEM") {

            return $this->viagemPrint($s,$lista);
        }elseif($s->tipo=="GUIA") {

            return $this->guiaPrint($s,$lista);
        }elseif ($s->tipo=="COMPRA") {

            return $this->compraPrint($s,$lista);
        }elseif ($s->tipo=="ANTECIPAÇÃO") {

            return $this->antecipacaoPrint($s,$lista);
        }
    }
    public function reembolsoPrint($s,$lista)
    {
        $processo = $s->processo ? $s->processo->codigo : 'SEM PROCESSO';
        foreach ($s->translado as $t) {
            $lista[] = 
            [
                'data' => date('d-m-Y',strtotime($t->data_translado)),
                'tipo' => $s->tipo,
                'cliente' => $s->cliente,
                'codigo' => $s->codigo,
                'descricao' => 'TRANSLADO - ' .$t->origem. ' - ' .$t->destino. '-' .$t->distancia. ' KM - OBSERVAÇÂO - ' .$t->observacao.' - '.$processo,
                'valor' => $t->distancia * ($s->cliente == null ? config('constantes.km') : $s->cliente->valor_km),
                'estornado' => $t->estornado,
                'img' => null,
                'imgC' => null,
                'exibir' => false,
            ];
        }
        foreach ($s->despesa as $d) {
            $lista[] = 
            [
                'data' => date('d-m-Y',strtotime($d->data_despesa)),
                'tipo' => $s->tipo,
                'cliente' => $s->cliente,
                'codigo' => $s->codigo,
                'descricao' => $d->descricao. ' - ' .$d->tipo_comprovante.' - '.$processo,
                'valor' => $d->valor,
                'estornado' => $d->estornado,
                'img' => $d->anexo_comprovante,
                'imgC' => null,
                'exibir' => true,
            ];

        }
        return $lista;
    }
    public function viagemPrint($s,$lista)
    {
        $processo = $s->processo ? $s->processo->codigo : 'SEM PROCESSO';
        foreach ($s->viagem as $viagem) {
            $data_volta = $viagem->data_volta ? $viagem->data_volta : 'SÓ IDA';
            $bagagem = $viagem->bagagem ? 'BAGAGEM'.$viagem->kg : '';
            $lista[] = 
            [
                'data' => $viagem->translado ? date('d-m-Y',strtotime($viagem->data_ida)) : date('d-m-Y',strtotime($viagem->data_compra)),
                'tipo' => $s->tipo,
                'cliente' => $s->cliente,
                'codigo' => $s->codigo,
                'descricao' => $viagem->origem.' <ida> '.date('d-m-Y',strtotime($viagem->data_ida)).' / '.$viagem->destino.' <volta> '.date('d-m-Y',strtotime($data_volta)).' - '.$bagagem.' - '.$processo,
                'valor' => $viagem->valor ? $viagem->valor : '0',
                'estornado' => $viagem->estornado,
                'img' => $viagem->anexo_passagem ? $viagem->anexo_passagem : null,
                'imgC' => null,
                'exibir' => true,
            ];
        }
        if ($viagem->hospedagens) {
            $lista[] = 
            [
                'data' => date('d-m-Y',strtotime($viagem->hospedagens->data_compra)),
                'tipo' => $s->tipo,
                'cliente' => $s->cliente,
                'codigo' => $s->codigo,
                'descricao' => 'HOSPEDAGEM '.$viagem->hospedagens->observacao.' - '.$processo,
                'valor' => $viagem->hospedagens->custo_hospedagem,
                'estornado' => $viagem->hospedagens->estornado,
                'img' => $viagem->hospedagens->anexo_hospedagem,
                'imgC' => null,
                'exibir' => true,
            ];
        }
        if ($viagem->locacoes) {
            $lista[] = 
            [
                'data' => date('d-m-Y',strtotime($viagem->locacoes->data_compra)),
                'tipo' => $s->tipo,
                'cliente' => $s->cliente,
                'codigo' => $s->codigo,
                'descricao' => 'LOCAÇÃO '.$viagem->locacoes->observacao.' - '.$processo,
                'valor' => $viagem->locacoes->valor,
                'estornado' => $viagem->locacoes->estornado,
                'img' => $viagem->locacoes->anexo_locacao,
                'imgC' => null,
                'exibir' => true,
            ];
        }
        if ($s->despesa) {
            foreach ($s->despesa as $d) {
                $lista[] = 
                [
                    'data' => date('d-m-Y',strtotime($d->data_despesa)),
                    'tipo' => $s->tipo,
                    'cliente' => $s->cliente,
                    'codigo' => $s->codigo,
                    'descricao' => $d->descricao. '-' .$d->tipo_comprovante.' - '.$processo,
                    'valor' => $d->valor,
                    'estornado' => $d->estornado,
                    'img' => $d->anexo_comprovante,
                    'imgC' => null,
                    'exibir' => true,
                ];

            }
        }
        return $lista;
    }
    public function guiaPrint($s,$lista)
    {
        $processo = $s->processo ? $s->processo->codigo : 'SEM PROCESSO';
        foreach ($s->guia as $guia) {
            $lista[] = 
            [
                'data' => $s->comprovante ? date('d-m-Y',strtotime($s->comprovante[0]->data)) : 'UNKNOW',
                'tipo' => $s->tipo,
                'cliente' => $s->cliente,
                'codigo' => $s->codigo,
                'descricao' => 'GUIA - '.$guia->perfil_pagamento. ' - ' .$guia->banco. ' - ' .$guia->tipoGuia()->first()->descricao.' - '.$processo,
                'valor' => $guia->valor,
                'estornado' => $guia->estornado,
                'img' => $guia->anexo_guia,
                'imgC' => $guia->anexo_comprovante,
                'exibir' => true,
            ];
        }
        return $lista;
    }
    public function compraPrint($s,$lista)
    {
        $processo = $s->processo ? $s->processo->codigo : 'SEM PROCESSO';
        foreach ($s->compra as $c) {
            foreach ($c->cotacao as $cota) {
                if ($cota->data_compra) {
                    $lista[] = 
                    [
                        'data' => date('d-m-Y',strtotime($cota->data_compra)),
                        'tipo' => $s->tipo,
                        'cliente' => $s->cliente,
                        'codigo' => $s->codigo,
                        'descricao' => $cota->descricao. ' - Fornecedor '.$cota->fornecedor.' - QUANTIDADE ' .$cota->quantidade.' - '.$processo,
                        'valor' => $cota->valor,
                        'estornado' => $cota->estornado,
                        'img' => $cota->anexo_comprovante,
                        'imgC' => null,
                        'exibir' => true,
                    ];
                }
            }
        }
        return $lista;
    }
    public function antecipacaoPrint($s,$lista)
    {
        $processo = $s->processo ? $s->processo->codigo : 'SEM PROCESSO';
        foreach ($s->despesa as $d) {
            $lista[] = 
            [
                'data' => date('d-m-Y',strtotime($d->data_despesa)),
                'tipo' => $s->tipo,
                'cliente' => $s->cliente,
                'codigo' => $s->codigo,
                'descricao' => $d->descricao. '-' .$d->tipo_comprovante.' - '.$processo,
                'valor' => $d->valor,
                'estornado' => $d->estornado,
                'img' => $d->anexo_comprovante,
                'imgC' => null,
                'exibir' => true,
            ];
        }
        return $lista;
    }
}