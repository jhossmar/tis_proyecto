<?php
$titulo="P&aacute;gina de inicio Grupo Empresas";
include("conexion/verificar_gestion.php");
session_start();
/*------------------VERIFICAR QUE SEAL LA GRUPO EMPRESA------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
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
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
/*----------------------FIN VERIFICACION------------------------------------*/
include("conexion/verificar_integrantes.php");
if(!$cantidad_valida && isset($_POST['enviar'])){
		$error=false;
		/*VALORES de usuario*/
		$id_usuario=$_POST['id_usuario'];
		$usuario=$_POST['username'];
		$clave=$_POST['password']; /*$clave = md5($pass); QUITADO ==> CONTRASEÑA SIMPLE*/
		$eMail=$_POST['email'];
		/*VALORES de integrante*/
		$cod_sis = $_POST['codSIS'];
		$nombre_rep = $_POST['firstname'];
		$apellido_rep = $_POST['lastname'];
		$telefono_rep = $_POST['telf'];
		$carrera_rep = $_POST['choose_carrera'];
		if (isset($_POST['roles'])) {
			$roles = $_POST['roles'];
			if (sizeof($roles)==0) {
				$error=true;
				$error_rol="Debe seleccionar m&iacute;nimamente un rol";
			}
		}
		else{
			$error=true;
			$error_rol="Debe seleccionar m&iacute;nimamente un rol";
		}
		if ($carrera_rep=='-1' ) {
			$error=true;
			$error_carrera="Debe seleccionar una carrera";
		}
		$consulta_usuario = mysql_query("SELECT nombre_usuario from usuario 
		                          where nombre_usuario='$usuario' AND (gestion=1 OR gestion=$id_gestion)",$conn)
		                          or die("Could not execute the select query.");
		$consulta_email = mysql_query("SELECT email from usuario 
		                         where email='$eMail'AND (gestion=1 OR gestion=$id_gestion)",$conn)
		                         or die("Could not execute the select query.");
		
		$consulta_cod = mysql_query("SELECT codigo_sis from usuario, integrante 
								where integrante.usuario=usuario.id_usuario AND codigo_sis='$cod_sis' AND (gestion=1 OR gestion=$id_gestion)",$conn)
		                         or die("Could not execute the select query."); 



		$resultado_usuario = mysql_fetch_assoc($consulta_usuario);
		$resultado_email = mysql_fetch_assoc($consulta_email);
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
			              $error_email="El correo electr&oacute;nico ya est&aacute; registrado";
			              $error=true;
			      } 
		   }
		   if(is_array($resultado_cod) && !empty($resultado_cod)){
		     	if (strcmp($resultado_cod['codigo_sis'],$cod_sis)==0) {
			              $error_cod="El integrante ya est&aacute; registrado en esta gesti&oacute;n";
			              $error=true;
			      } 
		   }

		   if(!$error){/*SI NO HAY NINGUN ERROR REGISTRO*/
		   		/*INSERTAR EL USUARIO*/
			$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
							or die("Error no se pudo realizar cambios.");
		        $sql = "INSERT INTO usuario (nombre_usuario, clave,nombre,apellido,telefono, email, habilitado, tipo_usuario,gestion)
		                VALUES ('$usuario','$clave','$nombre_rep','$apellido_rep','$telefono_rep','$eMail',1,5,$id_gestion)";
		        $result = mysql_query($sql,$conn) or die(mysql_error());

		        /*BUSCAR  el id de la grupo empresa con el id del representante legal*/
		        $consulta_id_ge = mysql_query("SELECT grupo_empresa
											from integrante 
											where usuario=$id_usuario",$conn)
		                         or die("Could not execute the select query.");
		        $resultado_id_ge = mysql_fetch_assoc($consulta_id_ge); 
		        $rep_id_ge=(int)$resultado_id_ge['grupo_empresa'];

				/*BUSCAR  el id del usuario*/
		        $consulta_id_usu = mysql_query("SELECT id_usuario from usuario where nombre_usuario='$usuario' and gestion=$id_gestion",$conn)
		                         or die("Could not execute the select query.");
		        $resultado_id_usu = mysql_fetch_assoc($consulta_id_usu); 
		        $rep_id_usu=(int)$resultado_id_usu['id_usuario'];
				
				/*INSERTAR AL INTEGRANTE*/
		   		$sql = "INSERT INTO integrante(usuario,codigo_sis,carrera,grupo_empresa)
		                VALUES ('$rep_id_usu','$cod_sis','$carrera_rep','$rep_id_ge')";
		        $result = mysql_query($sql,$conn) or die(mysql_error());
				
		        for ($i=0; $i < sizeof($roles) ; $i++) { 
		        	$id_rol=(int)$roles[$i];
		        	$sql = "INSERT INTO rol_integrante (integrante,rol)
		                VALUES ($rep_id_usu,$id_rol)";
		       		$result = mysql_query($sql,$conn) or die(mysql_error());

		        } 
		       	header('Location: home_grupo.php');
		   }
		}
		else{
			$usuario=NULL;
			$nombre_corto=NULL;
			$eMail=NULL;
			$nombre_rep=NULL;
			$apellido_rep=NULL;
			$cod_sis=NULL;
			$telefono_rep=NULL;
		}
include('header.php'); ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="home_grupo.php">Home Grupo Empresa</a>
					</li>				
				</ul>
			</div>
			<center><h3>Bienvenida Grupo Empresa</h3></center>
			<?php 
				if ($gestion_valida) {
					if (!$cantidad_valida) { 
				?>
			<div class="row-fluid">
				<div class="box span12 ">
					<div class="box-header well">
					<h2><i class="icon-warning-sign"></i> Importante: Agregar Integrante a la Grupo Empresa</h2>					
					</div>
					<div class="box-content" id="formulario">
					<?php	if (!$act_2_espera && $act_2==1) {
						?>
						<p><b>Para que su Grupo Empresa quede completamente habilitada debe agregar por lo menos <?php echo $cantidad_faltante; ?> integrantes m&aacute;s.</b></p><br>
						<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" accept-charset="utf-8" action="home_grupo.php">
							<fieldset>
								<input type="hidden" name="id_usuario" value=<?php echo $id_usuario ?> >
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
								<div class="control-group" >
								  <label class="control-label"  for="pass">C&oacute;digo SIS: </label>
								  <div class="controls">
									<input type="text" placeholder="C&oacute;digo SIS del integrante" name="codSIS" id="codSIS" class="codigos"value='<?php echo $cod_sis; ?>'>
									<label id="error_user" class="error"><?php if(isset($error_cod)){ echo $error_cod; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Nombre: </label>
								  <div class="controls">
									<input type="text" placeholder="Nombre del integrante" class="firstnames" name="firstname" id="firstname" value='<?php echo $nombre_rep; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Apellido: </label>
								  <div class="controls">
									<input type="text" placeholder="Apellido del integrante" name="lastname" class="lastnames" id="lastname" value='<?php echo $apellido_rep; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Tel&eacute;fono: </label>
								  <div class="controls">
									<input type="text" placeholder="Tel&eacute;fono del integrante" class="telefonos" name="telf" id="telf" value='<?php echo $telefono_rep; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Correo Electr&oacute;nico:</label>
								  <div class="controls">
									<input type="text" placeholder="E-mail del integrante" name="email"  id="email" value='<?php echo $eMail; ?>'>
									<label id="error_email" class="error"><?php if(isset($error_email)){ echo $error_email; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Carrera: </label>
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
								  <label class="control-label" for="pass">Roles del integrante: </label>
								  <div class="controls">
									<select name="roles[]" multiple data-rel="chosen">
										<?php
			                               $consulta_carrera = "SELECT DISTINCT id_rol, nombre
																FROM rol, metodologia, metodologia_grupo_empresa
																WHERE (rol.id_metodologia = metodologia.id_metodologia
																OR rol.id_metodologia = 0)
																AND metodologia.id_metodologia = metodologia_grupo_empresa.id_metodologia
																AND metodologia_grupo_empresa.id_grupo_empresa=$rep_id_ge
																AND rol.id_rol != 1
																AND id_rol NOT IN ( SELECT DISTINCT id_rol
																					FROM rol, rol_integrante, metodologia_grupo_empresa, integrante
																					WHERE rol.rol_unico = 'si'
																					AND rol.id_rol != 1
																					AND rol.id_rol = rol_integrante.rol
																					AND rol_integrante.integrante = integrante.usuario
																					AND integrante.grupo_empresa = metodologia_grupo_empresa.id_grupo_empresa
																					AND rol.id_metodologia = metodologia_grupo_empresa.id_metodologia
																					AND id_grupo_empresa = $rep_id_ge
																					)
																";
			                               $resultado_carrera = mysql_query($consulta_carrera) or die("error");
			                                while($row_sociedad = mysql_fetch_array($resultado_carrera)) {
			                               		echo "<option value=\"".$row_sociedad['id_rol']."\">".$row_sociedad['nombre']."</option>";
			                                }

			                             ?>
									  </select>
									<label id="error_user" class="error"><?php if(isset($error_rol)){ echo $error_rol; } ?></label>
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
								<?php }else{
									echo "Lo sentimos pero el registro no est&aacute; habilitado. Puede contactarse con su Consultor TIS
									asignado para solicitar una ampliaci&oacute;n de la fecha registro.";
								}	?>
								</div>
							</div>
						</div>
			 	
			<?php }
			else{ ?>
				<div class="row-fluid">
				<div class="box span12">
						<div class="box-header well">
							<h2><i class="icon-info-sign"></i> Informacion</h2>
						</div>
						<div class="box-content alerts">
								Bienvenida Grupo Empresa a la <b>Gesti&oacute;n <?php echo $nombre_gestion; ?></b>, en este sitio usted podr&aacute; administrar las
								actividades de su Grupo Empresa,tambi&eacute;n la entrega de los sobres A y B, entregar su producto y adem&aacute;s pod&aacute; participar del <a href="mensajes.php">Espacio de discuci&oacute;n</a>.<br>
						</div>
					</div><!--/span-->
				</div><!-- fin row -->
				<?php 
				if ($numero_integrantes<5 && $act_2==1 && !$act_2_espera) { ?>
					<div class="row-fluid">
					<div class="box span12">
						<div class="box-header well">
							<h2><i class="icon-exclamation-sign"></i> Nota</h2>
						</div>
						<div class="box-content alerts">
								Si usted desea puede agregar <b><?php echo $cantidad_faltante; ?> integrante(s) m&aacute;s <a href="agregar_integrante.php">aqu&iacute;.</a> </b>
								El registro estar&aacute; habilitado hasta la fecha <b><?php echo $act_fin_2 ?></b>, favor tomar nota.<br>
						</div>
					</div><!--/span-->
				</div><!-- fin row -->
				<?php }	
			}
		}else{ ?>
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
		<?php }
		include('footer.php'); ?>
