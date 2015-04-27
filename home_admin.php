<?php
$titulo="Administrador del Sistema";
include('conexion/verificar_gestion.php');
session_start();
/*------------------VERIFICAR QUE SEAL EL ADMINISTRADOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=1)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
	                    break;
	            case (4) :
	                	$home="home_grupo.php";
	                    break;
	            case (2) :
	                	$home="home_consultor_jefe.php";
	                    break;
	            case (3) :
	                    $home="home_consultor.php";
	                    break;                                                             		
	          }   
		header("Location: ".$home);
}
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
/*----------------------FIN VERIFICACION------------------------------------*/
if (!$gestion_valida) {
	$fecha = date("Y-m-d");
	$inicio = $fecha;
	$descripcion=NULL;
	$year = date('Y');
	$mes = date('m');
	if($mes >=1 && $mes <=6){
		$gestion = "1-".$year;
		$fin_max = $year."-07-31";
	}
	else{
		$gestion = "2-".$year;
		$fin_max = $year."-12-31";
	}
	$fin=$fin_max;
	if (isset($_POST['enviar'])) {
		$error=false;

		$inicio = $_POST['inicio'];
		$descripcion = $_POST['descripcionG'];
		$gestion=$_POST['gestion'];
		$fin = $_POST['fin'];

		$ini_dia = substr($inicio, 8);
		$ini_mes = substr($inicio, 5,2);
		$ini_year = substr($inicio, 0,4);

		if(@checkdate($ini_mes, $ini_dia, $ini_year)){
			if(!empty($fin)){
				$fin_dia = substr($fin, 8);
				$fin_mes = substr($fin, 5,2);
				$fin_year = substr($fin, 0,4);
				if (@checkdate($fin_mes, $fin_dia, $fin_year)) {
					if($inicio>=$fecha){//corecto
						if ($fin>$inicio) {//corecto escribir en base de datos
							$sql = "INSERT INTO gestion_empresa_tis(gestion,fecha_ini_gestion,fecha_fin_gestion,gestion_activa,descripcion_gestion)
									VALUES('$gestion','$inicio','$fin',1,'$descripcion')";
					        $result = mysql_query($sql,$conn) or die(mysql_error());
					        header("Location: home_consultor_jefe.php");
						}
						else{
							$error = true;
							$error_fecha_fin = "La fecha de finalizaci&oacute;n no debe ser menor o igual a la fecha de inicio";
						}
					}
					else{
						$error = true;
						$error_fecha_ini = "La fecha de inicio no debe ser menor a la fecha presente";
					}
				}
				else{
				$error = true;
				$error_fecha_fin = "La fecha de finalizaci&oacute;n no es valida";
				}
			}
			else{
				$error=true;
				$error_fecha_fin = "Ingrese una fecha de finalizaci&oacute;n";
			}
		}
		else{
			$error = true;
			$error_fecha_ini = "La fecha de inicio no es v&aacute;lida";
		}
	}
}
include('header.php');
 ?>
 			<!--PARTICIONAR
 			<li>
						<a href="#">Inicio</a> <span class="divider">/</span>
			</li>-->
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
			if (!$gestion_valida) { ?>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Importante</h2>
					</div>
					<div class="box-content alerts">
					
					<?php if ($gestion_espera) {
						echo "Bienvenido Administrador del Sistema de Apoyo a la Empresa TIS, usted ya defini&oacute; una nueva gesti&oacute;n que
						comenzar&aacute; la fecha <b>".$ini_gestion."</b>.";
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
							Bienvenido Administrador del Sistema de Apoyo a la Empresa TIS a la <b>Gesti&oacute;n <?php echo $nombre_gestion; ?></b>.
							
							<br>						
					</div>	
				</div><!--/span-->  
			</div><!-- fin row -->
<?php 
}
include('footer.php'); ?>