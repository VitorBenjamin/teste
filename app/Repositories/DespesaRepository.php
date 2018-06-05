<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Despesa;
use Intervention\Image\Facades\Image;

class DespesaRepository
{

    public function __construct()
    {

    }
    public function create($request,$id)
    {
        $mime = $request->file('anexo_comprovante')->getClientMimeType();
        $data = self::montaData($request);
        $data['solicitacoes_id'] = $id;
        if ($mime == "image/jpeg" || $mime == "image/jpg") {
            $file = Image::make($request->file('anexo_comprovante'));
            $file->widen(1280, function ($constraint) {
                $constraint->upsize();
            });
            $img_64 = (string) $file->encode('data-url');
            $data['anexo_comprovante'] = $img_64;
        }else{
            \Session::flash('flash_message',[
                'msg'=>"Arquivo tipo (".$mime.") não suportado!!!",
                'class'=>"alert bg-orange alert-dismissible"
            ]);
            return redirect()->back();
        } 
        $despesa = Despesa::create($data);
        return $despesa;
    }

    private function montaData($data)
    {
        $data = 
        [   
            'descricao' => $data->descricao,
            'data_despesa' => date('Y-m-d', strtotime($data->data_despesa)),
            'tipo_comprovante' => $data->tipo_comprovante,
            'valor' => $data->valor,
        ];
        return $data;
    }
    public function update($request,$id)
    {
        $despesa = Despesa::find($id);
        $mime = $request->file('anexo_comprovante')->getClientMimeType();
        $data = self::montaData($request);
        $data['solicitacoes_id'] = $id;
        if ($mime == "image/jpeg" || $mime == "image/jpg") {
            $file = Image::make($request->file('anexo_comprovante'))->encode('jpg');
            $file->widen(1280, function ($constraint) {
                $constraint->upsize();
            });
            $anexo = (string) $file->encode('data-url');
            $data['anexo_comprovante'] = $anexo;
        }else{
            \Session::flash('flash_message',[
                'msg'=>"Arquivo tipo (".$mime.") não suportado!!!",
                'class'=>"alert bg-orange alert-dismissible"
            ]);
            return redirect()->back();
        }
        $despesa->update($data);
        return $despesa;
    }
}