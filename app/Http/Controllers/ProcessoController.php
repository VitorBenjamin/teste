<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Processo;
class ProcessoController extends Controller
{

	public function getProcesso(Request $search){
		$processos = Processo::where('codigo','like','%'.$search->input('query').'%')
		->select('codigo') 
		->get();
		return response()->json($processos);
	}

}
