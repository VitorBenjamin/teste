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

class SolicitacaoController extends Controller
{
    //Buscando todas as informações das solicitacao e enviando para a view de listagem das solicitacao
	public function index()
	{
		//dd(Route::currentRouteName());
		$repo = new SolicitacaoRepository();
		$abertas = $repo->getSolicitacao(config('constantes.status_aberto'));
		$andamentos = $repo->getSolicitacao(config('constantes.status_andamento'));
		$aprovadas = $repo->getSolicitacao(config('constantes.status_aprovado'));
		$reprovados = $repo->getSolicitacao(config('constantes.status_reprovado'));
		$devolvidas = $repo->getSolicitacao(config('constantes.status_devolvido'));

		$abertas = $this->valorTotal($abertas);
		$andamentos = $this->valorTotal($andamentos);
		$aprovadas = $this->valorTotal($aprovadas);
		$reprovados = $this->valorTotal($reprovados);
		$devolvidas = $this->valorTotal($devolvidas);
		// dd($abertas);
		return view('dashboard.index',compact('abertas','andamentos','aprovadas','reprovados','devolvidas'));
	}
	public function valorTotal($solicitacoes)
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

	public function totalReembolso($reebolso)
	{
		$total = 0;
		$km = $reebolso->cliente->valor_km;
		if ($reebolso->despesa != null ) {
			foreach ($reebolso->despesa as $despesa) {
				$total += $despesa->valor;
			}
		}
		if ($reebolso->translado != null) {

			foreach ($reebolso->translado as $translado) {
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

// 	public function deletar(Request $request)
// {
//         //echo "asdasdasdasdasd";
//     $solicitacao = Solicitacao::find($request->id);
//     $tipo = $solicitacao->tipo;
//     if ($solicitacao->delete()) {
//        \Session::flash('flash_message',[
//         'msg'=>" Reembolso Removido com Sucesso!!!",
//         'class'=>"alert bg-red alert-dismissible"
//     ]);
//        return route('solicitacao.index');
//    }

//    return route('solicitacao.index');

// }
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
