<?php
session_start();
include('conexion/verificar_gestion.php');
$quien_ingresa="Administrador del sistema";
$pag_ini="home_admin.php";
$quien=1;
 $titulo="Modificar datos ".$quien_ingresa;
/*------------------VERIFICAR QUE SEAL EL CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=$quien)
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
	            case (1) :
	                    $home="home_admin.php";
	                    break;                                                             		
	          }   
		header("Location: ".$home);
}
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
		$sql = "SELECT id_usuario,nombre,apellido,telefono,email
				FROM usuario u
				WHERE id_usuario=".$_SESSION['id'];
		$auxiliar = mysql_query($sql,$conn);
		$result = mysql_fetch_array($auxiliar);
		$id_usuario=$result['id_usuario'];
		$nom=$result['nombre'];
		$ape=$result['apellido'];
		$telf=$result['telefono'];
		$mail=$result['email'];

/*--------------------------------VALIDAR REGISTRO------------------------------------*/
if(isset($_POST['enviar'])){
	/*VALORES DE FORMULARIO*/
	$apellido=$_POST['lastname'];
	$nombre=$_POST['firstname'];
	$telfFijo=trim($_POST['telf']);
	$eMail=trim($_POST['email']);
	$error=false;
	if (strcmp($mail,$eMail)!=0) { 
		$sql = "SELECT email
				FROM usuario
				WHERE email='$eMail' AND (gestion=1 OR gestion=$id_gestion)";
		$auxiliar = mysql_query($sql);
		$result = mysql_fetch_array($auxiliar);
		if(is_array($result) && !empty($result))//ya existe usuario o email
		{     
			if (strcmp($result['email'],$eMail)==0) { 
			        $error_email="El e-mail ya esta registrado";
			        $mail=$eMail;
			        $error=true;
			}   
	      
		}
	}
	 	if(!$error){/*SI NO HAY NINGUN ERROR REGISTRO*/
	 	$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
							or die("Error no se pudo realizar cambios.");
	        $sql = "UPDATE usuario as u
					SET nombre='$nombre',apellido='$apellido', telefono='$telfFijo',email='$eMail'
					WHERE u.id_usuario=$id_usuario";
	        $result = mysql_query($sql,$conn) or die(mysql_error());

	        header('Location: modificar_registro_admin.php');
			
	     }
	}
	/*----------------------FIN VALIDAR REGISTRO------------------------*/
	include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">					
					<li>
						<a href="index.php">Inicio</a><span class="divider">/</span>
					</li>
					<li>
						<a href='info_admin.php'> Informaci&oacute;n del usuario Administrador</a><span class="divider">/</span>
					</li>
					<li>
						<a href='modificar_registro_admin.php'> Modificar registro </a>
					</li>				
				</ul>
			</div>
			<center><h3>Modificar registro Consultor TIS</h3></center>
			<div class="row-fluid">
				<div class="box span12 center">
						<div class="box-header well">
							<h2><i class="icon-edit"></i> Formulario de modificaci&oacute;n de datos</h2>					
						</div>
						<div class="box-content" id="formulario">
						</br>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="modificar_registro_admin.php" accept-charset="utf-8">
								<fieldset>
								<div class="control-group">
								  <label class="control-label" for="pass">Nombre: </label>
								  <div class="controls">
									<input type="text" placeholder="Nombre" name="firstname" class="firstnames" id="firstname" value='<?php echo $nom; ?>' >
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Apellido: </label>
								  <div class="controls">
									<input type="text" placeholder="Apellido" name="lastname" class="lastnames" id="lastname" value='<?php echo $ape; ?>'>
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="pass">Tel&eacute;fono: </label>
								  <div class="controls">
									<input type="text" placeholder="Tel&eacute;fono fijo" name="telf" class="telefonos" id="telf" value='<?php echo $telf; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Correo Electr&oacute;nico:</label>
								  <div class="controls">
									<input type="text" placeholder="E-mail" name="email"  id="email" value='<?php echo $mail; ?>'>
									<label id="error_email" class="error"><?php if(isset($error_email)){ echo $error_email; } ?></label>
								  </div>
								</div>
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar Cambios</button>
								 <a href="javascript:history.back();" class="btn"><i class="icon-remove"></i> Cancelar</a>
								 </div>
								 </div>
						        </fieldset>
								</form>
		                </div>
				</div><!--/FORMULARIO DE INGRESO-->	
			</div>

<?php include('footer.php'); ?>
