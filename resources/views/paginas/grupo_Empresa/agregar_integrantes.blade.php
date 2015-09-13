@extends('header')
@section('contenido')
<div>
	<ul class="breadcrumb">
		<li>
			<a href={{url("index")}}>Inicio</a><span class="divider">/</span>
		</li>
		<li>
			<a href={{url("administrar_integrante")}}>Administrar Integrantes</a><span class="divider">/</span>
 	  </li>
		<li>
			<a href={{url("agregar_integrante")}}>Agregar Integrantes</a>
		</li>				
	</ul>
</div>
<center><h3>Agregar Integrantes a la Grupo Empresa</h3></center>
@if($numIntegrantes<5 && $gestion['gestion_valida'])
	<div class="row-fluid">
		<div class="box span12 ">
			<div class="box-header well">
				<h2><i class="icon-edit"></i> Agregar Integrantes a la Grupo Empresa</h2>					
			</div>
			<div class="box-content" id="formulario">
			  @if(!$datos['actividad']->act_2_espera && $datos['actividad']->activo_2==1)				
					<b>Usted puede agregar {{5-$numIntegrantes}} integrante(s) m&aacute;s hasta la fecha {{$datos['actividad']->fecha_fin_2}}</b>.</br></br>
					<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" accept-charset="utf-8" action="agregar_integrante">
						<fieldset>
					    <input type="hidden" name="_token" value="{{csrf_token()}}"></input>								
					 		<div class="control-group">
							  <label class="control-label" for="name">Nombre de Usuario: </label>
							  <div class="controls">
						 		  <input placeholder="Usuario" name="username" type="text" id="username">
								  <label id="error_user" class="error">@if(isset($error_user)){{$error_user}}@endif</label>
							  </div>
						  </div>
						  <div class="control-group">
 						    <label class="control-label" for="pass">Contrase&ntilde;a: </label>
						    <div class="controls">
								  <input type="password" placeholder="Contrase&ntilde;a" name="password" id="password">
						    </div>
						  </div>
							<div class="control-group">
							  <label class="control-label" for="pass">Confirmar Contrase&ntilde;a: </label>
							  <div class="controls">
							  	<input type="password" placeholder="Confirmar Contrase&ntilde;a" name="confirm_password" id="confirm_password">
							  </div>
							</div>
							<div class="control-group" >
							  <label class="control-label"  for="pass">C&oacute;digo SIS: </label>
							  <div class="controls">
								  <input type="text" placeholder="C&oacute;digo SIS del integrante" name="codSIS" id="codSIS" class="codigos">
								  <label id="error_user" class="error"> @if(isset($error_cod)){{$error_cod}}@endif</label>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="pass">Nombre: </label>
							  <div class="controls">
						   	  <input type="text" placeholder="Nombre del integrante" class="firstnames" name="firstname" id="firstname">
								</div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="pass">Apellido: </label>
							  <div class="controls">
								  <input type="text" placeholder="Apellido del integrante" name="lastname" class="lastnames" id="lastname">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="pass">Tel&eacute;fono: </label>
							  <div class="controls">
								  <input type="text" placeholder="Tel&eacute;fono del integrante" class="telefonos" name="telf" id="telf">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="pass">Correo Electr&oacute;nico:</label>
							  <div class="controls">
								  <input type="text" placeholder="E-mail del integrante" name="email"  id="email">
								  <label id="error_email" class="error">@if(isset($error_email)){{$error_email}}@endif</label>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="pass">Carrera: </label>
							  <div class="controls">
								  <select id="choose_carrera" name="choose_carrera" data-rel="chosen">
									  <option value="-1">-- Seleccione una carrera --</option>
			              <option value="1">Licenciatura en Informática</option>
			              <option value="2">Ingeniería de Sistemas</option>			                                
							  	</select>
							  	<label id="error_user" class="error">@if(isset($error_carrera)){{$error_carrera}}@endif</label>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="pass">Roles del integrante: </label>
							  <div class="controls">
							    <select name="rol" data-rel="chosen">
							      <option value="-1">-- Seleccione un rol --</option>
								    @foreach($roles as $rol)
								      @if($rol->id_rol!=1)
			                <option value={{$rol->id_rol}}>{{$rol->nombre}}</option>
			                @endif
			              @endforeach
								  </select>
								<label id="error_user" class="error"> @if(isset($error_rol)){{$error_rol}}@endif</label>
							  </div>
							</div>
							<div class="control-group">
								<div class="controls">
						      <button name="agregar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Agregar</button>
							    <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
							  </div>
							</div>
						</fieldset>
					</form>
				@else
						Lo sentimos pero el registro no est&aacute; habilitado. Puede contactarse con su Consultor TIS
									asignado para solicitar una ampliaci&oacute;n de la fecha registro
				@endif
			</div>
		</div>
	</div>	
@else
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header well">
			<h2><i class="icon-exclamation-sign"></i> Nota</h2>
		</div>
		<div class="box-content alerts">		
			<center><h4><i class="icon-info-sign"></i> Usted ha alcanzado el l&iacute;mite m&aacute;ximo de 5 integrantes para una sola Grupo Empresa.<br></h4></center>
		</div>	
	</div><!--/span-->  
</div><!-- fin row -->
@endif
@stop