@extends('header')
@section('contenido')
     <div>
		<ul class="breadcrumb">
			<li>
			   <a href="index">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="paginas/administrador/home_admin">Home Administrador</a>
					</li>					
				</ul>
			</div>
			<center><h3>Bienvenido Administrador</h3></center>
			<?php 
			if (!$gestionValida) { ?>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Importante</h2>
					</div>
					<div class="box-content alerts">
					
					<?php if($verificarG->gestion_espera){
						echo "Bienvenido Administrador del Sistema de Apoyo a la Empresa TIS, usted ya defini&oacute; una nueva gesti&oacute;n que
						comenzar&aacute; la fecha <b>".$verificarG->ini_gestion."</b>.";
					}
					else{?>						
							Para que el sistema pueda ser utilizado usted debe completar el siguiente formulario para habilitar una <b>Nueva Gesti&oacute;n.</b>
						<br><br>
						<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" action="home_admin.php" accept-charset="utf-8">
								<fieldset>
								<input type="hidden" name="gestion" id="gestion" value="<?php echo $gestion; ?>">
								<div class="control-group">
								  <label class="control-label" >Gesti&oacute;n: </label>
								  <div class="controls" style="padding-top:3px; font-size:13px;">
								  	 {{$gestion}}
								  </div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Inicio de gesti&oacute;n:</label>
									<div class="controls">
										<input type="text" class="datepicker" editable='false' name="inicio" id="inicio" value="<?php echo $inicio; ?>">
										<label class="error"><?php if(isset($error_fecha_ini)){ echo $error_fecha_ini; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Fin de gesti&oacute;n:</label>
									<div class="controls">
										<input type="text" class="datepicker" name="fin" id="fin" value="<?php echo $fin; ?>">
										<label class="error"><?php if(isset($error_fecha_fin)){ echo $error_fecha_fin; } ?></label>
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
							<?php } ?>								
					</div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<?php } 
			else{ ?>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Informacion</h2>
					</div>
					<div class="box-content alerts">
							Bienvenido Administrador del Sistema de Apoyo a la Empresa TIS a la <b>Gesti&oacute;n <?php echo $verificarG->nombre_gestion; ?></b>							
							<br>						
					</div>	
				</div>
			</div>
@stop