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
        //dd($mime);
        $data = self::montaData($request);
        $data['solicitacoes_id'] = $id;
        if ($mime == "image/jpeg") {
            //dd($request->file('anexo_comprovante'));
            $file = Image::make($request->file('anexo_comprovante'));
            $img_64 = (string) $file->encode('data-url');
            $data['anexo_comprovante'] = $img_64;
        }else{

            Session::flash('flash_message',[
                'msg'=>"Arquivo não suportado!!!",
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
        if ($request->hasFile('anexo_comprovante')) {
            if ($mime == "image/jpeg") {
                $data['anexo_pdf'] = null;
                $file = Image::make($request->file('anexo_comprovante'))->encode('jpg');
                $anexo = (string) $file->encode('data-url');
                $data['anexo_comprovante'] = $anexo;
            }elseif ($mime == "application/pdf") {
                Session::flash('flash_message',[
                    'msg'=>"Arquivo não suportado!!!",
                    'class'=>"alert bg-orange alert-dismissible"
                ]);
                return redirect()->back();
                $data['anexo_comprovante'] = null;
                $today = (string) date("Y-m-d");
                $fileName = $today.'_'.$id.'_'.$request->anexo_comprovante->getClientOriginalName();    
                $request->anexo_comprovante->storeAs('public/antecipacao',$fileName);
                $data['anexo_pdf'] = $fileName;
            }else{

                Session::flash('flash_message',[
                    'msg'=>"Arquivo não suportado!!!",
                    'class'=>"alert bg-orange alert-dismissible"
                ]);
                return redirect()->back();
            }
        }else{
            if ($despesa->anexo_comprovante) {
                $data['anexo_comprovante'] = $despesa->anexo_comprovante;
            } else {
                $data['anexo_pdf'] = $despesa->anexo_pdf;
            }
        }
        $despesa->update($data);
        return $despesa;
    }
}