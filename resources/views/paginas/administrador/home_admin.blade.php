@extends('header')

@section('contenido')

 <div>
   <ul class="breadcrumb">
	 <li>
	     <a href="index">Inicio</a>
		 <span class="divider">/</span>
	 </li>
	 <li>
	     <a href="home_admin">Home Administrador</a>
     </li>					
   </ul>
 </div>
 <center><h3>Bienvenido Administrador</h3></center>
      <div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Informacion</h2>
					</div>
					<div class="box-content alerts">
							Bienvenido Administrador al Sistema de Apoyo a la Empresa TIS a la <b>Gesti&oacute;n {{ $gestion['nombre_gestion']}}</b>							
							<br>						
					</div>	
				</div>
			</div>
@stop