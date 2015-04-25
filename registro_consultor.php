<?php
$titulo="Registro Consultor TIS";
include('conexion/verificar_gestion.php');
session_start();
$quien_ingresa="Consultor TIS";
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
/*--------------------------------VALIDAR REGISTRO------------------------------------*/
if(isset($_POST['enviar'])){
	include('conexion/conexion.php');
	/*VALORES DE FORMULARIO*/
	$usuario=trim($_POST['username']);
	$clave=trim($_POST['password']); /*$clave = md5($pass); QUITADO ==> CONTRASEÑA SIMPLE*/
	$apellido=$_POST['lastname'];
	$nombre=$_POST['firstname'];
	$telf=trim($_POST['telf']);
	$eMail=trim($_POST['email']);
	$consulta_usuario = mysql_query("SELECT nombre_usuario from usuario 
	                          where nombre_usuario='$usuario'AND (gestion=1 OR gestion=$id_gestion)",$conn)
	                          or die("Could not execute the select query.");
	$consulta_email = mysql_query("SELECT email from usuario 
	                         where email='$eMail'AND (gestion=1 OR gestion=$id_gestion)",$conn)
	                         or die("Could not execute the select query.");                         

	$resultado_usuario = mysql_fetch_assoc($consulta_usuario);
	$resultado_email = mysql_fetch_assoc($consulta_email);
	$error=false;
	$tiene_curriculum=0;
	$pdf=NULL;
	  if(is_array($resultado_usuario) && !empty($resultado_usuario))//ya existe usuario o email
	    {     
		      if (strcmp($resultado_usuario['nombre_usuario'],$usuario)==0) { 
		              $error_user="El usuario ya esta registrado";
		              $error=true;
		       }   
      
	     }
	     if(is_array($resultado_email) && !empty($resultado_email)){
	     	if (strcmp($resultado_email['email'],$eMail)==0) {
		              $error_email="El correo electr&oacute;nico ya esta registrado";
		              $error=true;
		      } 
	     }
	   $ext_permitidas = array('.pdf');
	   if(!empty($_FILES['pdf']['name'])){
            $nombre_archivo = $_FILES['pdf']['name'];
            $nombre_tmp = $_FILES['pdf']['tmp_name'];
            $ext = substr($nombre_archivo, strpos($nombre_archivo, '.'));
            $tamano = $_FILES['pdf']['size'];             
            $limite = 1000 * 1024;
            if(in_array($ext, $ext_permitidas)){
            	if( $tamano <= $limite ){
                    if( $_FILES['pdf']['error'] <= 0 ){
                    	if( file_exists( 'curriculum/'.$usuario.'.pdf') ){
                              $error_curriculum='El archivo ya existe';
                              $error=true;
                        }
                        else{ 
                        	 move_uploaded_file($nombre_tmp,'curriculum/'.$usuario.'.pdf');
                             $pdf='curriculum/'.$usuario.'.pdf';
                             $tiene_curriculum=1;
                        }
                      
                     }
                     else{
                     		$error_curriculum='Error al subir el archivo';
                      		$error=true;

                       }
                    }
                else{  
                      $error_curriculum='El archivo debe un tama&ntilde;o menor a 1 Mega Byte';
                      $error=true;
                    }
            }
            else{
            	$error=true;
            	$error_curriculum='El archivo debe tener formato " pdf "';
            }

   			}

	     if(!$error){/*SI NO HAY NINGUN ERROR REGISTRO*/
	        $bitacora = mysql_query("CALL iniciar_sesion(1)",$conn)
		or die("Error no se pudo realizar cambios.");
	        $sql = "INSERT INTO usuario (nombre_usuario,clave,nombre,apellido,telefono,email,habilitado,tipo_usuario,gestion)
	                VALUES ('$usuario','$clave','$nombre','$apellido','$telf','$eMail',0,3,1)";
	        $result = mysql_query($sql,$conn) or die(mysql_error());

	        $id_consultor = "SELECT id_usuario
							 FROM usuario
							 WHERE nombre_usuario='$usuario' AND gestion=1";
	        $consulta_id = mysql_query($id_consultor,$conn) or die(mysql_error());
	        $resultado_id = mysql_fetch_assoc($consulta_id);
	        $id=$resultado_id['id_usuario'];
	        if (is_null($pdf)) {
	        	$sql = "INSERT INTO consultor_tis (usuario, curriculum)
	                VALUES ($id,NULL)";
	        }else{
	        	$sql = "INSERT INTO consultor_tis (usuario, curriculum)
	                VALUES ($id,'$pdf')";
	        }
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	       	header('Location: valido.php?value=3');
	   }
	}
	else{
		$usuario=NULL;
		$apellido=NULL;
		$nombre=NULL;
		$telf=NULL;
		$eMail=NULL;
	}
	include('header.php');
	/*----------------------FIN VALIDAR REGISTRO------------------------*/
 ?>
			<div>
				<ul class="breadcrumb">					
					<li>
						<a href="index.php">Inicio</a><span class="divider">/</span>
					</li>
					<li>
						<a href="registro_consultor.php">Registro <?php echo $quien_ingresa; ?></a>
					</li>				
				</ul>
			</div>
			<center><h3><?php echo $titulo; ?></h3></center>
			<div class="row-fluid">
				<div class="box span12 center">
						<div class="box-header well">
							<h2><i class="icon-edit"></i> Formulario de registro: Consultor TIS</h2>					
						</div>
						<div class="box-content" id="formulario">
							<?php if ($gestion_valida) {
							 ?>
						</br>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" accept-charset="utf-8" action="registro_consultor.php">
								<fieldset>
								<div class="control-group">
								  <label class="control-label" for="pass">Nombre: </label>
								  <div class="controls">
									<input type="text" placeholder="Nombre" class="firstnames" name="firstname" id="firstname" value='<?php echo $nombre; ?>' >
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Apellido: </label>
								  <div class="controls">
									<input type="text" placeholder="Apellido" name="lastname" class="lastnames" id="lastname" value='<?php echo $apellido; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="name">Nombre de Usuario: </label>
								  <div class="controls">
									<input placeholder="Usuario" name="username" type="text" id="username" value='<?php echo $usuario; ?>'>
									<label id="error_user" class="error"><?php if(isset($error_user)){ echo $error_user; } ?></label>
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
									<input type="text" placeholder="E-mail" name="email"  id="email" value='<?php echo $eMail; ?>'>
									<label id="error_email" class="error"><?php if(isset($error_email)){ echo $error_email; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="fileInput">Curr&iacute;culo:</label>
								  <div class="controls">
									<input class="" name="pdf" id="pdf"  type="file" />
									<label id="error_curriculum" class="error"><?php if(isset($error_curriculum)){ echo $error_curriculum; } ?></label>
								  </div>
								</div>
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Registrar</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Restablecer</button>
								 </div>
								 </div>
						        </fieldset>
								</form>
								<?php } 
							else{
							echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No existe ninguna actividad para esta gesti&oacute;n.</h4>
				                      	</div>";
						
							}    ?>	 
		                </div>
				</div><!--/FORMULARIO DE INGRESO-->	
			</div>

<?php include('footer.php'); ?>
