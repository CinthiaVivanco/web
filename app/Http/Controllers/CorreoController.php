<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\WEBRegla;
use Session;

class CorreoController extends Controller
{
    public function enviocorreo(Request $request)
    {

        $accion = 0;
        // alerta para desactivar reglas
        if($accion = 1){

            $listado_reglas = WEBRegla::get();

        }


      
    }
}
