<!DOCTYPE html>
<html lang="es">

<head>
  <title>{{$titulo}}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link rel="icon" type="image/x-icon" href="{{ asset('public/favicon.ico') }}"> 
  <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pdf.css') }} "/>

</head>
<body>
    <header>
      <div class='reporte'>
        <h3 class="center titulo">{{$empresa}} - {{$centro}}</h3>
        <p class="subtitulo">
          <strong class='fecha'>FECHA : {{date_format(date_create($fechaactual), 'd-m-Y')}}</strong>
        </p>


      </div>
    </header>
    <section>
        <article>
          <table>
            <tr>
                <th colspan="2" class='titulotabla center tabladp'>DATOS</th>     
                <th colspan="2" class='titulotabla center tablaho'>PRECIO REGULAR</th>    
            </tr>

            <tr>
                <th width="140" class= 'tabladp'>CLIENTE</th>
                <th width="140" class= 'tabladp'>PRODUCTO</th>
                <th width="10" class= 'titulotabla tablaho'>DEPARTAMENTO</th>
                <th width="10" class= 'titulotabla tablaho'>PRECIO</th>     
            </tr>

	        @foreach($listacliente as $index_c => $item_c) 
	            @foreach($listadeproductos as $index => $item) 

	                <!-- PRECIOS CON DEPARTAMENTOS-->
	                @php
	                  $lista_precio_regular_departamento    =   $funcion->funciones->lista_precio_regular_departamento($item_c->COD_CONTRATO,$item->producto_id);
	                @endphp

	                @if(($index % 2) == 0 ) 
	                    @php  $color = 'tablafila1'; @endphp
	                @else 
	                    @php  $color = 'tablafila2'; @endphp
	                @endif

	                <tr>
	                    <td class='{{$color}}'> {{$item_c->NOM_EMPR}}</td>
	                    <td class='{{$color}}'>{{$item->NOM_PRODUCTO}}</td>
	                    <td class='negrita {{$color}}'>OTROS</td> 
	                    <td class='negrita {{$color}}'>S/. {{$funcion->funciones->calculo_precio_regular($item_c,$item)}}</td>                           
	                </tr>
	                @foreach($lista_precio_regular_departamento as $index_pr => $item_pr)
	                <tr>
	                    <td class='{{$color}}'> {{$item_c->NOM_EMPR}}</td>
	                    <td class='{{$color}}'>{{$item->NOM_PRODUCTO}}</td>
	                    <td class='negrita {{$color}}'>{{$funcion->funciones->departamento($item_pr->departamento_id)->NOM_CATEGORIA}}</td> 
	                    <td class='right negrita {{$color}}'>S/. {{number_format($item_pr->descuento, 2, '.', ',')}}</td>
	                </tr>     
	                @endforeach  
	            @endforeach
	        @endforeach

          </table>
        </article>
    </section>
</body>
</html>