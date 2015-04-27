<?php
$titulo="Planificaci&oacute;n de actividades";
include('conexion/verificar_gestion.php');
session_start();
$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
			or die("Error no se pudo realizar cambios.");
/*------------------VERIFICAR QUE SEAL EL JEFE CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=2)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
	                    break;
	            case (4) :
	                	$home="home_grupo.php";
	                    break;
	            case (3) :
	                	$home="home_consultor.php";
	                    break;	            
	            case (1) :
	                    $home="home_admin.php";
	                    break;                                                             		
	          }   
		header("Location: ".$home);
}
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
/*----------------------FIN VERIFICACION------------------------------------*/
/*----------------------INICIO HABILITAR REGISTRO---------------------------*/
$fecha = date("Y-m-d");
$mensaje="Fecha sin definir";
$inicio = $mensaje;
$fin = $mensaje;
$inicio_1=$mensaje;
$fin_1=$mensaje;
$inicio_3=$mensaje;
$fin_3=$mensaje;
$inicio_4=$mensaje;
$fin_4=$mensaje;
$inicio_5=$mensaje;
$fin_5=$mensaje;
$inicio_6=$mensaje;
$fin_6=$mensaje;
$inicio_7=$mensaje;
$fin_7=$mensaje;
if (isset($_POST['enviar'])) {//habilidar registro de grupo empresas
	$error=false;
	if (isset($_POST['inicio']) && isset($_POST['fin']) && isset($_POST['newsletter'])) {
		$actividad_2="checked";
		$inicio = $_POST['inicio'];
		$fin = $_POST['fin'];
		
		$ini_dia = substr($inicio, 8);
		$ini_mes = substr($inicio, 5,2);
		$ini_year = substr($inicio, 0,4);

		$fin_dia = substr($fin, 8);
		$fin_mes = substr($fin, 5,2);
		$fin_year = substr($fin, 0,4);
		if(@checkdate($ini_mes, $ini_dia, $ini_year)){
			if (@checkdate($fin_mes, $fin_dia, $fin_year)) {
				if($inicio>=$fecha){//corecto
					if ($fin>=$inicio) {//corecto sobreescribir base de datos
						if (strtotime($fin)<=$fecha_fin) {
							$consulta_sql="UPDATE fase_convocatoria
									set fecha_inicio='$inicio' , fecha_fin='$fin', activo=1
									WHERE gestion=$id_gestion AND tipo_fase_convocatoria=2";
							$consulta = mysql_query($consulta_sql,$conn)
							or die(mysql_error());
							header('Location:planificacion.php#registro');
						}
						else{
							$error = true;
							$error_fecha_fin = "La gesti&oacute;n termina la fecha ".$fin_gestion;
						}
					}
					else{
						$error = true;
						$error_fecha_fin = "La fecha de finalizaci&oacute;n no debe ser menor que la fecha de inicio";
					}
				}
				else{
					$error = true;
					$error_fecha_ini = "La fecha de inicio no debe ser menor a la fecha presente";
				}
			}
			else{
				$error = true;
				$error_fecha_fin = "La fecha de finalizacion no es v&aacute;lida";
			}
		}
		else{
			$error = true;
			$error_fecha_ini = "La fecha de inicio no es v&aacute;lida";
		}
	}
	else{
		if (!isset($_POST['newsletter'])) {
			$consulta_sql="UPDATE fase_convocatoria
						   set activo=0
						   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=2";
			$consulta = mysql_query($consulta_sql,$conn)
			or die("Could not execute the select query.");
			header('Location:planificacion.php#registro');
			
		}
	}
}
if (isset($_POST['enviar_1'])) {//lanzamiento convocatoria
	$error_1=false;
	if (isset($_POST['inicio_1']) && isset($_POST['fin_1']) && isset($_POST['newsletter_1'])) {
		$inicio_1 = $_POST['inicio_1'];
		$fin_1 = $_POST['fin_1'];
		$actividad_1="checked";
		$ini_dia_1 = substr($inicio_1, 8);
		$ini_mes_1 = substr($inicio_1, 5,2);
		$ini_year_1 = substr($inicio_1, 0,4);

		$fin_dia_1 = substr($fin_1, 8);
		$fin_mes_1 = substr($fin_1, 5,2);
		$fin_year_1 = substr($fin_1, 0,4);
		if(@checkdate($ini_mes_1, $ini_dia_1, $ini_year_1)){
			if (@checkdate($fin_mes_1, $fin_dia_1, $fin_year_1)) {
				if($inicio_1>=$fecha){//corecto
					if ($fin_1>=$inicio_1) {//corecto sobreescribir base de datos
						if (strtotime($fin_1)<=$fecha_fin) {
							$consulta_sql="UPDATE fase_convocatoria
										set fecha_inicio='$inicio_1' , fecha_fin='$fin_1', activo=1
										WHERE gestion=$id_gestion AND tipo_fase_convocatoria=1";
							$consulta = mysql_query($consulta_sql,$conn)
							or die("Could not execute the select query.");
							header('Location:planificacion.php#lanzamiento');
						}
						else{
							$error_1 = true;
							$error_fecha_fin_1 = "La gesti&oacute;n termina la fecha ".$fin_gestion;
						}
					}
					else{
						$error_1 = true;
						$error_fecha_fin_1 = "La fecha de finalizaci&oacute;n no debe ser menor que la fecha de inicio";
					}
				}
				else{
					$error_1 = true;
					$error_fecha_ini_1 = "La fecha de inicio no debe ser menor a la fecha presente";
				}
			}
			else{
				$error_1 = true;
				$error_fecha_fin_1 = "La fecha de finalizacion no es v&aacute;lida";
			}
		}
		else{
			$error_1 = true;
			$error_fecha_ini_1 = "La fecha de inicio no es v&aacute;lida";
		}
	}
	else{
		if (!isset($_POST['newsletter_1'])) {
			$consulta_sql="UPDATE fase_convocatoria
						   set activo=0
						   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=1";
			$consulta = mysql_query($consulta_sql,$conn)
			or die("Could not execute the select query.");
			header('Location:planificacion.php#lanzamiento');
			
		}
	}
}
if (isset($_POST['enviar_3'])) {//documentos
	$error_3=false;
	if (isset($_POST['inicio_3']) && isset($_POST['fin_3']) && isset($_POST['newsletter_3'])) {
		$inicio_3 = $_POST['inicio_3'];
		$fin_3 = $_POST['fin_3'];
		$actividad_3="checked";
		$ini_dia_3 = substr($inicio_3, 8);
		$ini_mes_3 = substr($inicio_3, 5,2);
		$ini_year_3 = substr($inicio_3, 0,4);

		$fin_dia_3 = substr($fin_3, 8);
		$fin_mes_3 = substr($fin_3, 5,2);
		$fin_year_3 = substr($fin_3, 0,4);
		if(@checkdate($ini_mes_3, $ini_dia_3, $ini_year_3)){
			if (@checkdate($fin_mes_3, $fin_dia_3, $fin_year_3)) {
				if($inicio_3>=$fecha){//corecto
					if ($fin_3>=$inicio_3) {//corecto sobreescribir base de datos
						if (strtotime($fin_3)<=$fecha_fin) {
							$consulta_sql="UPDATE fase_convocatoria
										set fecha_inicio='$inicio_3' , fecha_fin='$fin_3', activo=1
										WHERE gestion=$id_gestion AND tipo_fase_convocatoria=3";
							$consulta = mysql_query($consulta_sql,$conn)
							or die("Could not execute the select query.");
							header('Location:planificacion.php#documentos');
						}
						else{
							$error_3 = true;
							$error_fecha_fin_3 = "La gesti&oacute;n termina la fecha ".$fin_gestion;
						}
					}
					else{
						$error_3 = true;
						$error_fecha_fin_3 = "La fecha de finalizaci&oacute;n no debe ser menor que la fecha de inicio";
					}
				}
				else{
					$error_3 = true;
					$error_fecha_ini_3 = "La fecha de inicio no debe ser menor a la fecha presente";
				}
			}
			else{
				$error_3 = true;
				$error_fecha_fin_3 = "La fecha de finalizacion no es v&aacute;lida";
			}
		}
		else{
			$error_3 = true;
			$error_fecha_ini_3 = "La fecha de inicio no es v&aacute;lida";
		}
	}
	else{
		if (!isset($_POST['newsletter_3'])) {
			$consulta_sql="UPDATE fase_convocatoria
						   set activo=0
						   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=3";
			$consulta = mysql_query($consulta_sql,$conn)
			or die("Could not execute the select query.");
			header('Location:planificacion.php#documentos');
			
		}
	}
}
if (isset($_POST['enviar_4'])) {//firma de contratos
	$error_4=false;
	if (isset($_POST['inicio_4']) && isset($_POST['fin_4']) && isset($_POST['newsletter_4'])) {
		$inicio_4 = $_POST['inicio_4'];
		$fin_4 = $_POST['fin_4'];
		$actividad_4="checked";
		$ini_dia_4 = substr($inicio_4, 8);
		$ini_mes_4 = substr($inicio_4, 5,2);
		$ini_year_4 = substr($inicio_4, 0,4);

		$fin_dia_4 = substr($fin_4, 8);
		$fin_mes_4 = substr($fin_4, 5,2);
		$fin_year_4 = substr($fin_4, 0,4);
		if(@checkdate($ini_mes_4, $ini_dia_4, $ini_year_4)){
			if (@checkdate($fin_mes_4, $fin_dia_4, $fin_year_4)) {
				if($inicio_4>=$fecha){//corecto
					if ($fin_4>=$inicio_4) {//corecto sobreescribir base de datos
						if (strtotime($fin_4)<=$fecha_fin) {
							$consulta_sql="UPDATE fase_convocatoria
										set fecha_inicio='$inicio_4' , fecha_fin='$fin_4', activo=1
										WHERE gestion=$id_gestion AND tipo_fase_convocatoria=4";
							$consulta = mysql_query($consulta_sql,$conn)
							or die("Could not execute the select query.");
							header('Location:planificacion.php#contratos');
						}
						else{
							$error_4 = true;
							$error_fecha_fin_4 = "La gesti&oacute;n termina la fecha ".$fin_gestion;
						}
					}
					else{
						$error_4 = true;
						$error_fecha_fin_4 = "La fecha de finalizaci&oacute;n no debe ser menor que la fecha de inicio";
					}
				}
				else{
					$error_4 = true;
					$error_fecha_ini_4 = "La fecha de inicio no debe ser menor a la fecha presente";
				}
			}
			else{
				$error_4 = true;
				$error_fecha_fin_4 = "La fecha de finalizacion no es v&aacute;lida";
			}
		}
		else{
			$error_4 = true;
			$error_fecha_ini_4 = "La fecha de inicio no es v&aacute;lida";
		}
	}
	else{
		if (!isset($_POST['newsletter_4'])) {
			$consulta_sql="UPDATE fase_convocatoria
						   set activo=0
						   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=4";
			$consulta = mysql_query($consulta_sql,$conn)
			or die("Could not execute the select query.");
			header('Location:planificacion.php#contratos');
			
		}
	}
}
if (isset($_POST['enviar_5'])) {//proceso de desarrollo
	$error_5=false;
	if (isset($_POST['inicio_5']) && isset($_POST['fin_5']) && isset($_POST['newsletter_5'])) {
		$inicio_5 = $_POST['inicio_5'];
		$fin_5 = $_POST['fin_5'];
		$actividad_5="checked";
		$ini_dia_5 = substr($inicio_5, 8);
		$ini_mes_5 = substr($inicio_5, 5,2);
		$ini_year_5 = substr($inicio_5, 0,4);

		$fin_dia_5 = substr($fin_5, 8);
		$fin_mes_5 = substr($fin_5, 5,2);
		$fin_year_5 = substr($fin_5, 0,4);
		if(@checkdate($ini_mes_5, $ini_dia_5, $ini_year_5)){
			if (@checkdate($fin_mes_5, $fin_dia_5, $fin_year_5)) {
				if($inicio_5>=$fecha){//corecto
					if ($fin_5>=$inicio_5) {//corecto sobreescribir base de datos
						if (strtotime($fin_5)<=$fecha_fin) {
							$consulta_sql="UPDATE fase_convocatoria
										set fecha_inicio='$inicio_5' , fecha_fin='$fin_5', activo=1
										WHERE gestion=$id_gestion AND tipo_fase_convocatoria=5";
							$consulta = mysql_query($consulta_sql,$conn)
							or die("Could not execute the select query.");
							header('Location:planificacion.php#desarrollo');
						}
						else{
							$error_5 = true;
							$error_fecha_fin_5 = "La gesti&oacute;n termina la fecha ".$fin_gestion;
						}
					}
					else{
						$error_5 = true;
						$error_fecha_fin_5 = "La fecha de finalizaci&oacute;n no debe ser menor que la fecha de inicio";
					}
				}
				else{
					$error_5 = true;
					$error_fecha_ini_5 = "La fecha de inicio no debe ser menor a la fecha presente";
				}
			}
			else{
				$error_5 = true;
				$error_fecha_fin_5 = "La fecha de finalizacion no es v&aacute;lida";
			}
		}
		else{
			$error_5 = true;
			$error_fecha_ini_5 = "La fecha de inicio no es v&aacute;lida";
		}
	}
	else{
		if (!isset($_POST['newsletter_5'])) {
			$consulta_sql="UPDATE fase_convocatoria
						   set activo=0
						   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=5";
			$consulta = mysql_query($consulta_sql,$conn)
			or die("Could not execute the select query.");
			header('Location:planificacion.php#desarrollo');
			
		}
	}
}
if (isset($_POST['enviar_6'])) {//entrega productos
	$error_6=false;
	if (isset($_POST['inicio_6']) && isset($_POST['fin_6']) && isset($_POST['newsletter_6'])) {
		$inicio_6 = $_POST['inicio_6'];
		$fin_6 = $_POST['fin_6'];
		$actividad_6="checked";
		$ini_dia_6 = substr($inicio_6, 8);
		$ini_mes_6 = substr($inicio_6, 5,2);
		$ini_year_6 = substr($inicio_6, 0,4);

		$fin_dia_6 = substr($fin_6, 8);
		$fin_mes_6 = substr($fin_6, 5,2);
		$fin_year_6 = substr($fin_6, 0,4);
		if(@checkdate($ini_mes_6, $ini_dia_6, $ini_year_6)){
			if (@checkdate($fin_mes_6, $fin_dia_6, $fin_year_6)) {
				if($inicio_6>=$fecha){//corecto
					if ($fin_6>=$inicio_6) {//corecto sobreescribir base de datos
						if (strtotime($fin_6)<=$fecha_fin) {
							$consulta_sql="UPDATE fase_convocatoria
										set fecha_inicio='$inicio_6' , fecha_fin='$fin_6', activo=1
										WHERE gestion=$id_gestion AND tipo_fase_convocatoria=6";
							$consulta = mysql_query($consulta_sql,$conn)
							or die("Could not execute the select query.");
							header('Location:planificacion.php#productos');
						}
						else{
							$error_6 = true;
							$error_fecha_fin_6 = "La gesti&oacute;n termina la fecha ".$fin_gestion;
						}
					}
					else{
						$error_6 = true;
						$error_fecha_fin_6 = "La fecha de finalizaci&oacute;n no debe ser menor que la fecha de inicio";
					}
				}
				else{
					$error_6 = true;
					$error_fecha_ini_6 = "La fecha de inicio no debe ser menor a la fecha presente";
				}
			}
			else{
				$error_6 = true;
				$error_fecha_fin_6 = "La fecha de finalizacion no es v&aacute;lida";
			}
		}
		else{
			$error_6 = true;
			$error_fecha_ini_6 = "La fecha de inicio no es v&aacute;lida";
		}
	}
	else{
		if (!isset($_POST['newsletter_6'])) {
			$consulta_sql="UPDATE fase_convocatoria
						   set activo=0
						   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=6";
			$consulta = mysql_query($consulta_sql,$conn)
			or die("Could not execute the select query.");
			header('Location:planificacion.php#productos');
			
		}
	}
}
if (isset($_POST['enviar_7'])) {//cierre convocatoria
	$error_7=false;
	if (isset($_POST['inicio_7']) && isset($_POST['fin_7']) && isset($_POST['newsletter_7'])) {
		$inicio_7 = $_POST['inicio_7'];
		$fin_7 = $_POST['fin_7'];
		$actividad_7="checked";
		$ini_dia_7 = substr($inicio_7, 8);
		$ini_mes_7 = substr($inicio_7, 5,2);
		$ini_year_7 = substr($inicio_7, 0,4);

		$fin_dia_7 = substr($fin_7, 8);
		$fin_mes_7 = substr($fin_7, 5,2);
		$fin_year_7 = substr($fin_7, 0,4);
		if(@checkdate($ini_mes_7, $ini_dia_7, $ini_year_7)){
			if (@checkdate($fin_mes_7, $fin_dia_7, $fin_year_7)) {
				if($inicio_7>=$fecha){//corecto
					if ($fin_7>=$inicio_7) {//corecto sobreescribir base de datos
						if (strtotime($fin_7)<=$fecha_fin) {
							$consulta_sql="UPDATE fase_convocatoria
										set fecha_inicio='$inicio_7' , fecha_fin='$fin_7', activo=1
										WHERE gestion=$id_gestion AND tipo_fase_convocatoria=7";
							$consulta = mysql_query($consulta_sql,$conn)
							or die("Could not execute the select query.");
							header('Location:planificacion.php#cierre');
						}
						else{
							$error_7 = true;
							$error_fecha_fin_7 = "La gesti&oacute;n termina la fecha ".$fin_gestion;
						}
					}
					else{
						$error_7 = true;
						$error_fecha_fin_7= "La fecha de finalizaci&oacute;n no debe ser menor que la fecha de inicio";
					}
				}
				else{
					$error_7 = true;
					$error_fecha_ini_7 = "La fecha de inicio no debe ser menor a la fecha presente";
				}
			}
			else{
				$error_7 = true;
				$error_fecha_fin_7 = "La fecha de finalizacion no es v&aacute;lida";
			}
		}
		else{
			$error_7 = true;
			$error_fecha_ini_7 = "La fecha de inicio no es v&aacute;lida";
		}
	}
	else{
		if (!isset($_POST['newsletter_7'])) {
			$consulta_sql="UPDATE fase_convocatoria
						   set activo=0
						   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=7";
			$consulta = mysql_query($consulta_sql,$conn)
			or die("Could not execute the select query.");
			header('Location:planificacion.php#cierre');
			
		}
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
						<a href="planificacion.php">Planificaci&oacute;n de actividades</a>
					</li>				
				</ul>
			</div>
			<center><h3>Planificar las actividades de la Empresa TIS</h3></center>
			<?php if($gestion_valida && !$gestion_espera) { //formulario 2 habilitar registro de grupo empresas
			?>
			<div class="row-fluid" id="planificacion">
				<div class="span12">
					<ol>
						  <li><a class="lista" href="#lanzamiento">Lanzamiento Convocatoria P&uacute;blica</a></li>
						  <li><a class="lista" href="#registro">Registro de Grupo Empresas</a></li>
						  <li><a class="lista" href="#documentos">Entrega de Documentos</a></li>
						  <li><a class="lista" href="#contratos">Firma de Contratos</a></li>
						  <li><a class="lista" href="#desarrollo">Proceso de Desarrollo</a></li>
						  <li><a class="lista" href="#productos">Entrega de Productos</a></li>
						  <li><a class="lista" href="#cierre">Cierre de la Convocatoria</a></li>	  
						</ol> 
				</div>
			</div>
			<div class="row-fluid" id="lanzamiento">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> 1. Lanzamiento de la Convocatoria P&uacute;blica</h2>
					</div>
					<div class="box-content">
						<?php
						if (!isset($_POST['enviar_1'])) {
							$consulta_act_1 = "SELECT fecha_inicio,fecha_fin,descripcion,activo
										FROM fase_convocatoria
										WHERE gestion=$id_gestion and tipo_fase_convocatoria=1";
				            $res_1 = mysql_query($consulta_act_1);
				            $row_1= mysql_fetch_array($res_1);
				            $actividad_1=NULL;
				            if (!is_null($row_1['fecha_fin']) && !is_null($row_1['fecha_inicio'])) {            	
				            	$inicio_1=$row_1['fecha_inicio'];
				            	$fin_1=$row_1['fecha_fin'];
				            	if ($row_1['activo']==1) {
				            		$actividad_1="checked";
				            	}
				            }
				            else{
				            	$inicio_1=$mensaje;
				            	$fin_1=$mensaje;
				            }
				        }
						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="form_1" action="planificacion.php#lanzamiento" accept-charset="utf-8">
								<div class="control-group">
								  <label class="control-label">Habilitado: </label>
								  <div class="controls">
									<input type="checkbox" value="actividad_1" class="checkbox" id="actividad_1" name="newsletter_1" <?php echo $actividad_1; ?> />
								  </div>
								</div>
								<fieldset id="actividad_1_topics">
								<div class="control-group">
									<label class="control-label">Desde:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="inicio_1" id="inicio_1" value="<?php echo $inicio_1; ?>">
										<label class="error"><?php if(isset($error_fecha_ini_1)){ echo $error_fecha_ini_1; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Hasta:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="fin_1" id="fin_1" value="<?php echo $fin_1; ?>" >
										<label class="error"><?php if(isset($error_fecha_fin_1)){ echo $error_fecha_fin_1; } ?></label>
									</div>
								</div>
								</fieldset>	
								<div class="control-group">
									<div class="controls">
						         <button name="enviar_1"type="submit" class="btn btn-primary" id="enviar_1"><i class="icon-ok"></i> Aceptar</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								 </div>
								 </div>
						        
							</form>
							<label><b>Nota:</b> Esta actividad no restringe ninguna funcionalidad del sistema, solo se limita a la planificaci&oacute;n de la gesti&oacute;n actual .</label>
		                </div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<div class="row-fluid" id="registro">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> 2. Habilitar registro de Grupo Empresas e Integrantes</h2>
					</div>
					<div class="box-content">
						<?php
						if (!isset($_POST['enviar'])) {
							$consulta_act_2 = "SELECT fecha_inicio,fecha_fin,descripcion,activo
										FROM fase_convocatoria
										WHERE gestion=$id_gestion and tipo_fase_convocatoria=2";
				            $res_2 = mysql_query($consulta_act_2);
				            $row_2= mysql_fetch_array($res_2);
				            $actividad_2=NULL;
				            if (!is_null($row_2['fecha_fin']) && !is_null($row_2['fecha_inicio'])) {            	
				            	$inicio=$row_2['fecha_inicio'];
				            	$fin=$row_2['fecha_fin'];
				            	if ($row_2['activo']==1) {
				            		$actividad_2="checked";
				            	}
				            }
				            else{
				            	$inicio=$mensaje;
				            	$fin=$mensaje;
				            }
				        }
						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" action="planificacion.php#registro" accept-charset="utf-8">
								<div class="control-group">
								  <label class="control-label" for="tituloD">Habilitado: </label>
								  <div class="controls">
									<input type="checkbox" class="checkbox" id="newsletter" name="newsletter" <?php echo $actividad_2; ?> />
								  </div>
								</div>
								<fieldset id="newsletter_topics">
								<div class="control-group">
									<label class="control-label" for="descripcion">Desde:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="inicio" id="inicio" value="<?php echo $inicio; ?>">
										<label class="error"><?php if(isset($error_fecha_ini)){ echo $error_fecha_ini; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Hasta:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="fin" id="fin" value="<?php echo $fin; ?>" >
										<label class="error"><?php if(isset($error_fecha_fin)){ echo $error_fecha_fin; } ?></label>
									</div>
								</div>
								</fieldset>	
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Aceptar</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								 </div>
								 </div>
							</form>
							<label><b>Nota:</b> Si no habilita esta opci&oacute;n, no se podr&aacute; registrar ninguna nueva Grupo Empresa.</label>
		                </div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<div class="row-fluid" id="documentos">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> 3. Entrega de Documentos</h2>
					</div>
					<div class="box-content">
						<?php
						if (!isset($_POST['enviar_3'])) {
							$consulta_act_3 = "SELECT fecha_inicio,fecha_fin,descripcion,activo
										FROM fase_convocatoria
										WHERE gestion=$id_gestion and tipo_fase_convocatoria=3";
				            $res_3 = mysql_query($consulta_act_3);
				            $row_3= mysql_fetch_array($res_3);
				            $actividad_3="";
				            if (!is_null($row_3['fecha_fin']) && !is_null($row_3['fecha_inicio'])) {            	
				            	$inicio_3=$row_3['fecha_inicio'];
				            	$fin_3=$row_3['fecha_fin'];
				            	if ($row_3['activo']==1) {
				            		$actividad_3="checked";
				            	}
				            }
				            else{
				            	$inicio_3=$mensaje;
				            	$fin_3=$mensaje;
				            }
				        }
						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="form_3" action="planificacion.php#documentos" accept-charset="utf-8">
								<div class="control-group">
								  <label class="control-label">Habilitado: </label>
								  <div class="controls">
									<input type="checkbox" value="actividad_3" class="checkbox" id="actividad_3" name="newsletter_3" <?php echo $actividad_3; ?> />
								  </div>
								</div>
								<fieldset id="actividad_3_topics">
								<div class="control-group">
									<label class="control-label">Desde:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="inicio_3" id="inicio_3" value="<?php echo $inicio_3; ?>">
										<label class="error"><?php if(isset($error_fecha_ini_3)){ echo $error_fecha_ini_3; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Hasta:</label>
									<div class="controls">
										<input type="text" class="datepicker" name="fin_3" etitable='false' id="fin_3" value="<?php echo $fin_3; ?>" >
										<label class="error"><?php if(isset($error_fecha_fin_3)){ echo $error_fecha_fin_3; } ?></label>
									</div>
								</div>
								</fieldset>	
								<div class="control-group">
									<div class="controls">
						         <button name="enviar_3"type="submit" class="btn btn-primary" id="enviar_3"><i class="icon-ok"></i> Aceptar</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								 </div>
								 </div>
						        
							</form>
							<label><b>Nota:</b> Si no habilita esta opci&oacute;n, ninguna Grupo Empresa podr&aacute; subir sus Sobres "A" y "B" correspondientes.</label>
		                </div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<div class="row-fluid" id="contratos">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> 4. Firma de Contratos</h2>
					</div>
					<div class="box-content">
						<?php
						if (!isset($_POST['enviar_4'])) {
							$consulta_act_4 = "SELECT fecha_inicio,fecha_fin,descripcion,activo
										FROM fase_convocatoria
										WHERE gestion=$id_gestion and tipo_fase_convocatoria=4";
				            $res_4 = mysql_query($consulta_act_4);
				            $row_4= mysql_fetch_array($res_4);
				            $actividad_4=NULL;
				            if (!is_null($row_4['fecha_fin']) && !is_null($row_4['fecha_inicio'])) {            	
				            	$inicio_4=$row_4['fecha_inicio'];
				            	$fin_4=$row_4['fecha_fin'];
				            	if ($row_4['activo']==1) {
				            		$actividad_4="checked";
				            	}
				            }
				            else{
				            	$inicio_4=$mensaje;
				            	$fin_4=$mensaje;
				            }
				        }
						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="form_4" action="planificacion.php#contratos" accept-charset="utf-8">
								<div class="control-group">
								  <label class="control-label">Habilitado: </label>
								  <div class="controls">
									<input type="checkbox" value="actividad_4" class="checkbox" id="actividad_4" name="newsletter_4" <?php echo $actividad_4; ?> />
								  </div>
								</div>
								<fieldset id="actividad_4_topics">
								<div class="control-group">
									<label class="control-label">Desde:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="inicio_4" id="inicio_4" value="<?php echo $inicio_4; ?>">
										<label class="error"><?php if(isset($error_fecha_ini_4)){ echo $error_fecha_ini_4; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Hasta:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="fin_4" id="fin_4" value="<?php echo $fin_4; ?>" >
										<label class="error"><?php if(isset($error_fecha_fin_4)){ echo $error_fecha_fin_4; } ?></label>
									</div>
								</div>
								</fieldset>	
								<div class="control-group">
									<div class="controls">
						         <button name="enviar_4"type="submit" class="btn btn-primary" id="enviar_4"><i class="icon-ok"></i> Aceptar</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								 </div>
								 </div>
						        
							</form>
							<label><b>Nota:</b> Esta actividad no restringe ninguna funcionalidad del sistema, solo se limita a la planificaci&oacute;n de la gesti&oacute;n actual .</label>
		                </div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<div class="row-fluid" id="desarrollo">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> 5. Proceso de Desarrollo</h2>
					</div>
					<div class="box-content">
						<?php
						if (!isset($_POST['enviar_5'])) {
							$consulta_act_5 = "SELECT fecha_inicio,fecha_fin,descripcion,activo
										FROM fase_convocatoria
										WHERE gestion=$id_gestion and tipo_fase_convocatoria=5";
				            $res_5 = mysql_query($consulta_act_5);
				            $row_5= mysql_fetch_array($res_5);
				            $actividad_5=NULL;
				            if (!is_null($row_5['fecha_fin']) && !is_null($row_5['fecha_inicio'])) {            	
				            	$inicio_5=$row_5['fecha_inicio'];
				            	$fin_5=$row_5['fecha_fin'];
				            	if ($row_5['activo']==1) {
				            		$actividad_5="checked";
				            	}
				            }
				            else{
				            	$inicio_5=$mensaje;
				            	$fin_5=$mensaje;
				            }
				        }
						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="form_5" action="planificacion.php#desarrollo" accept-charset="utf-8">
								<div class="control-group">
								  <label class="control-label">Habilitado: </label>
								  <div class="controls">
									<input type="checkbox" value="actividad_5" class="checkbox" id="actividad_5" name="newsletter_5" <?php echo $actividad_5; ?> />
								  </div>
								</div>
								<fieldset id="actividad_5_topics">
								<div class="control-group">
									<label class="control-label">Desde:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="inicio_5" id="inicio_5" value="<?php echo $inicio_5; ?>">
										<label class="error"><?php if(isset($error_fecha_ini_5)){ echo $error_fecha_ini_5; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Hasta:</label>
									<div class="controls">
										<input type="text" etitable='false' class="datepicker" name="fin_5" id="fin_5" value="<?php echo $fin_5; ?>" >
										<label class="error"><?php if(isset($error_fecha_fin_5)){ echo $error_fecha_fin_5; } ?></label>
									</div>
								</div>
								</fieldset>	
								<div class="control-group">
									<div class="controls">
						         <button name="enviar_5"type="submit" class="btn btn-primary" id="enviar_5"><i class="icon-ok"></i> Aceptar</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								 </div>
								 </div>
						        
							</form>
							<label><b>Nota:</b> Si no habilita esta opci&oacute;n, ninguna Grupo Empresa podr&aacute; planificar y registrar sus avances del proyecto.</label>
		                </div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<div class="row-fluid" id="productos">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> 6. Entrega de Producto Final</h2>
					</div>
					<div class="box-content">
						<?php
						if (!isset($_POST['enviar_6'])) {
							$consulta_act_6 = "SELECT fecha_inicio,fecha_fin,descripcion,activo
										FROM fase_convocatoria
										WHERE gestion=$id_gestion and tipo_fase_convocatoria=6";
				            $res_6 = mysql_query($consulta_act_6);
				            $row_6= mysql_fetch_array($res_6);
				            $actividad_6=NULL;
				           if (!is_null($row_6['fecha_fin']) && !is_null($row_6['fecha_inicio'])) {            	
				            	$inicio_6=$row_6['fecha_inicio'];
				            	$fin_6=$row_6['fecha_fin'];
				            	if ($row_6['activo']==1) {
				            		$actividad_6="checked";
				            	}
				            }
				            else{
				            	$inicio_6=$mensaje;
				            	$fin_6=$mensaje;
				            }
				        }
						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="form_6" action="planificacion.php#productos" accept-charset="utf-8">
								<div class="control-group">
								  <label class="control-label">Habilitado: </label>
								  <div class="controls">
									<input type="checkbox" value="actividad_6" class="checkbox" id="actividad_6" name="newsletter_6" <?php echo $actividad_6; ?> />
								  </div>
								</div>
								<fieldset id="actividad_6_topics">
								<div class="control-group">
									<label class="control-label">Desde:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="inicio_6" id="inicio_6" value="<?php echo $inicio_6; ?>">
										<label class="error"><?php if(isset($error_fecha_ini_6)){ echo $error_fecha_ini_6; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Hasta:</label>
									<div class="controls">
										<input type="text" etitable='false' class="datepicker" name="fin_6" id="fin_6" value="<?php echo $fin_6; ?>" >
										<label class="error"><?php if(isset($error_fecha_fin_6)){ echo $error_fecha_fin_6; } ?></label>
									</div>
								</div>
								</fieldset>	
								<div class="control-group">
									<div class="controls">
						         <button name="enviar_6"type="submit" class="btn btn-primary" id="enviar_6"><i class="icon-ok"></i> Aceptar</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								 </div>
								 </div>
						        
							</form>
							<label><b>Nota:</b> Esta actividad no restringe ninguna funcionalidad del sistema, solo se limita a la planificaci&oacute;n de la gesti&oacute;n actual .</label>
		                </div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<div class="row-fluid" id="cierre">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> 7. Cierre de la Convocatoria</h2>
					</div>
					<div class="box-content">
						<?php
						if (!isset($_POST['enviar_7'])) {
							$consulta_act_7 = "SELECT fecha_inicio,fecha_fin,descripcion,activo
										FROM fase_convocatoria
										WHERE gestion=$id_gestion and tipo_fase_convocatoria=7";
				            $res_7 = mysql_query($consulta_act_7);
				            $row_7= mysql_fetch_array($res_7);
				            $actividad_7=NULL;
				           	if (!is_null($row_7['fecha_fin']) && !is_null($row_7['fecha_inicio'])) {            	
				            	$inicio_7=$row_7['fecha_inicio'];
				            	$fin_7=$row_7['fecha_fin'];
				            	if ($row_7['activo']==1) {
				            		$actividad_7="checked";
				            	}
				            }
				            else{
				            	$inicio_7=$mensaje;
				            	$fin_7=$mensaje;
				            }
				        }
						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="form_7" action="planificacion.php#cierre" accept-charset="utf-8">
								<div class="control-group">
								  <label class="control-label">Habilitado: </label>
								  <div class="controls">
									<input type="checkbox" value="actividad_7" class="checkbox" id="actividad_7" name="newsletter_7" <?php echo $actividad_7; ?> />
								  </div>
								</div>
								<fieldset id="actividad_7_topics">
								<div class="control-group">
									<label class="control-label">Desde:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="inicio_7" id="inicio_7" value="<?php echo $inicio_7; ?>">
										<label class="error"><?php if(isset($error_fecha_ini_7)){ echo $error_fecha_ini_7; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Hasta:</label>
									<div class="controls">
										<input type="text" etitable='false' class="datepicker" name="fin_7" id="fin_7" value="<?php echo $fin_7; ?>" >
										<label class="error"><?php if(isset($error_fecha_fin_7)){ echo $error_fecha_fin_7; } ?></label>
									</div>
								</div>
								</fieldset>	
								<div class="control-group">
									<div class="controls">
						         <button name="enviar_7"type="submit" class="btn btn-primary" id="enviar_7"><i class="icon-ok"></i> Aceptar</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								 </div>
								 </div>
						        
							</form>
							<label><b>Nota:</b> Esta actividad no restringe ninguna funcionalidad del sistema, solo se limita a la planificaci&oacute;n de la gesti&oacute;n actual .</label>
		                </div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<p class="pull-right"><a href="#top"><i class="icon-circle-arrow-up"></i> Volver arriba</a></p>
			<?php }
			else{ ?>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> Planificacion de Actividades</h2>
					</div>
					<div class="box-content alerts">
						<?php 
							echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        La gesti&oacute;n no se encuentra disponible.</h4>
				                      	</div>";
						?>						
					</div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<?php } ?>
<?php include('footer.php'); ?>