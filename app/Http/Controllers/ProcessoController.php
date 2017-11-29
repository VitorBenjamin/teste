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
		$data = array(); 
		foreach ($processos as $value) {
			$data[] = $value->codigo;
		}
		
		return response()->json($data);
	}

}
