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


		//$status = Status::find(1);
		$status = Status::with('solicitacao')->where('descricao',"ABERTO")->get();
		dd($status);


		$status = \App\solicitacao::with(
			[
			'status' => function ($query) {
				$query->where('status.descricao', 'ABERTO');
			}
			])->get();
		dd($status);
		foreach ($status->Solicitacao()->get() as $value) {
			echo($value);
		}
		

		
		//dd($status->solicitacao()->get());
		//return view('reembolso.index',compact('solicitacao'));
	}
}
