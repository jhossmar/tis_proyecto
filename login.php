<?php
	$titulo="Iniciar sesi&oacute;n Administrador del Sistema";
	include('conexion/verificar_gestion.php');
	$no_visible_elements=true;
	session_start();
	/*----------------------VERIFICAR QUE NO ENTREN USUARIOS-------------*/
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
	/*----------------------FIN VERIFICAR--------------------------------*/
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
					<form class="form-horizontal" action="conexion/verificar.php" method="post"accept-charset="utf-8">
						<fieldset>
							<input name="tipo" value=1 type="hidden">
							<div class="input-prepend">
								<span class="add-on"><i class="icon-user"></i></span><input autofocus placeholder="Usuario" class="input-large span10" name="username" id="username" type="text"  />
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend">
								<span class="add-on"><i class="icon-lock"></i></span><input placeholder="Contrase&ntilde;a" class="input-large span10" name="password" id="password" type="password"/>
							</div>
							<div class="clearfix"></div>
							<!-- RECORDARME????
								<div class="input-prepend">
								<label class="remember" for="remember"><input type="checkbox" id="remember" />Remember me</label>
								</div>
								<div class="clearfix"></div>
							-->
							<p class="center span5">
							<button type="submit" class="btn btn-primary">Ingresar</button>
							</p>
						</fieldset>
					</form>
				</div><!--/span-->
			</div><!--/row-->
<?php include('footer.php'); ?>
