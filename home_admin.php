<?php
  $titulo="Administrador del Sistema";
  require_once("conexion/verificar_gestion.php");
  require_once("conexion/conexion.php");
  $verificarG = new VerificarGestion();
  $gestionValida = $verificarG->GetGestionValida();

  $conexion = new Conexion;
  $conexion->EstablecerConexion();
  $conn = $conexion->GetConexion();
  session_start();

    if(!$gestionValida)
    {
	   $fecha = date("Y-m-d");
	   $inicio = $fecha;
	   $descripcion=NULL;
	   $year = date('Y');
	   $mes = date('m');
	   if($mes >=1 && $mes <=6)
	   {
		 $gestion = "1-".$year;
		 $fin_max = $year."-07-31";
	   }
	   else
	   {
		$gestion = "2-".$year;
		$fin_max = $year."-12-31";
	   }
	    $fin=$fin_max;
	}
	if(isset($_POST['enviar']))
	{
		$error=false;

		$inicio = $_POST['inicio'];
		$descripcion = $_POST['descripcionG'];
		$gestion=$_POST['gestion'];
		$fin = $_POST['fin'];

		if(!empty($fin))
		{
			if($inicio>=$fecha)
			{
				if($fin>$inicio)
				{
					$sql = "INSERT INTO gestion_empresa_tis(gestion,fecha_ini_gestion,fecha_fin_gestion,gestion_activa,descripcion_gestion)
							VALUES('$gestion','$inicio','$fin',1,'$descripcion')";
					 mysql_query($sql,$conn) or die(mysql_error());
					 header("Location: index.php");
				}
				else
				{
					$error = true;
					$error_fecha_fin = "La fecha de finalizaci&oacute;n no debe ser menor o igual a la fecha de inicio";
				}
			}
			else
			{
				$error = true;
				$error_fecha_ini = "La fecha de inicio no debe ser menor a la fecha presente";
			}
		}
		else
		{
			$error = true;
			$error_fecha_ini = "ingrese una fecha final";
		}
	}

include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="home_admin.php">Home Administrador</a>
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
								  	<?php echo $gestion; ?>
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
<?php 
}
include('footer.php'); ?>