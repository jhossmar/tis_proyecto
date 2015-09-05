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
@foreach($entregaProducto as $entrega) 
<div class="row-fluid">
	<div class="box span12">	  
    <center><h3>calificar la entrega del producto de la grupo empresa: {{$nombreGrupo}}</h3></center>
	  <table class='table table-bordered  table-striped table-hover'>
	    <tr>
	      <td>ID ENTREGA</td>
	      <td>DESCRIPCION</td>
	      <td>FECHA INICIO</td>
	      <td>FECHA FIN</td>
	      <td>FECHA REAL DE ENTREGA</td>
	      <td>PAGO ESTABLECIDO</td>
	      <td>PAGO RECIBIDO</td>
	      <td>OBSERVACIONES POR PARTE DEL CONSULTOR</td>
	      <td>ENLACE AL PRODUCTO</td>
	      <td>RESPONSABLE</td>
	    </tr>        
      <tr>
        <center>
        <td>{{$entrega->id_entrega_producto}}</td>
        <td>{{$entrega->descripcion}}</td>
        <td>{{$entrega->fecha_inicio}}</td>
        <td>{{$entrega->fecha_fin}}</td>
        <td>{{$entrega->fecha_real_entrega}}</td>
        <td>{{$entrega->pago_establecido}}</td>
        <form name="form-data" class="form-horizontal cmxform" method="POST" enctype="multipart/form-data" action={{url("modificar_entrega_producto")}} accept-charset="utf-8">
			    <input type="hidden" name="_token" value="{{csrf_token()}}"></input>                			    
			    <input type="hidden" name="id_grupo" value="{{$id_grupo}}"></input>
			    <input type="hidden" name="id_entrega_p" value="{{$entrega->id_entrega_producto}}"></input>
			    <input type="hidden" name="pago_e" value="{{$entrega->pago_establecido}}"></input>
			    <input type="hidden" name="pago_r" value="{{$entrega->pago_recibido}}"></input>			    
        <td><center>{{$entrega->pago_recibido}}<br><button name="enviar_1" type="submit" class="btn btn-primary btn-small"><i class='icon-shopping-cart'></i> editar</button></center></td>
        <td><center>{{$entrega->observacion}}<br><button name="enviar_2" type="submit" class="btn btn-primary btn-small" ><i class='icon-comment'></i> editar</button></center></td>
        </form>
        <td>{{$entrega->enlace_producto}}</td>
        <td>{{$responsables_entrega[$contador]}}</td>     
        </center>        
      </tr>
      <tr>
        <td colspan="10"></td>
      </tr>
      <tr><td align="center" colspan="10"><font size ="4" COLOR="006060"><center><strong> Actividades</strong></center></font></td></tr>
      <tr><td align="center" colspan="10"><font size ="3" COLOR="006060"> para esta entrega de producto se realizaron las siguientes actividades:</font></td></tr>
      <tr><td colspan="10"></td></tr>
      @if($actividades[$contador]!=null)
      <tr>      
      	<td>ID ACTIVIDAD</td>
      	<td colspan="3">DESCRIPCION</td>            
      	<td>FECHA INICIO</td>
      	<td>FECHA FIN</td>
      	<td> AVANZE <br>%</td>
      	<td colspan="2">MODIFICACIONES</td>
      	<td>RESPONSABLE</td>      	
      </tr> 
      @foreach($actividades[$contador] as $act)
	      <tr>
	        <td>{{$act->id_actividad}}</td>
	        <td colspan="3">{{$act->descripcion." &nbsp;&nbsp;&nbsp;"}}<a href={{url('evaluar_grupo_empresa/'.$id_grupo.'/'.$act->id_actividad)}} class='btn btn-primary btn-small'><i class='icon-search'></i> detalle</a></td>
	        <td>{{$act->fecha_inicio}}</td>
	        <td>{{$act->fecha_fin}}</td>	        
	        <td>{{$act->porcentaje_completado." %"}}</td>
	        <td colspan="2">{{$act->modificado}}</td>
	        <td>{{$act->id_responsable}}</td>
	      </tr>
	    @endforeach	
	    <!--{{$contador++}}-->
	    @else
	    <tr>
	    	<td colspan="10">para esta entrega de producto nose establecio ninguna actividad</td>
	    </tr>
	    @endif
	  </table>	    	  
	</div>
</div>
    @endforeach
@stop