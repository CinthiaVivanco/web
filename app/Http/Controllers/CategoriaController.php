<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\CMPCategoria;
use Session;

class CategoriaController extends Controller
{
    public function ListarCategoria(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        $grupo = $request->buscar;

        if ($grupo=='JEFE_VENTA') {
            
             $categoria = CMPCategoria::from('CMP.CATEGORIA AS CA')
            ->select('CA.COD_CATEGORIA', 'CA.NOM_CATEGORIA')
            ->where('CA.COD_ESTADO','=',1)
            ->where('IND_ACTIVO','=',1)
            ->where('CA.TXT_GRUPO', '=' , $grupo)
            ->where('CA.TXT_ABREVIATURA','=', Session::get('centros')->COD_CENTRO)
            ->get();
            
            return [
                
                'categoria' => $categoria
            ];

        }else {
            $categoria = CMPCategoria::from('CMP.CATEGORIA AS CA')
            ->select('CA.COD_CATEGORIA', 'CA.NOM_CATEGORIA')
            ->where('CA.COD_ESTADO','=',1)
            ->where('CA.TXT_GRUPO', '=' , $grupo)
            ->get();
            
            return [
                
                'categoria' => $categoria
            ];
        }


      
    }
}
