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
     
   @if($gestion['gestion_valida'])
     <div class="row-fluid">
	   <div class="boxgestion_valida span12">
		  <div class="box-header well">
			 <h2><i class="icon-info-sign"></i> Informacion</h2>
		  </div>
	      <div class="box-content alerts">
		    Bienvenido Administrador al Sistema de Apoyo a la Empresa TIS a la <b>Gesti&oacute;n {{ $gestion['nombre_gestion']}}</b>							
		    <br>						
	      </div>	
	   </div>
     </div>
   @else
      <div class="iniciorow-fluid">
        <div class="box span12">
	      <div class="box-header well">
			 <h2><i class="icon-info-sign"></i> Importante</h2>
		  </div>
		<div class="box-content alerts">
		   Para que el sistema pueda ser utilizado usted debe completar el siguiente formulario para habilitar una <b>Nueva Gesti&oacute;n.</b>
		   <br><br>
		<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" action="home_admin" accept-charset="utf-8">
			<input type="hidden" name="_token" value="{{csrf_token()}}"></input>					
			<fieldset>
			<input type="hidden" name="gestion" id="gestion" value= {{$gestion_nuevo}}>
			<div class="control-group">
		   <label class="control-label" >Gesti&oacute;n: </label>
								  <div class="controls" style="padding-top:3px; font-size:13px;">
								  	{{$gestion_nuevo}}
								  </div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Inicio de gesti&oacute;n:</label>
									<div class="controls">
										<input type="text" class="datepicker" editable='false' name="inicio" id="inicio" value="<?php echo $inicio; ?>">
										<label class="error">{{$error_fecha_ini}}</label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Fin de gesti&oacute;n:</label>
									<div class="controls">
										<input type="text" class="datepicker" name="fin" id="fin" value="<?php echo $fin; ?>">
										<label class="error">{{$error_fecha_fin}}</label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Descripci&oacute;n:</label>
									<div class="controls">
										<input placeholder="Breve descripcion" type="text" name="descripcionG" id="descripcionG" value="<?php echo $descripcion; ?>">
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Aceptar</button>
								 </div>
								 </div>
						        </fieldset>
							</form>	
															
					</div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			 




   @endif

@stop