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

        $accion = 1;

        // alerta de las reglas que se van a desactivar al dia siguiente
        if($accion = 1){


        	$tipo 							= 	'PRD';
			$fecha_actual 					= 	date("d-m-Y");
			$fecha_manana   				= 	date("Y-m-d",strtotime($fecha_actual."+ 1 days"));

			// 	LIMA
			$lista_reglas_desactivaran 		= 	WEBRegla::where('activo','=',1)
												->where('tiporegla','<>',$tipo)
												->where('estado','=','PU')
												->where('centro_id','=','CEN0000000000002')
												->where('fechafin','<>','1900-01-01 00:00:00.000')
												->whereRaw('Convert(varchar(10), fechafin, 120) = ?', [$fecha_manana])
				    							->get();


			//  CHILAYO
			


        }


      
    }
}
