<?php
include('conexion/verificar_gestion.php');
$titulo="Iniciar sesi&oacute;n Consultor TIS";
session_start();
if(isset($_SESSION['nombre_usuario']))
		{
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
		            case (2) :
		                	$home="home_consultor_jefe.php";
		                    break;
		            case (1) :
		                    $home="home_admin.php";
		                    break;                                                             		
		          }   
			header("Location: ".$home);
		}		
$quien_ingresa="Consultor TIS";
$pag_registro="registro_consultor.php";
$error=false;
include('conexion/conexion.php');
	if (isset($_POST['aceptar'])) {	
		$usuario = trim($_POST['username']);
		$clave = trim($_POST['password']);
		$consulta_sql="SELECT id_usuario, nombre_usuario, tipo_usuario
					   from usuario 
					   where nombre_usuario='$usuario' and clave='$clave' and (tipo_usuario=2 OR tipo_usuario=3) AND habilitado=1 AND gestion=1";
		$consulta = mysql_query($consulta_sql,$conn)
		or die("Could not execute the select query.");
		$resultado = mysql_fetch_assoc($consulta);

					if(is_array($resultado) && !empty($resultado) )
					{
						$_SESSION['id'] = $resultado['id_usuario'];
						$_SESSION['tipo']= $resultado['tipo_usuario'];
						$_SESSION['nombre_usuario'] = $resultado['nombre_usuario'];
					}
				else{
						$error=true;
						$error_sesion="Los datos incorrectos o usted no esta habilitado para esta gesti&oacute;n";
					}
					if(!$error){
						if(isset($_SESSION['nombre_usuario']))
						{
							$bitacora = mysql_query("INSERT into bitacora_sesion(usuario,fecha_hora,operacion)
													VALUES (".$_SESSION['id'].",CURRENT_TIMESTAMP,0)",$conn)
							or die("Error en la bitacora.");
							$home="";
							switch  ($_SESSION['tipo']){
						            case (3) :
						                	$home="home_consultor.php";
						                    break;
						            case (2) :
						                	$home="home_consultor_jefe.php";
						                    break;
						          }
							header("Location: ".$home);
						}
						mysql_free_result($consulta);
					}

	}


include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a><span class="divider">/</span>
					</li>
					<li>
<!----------------------ERROR DESCUBIERTO, NO ESTABA BIEN REDIRIGIDA LA PAGINA-->
						<a href="iniciar_sesion_consultor.php">Iniciar sesi&oacute;n <?php echo $quien_ingresa; ?></a>
					</li>
				</ul>
			</div>
			<center><h3>Iniciar sesi&oacute;n: <?php echo $quien_ingresa; ?></h3></center>
			<div class="row-fluid">
				<div class="box span12 center">
						<div class="box-header well">
							<h2><i class="icon-edit"></i> Formulario de inicio de sesi&oacute;n: <?php echo $quien_ingresa; ?></h2>
						</div>
						<div class="box-content">
							<br>
	                  		<form class="form-horizontal" id="signupForm" style="text-align:left;" action="iniciar_sesion_consultor.php" method="post" accept-charset="utf-8">
							  <fieldset>
								<div class="control-group">
								  <label class="control-label" for="name">Nombre de Usuario: </label>
								  <div class="controls">
									<input placeholder="Usuario" name="username" type="text" id="username">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Contrase&ntilde;a: </label>
								  <div class="controls">
									<input type="password" placeholder="Contrase&ntilde;a" name="password" id="password">
								  </div>
								</div>   
								<div class="control-group">
								<div class="controls">
						         <button name="aceptar" type="submit" class="btn btn-primary" id="enviar">Ingresar</button>
								 <button type="reset" class="btn">Restablecer</button>
								 <label class="error"><?php if(isset($error_sesion)){ echo $error_sesion; } ?></label>
								 </div>
								 </div>
							  </fieldset>
							</form>
		                </div>
				</div><!--/FORMULARIO DE INGRESO-->
			</div>
<?php include('footer.php'); ?>
