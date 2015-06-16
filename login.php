<?php
	$titulo="Iniciar sesi&oacute;n Administrador del Sistema";	

	if(isset($_POST['username'])&& isset($_POST['password']))
    {    	  
    	include('conexion/conexion.php');
    	$conexion = new Conexion;
        $conexion->EstablecerConexion();
        $conn = $conexion->GetConexion();

        $nombre=$_POST['username'];
        $clave=$_POST['password'];
        $consulta_sql="SELECT * FROM usuario WHERE nombre_usuario='".$nombre."' AND clave='".$clave."' AND tipo_usuario=1";

        $consulta = mysql_query($consulta_sql,$conn) or die("Could not execute the select query.");

	    $resultado = mysql_fetch_assoc($consulta);
	
	    if(!empty($resultado))
		{	
			session_start();
			$_SESSION['id'] = $resultado['id_usuario'];
			$_SESSION['tipo']= $resultado['tipo_usuario'];			
			$_SESSION['nombre_usuario'] = $resultado['nombre_usuario'];
			$bitacora = mysql_query("INSERT into bitacora_sesion(usuario,fecha_hora,operacion)
								     VALUES (".$_SESSION['id'].",CURRENT_TIMESTAMP,0)",$conn);
			header("Location: home_admin.php");
		}
		else
		{
			echo "<center><h1>Acceso denegado</h1></center>"."<br />";
			echo "<center><h3>Por favor espera 3 segundos mientras te redirigimos al inicio. $nombre $clave</h3></center>"."<br />";
			header('Refresh: 3; url=../index.php');
		}
    }
	include('header.php');
 ?>

			<div class="row-fluid">
				<div class="span12 center login-header">
					<h2>Administrador: Sistema de apoyo a la Empresa TIS</h2>
				</div><!--/span-->
			</div><!--/row-->
			
			<div class="row-fluid">
				<div class="well span5 center login-box">
					<div class="alert alert-info">
						Por favor ingrese su nombre de usuario y contrase&ntilde;a asociada, caso contrario puede volver al <strong><a href="index.php">Inicio</a></strong>
					</div>
					<form class="form-horizontal" action="login.php" method="post"accept-charset="utf-8">
						<fieldset>						
							<div class="input-prepend">
								<span class="add-on"><i class="icon-user"></i></span><input autofocus placeholder="Usuario" class="input-large span10" name="username" id="username" type="text"  />
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend">
								<span class="add-on"><i class="icon-lock"></i></span><input placeholder="Contrase&ntilde;a" class="input-large span10" name="password" id="password" type="password"/>
							</div>
							<div class="clearfix"></div>

							<p class="center span5">
							<button type="submit" class="btn btn-primary">Ingresar</button>
							</p>
						</fieldset>
					</form>
				</div><!--/span-->
			</div><!--/row-->
<?php include('footer.php'); ?>
