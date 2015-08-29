@extends('header')
@section('contenido')
<div>
	<ul class="breadcrumb">
	  <li>
			<a href="index">Inicio</a>
			<span class="divider">/</span>
		</li>
	  <li>
			<a href="home_grupo">Home Grupo Empresa</a>
		</li>
	</ul>
</div>
<center><h3>Bienvenida Grupo Empresa</h3></center>
@if($gestion['gestion_valida'])					
	@if($numIntegrantes < 3)				
		<div class="row-fluid">
			<div class="box span12 ">
				<div class="box-header well">
				  <h2><i class="icon-warning-sign"></i> Importante: Agregar Integrante a la Grupo Empresa</h2>
 			  </div>
				<div class="box-content" id="formulario">
				  @if($datos['actividad']->act_2_espera && $datos['actividad']->activo_2==1)
						<p><b>Para que su Grupo Empresa quede completamente habilitada debe agregar por lo menos {{3-$numIntegrantes}} integrantes m&aacute;s.</b></p><br>
						<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" accept-charset="utf-8" action="home_grupo.php">
							<fieldset>								
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
									  <label id="error_user" class="error">@if(isset($error_cod)){{$error_cod}}@endif</label>
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
			              <option value="1">Licenciatura en Informatica</option>
			              <option value="2">Ingenieria de Sistemas</option>			                           
								  </select>
								  <label id="error_user" class="error">@if(isset($error_carrera)){{$error_carrera}}@endif</label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Roles del integrante: </label>
								  <div class="controls">
									<select name="roles[]" multiple data-rel="chosen">
										@foreach($roles as $rol)			                                
			                <option value={{$rol->id_rol}}>{{$rol->nombre}}</option>
			              @endforeach
									</select>
									<label id="error_user" class="error">@if(isset($error_rol)){{$error_rol}}@endif</label>
								  </div>
								</div>
								<div class="control-group">
									<div class="controls">
						        <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Agregar</button>
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
				<h2><i class="icon-info-sign"></i> Informacion</h2>
			</div>
			<div class="box-content alerts">
				Bienvenida Grupo Empresa a la <b>Gesti&oacute;n <?php echo $verificarA->nombre_gestion; ?></b>, en este sitio usted podr&aacute; administrar las
				actividades de su Grupo Empresa,tambi&eacute;n la entrega de los sobres A y B, entregar su producto y adem&aacute;s pod&aacute; participar del <a href="mensajes.php">Espacio de discuci&oacute;n</a>.<br>
			</div>
		</div><!--/span-->
	</div><!-- fin row -->	
	@if($numIntegrantes<3 && $datos['actividad']->act_2==1 && !$datos['activida']->act_2_espera)
	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header well">
				<h2><i class="icon-exclamation-sign"></i> Nota</h2>
			</div>
		  <div class="box-content alerts">
		    Si usted desea puede agregar <b>{{3 - $numIntegrantes}} integrante(s) m&aacute;s <a href="agregar_integrante.php">aqu&iacute;.</a> </b>
		    El registro estar&aacute; habilitado hasta la fecha <b><?php echo $VeriricarG->act_fin_2 ?></b>, favor tomar nota.<br>
	    </div>
	  </div><!--/span-->
	</div><!-- fin row -->
	@endif	
				
@else
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header well">
			<h2><i class="icon-plus-sign"></i> Informaci&oacute;n</h2>
		</div>
  	<div class="box-content alerts">
			<div align="center">
	      <h4><i class="icon-info-sign"></i>
				La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
			</div>
		</div>
	</div><!--/span-->
</div><!-- fin row -->		
@endif
@stop