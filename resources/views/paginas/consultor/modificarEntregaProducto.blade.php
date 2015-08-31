@extends('header')
@section('contenido')
<div>
	<ul class="breadcrumb">
		<li>
			<a href="{{url('index')}}">Inicio</a><span class="divider">/</span>
		</li>
		<li>
			<a href="{{url('calificar_grupo_empresa')}}">notas de la grupo empresa </a><span class="divider">/</span>
		</li>
		<li>
			<a href="{{url('evaluar_grupo_empresa/'.$id_grupo)}}"> calificar las actividades a la grupo empresa </a>
		</li>	
	</ul>
</div>
<center><h3>@if($opcion == 0)califica la actividad a la grupo empresa @elseif($opcion == 1)escribir las observaciones sobre la actividad @endif</h3></center>
<div class="row-fluid">
  <div class="span12">
    @if($opcion == 0)
      <div class='well'>
        <p> el precio establecido establecido para la actividad es :<strong> {{$establecido}}</strong></p>
        <br>
        <p>hasta ahora se le ha cancelado a la grupo empresa el monto de: <strong>{{$recibido}}</strong></p>
        <br>        
        <label> escriba el monto que se le pagara por la actividad:</label>
        <br>
          <form action={{url('actualizar_entrega_producto')}} method='post'> 
            <div class='input-append'>
              <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
              <input type='hidden' name='opcion' value=0></input>
              <input type='hidden' name='idgrupo' value='{{$id_grupo}}'></input>
              <input type='hidden' name='identrega' value='{{$id_entrega_p}}'></input>
              <input type='text' value='' name='dinero'></input>
              <span class='add-on'>$</span>
              <button type='submit' class='btn btn-primary' value='aceptar'><i class='icon-ok'></i> aceptar</button>
              <a class='btn btn-primary' href={{url('evaluar_grupo_empresa/'.$id_grupo)}}><i class='icon-repeat'></i> atras</a></center>
            </div>          
          </form>          
      </div>
    @elseif($opcion == 1)
      <div class='well'>        
        <p>aqui puede ingresar las observaciones que tuvo respecto a la entrega del producto</p>
        <br>                
        <form action={{url('actualizar_entrega_producto')}} method=post>  
        <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
        <input type='hidden' name='opcion' value=1></input>
          <input type='hidden' name='idgrupo' value='{{$id_grupo}}'>
          <input type='hidden' name='identrega' value='{{$id_entrega_p}}'>         
          <center> <textarea name='observaciones' rows='10' cols='70'></textarea>
          <br>
           <button type='submit' class='btn btn-primary' value='aceptar'><i class='icon-ok'></i> aceptar</button>
              <a class='btn btn-primary' href={{url('evaluar_grupo_empresa/'.$id_grupo)}}><i class='icon-repeat'></i> atras</a></center>
        </form>
     </div>
    @endif    
  </div>
</div>
@stop