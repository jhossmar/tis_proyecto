<?php
$titulo="Registro Grupo Empresa";
include ('conexion/verificar_gestion.php');
session_start();
$quien_ingresa="Grupo Empresa";
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
		$error=false;
		/*VALORES GRUPO EMPRESA*/
		$nombre_largo=$_POST['lname'];
		$nombre_corto=$_POST['sname'];
		$sociedad=$_POST['choose_sociedad'];
		$consultor=$_POST['choose_consultor'];
		if (isset($_POST['metodologias'])) {
			$metodologias=$_POST['metodologias'];
			if (sizeof($metodologias)==0) {
				$error=true;
				$error_metodologia="Debe seleccionar m&iacute;nimamente una metodologia";
			}
		}
		else{
			$error=true;
			$error_metodologia="Debe seleccionar m&iacute;nimamente una metodologia";
		}
		/*VALORES REPRESENTANTE LEGAL*/
		$usuario=trim($_POST['username']);
		$clave=trim($_POST['password']); /*$clave = md5($pass); QUITADO ==> CONTRASEÑA SIMPLE*/
		$cod_sis = trim($_POST['codSIS']);
		$eMail=trim($_POST['email']);
		$nombre_rep = $_POST['firstname'];
		$apellido_rep = $_POST['lastname'];
		$telefono_rep = trim($_POST['telf']);
		$carrera_rep = $_POST['choose_carrera'];

		if ($sociedad=='-1' ) {
			$error=true;
			$error_sociedad="Debe seleccionar una sociedad para su Grupo Empresa";
		}
		if ($consultor=='-1' ) {
			$error=true;
			$error_consultor="Debe seleccionar una Consultor para su Grupo Empresa";
		}
		if ($carrera_rep=='-1' ) {
			$error=true;
			$error_carrera="Debe seleccionar una carrera";
		}

		$consulta_usuario = mysql_query("SELECT nombre_usuario from usuario 
		                          where nombre_usuario='$usuario' AND (gestion=1 OR gestion=$id_gestion)",$conn)
		                          or die("Could not execute the select query.");//unico para la gestion
		$consulta_email = mysql_query("SELECT email from usuario 
		                         where email='$eMail'AND (gestion=1 OR gestion=$id_gestion)",$conn)
		                         or die("Could not execute the select query.");//unico para la gestion
		$consulta_nl = mysql_query("SELECT nombre_largo from grupo_empresa 
		                         where nombre_largo='$nombre_largo'",$conn)
		                         or die("Could not execute the select query.");//unico siempre
		$consulta_nc = mysql_query("SELECT nombre_corto from grupo_empresa 
		                         where nombre_corto='$nombre_corto'",$conn)
		                         or die("Could not execute the select query.");//unico siempre
		$consulta_cod = mysql_query("SELECT codigo_sis from usuario, integrante 
								where integrante.usuario=usuario.id_usuario AND codigo_sis='$cod_sis' AND (gestion=1 OR gestion=$id_gestion)",$conn)
		                         or die("Could not execute the select query."); //unico para la gestion



		$resultado_usuario = mysql_fetch_assoc($consulta_usuario);
		$resultado_email = mysql_fetch_assoc($consulta_email);
		$resultado_nl = mysql_fetch_assoc($consulta_nl);
		$resultado_nc = mysql_fetch_assoc($consulta_nc);
		$resultado_cod = mysql_fetch_assoc($consulta_cod);
		
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
		   if(is_array($resultado_nl) && !empty($resultado_nl)){
		     	if (strcmp($resultado_nl['nombre_largo'],$nombre_largo)==0) {
			              $error_nl="El nombre largo ya esta registrado";
			              $error=true;
			      } 
		   }
		   if(is_array($resultado_nc) && !empty($resultado_nc)){
		     	if (strcmp($resultado_nc['nombre_corto'],$nombre_corto)==0) {
			              $error_nc="El nombre corto ya esta registrado";
			              $error=true;
			      } 
		   }
		   if(is_array($resultado_cod) && !empty($resultado_cod)){
		     	if (strcmp($resultado_cod['codigo_sis'],$cod_sis)==0) {
			              $error_cod="El integrante ya est&aacute; registrado";
			              $error=true;
			      } 
		   }

		   if(!$error){/*SI NO HAY NINGUN ERROR REGISTRO*/
		
			$bitacora = mysql_query("CALL iniciar_sesion(1)",$conn)
			or die("Error no se pudo realizar cambios.");
		   		/*INSERTAR EL USUARIO*/
		        $sql = "INSERT INTO usuario (nombre_usuario, clave,nombre,apellido,telefono, email, tipo_usuario, habilitado,gestion)
		                VALUES ('$usuario','$clave','$nombre_rep','$apellido_rep','$telefono_rep','$eMail',4,0,$id_gestion)";
		        $result = mysql_query($sql,$conn) or die(mysql_error());
			
			/*ID DEL USUARIO PARA EL INTEGRANTE*/
		        $sql = "SELECT id_usuario from usuario where nombre_usuario='$usuario' and gestion=$id_gestion";
		        $result = mysql_query($sql,$conn) or die(mysql_error());
		        $resultado_user = mysql_fetch_assoc($result);
		        $id_user=(int)$resultado_user['id_usuario'];
		        
		        /*INSERTAR LA GRUPO EMPRESA*/
		        $sql = "INSERT INTO grupo_empresa (nombre_largo, nombre_corto,sociedad, consultor_tis)
		                VALUES ('$nombre_largo','$nombre_corto','$sociedad','$consultor')";
		        $result = mysql_query($sql,$conn) or die(mysql_error());

		        /*ID DE LA GRUPO EMPRESA PARA EL INTEGRANTE*/
		        $sql = "SELECT id_grupo_empresa from grupo_empresa where nombre_largo='$nombre_largo'";
		        $result = mysql_query($sql,$conn) or die(mysql_error());
		        $resultado_grupo = mysql_fetch_assoc($result);
		        $id_grupo_empresa=(int)$resultado_grupo['id_grupo_empresa'];

		   		/*INSERTAR AL INTEGRANTE*/
		   		$sql = "INSERT INTO integrante (usuario,codigo_sis,carrera,grupo_empresa)
		                VALUES ($id_user,'$cod_sis',$carrera_rep,$id_grupo_empresa)";
		        $result = mysql_query($sql,$conn) or die(mysql_error());

		        /*INSERTAR SU ROL DE REPRESENTATE LEGAL*/
		        $sql = "INSERT INTO rol_integrante (integrante,rol)
		                VALUES ($id_user,1)";
		       		$result = mysql_query($sql,$conn) or die(mysql_error());
				
		       	/*METODOLOGIAS*/
                for ($i=0; $i < sizeof($metodologias) ; $i++) { 
		        	$id_metodologia=(int)$metodologias[$i];
		        	$sql = "INSERT INTO metodologia_grupo_empresa (id_grupo_empresa,id_metodologia)
		                VALUES ($id_grupo_empresa,$id_metodologia)";
		       		$result = mysql_query($sql,$conn) or die(mysql_error());

		        } 
		       	header('Location: valido.php?value=4');
		   }
		}
		else{
			$usuario=NULL;
			$nombre_largo=NULL;
			$nombre_corto=NULL;
			$eMail=NULL;
			$nombre_rep=NULL;
			$apellido_rep=NULL;
			$cod_sis=NULL;
			$telefono_rep=NULL;
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
						<a href="registro_grupo.php">Registro <?php echo $quien_ingresa; ?></a>
					</li>				
				</ul>
			</div>
			<center><h3><?php echo $titulo; ?></h3></center>
			<div class="row-fluid">
				<div class="box span12 center">
						<div class="box-header well">
							<h2><i class="icon-edit"></i> Formulario de registro: <?php echo $quien_ingresa; ?></h2>					
						</div>
						<div class="box-content" id="formulario">
						<?php 
						if($gestion_valida){
							if ($act_2==1) {
								if (!$act_2_espera) {	
						?>	
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" accept-charset="utf-8" action="registro_grupo.php">
								<fieldset>
								<legend><h5>Datos de la Grupo Empresa:</h5></legend>
								<div class="control-group">
								  <label class="control-label">Nombre largo: </label>
								  <div class="controls">
									<input type="text" placeholder="Nombre largo Grupo Empresa" name="lname" id="lname" value='<?php echo $nombre_largo; ?>' >
									<label id="error_user" class="error"><?php if(isset($error_nl)){ echo $error_nl; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">Nombre corto: </label>
								  <div class="controls">
									<input type="text" placeholder="Nombre Corto Grupo Empresa" name="sname" id="sname" value='<?php echo $nombre_corto; ?>'>
									<label id="error_user" class="error"><?php if(isset($error_nc)){ echo $error_nc; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">Tipo de Sociedad: </label>
								  <div class="controls">
									<select id="choose_sociedad" name="choose_sociedad" data-rel="chosen">
										<option value="-1">-- Seleccione una sociedad --</option>
										<?php
			                               $consulta_sociedad = "SELECT *
														FROM sociedad";
			                               $resultado_sociedad = mysql_query($consulta_sociedad);
			                                while($row_sociedad = mysql_fetch_array($resultado_sociedad)) {
			                               		echo "<option value=\"".$row_sociedad['id_sociedad']."\">".$row_sociedad['descripcion']."</option>";
			                                }

			                             ?>
								  	</select>
								  	<label id="error_user" class="error"><?php if(isset($error_sociedad)){ echo $error_sociedad; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">Consultor TIS encargado: </label>
								  <div class="controls">
									<select id="choose_consultor" name="choose_consultor" data-rel="chosen">
									<option value="-1">-- Seleccione un Consultor --</option>
									<?php
		                               $consulta = "SELECT id_usuario, nombre , apellido
													FROM usuario
													WHERE habilitado=1 AND (tipo_usuario=2 or tipo_usuario=3) ";//and gestion=$id_gestion
		                               $resultado = mysql_query($consulta);
		                                while($row = mysql_fetch_array($resultado)) {
		                               		echo "<option value=\"".$row['id_usuario']."\">".$row['nombre']." ".$row['apellido']."</option>";
		                                }

		                             ?>
								  </select>
								  <label id="error_user" class="error"><?php if(isset($error_consultor)){ echo $error_consultor; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">Metodologia : </label>
								  <div class="controls">
									<select name="metodologias[]" multiple data-rel="chosen" id="metodologias">
										<?php
			                               $consulta_metodologia = "SELECT id_metodologia, nombre_metodologia
														FROM metodologia";
			                               $resultado_metodologia = mysql_query($consulta_metodologia);
			                                while($metodologia = mysql_fetch_array($resultado_metodologia)) {
			                               		echo "<option value=\"".$metodologia['id_metodologia']."\">".$metodologia['nombre_metodologia']."</option>";
			                                }

			                             ?>
									  </select>
								  </div>
								</div>
								<br>
								<legend><h5>Datos del representate legal:</h5></legend><br>
								<div class="control-group">
								  <label class="control-label">Nombre de Usuario: </label>
								  <div class="controls">
									<input placeholder="Usuario" name="username" type="text" id="username" value='<?php echo $usuario; ?>'>
									<label id="error_user" class="error"><?php if(isset($error_user)){ echo $error_user; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">Contrase&ntilde;a: </label>
								  <div class="controls">
									<input type="password" placeholder="Contrase&ntilde;a" name="password" id="password">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">Confirmar Contrase&ntilde;a: </label>
								  <div class="controls">
									<input type="password" placeholder="Confirmar Contrase&ntilde;a" name="confirm_password" id="confirm_password">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">C&oacute;digo SIS: </label>
								  <div class="controls">
									<input type="text" placeholder="C&oacute;digo SIS" name="codSIS" class="codigos" id="codSIS" value='<?php echo $cod_sis; ?>'>
									<label id="error_user" class="error"><?php if(isset($error_cod)){ echo $error_cod; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">Nombre: </label>
								  <div class="controls">
									<input type="text" placeholder="Nombre del representate" class="firstnames" name="firstname" id="firstname" value='<?php echo $nombre_rep; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">Apellido: </label>
								  <div class="controls">
									<input type="text" placeholder="Apellido" name="lastname" class="lastnames" id="lastname" value='<?php echo $apellido_rep; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">Tel&eacute;fono: </label>
								  <div class="controls">
									<input type="text" placeholder="Tel&eacute;fono fijo" name="telf" id="telf" class="telefonos" value='<?php echo $telefono_rep; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">Correo Electr&oacute;nico:</label>
								  <div class="controls">
									<input type="text" placeholder="E-mail del representante legal" name="email"  id="email" value='<?php echo $eMail; ?>'>
									<label id="error_email" class="error"><?php if(isset($error_email)){ echo $error_email; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">Carrera: </label>
								  <div class="controls">
									<select id="choose_carrera" name="choose_carrera" data-rel="chosen">
										<option value="-1">-- Seleccione una carrera --</option>
										<?php
			                               $consulta_carrera = "SELECT *
														FROM carrera";
			                               $resultado_carrera = mysql_query($consulta_carrera);
			                                while($row_sociedad = mysql_fetch_array($resultado_carrera)) {
			                               		echo "<option value=\"".$row_sociedad['id_carrera']."\">".$row_sociedad['nombre_carrera']."</option>";
			                                }

			                             ?>
								  	</select>
								  	<label id="error_user" class="error"><?php if(isset($error_carrera)){ echo $error_carrera; } ?></label>
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
								<?php
				                mysql_free_result($resultado_sociedad);
								mysql_free_result($resultado);
									}
					                 else{
					                	 echo "<div align=\"center\">
					                        <h4><i class=\"icon-info-sign\"></i>
					                        <strong>El registro de Grupo Empresas estar&aacute; habilitado la fecha ".$act_ini_2.".</strong></h4>
					                      </div>";;
					                } 
				                 }
				                 else{
				                	 echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        <strong>El registro de Grupo Empresas no se encuentra habilitado.</strong></h4>
				                      </div>";;
				                } 
				             }
				             else{
				                echo "<div align=\"center\">
				                      <h4><i class=\"icon-info-sign\"></i>
				                      <strong>No existe ninguna actividad para esta gesti&oacute;n.</strong></h4>
				                      </div>";;
				            } ?>
				              <!--/ELSE DE GESTION-->
		                </div>  
				</div>	
			</div>
			<script type="text/javascript">
				function listarRoles()[
					alert("mensaje");
				}
				
			</script>
<?php 
include('footer.php'); ?>
