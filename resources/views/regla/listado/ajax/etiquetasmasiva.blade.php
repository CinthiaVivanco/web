<div class='etiquetas-reglas'>
	@foreach($listareglaproductoclientes as $item)
        @if ($item->producto_id == $producto_id && $item->cliente_id == $cliente_id && $item->contrato_id == $contrato_id) 
        	<div class='etiquetas-reglas-modal'>
			  	<span class="label label-{{$color}} ">
			  		{{$item->regla->codigo}}
			  	</span>
			  	@include('regla.listado.ajax.departamento')
			  	@include('regla.listado.ajax.precioregular')
				@include('regla.listado.ajax.descuento')		  			  	
				@include('regla.listado.ajax.localizacion')	        		
        	</div>
        @endif
	@endforeach
</div>



