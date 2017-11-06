<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitante;


class SolicitanteController extends Controller
{
    //

    public function getSolicitante(Request $search){

        $solicitantes = Solicitante::where('nome','like','%'.$search->q.'%')
        ->select('id','nome')
        ->get();

        return response()->json(array("solicitantes" => $solicitantes));
    }
}
