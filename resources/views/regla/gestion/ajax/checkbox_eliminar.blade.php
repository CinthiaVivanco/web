@php $sw    =   0; @endphp
@foreach($listareglaproductoclientes as $item)
      @if ($item->producto_id == $producto_id && $item->cliente_id == $cliente_id && $item->contrato_id == $contrato_id)
        @php $sw    =   1; @endphp
      @endif
@endforeach

@if ($sw == 1) 
<div class="text-center be-checkbox be-checkbox-sm has-danger">
  <input  type="checkbox"
    class="e{{$indexp}}{{$index}} input_eliminar"
    id="e{{$indexp}}{{$index}}" >

  <label  for="e{{$indexp}}{{$index}}"
        data-atr = "ver"
        class = "checkbox checkbox_eliminar"                    
        name="e{{$indexp}}{{$index}}"
  ></label>
</div>
@endif
