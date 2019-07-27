@php $sw    =   0; @endphp
@foreach($listareglaproductoclientes as $item)
      @if ($item->producto_id == $producto_id && $item->cliente_id == $cliente_id && $item->contrato_id == $contrato_id)
        @php $sw    =   1; @endphp
      @endif
@endforeach

@if ($sw == 0) 
<div class="text-center be-checkbox be-checkbox-sm has-primary">
  <input  type="checkbox"
    class="{{$indexp}}{{$index}} input_asignar"
    id="{{$indexp}}{{$index}}" >

  <label  for="{{$indexp}}{{$index}}"
        data-atr = "ver"
        class = "checkbox checkbox_asignar"                    
        name="{{$indexp}}{{$index}}"
  ></label>
</div>
@endif
