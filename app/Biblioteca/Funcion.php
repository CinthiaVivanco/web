<?php
namespace App\Biblioteca;

use Illuminate\Support\Facades\DB;
use Hashids,Session,Redirect,table;
use App\WEBRolOpcion,App\WEBListaCliente,App\STDTipoDocumento,App\WEBPrecioProducto,App\WEBReglaProductoCliente;
use App\WEBRegla,App\WEBUserEmpresaCentro,App\WEBPrecioProductoContrato,App\CMPCategoria;
use Keygen;
use PDO;

class Funcion{


	public function lista_precios_departamento_cliente($contrato_id,$producto_id,$cliente_id) {


		$departamento_id 					= 	"";
		$lista_reglas_departamento 			= 	WEBReglaProductoCliente::join('WEB.reglas', 'WEB.reglas.id', '=', 'WEB.reglaproductoclientes.regla_id')
												->join('CMP.CATEGORIA', 'WEB.reglas.departamento_id', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
												->where('WEB.reglaproductoclientes.activo','=','1')
												->where('WEB.reglas.activo','=','1')
												->where('WEB.reglas.estado','=','PU')
												->where('WEB.reglas.tiporegla','=','PRD')
												->where('WEB.reglaproductoclientes.contrato_id','=',$contrato_id)
												->where('WEB.reglaproductoclientes.cliente_id','=',$cliente_id)
												->where('WEB.reglaproductoclientes.producto_id','=',$producto_id)
												->get();


		$lista_precio_departamento = array();
		$cadena = '';
		// RECORRER TODOS LOS DEPARTAMENTOS CON SU PRECIO
		foreach($lista_reglas_departamento as $item){

			$departamento_id 	= 	$item->departamento_id;

			$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC web.precio_producto_contrato ?,?,?,?');
	        $stmt->bindParam(1, $contrato_id ,PDO::PARAM_STR);
	        $stmt->bindParam(2, $producto_id ,PDO::PARAM_STR);
	        $stmt->bindParam(3, $cliente_id ,PDO::PARAM_STR);
	        $stmt->bindParam(4, $departamento_id ,PDO::PARAM_STR); 
	        $stmt->execute();
	        $resultado = $stmt->fetch();

	        $cadena	=	$item->NOM_CATEGORIA.' : S/. '.$resultado['precio'];
			array_push($lista_precio_departamento, $cadena);

		}

	 	return   $lista_precio_departamento;				 			
	}



	public function descuento_reglas_producto($contrato_id,$producto_id,$cliente_id,$departamento_id) {

		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC web.descuento_regla_producto_contrato ?,?,?,?');
        $stmt->bindParam(1, $contrato_id ,PDO::PARAM_STR);
        $stmt->bindParam(2, $producto_id ,PDO::PARAM_STR);
        $stmt->bindParam(3, $cliente_id ,PDO::PARAM_STR);
        $stmt->bindParam(4, $departamento_id ,PDO::PARAM_STR); 
        $stmt->execute();
        $resultado = $stmt->fetch();
		return  $resultado['descuento'];
			 			
	}


	public function precio_descuento_reglas_producto($contrato_id,$producto_id,$cliente_id,$departamento_id) {

		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC web.precio_producto_contrato ?,?,?,?');
        $stmt->bindParam(1, $contrato_id ,PDO::PARAM_STR);
        $stmt->bindParam(2, $producto_id ,PDO::PARAM_STR);
        $stmt->bindParam(3, $cliente_id ,PDO::PARAM_STR);
        $stmt->bindParam(4, $departamento_id ,PDO::PARAM_STR); 
        $stmt->execute();
        $resultado = $stmt->fetch();
		return  $resultado['precio'];
			 			
	}



	public function lista_reglas_cliente($contrato_id,$producto_id) {


		$lista_reglas_cliente 			= 	WEBReglaProductoCliente::join('WEB.reglas', 'WEB.reglas.id', '=', 'WEB.reglaproductoclientes.regla_id')
												->where('WEB.reglaproductoclientes.activo','=','1')
												->where('WEB.reglas.activo','=','1')
												->where('WEB.reglas.estado','=','PU')
												->where('WEB.reglas.tiporegla','<>','PRD')
												->where('WEB.reglas.empresa_id','=',Session::get('empresas')->COD_EMPR)
												->where('WEB.reglas.centro_id','=',Session::get('centros')->COD_CENTRO)
												->where('WEB.reglaproductoclientes.contrato_id','=',$contrato_id)
												->where('WEB.reglaproductoclientes.producto_id','=',$producto_id)
												->orderBy('WEB.reglas.departamento_id', 'asc')
												->get();

	 	return   $lista_reglas_cliente;				 			
	}




	public function lista_precio_regular_departamento($contrato_id,$producto_id) {


		$lista_precio_regular_departamento 	= 	WEBReglaProductoCliente::join('WEB.reglas', 'WEB.reglas.id', '=', 'WEB.reglaproductoclientes.regla_id')
												->where('WEB.reglaproductoclientes.activo','=','1')
												->where('WEB.reglas.activo','=','1')
												->where('WEB.reglas.estado','=','PU')
												->where('WEB.reglas.tiporegla','=','PRD')
												->where('WEB.reglas.empresa_id','=',Session::get('empresas')->COD_EMPR)
												->where('WEB.reglas.centro_id','=',Session::get('centros')->COD_CENTRO)
												->where('WEB.reglaproductoclientes.contrato_id','=',$contrato_id)
												->where('WEB.reglaproductoclientes.producto_id','=',$producto_id)
												->orderBy('WEB.reglas.departamento_id', 'asc')
												->get();

	 	return   $lista_precio_regular_departamento;				 			
	}



	public function lista_productos_reglas($cuenta_id) {

		$array_productos_id 	= 	WEBReglaProductoCliente::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
									->join('WEB.reglas', 'WEB.reglas.id', '=', 'WEB.reglaproductoclientes.regla_id')
									->where('WEB.reglas.activo','=','1')
									->where('WEB.reglas.estado','=','PU')
									->where('WEB.reglas.tiporegla','<>','PRD')
									->where('WEB.reglas.empresa_id','=',Session::get('empresas')->COD_EMPR)
									->where('WEB.reglas.centro_id','=',Session::get('centros')->COD_CENTRO)
									->where('WEB.reglaproductoclientes.contrato_id','=',$cuenta_id)
									->where('WEB.reglaproductoclientes.activo','=','1')
									->pluck('WEB.reglaproductoclientes.producto_id')->toArray();


		$lista_producto_regla 	= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
					    			->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
					    			->where('centro_id','=',Session::get('centros')->COD_CENTRO)
									->whereIn('producto_id',$array_productos_id)
	    					 		->orderBy('NOM_PRODUCTO', 'asc')->get();



	 	return   $lista_producto_regla;				 			
	}



	public function lista_productos_precio_favotitos($cuenta_id) {

		$lista_producto_precio 	= 	WEBPrecioProductoContrato::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
							    	->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
					    			->where('centro_id','=',Session::get('centros')->COD_CENTRO)
									->where('contrato_id','=',$cuenta_id)
									->where('activo','=','1')
									->where('ind_contrato','=',1)
									->orderBy('NOM_PRODUCTO', 'asc')
									->get();

	 	return   $lista_producto_precio;				 			
	}


	public function combo_tipo_precio_productos_reglas() {

		$combotipoprecio_producto  	= 	array('2' => "Reglas" ,'1' => "Contratos" ,'0' => "Todos");
		return $combotipoprecio_producto;		 			
	}

	public function combo_tipo_precio_productos() {

		$combotipoprecio_producto  	= 	array('1' => "Contratos" ,'0' => "Todos");
		return $combotipoprecio_producto;		 			
	}


	public function combo_tipo_precio_productos_asignar() {
		$combotipoprecio_producto  	= 	array('0' => "Todos",'1' => "Contratos" ,);
		return $combotipoprecio_producto;		 			
	}


	public function tiene_contrato_activo($precioproducto_id,$contrato_id) {
		

		$precio_producto 		  	= 	WEBPrecioProducto::where('id','=',$precioproducto_id)->first();

		$precio_producto_contrato 	= 	WEBPrecioProductoContrato::where('producto_id','=',$precio_producto->producto_id)
										->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
										->where('centro_id','=',Session::get('centros')->COD_CENTRO)
										->where('contrato_id','=',$contrato_id)
										->first();

		if(count($precio_producto_contrato)>0){
			if($precio_producto_contrato->ind_contrato == 1){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}

					 			
	}

	public function favorito_precio_producto_contrato($precioproducto_id,$contrato_id) {
		

		$precio_producto 		  	= 	WEBPrecioProducto::where('id','=',$precioproducto_id)->first();

		$precio_producto_contrato 	= 	WEBPrecioProductoContrato::where('producto_id','=',$precio_producto->producto_id)
										->where('empresa_id','=',$precio_producto->empresa_id)
										->where('centro_id','=',$precio_producto->centro_id)
										->where('contrato_id','=',$contrato_id)
										->first();

		if(count($precio_producto_contrato)>0){
			return true;
		}else{
			return false;
		}

					 			
	}




	public function calculo_precio_regular($cliente,$producto) {


		$precioregular =      	WEBPrecioProductoContrato::where('contrato_id','=',$cliente->COD_CONTRATO)
								->where('producto_id','=',$producto->producto_id)
								->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
								->where('centro_id','=',Session::get('centros')->COD_CENTRO)
								->first();


		if(count($precioregular)){
			return $precioregular->precio;
		}

		return $producto->precio;
	 			
	}


	public function combo_clientes_cuenta() {

		$listaclientes   		=	WEBListaCliente::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
					    			->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
									->pluck('NOM_EMPR','COD_CONTRATO')
									->toArray();

		$combolistaclientes  	= 	array('' => "Seleccione cliente") + $listaclientes;
		return $combolistaclientes;		 			
	}



	public function combo_clientes() {

		$listaclientes   		=	WEBListaCliente::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
					    			->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
									->pluck('NOM_EMPR','id')
									->toArray();

		$combolistaclientes  	= 	array('' => "Seleccione cliente") + $listaclientes;
		return $combolistaclientes;		 			
	}

	public function departamento($departamento_id) {

		$departamento   		=	CMPCategoria::where('TXT_PREFIJO','=','DEP')
									->where('COD_CATEGORIA','=',$departamento_id)
									->first();

		return 	$departamento;		 			
	}


	public function combo_departamentos() {

		$listadepartamentos   		=	CMPCategoria::where('TXT_PREFIJO','=','DEP')
										->where('COD_ESTADO','=',1)
										->pluck('NOM_CATEGORIA','COD_CATEGORIA')
										->toArray();

		$combolistadepartamentos  	= 	array('' => "Seleccione departamento") + $listadepartamentos;
		return $combolistadepartamentos;					 			
	}


	public function combo_departamentos_modificar($documento_id) {

		$listadepartamentos   		=	CMPCategoria::where('TXT_PREFIJO','=','DEP')
										->where('COD_ESTADO','=',1)
										->pluck('NOM_CATEGORIA','COD_CATEGORIA')
										->toArray();

		$nombre_departamento 		=   $this->departamento($documento_id)->NOM_CATEGORIA;

		$combolistadepartamentos  	= 	array($documento_id => $nombre_departamento) + $listadepartamentos;
		return $combolistadepartamentos;					 			
	}


	public function precio_producto_contrato($precioproducto_id,$contrato_id) {
		

		$precio_producto 		  	= 	WEBPrecioProducto::where('id','=',$precioproducto_id)->first();

		$precio_producto_contrato 	= 	WEBPrecioProductoContrato::where('producto_id','=',$precio_producto->producto_id)
										->where('empresa_id','=',$precio_producto->empresa_id)
										->where('centro_id','=',$precio_producto->centro_id)
										->where('contrato_id','=',$contrato_id)
										->first();

		if(count($precio_producto_contrato)>0){
			return $precio_producto_contrato->precio;
		}else{
			return $precio_producto->precio;
		}

					 			
	}


	public function cuenta_cliente($id_cliente) {
		
		$cuenta 		= 		DB::table('WEB.LISTACLIENTE')
        							->where('id','=',$id_cliente)
        							->first();

	 	return  $cuenta->CONTRATO;					 			
	}


	public function tipo_cambio() {
		
		$tipocambio 		= 		DB::table('WEB.VIEWTIPOCAMBIO')
        							->where('FEC_CAMBIO','<=',date('d/m/Y'))
        							->orderBy('FEC_CAMBIO', 'desc')
        							->first();

        return $tipocambio; 							
	}




	public function desencriptar_id($id,$count) {
		
		$idarray = explode('-', $id);
	  	//decodificar variable
	  	$decid 	= Hashids::decode($idarray[1]);
	  	//ver si viene con letras la cadena codificada
	  	if(count($decid)==0){ 
	  		return Redirect::back()->withInput()->with('errorurl', 'Indices de la url con errores'); 
	  	}
	  	//concatenar con ceros
	  	$idcompleta = str_pad($decid[0], $count, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo
		$idcompleta = $idarray[0].$idcompleta;
		return $idcompleta;
	}


	public function calcular_cabecera_total($productos) {

		$total 						=   0.0000;
		$productos 					= 	json_decode($productos, true);

		foreach($productos as $obj){
			$total = $total + (float)$obj['precio_producto']*(float)$obj['cantidad_producto'];
		}
		return $total;
	}

	public function calculo_igv($monto) {
	  	return $monto - ($monto/1.18);
	}
	public function calculo_subtotal($monto) {
	  	return $monto/1.18;
	}

	public function generar_codigo($basedatos,$cantidad) {

	  		// maximo valor de la tabla referente
			$tabla = DB::table($basedatos)
            ->select(DB::raw('max(codigo) as codigo'))
            ->get();

            //conversion a string y suma uno para el siguiente id
            $idsuma = (int)$tabla[0]->codigo + 1;

		  	//concatenar con ceros
		  	$correlativocompleta = str_pad($idsuma, $cantidad, "0", STR_PAD_LEFT); 

	  		return $correlativocompleta;

	}

	public function tiene_perfil($empresa_id,$centro_id,$usuario_id) {

		$perfiles 		=   WEBUserEmpresaCentro::where('empresa_id','=',$empresa_id)
							->where('centro_id','=',$centro_id)
							->where('usuario_id','=',$usuario_id)
							->where('activo','=','1')
							->first();

		if(count($perfiles)>0){
			return true;
		}else{
			return false;
		}	

	}

	public function precio_regla_calculo_menor_cero($producto_id,$cliente_id,$mensaje,$tiporegla,$regla_id) {

		$mensaje					=   $mensaje;
		$error						=   false;
		$precio 					=   WEBPrecioProducto::where('producto_id','=',$producto_id)
								    	->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
					    				->where('centro_id','=',Session::get('centros')->COD_CENTRO)
										->first();

		$regla 						=   WEBRegla::where('id','=',$regla_id)->first();

		$calculo 					= 	$this->calculo_precio_regla($regla->tipodescuento,$precio->precio,$regla->descuento,$regla->descuentoaumento);

		if($calculo < 0 && $regla->descuentoaumento <> 'AU'){
			$mensaje = 'La regla afecta al precio del producto en un valor negativo';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;
	}


	public function calculo_precio_regla($tipodescuento,$precio,$descuento,$aumentodescuento) {


		// precio regular 



		//calculo entre el producto y la regla
		$calculo = 0;
		if($tipodescuento == 'IMP'){
			if($aumentodescuento == 'AU'){
				$calculo = $precio + $descuento;
			}else{
				$calculo = $precio - $descuento;
			}
		}else{
			if($aumentodescuento == 'AU'){
				$calculo = $precio + $precio * ($descuento/100);
			}else{
				$calculo = $precio - $precio * ($descuento/100);
			}
		}
		return $calculo;

	}



	public function tiene_regla_activa($producto_id,$cliente_id,$contrato_id,$mensaje,$tiporegla) {

		$mensaje					=   $mensaje;
		$error						=   false;
		$cantidad 					=  	0;

		$listareglas = 	WEBReglaProductoCliente::join('WEB.reglas', 'WEB.reglaproductoclientes.regla_id', '=', 'WEB.reglas.id')
						->where('producto_id','=',$producto_id)
						->where('WEB.reglas.tiporegla','=',$tiporegla)
						->where('cliente_id','=',$cliente_id)
						->where('contrato_id','=',$contrato_id)
						->where('WEB.reglaproductoclientes.activo','=','1')
						->get();

		if($tiporegla=='PNC' or $tiporegla=='POV' or $tiporegla=='PRD'){
			$cantidad = 6; //osea si tiene 7 reglas
		}

		if($tiporegla=='NEG'){
			$cantidad = 0; //osea si tiene 2 reglas
		}

		if($tiporegla=='CUP'){
			$cantidad = 0; //osea si tiene 2 reglas
		}


		if(count($listareglas) > $cantidad ){
			$mensaje = 'Tienes una regla activa por el momento';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}

	public function tiene_regla_repetida_departamento($producto_id,$cliente_id,$contrato_id,$departamento_id_pr,$mensaje,$tipo){

		$mensaje					=   $mensaje;
		$error						=   false;
		$cantidad 					=  	0;

		$listareglas = 	WEBReglaProductoCliente::join('WEB.reglas', 'WEB.reglaproductoclientes.regla_id', '=', 'WEB.reglas.id')
						->where('WEB.reglaproductoclientes.producto_id','=',$producto_id)
						->where('WEB.reglaproductoclientes.cliente_id','=',$cliente_id)
						->where('WEB.reglaproductoclientes.contrato_id','=',$contrato_id)
						->where('WEB.reglas.departamento_id','=',$departamento_id_pr)						
						->where('WEB.reglaproductoclientes.activo','=','1')
						->get();


		if(count($listareglas) > 0){
			$mensaje = 'Este departamento ya tiene un precio regular';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}


	public function tiene_regla_repetida($producto_id,$cliente_id,$contrato_id,$regla_id,$mensaje,$tiporegla){

		$mensaje					=   $mensaje;
		$error						=   false;
		$cantidad 					=  	0;

		$listareglas = 	WEBReglaProductoCliente::where('producto_id','=',$producto_id)
						->where('cliente_id','=',$cliente_id)
						->where('contrato_id','=',$contrato_id)
						->where('regla_id','=',$regla_id)						
						->where('activo','=','1')
						->get();

		if(count($listareglas) > 0){
			$mensaje = 'Esta que registra regla repetida';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}




	public function reglas_actualizar_modal($producto_id,$cliente_id,$contrato_id,$tiporegla) {

		$listareglas = 	WEBReglaProductoCliente::join('WEB.reglas', 'WEB.reglaproductoclientes.regla_id', '=', 'WEB.reglas.id')
						->select('WEB.reglaproductoclientes.*')
						->where('producto_id','=',$producto_id)
						->where('WEB.reglas.tiporegla','=',$tiporegla)
						->where('cliente_id','=',$cliente_id)
						->where('contrato_id','=',$contrato_id)
						->where('WEB.reglaproductoclientes.activo','=','1')
						->orderBy('WEB.reglaproductoclientes.activo', 'desc')
						->orderBy('WEB.reglaproductoclientes.fecha_crea', 'desc')
						//->take(5)
						->get();

	 	return  $listareglas;
	}

	public function combo_activas_regla_tipo($tipo,$nombreselect) {


		if($tipo == 'PRD'){

			$lista_activas 		= 	WEBRegla::join('CMP.CATEGORIA', 'COD_CATEGORIA', '=', 'departamento_id')
									->where('activo','=',1)
									->where('tiporegla','=',$tipo)
									->where('estado','=','PU')
									->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
	    							->where('centro_id','=',Session::get('centros')->COD_CENTRO)
									->select('id', DB::raw("(nombre + ' ' + NOM_CATEGORIA + ' ' + CASE WHEN tipodescuento = 'POR' THEN '%' WHEN tipodescuento = 'IMP' THEN 'S/.' END + CAST(descuento AS varchar(100)) ) AS nombre"))
									->pluck('nombre','id')
									->toArray();			
		}else{

		
			$lista_activas 		= 	WEBRegla::where('activo','=',1)
									->where('tiporegla','=',$tipo)
									->where('estado','=','PU')
									->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
	    							->where('centro_id','=',Session::get('centros')->COD_CENTRO)									
									->select('id', DB::raw("(nombre + ' ' + CASE WHEN tipodescuento = 'POR' THEN '%' WHEN tipodescuento = 'IMP' THEN 'S/.' END  + CAST(descuento AS varchar(100)) ) AS nombre"))
									->pluck('nombre','id')
									->toArray();


		}




		$comboreglas 		= 	array('' => "Seleccione ".$nombreselect) + $lista_activas;

	 	return  $comboreglas;

	}

	
	public function nombre_producto_seleccionado($idproducto) {

		$nombre 						= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
											->where('producto_id','=',$idproducto)
					    					->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
					    					->where('centro_id','=',Session::get('centros')->COD_CENTRO)
	    					 				->first();
	 	return    $nombre->NOM_PRODUCTO;					 			
	}


	public function lista_productos_precio_buscar($idproducto,$tipoprecio_id,$contrato_id) {

		if($idproducto != ''){

			$lista_producto_precio 		= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
											->where('producto_id','=',$idproducto)
					    					->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
					    					->where('centro_id','=',Session::get('centros')->COD_CENTRO)
	    					 				->orderBy('NOM_PRODUCTO', 'asc')
	    					 				->get();
		}else{


			if($tipoprecio_id == '1'){

				$arrayproducto_id 				= 	WEBPrecioProductoContrato::where('WEB.precioproductocontratos.activo','=','1')
													->where('WEB.precioproductocontratos.ind_contrato','=','1')												
													->where('WEB.precioproductocontratos.empresa_id','=',Session::get('empresas')->COD_EMPR)
													->where('WEB.precioproductocontratos.centro_id','=',Session::get('centros')->COD_CENTRO)
													->where('WEB.precioproductocontratos.contrato_id','=',$contrato_id)
													->pluck('WEB.precioproductocontratos.producto_id')->toArray();


				$lista_producto_precio 		= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
						    					->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
						    					->where('centro_id','=',Session::get('centros')->COD_CENTRO)
						    					->whereIn('producto_id',$arrayproducto_id)
		    					 				->orderBy('NOM_PRODUCTO', 'asc')->get();

			}else{

				$lista_producto_precio 		= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
						    					->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
						    					->where('centro_id','=',Session::get('centros')->COD_CENTRO)
						    					//->whereIn('producto_id',$arrayproducto_id)
		    					 				->orderBy('NOM_PRODUCTO', 'asc')->get();

			}



		}

	 	return    $lista_producto_precio;					 			
	}


	public function producto_buscar($idproducto) {

		$producto 		= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
	    					->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
	    					->where('centro_id','=',Session::get('centros')->COD_CENTRO)
							->where('producto_id','=',$idproducto)
    					 	->first();

	 	return    $producto;					 			
	}

	public function regla_buscar($regla_id){

		$regla 		= 	WEBRegla::where('id','=',$regla_id)
    					->first();

	 	return    $regla;					 			
	}

	public function cliente_buscar($cliente_id) {

		$cliente 		= 	WEBListaCliente::where('id','=',$cliente_id)
    						->first();

	 	return    $cliente;					 			
	}



	public function lista_productos_precio() {

		$lista_producto_precio 		= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
					    				->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
					    				->where('centro_id','=',Session::get('centros')->COD_CENTRO)
	    					 			->orderBy('NOM_PRODUCTO', 'asc')->get();
	 	return    $lista_producto_precio;				 			
	}


	public function combo_nombres_lista_productos() {

		$lista_producto_precio 		= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
						    			->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
						    			->where('centro_id','=',Session::get('centros')->COD_CENTRO)
										->pluck('NOM_PRODUCTO','producto_id')
										->take(10)
										->toArray();

		$combolistaproductos  		= 	array('' => "Seleccione producto") + $lista_producto_precio;

	 	return  $combolistaproductos;					 			
	}

	public function combo_nombres_lista_clientes() {

		$listaclientes   		=	WEBListaCliente::select('NOM_EMPR')
					    			->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
					    			->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
									->pluck('NOM_EMPR','NOM_EMPR')
									->take(10)
									->toArray();

		$combolistaclientes  	= 	array('' => "Seleccione clientes") + $listaclientes;
		return $combolistaclientes;					 			
	}






	public function respuestavacio($cliente,$producto_select) {

		if(!is_null($cliente)){
			return false;
		}
		if(!is_null($producto_select)){
			return false;
		}

		return true;
	}

	public function array_id_clientes_top($cantidad){
		$arrayidclientes   			=	WEBListaCliente::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
					    				->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
										->take($cantidad)->pluck('id')->toArray();
		return $arrayidclientes;
	}

	public function combotipodocumentoxclientes() {

		$arraytipodocumentocliente   	=	WEBListaCliente::select('COD_TIPO_DOCUMENTO','NOM_TIPO_DOCUMENTO')
											->groupBy('COD_TIPO_DOCUMENTO')
											->groupBy('NOM_TIPO_DOCUMENTO')
											->where('COD_TIPO_DOCUMENTO','!=','')
					    					->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
					    					->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
											->pluck('NOM_TIPO_DOCUMENTO','COD_TIPO_DOCUMENTO')
											->toArray();

		$combotipodocumento  			= 	array('' => "Seleccione tipo documento") + $arraytipodocumentocliente;

		return $combotipodocumento;

	}

	public function getUrl($idopcion,$accion) {

	  	//decodificar variable
	  	$decidopcion = Hashids::decode($idopcion);
	  	//ver si viene con letras la cadena codificada
	  	if(count($decidopcion)==0){ 
	  		return Redirect::back()->withInput()->with('errorurl', 'Indices de la url con errores'); 
	  	}

	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($decidopcion[0], 8, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo

	  	// hemos hecho eso porque ahora el prefijo va hacer fijo en todas las empresas que 1CIX
		//$prefijo = Local::where('activo', '=', 1)->first();
		//$idopcioncompleta = $prefijo->prefijoLocal.$idopcioncompleta;
		$idopcioncompleta = '1CIX'.$idopcioncompleta;

	  	// ver si la opcion existe
	  	$opcion =  WEBRolOpcion::where('opcion_id', '=',$idopcioncompleta)
	  			   ->where('rol_id', '=',Session::get('usuario')->rol_id)
	  			   ->where($accion, '=',1)
	  			   ->first();

	  	if(count($opcion)<=0){
	  		return Redirect::back()->withInput()->with('errorurl', 'No tiene autorización para '.$accion.' aquí');
	  	}
	  	return 'true';

	 }

	public function prefijomaestra() {

		$prefijo = '1CIX';
	  	return $prefijo;
	}

	public function getCreateIdMaestra($tabla) {

  		$id="";

  		// maximo valor de la tabla referente
		$id = DB::table($tabla)
        ->select(DB::raw('max(SUBSTRING(id,5,8)) as id'))
        ->get();

        //conversion a string y suma uno para el siguiente id
        $idsuma = (int)$id[0]->id + 1;

	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($idsuma, 8, "0", STR_PAD_LEFT);

	  	//concatenar prefijo
		$prefijo = $this->prefijomaestra();

		$idopcioncompleta = $prefijo.$idopcioncompleta;

  		return $idopcioncompleta;	

	}

	public function decodificarmaestra($id) {

	  	//decodificar variable
	  	$iddeco = Hashids::decode($id);
	  	//ver si viene con letras la cadena codificada
	  	if(count($iddeco)==0){ 
	  		return ''; 
	  	}
	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($iddeco[0], 8, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo

		//$prefijo = Local::where('activo', '=', 1)->first();

		// apunta ahi en tu cuaderno porque esto solo va a permitir decodifcar  cuando sea el contrato del locl en donde estas del resto no 
		//¿cuando sea el contrato del local?
		$prefijo = $this->prefijomaestra();
		$idopcioncompleta = $prefijo.$idopcioncompleta;
	  	return $idopcioncompleta;

	}


	public function decodificarid($id,$prefijo) {

	  	//decodificar variable
	  	$iddeco = Hashids::decode($id);
	  	//ver si viene con letras la cadena codificada
	  	if(count($iddeco)==0){ 
	  		return ''; 
	  	}
	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($iddeco[0], 13, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo
		$idopcioncompleta = $prefijo.$idopcioncompleta;
	  	return $idopcioncompleta;

	}

	public function codecupon(){
	  	return Hashids::encode(Keygen::numeric(10)->generate());
	}





}

