<?php
include('conexion/conexion.php');
include('conexion/verificar_gestion.php');

$conexion = new Conexion;
$conexion->EstablecerConexion();
$conn = $conexion->GetConexion();
$verificarG = new VerificarGestion;

session_start();

  $quien_ingresa="";
  $pag_ini="";
  $quien=$_SESSION['tipo'];
  switch($quien)
  {
    case (3) :
    $quien_ingresa="Consultor TIS";
    $pag_ini="home_cosultor.php";
    break;
    case (2) :
    $quien_ingresa="Jefe Consultor TIS";
    $pag_ini="home_consultor_jefe.php";
    break;
  } 
  $titulo="Modificar datos ".$quien_ingresa;

    	$sql = "SELECT id_usuario,nombre_usuario,clave,nombre,apellido,telefono,email,curriculum
				FROM usuario u, consultor_tis c
				WHERE id_usuario=usuario AND id_usuario=".$_SESSION['id'];
		$auxiliar = mysql_query($sql,$conn);
		$result = mysql_fetch_array($auxiliar);
		$id_usuario=$result['id_usuario'];
        $user=$result['nombre_usuario'];
        $cla=$result['clave'];
		$nom=$result['nombre'];
		$ape=$result['apellido'];
		$telf=$result['telefono'];
		$mail=$result['email'];

/*--------------------------------VALIDAR REGISTRO------------------------------------*/
if(isset($_POST['enviar']))
{
	/*VALORES DE FORMULARIO*/
    $usuario=trim($_POST['username']);
    $clave=trim($_POST['password']);
	$apellido=$_POST['lastname'];
	$nombre=$_POST['firstname'];
	$telfFijo=trim($_POST['telf']);
	$eMail=trim($_POST['email']);
	$error=false;
	if(strcmp($mail,$eMail)!=0) 
	{ 
		$sql = "SELECT email
				FROM usuario
				WHERE email='$eMail' AND (gestion=1 OR gestion=$verificarG->id_gestion)";
		$auxiliar = mysql_query($sql,$conn);
		$result = mysql_fetch_array($auxiliar);
		if(is_array($result) && !empty($result))//ya existe usuario o email
		{
			if (strcmp($result['email'],$eMail)==0)
			{ 
			        $error_email="El e-mail ya esta registrado";
			        $mail=$eMail;
			        $error=true;
			}   
	      
		}
	}
    if(strcmp($user,$usuario)!=0)
    {
        $sql_user= "SELECT nombre_usuario
                    FROM usuario
                    WHERE nombre_usuario='$usuario' AND (gestion=1 OR gestion=$verrificarG->id_gestion)";
        $auxiliar_usuario = mysql_query($sql_user,$conn);
        $result_user = mysql_fetch_array($auxiliar_usuario) or die("no esta ejecutando los datos");
        if(is_array($result_user) && !empty($result_user))
        {
            if(strcmp($result_user['nombre_usuario'],$usuario)==0)
            {
                $error_usuario="El nombre de usuario ya esta registrado";
                $user=$usuario;
                $error = true;
            }
        }
    }
	if(!$error)
	{/*SI NO HAY NINGUN ERROR REGISTRO*/
	 	$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
							or die("Error no se pudo realizar cambios.");
	        $sql = "UPDATE usuario as u
					SET nombre_usuario='$usuario', clave='$clave', nombre='$nombre',apellido='$apellido', telefono='$telfFijo',email='$eMail'
					WHERE u.id_usuario=$id_usuario";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	        
            echo "<script type='text/javascript'>"; 
            echo "alert('Tus datos se han modificado de forma exitosa!');";
            echo "</script>";
            echo"<META HTTP-EQUIV='Refresh' CONTENT='1; URL=index.php'> ";
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
						<a href='info_consultor.php?value=<?php echo $quien; ?>'> Informaci&oacute;n del usuario </a><span class="divider">/</span>
					</li>
					<li>
						<a href='modificar_registro_consultor.php?value=<?php echo $quien; ?>'> Modificar registro </a>
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
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="modificar_registro_consultor.php" accept-charset="utf-8">
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
                                  <label class="control-label" for="pass">Nombre de Usuario: </label>
                                  <div class="controls">
                                    <input type="text" placeholder="Usuario" name="username" id="username" value='<?php echo $user; ?>'>
                                    <label id="error_usuario" class="error"><?php if(isset($error_usuario)){echo $error_usuario; }?></label>
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
