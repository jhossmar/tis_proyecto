@extends('header')
@section('contenido')
	<ul class="breadcrumb"><!-- $gestion_valida,$nombre_gestion-->
   		<li>
			<a href="index">Inicio</a>			
		</li>
	</ul>
<center><h3>Bienvenidos al Sistema de Apoyo a la Empresa TIS</h3></center>
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header well">
			<h2><i class="icon-bullhorn"></i> Avisos: Gesti&oacute;n {{$gestion['nombre_gestion']}}</h2>
     	</div>
		<div class="box-content alerts">
		    @if($gestion['gestion_valida'])		        
		        @include('noticias')
            @else
            <div align=\"center\">
	            <h4><i class=\"icon-info-sign\"></i>
 	            No existe ning&uacute;n aviso para esta gesti&oacute;n.</h4>
   	        </div>
            @endif
	    </div>
    </div>  
</div>  
@stop