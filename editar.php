<?php
include('conexion/verificar_gestion.php');
session_start();
if (isset($_GET['value'])) {
	$integrante=$_GET['value'];
}
else{
	header('Location: index.php');
}
$titulo="Modificar datos Integrante Grupo Empresa";
/*------------------VERIFICAR QUE SEAL EL CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4 && $_SESSION['tipo']!=5)
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
		$sql = "SELECT id_usuario,nombre_usuario,clave,nombre,apellido,telefono,email,i.codigo_sis
				FROM usuario u, integrante i
				WHERE u.id_usuario=i.usuario AND id_usuario=$integrante";
		$auxiliar = mysql_query($sql,$conn);
		$result = mysql_fetch_array($auxiliar);
		$id_usuario=$result['id_usuario'];
        $user=$result['nombre_usuario'];
        $cla=$result['clave'];
		$nom=$result['nombre'];
		$ape=$result['apellido'];
		$telf=$result['telefono'];
		$mail=$result['email'];
		$cod_sis_2=$result['codigo_sis'];

/*--------------------------------VALIDAR REGISTRO------------------------------------*/
if(isset($_POST['enviar'])){
	/*VALORES DE FORMULARIO*/
	$error=false;
    $usuario=trim($_POST['username']);
    $clave=trim($_POST['password']);
	$apellido=$_POST['lastname'];
	$nombre=$_POST['firstname'];
	$telfFijo=trim($_POST['telf']);
	$eMail=trim($_POST['email']);
	$cod_sis = trim($_POST['codSIS']);
	if (isset($_POST['roles'])) {
			$roles = $_POST['roles'];
			if (sizeof($roles)==0) {
				$error=true;
				$error_rol="Debe seleccionar m&iacute;nimamente un rol";
			}
	}else{
		$error=true;
		$error_rol="Debe seleccionar m&iacute;nimamente un rol";
	}
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
		if (strcmp($cod_sis_2, $cod_sis)!=0) {
			$consulta_cod = mysql_query("SELECT codigo_sis from usuario, integrante 
								where integrante.usuario=usuario.id_usuario AND codigo_sis='$cod_sis' AND (gestion=1 OR gestion=$id_gestion)",$conn)
		                         or die("Could not execute the select query.");
		    $resultado_cod = mysql_fetch_assoc($consulta_cod);

			if(is_array($resultado_cod) && !empty($resultado_cod)){
		     	if (strcmp($resultado_cod['codigo_sis'],$cod_sis)==0) {
			              $error_cod="El C&oacute;digo SIS ya est&aacute; registrado";
			              $error=true;
			              $cod_sis_2=$cod_sis;
			      } 
		   }

		}
        if (strcmp($user,$usuario)!=0){
        $sql_user= "SELECT nombre_usuario
                    FROM usuario
                    WHERE nombre_usuario='$usuario' AND (gestion=1 OR gestion=$id_gestion)";
        $auxiliar_usuario = mysql_query($sql_user);
        $result_user = mysql_fetch_array($auxiliar_usuario);
        if(is_array($result_user) && !empty($result_user)){
            if(strcmp($result_user['nombre_usuario'],$usuario)==0){
                $error_usuario="El nombre de usuario ya esta registrado";
                $user=$usuario;
                $error = true;
            }
        }
    }


	 	if(!$error){/*SI NO HAY NINGUN ERROR REGISTRO*/
	 		$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
							or die("Error no se pudo realizar cambios.");
	        $sql = "UPDATE usuario as u
					SET nombre_usuario='$usuario', clave='$clave', nombre='$nombre',apellido='$apellido', telefono='$telfFijo',email='$eMail'
					WHERE u.id_usuario=$id_usuario";
	        $result = mysql_query($sql,$conn) or die(mysql_error());

	        $sql = "UPDATE integrante
					SET codigo_sis='$cod_sis'
					WHERE usuario=$id_usuario";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	        $sql = "DELETE FROM rol_integrante
					WHERE integrante=$id_usuario";
	        $result = mysql_query($sql,$conn) or die(mysql_error());

	        if (strcmp($id_usuario,$_SESSION['id'])==0) {
	        	 $sql = "INSERT INTO rol_integrante (integrante,rol)
		                VALUES ($id_usuario,1)";
		       	$result = mysql_query($sql,$conn) or die(mysql_error());
	        }

	        for ($i=0; $i < sizeof($roles) ; $i++) { 
		        	$id_rol=(int)$roles[$i];
		        	$sql = "INSERT INTO rol_integrante (integrante,rol)
		                VALUES ($id_usuario,$id_rol)";
		       		$result = mysql_query($sql,$conn) or die(mysql_error());

		        } 
	        header('Location: editar.php?value='.$integrante);
			
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
						<a href='administrar_integrante.php'> Administrar Integrantes</a><span class="divider">/</span>
					</li>
					<li>
						<a href='editar.php?value=<?php echo $integrante; ?>'> Modificar registro Integrante</a>
					</li>				
				</ul>
			</div>
			<center><h3>Modificar registro Integrante</h3></center>
			<div class="row-fluid">
				<div class="box span12 center">
						<div class="box-header well">
							<h2><i class="icon-edit"></i> Formulario de Modificaci&oacute;n de datos</h2>					
						</div>
						<div class="box-content" id="formulario">
						</br>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" action="editar.php?value=<?php echo $integrante; ?>" accept-charset="utf-8">
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

                                <!--Esta parte es donde se debe colocar las condiciones-->
                                <?php if($_SESSION['id']==$integrante){
                                ?>
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
                                <?php }
                                    else{
                                        ?>
                                            <input type="hidden" name="username" id="username" value='<?php echo $user; ?>'>
                                            <input type="hidden" name="password" id="password" value='<?php echo $cla;?>'>
                                        <?php
                                    }
                                ?>
								<!--Esta parte es donde finaliza las modificaciones pendientes para las excepciones-->

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
								  <label class="control-label">C&oacute;digo SIS: </label>
								  <div class="controls">
									<input type="text" placeholder="C&oacute;digo SIS" name="codSIS" class="codigos" id="codSIS" value='<?php echo $cod_sis_2; ?>'>
									<label id="error_user" class="error"><?php if(isset($error_cod)){ echo $error_cod; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label">Roles: </label>
								  <div class="controls">
									<select name="roles[]" multiple data-rel="chosen">
										<?php
											/*
			                                $resultado_carrera = mysql_query($consulta_carrera,$conn);
			                                while($row_sociedad = mysql_fetch_array($resultado_carrera)) {
			                                		echo "<option value=\"".$row_sociedad['id_rol']."\">".$row_sociedad['nombre']."</option>";
			                                }
											$consulta_actuales = "SELECT id_rol, nombre
																FROM rol_integrante
																WHERE rol_integrante.integrante = $id_usuario";
											$resultado_actuales = mysql_query($consulta_actuales,$conn);
											while($actual = mysql_fetch_array($resultado_actuales)) {
												echo "<option value=\"".$actual['id_rol']."\" data-rel=\"popover\" data-content=\"".$actual['descripcion']."\" selected>".$actual['nombre']."</option>";
											}
											*/
											$consulta_id_ge = mysql_query("SELECT grupo_empresa
																			from integrante 
																			where usuario=$id_usuario",$conn)
											or die("Could not execute the select query.");
											$resultado_id_ge = mysql_fetch_assoc($consulta_id_ge); 
											$rep_id_ge=(int)$resultado_id_ge['grupo_empresa'];
											
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
			                                $resultado_carrera = mysql_query($consulta_carrera,$conn);

			                                $consulta_carrera_2 = "SELECT id_rol, nombre, descripcion, rol_unico
											FROM rol r, rol_integrante i
											where r.id_rol=i.rol AND id_rol!=1 AND i.integrante=$integrante";
			                                $resultado_carrera_2 = mysql_query($consulta_carrera_2,$conn);
			                                $arreglo[][]=NULL;
			                                $i=0;
			                                while ($row_sociedad_2 = mysql_fetch_array($resultado_carrera_2)) {
			                                	$arreglo[$i][0]=$row_sociedad_2['id_rol'];
												$arreglo[$i][1]=$row_sociedad_2['nombre'];
			                                	$i++;
												echo "<option value=\"".$row_sociedad_2['id_rol']."\" data-rel=\"popover\" data-content=\"".$row_sociedad_2['descripcion']."\" selected>".$row_sociedad_2['nombre']."</option>";
			                                }
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
