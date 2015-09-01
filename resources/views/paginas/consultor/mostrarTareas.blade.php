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
			<a href="{{url('evaluar_grupo_empresa/'.$id_grupo)}}"> calificar las actividades a la grupo empresa </a><span class="divider">/</span>
		</li>
		<li>
			<a href="{{url('evaluar_grupo_empresa/'.$id_grupo.'/'.$id_actividad)}}">mostrar las tareas de la actividad </a>
		</li>		
	</ul>
</div>
<div class="row-fluid">
	<div class="box span12">
	  @if($tareas != null)
	  <center><h3>estos son los datos sobre las tareas asignadas a la actividad</h3></center>
	  <table class='table table-bordered  table-striped table-hover'>
	    <tr> 
	      <td>ID TAREA</td>
	      <td>DESCRIPCION</td>
	      <td>FECHA INICIO</td>
	      <td>FECHA FIN</td>
	      <td>RESULTADO ESPERADO</td>
	      <td>RESULTADO OBTENIDO</td>
	      <td>PORCENTAJE COMPLETADO</td>	      
	      <td>MODIFICADO</td>
	      <td>RESPONSABLE</td>
	    </tr>	
    @foreach($tareas as $tarea)
      <tr>
        <center>
        <td>{{$tarea->id_tarea}}</td>
        <td>{{$tarea->descripcion}}</td>
        <td>{{$tarea->fecha_inicio}}</td>
        <td>{{$tarea->fecha_fin}}</td>
        <td>{{$tarea->resultado_esperado}}</td>
        <td>{{$tarea->resultado_obtenido}}</td>
        <td>{{$tarea->porcentaje_completado}}</td>        
        <td>{{$tarea->modificado}}</td>
        <td>{{$tarea->responsable}}</td>     
        </center>        
      </tr>
    @endforeach
    </table>
    @else
    <center><h3>actualmente para esta actividad no se planifico tareas</h3>
    <br>
	  @endif
    <a class='btn btn-primary' href={{url('evaluar_grupo_empresa/'.$id_grupo)}}><i class='icon-repeat'></i> ATRAS</a></center>
  </div>
</div>
@stop