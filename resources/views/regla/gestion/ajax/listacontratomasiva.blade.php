
<table id="tablereglamasivo" class="table table-striped table-hover table-fw-widget listatabla">
  <thead>

    <tr> 
      <th class= 'tabladp'>CLIENTE</th>
      <th class= 'tabladp'>RESPONSABLE</th>
      <th class= 'tabladp'>CANAL</th>
      <th class= 'tabladp'>SUB CANAL</th>
      <th class= 'tabladp'>PRODUCTO</th>
      <th class= 'center tablamar' width="120px;">REGLA</th> 

      <th>
        <div class="text-center be-checkbox be-checkbox-sm has-danger">
          <input  type="checkbox"
                  class="todo_eliminar input_eliminar"
                  id="todo_eliminar"
          >
          <label  for="todo_eliminar"
                  data-atr = "todas_eliminar"
                  class = "checkbox_eliminar"                    
                  name="todo_eliminar"
            ></label>
        </div>
      </th>

      <th>
        <div class="text-center be-checkbox be-checkbox-sm has-primary">
          <input  type="checkbox"
                  class="todo_asignar input_asignar"
                  id="todo_asignar"
          >
          <label  for="todo_asignar"
                  data-atr = "todas_asignar"
                  class = "checkbox_asignar"                    
                  name="todo_asignar"
            ></label>
        </div>
      </th>

    </tr>
  </thead>
  <tbody>
    @foreach($listadeproductos as $indexp => $itemproducto)
      @foreach($listacliente as $index => $item)
	        <tr class='fila_regla'
              data_producto='{{$itemproducto->COD_PRODUCTO}}'
              data_cliente='{{$item->id}}'
              data_contrato='{{$item->COD_CONTRATO}}'>

	            <td>{{$item->NOM_EMPR}}</td>
              <td>{{$item->TXT_CATEGORIA_JEFE_VENTA}}</td>
              <td>{{$item->TXT_CATEGORIA_CANAL_VENTA}}</td>
              <td>{{$item->TXT_CATEGORIA_SUB_CANAL}}</td>
              <td>{{$itemproducto->NOM_PRODUCTO}}</td>
              <td class="relative">
                  <div>

                      @include('regla.listado.ajax.etiquetasmasiva',
                               [
                                'producto_id'                     => $itemproducto->COD_PRODUCTO,
                                'cliente_id'                      => $item->id,
                                'contrato_id'                     => $item->COD_CONTRATO,
                                'listareglaproductoclientes'      => $listareglaproductoclientes,
                                'color'                           => 'primary'
                               ])

                  </div>
              </td>


              <td>

                    @include('regla.gestion.ajax.checkbox_eliminar',
                             [
                              'producto_id'                     => $itemproducto->COD_PRODUCTO,
                              'cliente_id'                      => $item->id,
                              'contrato_id'                     => $item->COD_CONTRATO,
                              'listareglaproductoclientes'      => $listareglaproductoclientes,
                              'color'                           => 'primary'
                             ])

              </td>

              <td>

                    @include('regla.gestion.ajax.checkbox',
                             [
                              'producto_id'                     => $itemproducto->COD_PRODUCTO,
                              'cliente_id'                      => $item->id,
                              'contrato_id'                     => $item->COD_CONTRATO,
                              'listareglaproductoclientes'      => $listareglaproductoclientes,
                              'color'                           => 'primary'
                             ])

              </td>


	        </tr>
      @endforeach       
  	@endforeach
  </tbody>
</table>


<script type="text/javascript">
  $(document).ready(function(){
     App.dataTables();
  });
</script> 