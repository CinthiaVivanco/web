<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/********************** USUARIOS *************************/

Route::group(['middleware' => ['guestaw']], function () {

	Route::any('/', 'UserController@actionLogin');
	Route::any('/login', 'UserController@actionLogin');
	Route::any('/acceso', 'UserController@actionAcceso');
	Route::any('/accesobienvenido/{idempresa}/{idcargo}', 'UserController@actionAccesoBienvenido');
	
}); 

Route::get('/cerrarsession', 'UserController@actionCerrarSesion');
Route::get('/cambiarperfil', 'UserController@actionCambiarPerfil');


Route::group(['middleware' => ['authaw']], function () {


	Route::get('/bienvenido', 'UserController@actionBienvenido');

	Route::any('/gestion-de-usuarios/{idopcion}', 'UserController@actionListarUsuarios');
	Route::any('/agregar-usuario/{idopcion}', 'UserController@actionAgregarUsuario');
	Route::any('/modificar-usuario/{idopcion}/{idusuario}', 'UserController@actionModificarUsuario');
	Route::any('/ajax-activar-perfiles', 'UserController@actionAjaxActivarPerfiles');

	Route::any('/gestion-de-roles/{idopcion}', 'UserController@actionListarRoles');
	Route::any('/agregar-rol/{idopcion}', 'UserController@actionAgregarRol');
	Route::any('/modificar-rol/{idopcion}/{idrol}', 'UserController@actionModificarRol');

	Route::any('/gestion-de-permisos/{idopcion}', 'UserController@actionListarPermisos');
	Route::any('/ajax-listado-de-opciones', 'UserController@actionAjaxListarOpciones');
	Route::any('/ajax-activar-permisos', 'UserController@actionAjaxActivarPermisos');

	Route::any('/gestion-de-precio-producto/{idopcion}', 'ProductoController@actionPrecioProducto');
	Route::any('/ajax-guardar-precio-producto', 'ProductoController@actionAjaxGuardarPrecioProducto');

	Route::get('/gestion-de-regla-del-producto/{idopcion}', 'AsignarReglaController@actionListarClienteRegla');
	Route::any('/ajax-modal-detalle', 'AsignarReglaController@actionAjaxModalDetalle');
	Route::any('/ajax-modal-detalle-precio-regular', 'AsignarReglaController@actionAjaxModalDetallePrecioRegular');
	Route::any('/ajax-detalle-regla', 'AsignarReglaController@actionAjaxDetalleRegla');	
	Route::any('/ajax-agregar-regla', 'AsignarReglaController@actionAjaxAgregarRegla');
	Route::any('/ajax-agregar-regla-precio-regular', 'AsignarReglaController@actionAjaxAgregarReglaPrecioRegular');
	Route::any('/ajax-precio-regular-descuento', 'AsignarReglaController@actionAjaxPrecioRegularDescuento');


	Route::any('/ajax-actualizar-lista-regla', 'AsignarReglaController@actionAjaxActualizarListaRegla');
	Route::any('/ajax-actualizar-modal-regla', 'AsignarReglaController@actionAjaxActualizarModalRegla');

	Route::any('/ajax-actualizar-lista-regla-pr', 'AsignarReglaController@actionAjaxActualizarListaReglaPrecioRegular');
	Route::any('/ajax-actualizar-modal-regla-pr', 'AsignarReglaController@actionAjaxActualizarModalReglaPrecioRegular');

	Route::any('/ajax-eliminar-regla', 'AsignarReglaController@actionAjaxEliminarRegla');
	Route::any('/ajax-guardar-precio-producto-contrato', 'AsignarReglaController@actionAjaxGuardarPrecioProductoContrato');
	Route::any('/ajax-cambiar-estado-contrato', 'AsignarReglaController@actionAjaxCambiarEstadoContrato');

	Route::any('/gestion-de-regla-de-negociacion/{idopcion}', 'ProductoController@actionListarReglaNegociacion');
	Route::any('/agregar-regla-negociacion/{idopcion}', 'ProductoController@actionAgregarNegociacion');
	Route::any('/modificar-regla-negociacion/{idopcion}/{idregla}', 'ProductoController@actionModificarNegociacion');

	Route::any('/gestion-de-regla-de-precio-producto/{idopcion}', 'ProductoController@actionListarReglaPrecio');
	Route::any('/agregar-regla-precio/{idopcion}', 'ProductoController@actionAgregarPrecio');
	Route::any('/modificar-regla-precio/{idopcion}/{idregla}', 'ProductoController@actionModificarPrecio');

	Route::any('/gestion-masiva-regla-precio/{idopcion}/{idregla}', 'GestionReglaController@actionGestionMasivaReglaPrecio');
	Route::any('/asignar_reglas_masiva', 'GestionReglaController@actionAsignarReglas');
	Route::any('/ajax-lista-contrato-producto_masivo', 'GestionReglaController@actionAjaxListaContratoProductoMasiva');
	Route::any('/ajax-actualizar-reglas-masivas', 'GestionReglaController@actionAjaxActualizarReglasMasivas');
	Route::any('/ajax-elimnar-reglas-masivas', 'GestionReglaController@actionAjaxEliminarReglasMasivas');

	Route::any('/gestion-de-precio-regular-producto/{idopcion}', 'GestionProductoController@actionGestionMasivaPrecioProducto');
	Route::any('/ajax-lista-precio-producto_masivo', 'GestionProductoController@actionAjaxListaPrecioProductoMasiva');
	Route::any('/ajax-actualizar-precio-producto-masivas', 'GestionProductoController@actionAjaxActualizarPrecioProductoMasivas');


	Route::any('/gestion-de-regla-de-cupon-producto/{idopcion}', 'ProductoController@actionListarReglaCupones');
	Route::any('/agregar-regla-cupon/{idopcion}', 'ProductoController@actionAgregarCupon');
	Route::any('/modificar-regla-cupon/{idopcion}/{idregla}', 'ProductoController@actionModificarCupon');

	Route::any('/gestion-de-regla-de-precio-regular/{idopcion}', 'ProductoController@actionListarReglaPrecioRegular');
	Route::any('/agregar-regla-precio-regular/{idopcion}', 'ProductoController@actionAgregarReglaPrecioRegular');
	Route::any('/modificar-regla-precio-regular/{idopcion}/{idregla}', 'ProductoController@actionModificarPrecioRegular');


	Route::any('/ajax-generarcupon', 'ProductoController@actionAjaxGenerarCupon');

	Route::any('/gestion-de-toma-de-pedido/{idopcion}', 'OrdenPedidoController@actionListarPedido');
	Route::any('/agregar-orden-pedido/{idopcion}', 'OrdenPedidoController@actionAgregarOrdenPedido');
	Route::any('/ajax-direcion-cliente', 'OrdenPedidoController@actionAjaxDireccioncliente');

	Route::any('/gestion-de-orden-de-pedido/{idopcion}', 'OrdenPedidoController@actionListarTomaPedido');
	Route::any('/ajax-listado-de-toma-pedidos', 'OrdenPedidoController@actionAjaxListarTomaPedido');
	Route::any('/ajax-modal-detalle-pedido', 'OrdenPedidoController@actionAjaxDetallePedido');
	Route::any('/enviar-a-osiris/{idopcion}', 'OrdenPedidoController@actionEnviarOsiris');
	Route::any('/enviar-a-osiris-rechazar/{idopcion}', 'OrdenPedidoController@actionEnviarOsirisRechazar');

	/************************************** GENERALES ********************************************/

	Route::any('/ajax-canal-responsable', 'GeneralAjaxController@actionCanalResponsable');
	Route::any('/ajax-cliente-responsable', 'GeneralAjaxController@actionClienteResponsable');
	Route::any('/ajax-subcanal_canal-responsable', 'GeneralAjaxController@actionSubCanalCanalResponsable');


	/************************************** Reportes ********************************************/


	Route::any('/reporte-reglas-cliente/{idopcion}', 'ReglaReporteController@actionReglasXcliente');
	Route::any('/ajax-reporte-lista-regla-clientes', 'ReglaReporteController@actionAjaxReglasxCliente');
	Route::any('/reglas-cliente-excel/{idcuenta}/{idtipoprecio}', 'ReglaReporteController@actionReglasClienteExcel');
	Route::any('/reglas-cliente-pdf/{idcuenta}/{idtipoprecio}', 'ReglaReporteController@actionReglaClientePDF');


	Route::any('/reporte-precio-producto-cliente/{idopcion}', 'ProductoReporteController@actionPrecioProductoXcliente');
	Route::any('/ajax-reporte-lista-precio-producto', 'ProductoReporteController@actionAjaxProductosxCliente');
	Route::any('/precio-producto-cliente-excel/{idcuenta}/{idtipoprecio}', 'ProductoReporteController@actionPrecioProductoClienteExcel');
	Route::any('/precio-producto-cliente-pdf/{idcuenta}/{idtipoprecio}', 'ProductoReporteController@actionPrecioProductoClientePDF');

	Route::any('/reporte-evolucion-precio-producto-cliente/{idopcion}', 'ProductoReporteController@actionEvolucionPrecioProductoXcliente');
	Route::any('/ajax-reporte-lista-evolucion-precio-producto', 'ProductoReporteController@actionAjaxEvolucionProductosxCliente');
	Route::any('/evolucion-precio-producto-cliente-excel/{idcuenta}/{fechadia}', 'ProductoReporteController@actionEvolucionPrecioProductoClienteExcel');
	Route::any('/evolucion-precio-producto-cliente-pdf/{idcuenta}/{fechadia}', 'ProductoReporteController@actionEvolucionPrecioProductoClientePDF');


	Route::any('/gestion-de-cuentas/{idopcion}', 'CarteraController@index');
	Route::any('/cartera', 'CarteraController@ListarCuentas');
	Route::any('/categoria/listarCategoria','CategoriaController@ListarCategoria');
	Route::any('/reglacredito/actualizar','AsignarReglaController@ActualizarReglaCredito');


	Route::any('/gestion-de-nota-credito-autoservicios/{idopcion}', 'NotaCreditoController@actionListarNotaCreditoAutoservicio');
	Route::any('/agregar-reglas-orden-cen/{idopcion}', 'NotaCreditoController@actionAgregarReglaOrdenCen');
	Route::any('/ajax-reglas-cliente-fechas', 'NotaCreditoController@actionAjaxReglasClienteFechas');
	Route::any('/ajax-lista-oredencen-nota-credito', 'NotaCreditoController@actionAjaxListaOrdenCenNotaCredito');
	Route::any('/ajax-modal-detalle-documento', 'NotaCreditoController@actionAjaxModalDetalleDocumento');
	Route::any('/asociar-nota-credito/{idopcion}/{iddocumentonotacredito}', 'NotaCreditoController@actionAsociarNotaCredito');
	Route::any('/ajax-nro-documento', 'NotaCreditoController@actionAjaxNroDocumento');

	Route::any('/agregar-nota-credito', 'NotaCreditoController@actionGuardarNotaCredito');
	Route::any('/ajax-glosa-documento', 'NotaCreditoController@actionAjaxGlosaDocumento');
	Route::any('/ver-asignacion-nota-credito/{idopcion}/{iddocumentonotacredito}', 'NotaCreditoController@actionVerAsignacionNotaCredito');
	Route::any('/agregar-orden-cen/{idopcion}/{iddocumentonotacredito}', 'NotaCreditoController@actionAgregarOrdenCen');
	Route::any('/eliminar-orden-cen/{idopcion}/{iddocumentonotacredito}', 'NotaCreditoController@actionEliminarOrdenCen');
	Route::any('/ajax-eliminar-orden-cen', 'NotaCreditoController@actionAjaxEliminarOrdenCen');

	Route::any('/ajax-lista-agregar-oredencen-nota-credito', 'NotaCreditoController@actionAjaxListaAgregarOrdenCenNotaCredito');



	/*Route::any('/ajax-lista-precio-producto_masivo', 'GestionProductoController@actionAjaxListaPrecioProductoMasiva');
	Route::any('/ajax-actualizar-precio-producto-masivas', 'GestionProductoController@actionAjaxActualizarPrecioProductoMasivas');*/




   	Route::get('buscarcliente', function (Illuminate\Http\Request  $request) {
        $term = $request->term ?: '';
        $tags = App\WEBListaCliente::where('NOM_EMPR', 'like', '%'.$term.'%')
				->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
				->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
				->take(100)
        		->pluck('NOM_EMPR', 'NOM_EMPR');
        $valid_tags = [];
        foreach ($tags as $id => $tag) {
            $valid_tags[] = ['id' => $id, 'text' => $tag];
        }
        return \Response::json($valid_tags);
    });


   	Route::get('buscarproducto', function (Illuminate\Http\Request  $request) {
        $term = $request->term ?: '';
        $tags = App\WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
        								->where('NOM_PRODUCTO', 'like', '%'.$term.'%')
										->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
										->where('centro_id','=',Session::get('centros')->COD_CENTRO)
										->take(100)
										->pluck('NOM_PRODUCTO','producto_id');

        $valid_tags = [];
        foreach ($tags as $id => $tag) {
            $valid_tags[] = ['id' => $id, 'text' => $tag];
        }
        return \Response::json($valid_tags);
    });



   	Route::any('/enviocorreos', 'CorreoController@enviocorreo');
   	Route::any('/pruebaquery', 'PruebaController@pruebas');
   	Route::any('/power-bi', 'PruebaController@indicadoresISL');

});

