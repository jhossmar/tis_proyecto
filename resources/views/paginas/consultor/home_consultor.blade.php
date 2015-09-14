@extends('header')

@section('contenido')
<div>
	<ul class="breadcrumb">
		<li>
			<a href="index">Inicio</a>
			<span class="divider">/</span>
	  </li>
		<li>
			<a href="home_consultor">Home Consultor TIS{{ $gestion['nombre_gestion']}}</a>			
		</li>				
	</ul>
</div>
<center><h3>Bienvenido Consultor TIS</h3></center>
@if($gestion['gestion_valida']==false)
	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header well">
				<h2><i class="icon-info-sign"></i> Importante</h2>
			</div>
			<div class="box-content alerts">
		   @if($gestion['gestion_espera'])        				 
			  {{"En estos momentos el sistema no se encuentra disponible. Ya se habilit&oacute; una nueva gesti&oacute;n pero el inicio de la misma 
					 esta programada para la fecha <b>".$gestion['fecha_ini']}}</b>. Favor tomar nota.";					      
           @else			
			   <div align="center">
				 <h4><i class="icon-info-sign"></i>
				   La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				 </div>
           @endif
			</div>	
	  </div>
	</div>
@else
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header well">
				<h2><i class="icon-info-sign"></i> Informaci&oacute;n</h2>
		</div>
		<div class="box-content alerts">
			Bienvenido Consultor TIS a la <b>Gesti&oacute;n {{ $gestion['nombre_gestion']}}</b>, en este sitio usted podr&aacute; realizar la publicaci&oacute;n de avisos
			y documentos, realizar el seguimiento de las Grupo Empresas que se inscribieron con usted, enviar mensajes a cualquier usuario
			del sistema y tambi&eacute;n podr&aacute; participar del espacio de discuci&oacute;n donde las grupo empresas
			inscritas con usted dejaran preguntas o dudas esperando su respuesta.
			<br>						
		</div>	
	</div>
</div>
@endif
@stop