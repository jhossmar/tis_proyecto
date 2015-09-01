@extends('header')
@section('contenido')
<div>
	<ul class="breadcrumb">
		<li>
			<a href="index">Inicio</a>
			<span class="divider">/</span>
		</li>
		<li>
			<a href="calificar_grupo_empresa">calificar las actividades a la grupo empresa</a>
		</li>				
	</ul>
</div>
<center><h3>calificar las actividades de la grupo empresa</h3></center>
<div class="row-fluid">
	<div class="span12">    
	  @if($grupoEmpresa == null)
	    <br>  
	    <br>  
      <center><h3> ACTUALMENTE NO TIENE NINGUN GRUPO EMPRESA REGISTRADO CON USTED</h3></center>
	  @else
	    @foreach($grupoEmpresa as $grupo)      
	      @if($aux==0)	    
	    	  <br>
    	      <center><h3>estas son las grupo empresa registradas con el consultor Tis: {{$nombre_usuario}}</h3></center>
          <br>
          <table class='table table-bordered table-striped table-hover'>
 	          <tr> 
   	          <td><center><h4>NRO GRUPO EMPRESA</h4></center></td>
   	          <td><center><h4>GRUPO EMPRESA</h4></center></td>   	          
 	          </tr>
	    	  <!--{{ $aux=1 }}-->
	      @endif
	      @if($grupo->habilitado==1)
	    	    <tr> 
	    	      <td><center>{{$grupo->id_grupo_empresa}}</center></td>
	    	      <td><center><a href="{{ url('evaluar_grupo_empresa/'.$grupo->id_grupo_empresa) }}"><i class='icon-edit'></i>{{$grupo->nombre_largo}}</a></center></td>
	    	    </tr>
	       @else
	          <tr> 
	    	      <td><center>{{$grupo->id_grupo_empresa}}</center></td>
	    	      <td><center><i class='icon-edit'><strong></i>{{" ".$grupo->nombre_largo}}</strong>
	    	          IMPORTANTE! no puede calificar esta grupo empresa ya que se encuentra inhabilitada</center></td>
	    	    </tr>
	    	  @endif
	    @endforeach
	      </table>
	  @endif
	</div>
</div>
@stop
