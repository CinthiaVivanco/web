<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\WEBListaCliente,App\STDTipoDocumento,App\WEBReglaProductoCliente;
use App\WEBPrecioProductoContrato,App\WEBPrecioProductoContratoHistorial;
use View;
use Session;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class ProductoReporteController extends Controller
{


	public function actionPrecioProductoXcliente($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		$comboclientes				= 	$this->funciones->combo_clientes_cuenta();
		$combotipoprecio_producto	= 	$this->funciones->combo_tipo_precio_productos();		
	
		return View::make('catalogo/reporte/precioproductoxcliente',
						 [
						 	'idopcion' 					=> $idopcion,
							'comboclientes' 			=> $comboclientes,
							'combotipoprecio_producto' 	=> $combotipoprecio_producto,
							'inicio'					=> $this->inicio,
							'hoy'						=> $this->fin,
						 ]);

	}


	public function actionAjaxProductosxCliente(Request $request)
	{

		set_time_limit(0);
		$cuenta_id 						=  	$request['cuenta_id'];
		$tipoprecio_id 					=  	$request['tipoprecio_id'];		

		if($tipoprecio_id=='1'){

	    	// lista productos
	    	$listadeproductos 				= 	$this->funciones->lista_productos_precio_favotitos($cuenta_id);	


		}else{
	    	// lista productos
	    	$listadeproductos 				= 	$this->funciones->lista_productos_precio();			
		}

		// lista de clientes
		$listacliente 					= 	WEBListaCliente::where('COD_CONTRATO','=',$cuenta_id)
											->orderBy('NOM_EMPR', 'asc')
											->get();




		$funcion 						= 	$this;


		return View::make('catalogo/reporte/ajax/listaprecioproducto',
						 [
							'listadeproductos'   	=> $listadeproductos,
							'listacliente'   		=> $listacliente,
						 	'funcion' 				=> $funcion,						 				 							 							 						 					 
						 ]);

	}



	public function actionPrecioProductoClienteExcel($idcuenta,$idtipoprecio)
	{
		set_time_limit(0);


		$cuenta_id 				=  	$idcuenta;
		$tipoprecio_id 			=  	$idtipoprecio;
		$nombretipoprecio		=   'TODO';

		if($tipoprecio_id == '1'){
			$nombretipoprecio		=   'CONTRATOS';
		}

		$titulo 				=   'Precios de los Productos';
		if($tipoprecio_id=='1'){
	    	// lista productos
	    	$listadeproductos 				= 	$this->funciones->lista_productos_precio_favotitos($cuenta_id);	

		}else{
	    	// lista productos
	    	$listadeproductos 				= 	$this->funciones->lista_productos_precio();			
		}


		$funcion 				= 	$this;	

		// lista de clientes
		$listacliente 					= 	WEBListaCliente::where('COD_CONTRATO','=',$cuenta_id)
											->orderBy('NOM_EMPR', 'asc')
											->get();

		$empresa 				= 	Session::get('empresas')->NOM_EMPR;
		$centro 				= 	Session::get('centros')->NOM_CENTRO;								


	    Excel::create($titulo.' ('.$nombretipoprecio.')', function($excel) use ($listadeproductos,$titulo,$listacliente,$funcion,$empresa,$centro) {

	        $excel->sheet('Precios Productos', function($sheet) use ($listadeproductos,$titulo,$listacliente,$funcion,$empresa,$centro) {

	            $sheet->loadView('catalogo/excel/listaprecioproducto')->with('listadeproductos',$listadeproductos)
	                                         		 ->with('titulo',$titulo)
	                                         		 ->with('listacliente',$listacliente)
	                                         		 ->with('empresa',$empresa)
	                                         		 ->with('centro',$centro)	                                         		 
	                                         		 ->with('funcion',$funcion);	                                         		 
	        });
	    })->export('xls');

	}




	public function actionPrecioProductoClientePDF($idcuenta,$idtipoprecio)
	{

		$cuenta_id 				=  	$idcuenta;
		$tipoprecio_id 			=  	$idtipoprecio;
		$nombretipoprecio		=   'TODO';

		if($tipoprecio_id == '1'){
			$nombretipoprecio		=   'CONTRATOS';
		}

		$titulo 				=   'Precios de los Productos';
		if($tipoprecio_id=='1'){
	    	// lista productos
	    	$listadeproductos 				= 	$this->funciones->lista_productos_precio_favotitos($cuenta_id);	

		}else{
	    	// lista productos
	    	$listadeproductos 				= 	$this->funciones->lista_productos_precio();			
		}


		$funcion 				= 	$this;	

		// lista de clientes
		$listacliente 			= 	WEBListaCliente::where('COD_CONTRATO','=',$cuenta_id)
									->orderBy('NOM_EMPR', 'asc')
									->get();

		$empresa 				= 	Session::get('empresas')->NOM_EMPR;
		$centro 				= 	Session::get('centros')->NOM_CENTRO;	
		$fechaactual 			=   $this->fechaactualinput;



		$pdf 					= 	PDF::loadView('catalogo.pdf.listaprecioproducto', 
												[
													'listadeproductos' 	  => $listadeproductos,
													'titulo' 		  	  => $titulo,
													'listacliente' 		  => $listacliente,
													'empresa' 		  	  => $empresa,											
													'centro' 		  	  => $centro,
													'funcion' 		  	  => $funcion,
													'fechaactual' 		  => $fechaactual,										
												]);

		return $pdf->stream('download.pdf');
	}









}
