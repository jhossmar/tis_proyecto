<?php
	if(!isset($titulo)){
		header('Location: index.php');
	}
	if (isset($_SESSION['nombre_usuario'])){
		$sesion_valida=true;
		$nombre_usuario=$_SESSION['nombre_usuario'];
		$id_usuario=$_SESSION['id'];
		switch  ($_SESSION['tipo']){
				case (5) :
                	$tipo="Integrante Grupo Empresa";
                    break;
                case (4) :
                	$tipo="Grupo Empresa";
                    break;
                case (3) :
                	$tipo="Consultor TIS";
                    break;
                case (2) :
                	$tipo="Jefe Consultor TIS";
                    break;
                case (1) :
                    $tipo ="Administrador";
                    break;
          }
	}
	else{
		$sesion_valida=false;
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title><?php if(isset($titulo)) {echo $titulo;} else{ echo "Sistema de Apoyo a la Empresa TIS";} ?></title>
	<meta name="description" content="Sistema de Apoyo a la Empresa TIS">
	<meta name="author" content="TIS">


	<!-- The styles -->
	<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
	  	font-family: Arial;
	  	font-size: 12px;
		padding-bottom: 30px;
		min-width: 980px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>

	<style type="text/css">
		#commentForm { width: 500px; }
		#commentForm label { width: 250px; }
		#commentForm label.error, #commentForm input.submit { margin-left: 253px; }
		#signupForm { width: 100%; text-align: left;}
		#signupForm label.error {
		color: #FF5105;
		margin-left: 10px;
		width: auto;
		display: inline;
		}

		form.cmxform .gray * { color: gray; }
	</style>

	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>
	<link href='css/style2.css' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/uploadify.css">
	<link href='css/noticias.css' rel='stylesheet'>

     <!-- calendario -->
<link rel="stylesheet" type="text/css" href="css/frontierCalendar/jquery-frontier-cal-1.3.2.css" />
<link rel="stylesheet" type="text/css" href="css/colorpicker/colorpicker.css" />
<link href="css/jquery.alerts.css" rel="stylesheet" type="text/css">
	<!-- calendario -->


	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="img/favicon.png">

</head>

<body>
	<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
	<!-- topbar starts -->
	<div class="container-fluid" id="top">
	<div class="navbar">
        <div class="row-fluid navegacion">
            	<div class="span2 logo" >
	                <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </a>
                	<img class="logo" alt="Logo Sistema de Apoyo a la Empresa TIS" src="img/umssd.png" height="120px"/>
                </div>
                <div class="span10">
                	<div class="row-fluid contenido-navegacion">
                		<div class="span10 title">
                			<img src="img/titulo2.png" height="80px" width="100%" />
                		</div>
                		<?php if ($sesion_valida) {?>
                			<div class="span2 usuarios">
                			<!-- USUARIOS-->
						                <div class="btn-group pull-right">
						                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						                        <i class="icon-user"></i><span class="hidden-phone"> <?php echo $nombre_usuario;  ?></span>
						                        <span class="caret"></span>
						                    </a>
						                    <ul class="dropdown-menu">
						                    	<?php switch($_SESSION['tipo']) {
						                    		case (5):
									                	echo '<li><a href="editar.php?value='.$id_usuario.'">Modificar Perfil</a></li>';
                                                        /*echo '<li><a href="#">Modificar Perfil</a></li>';*/
									                    break;
						                    		case (4):
									                	echo '<li><a href="editar.php?value='.$id_usuario.'">Modificar Perfil</a></li>';
                                                        /*echo '<li><a href="#">Modificar Perfil</a></li>';*/
									                    break;
									                case (3) :
									                	echo '<li><a href="modificar_registro_consultor.php?value=3">Modificar Perfil</a></li>';
									                    break;
									                case (2) :
									                	echo '<li><a href="modificar_registro_consultor.php?value=2">Modificar Perfil</a></li>';
									                    break;
									                case (1) :
									                    echo '<li><a href="modificar_registro_admin.php">Modificar Perfil</a></li>';
									                    break;
						                        } ?>

						                        <li class="divider"></li>
						                        <li><a href="conexion/salir.php">Salir</a></li>
						                    </ul>
						                </div>
    	           		</div><!-- FIN USUARIOS-->
    	           		<?php } ?>
                	</div>
            <div class="row-fluid">
            <div class="menu">
                        <ul class="nav">
                            <li class="hidden-tablet">
                                <a href="index.php" id="link_inicio">Inicio</a>
                            </li>
                            <li class="dropdown">
                                <a href="iniciar_sesion.php?value=4" data-toggle="dropdown" class="dropdown-toggle" id="link_grupo">Grupo Empresa <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu" id="menu1">
                                    <li>
                                        <a href="iniciar_sesion_grupo.php" id="link_grupo_ingresar">Ingresar </a>
                                    </li>
                                    <li>
                                        <a href="registro_grupo.php" id="link_grupo_registro">Registrarse</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" id="link_consultor">Consultor TIS <i class="caret"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="iniciar_sesion_consultor.php" id="link_consultor_ingresar">Ingresar</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="registro_consultor.php" id="link_consultor_registro">Registrarse</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="ayuda.php" id="link_ayuda">Ayuda </a>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
        	</div><!--FIN FILA ROW-->
        </div>
	</div>
	</div>
	</div>
	<!-- topbar ends -->
	<!-- topbar ends -->
	<?php } ?>
	<div class="container-fluid">
		<div class="row-fluid">
		<?php if(!isset($no_visible_elements) || !$no_visible_elements) {
					if($sesion_valida && $_SESSION['tipo']==1){?>
					<!-- INICIO DEL MENU IZQUIERDO PARA UN USUARIO ADMIN -->
					<div class="span2 main-menu-span">
						<div class="well2 nav-collapse ">
							<ul class="nav nav-tabs nav-stacked main-menu">
								<li class="nav-header box-header"><h5>Men&uacute; </h5></li>
								<li><a href="home_admin.php"><i class="icon-home"></i><span class="hidden-tablet"> Home <?php echo $tipo ?></span></a></li>
								<li><a href="info_admin.php"><i class="icon-edit"></i><span class="hidden-tablet"> Informaci&oacute;n del Administrador</span></a></li>
								<li><a href="administrar_consultor.php"><i class="icon-briefcase"></i><span class="hidden-tablet"> Administrar Consultores TIS</span></a></li>
								<li><a href="administrar_grupo_empresa.php"><i class="icon-edit"></i><span class="hidden-tablet"> Administrar Grupo Empresas</span></a></li>
								<li><a href="bitacoras_usuario.php"><i class="icon-eye-open"></i><span class="hidden-tablet"> Bit&aacute;coras de usuario</span></a></li>
								<li><a href="backup.php"><i class="icon-hdd"></i><span class="hidden-tablet"> Respaldo y Restauraci&oacute;n de la Base de Datos</span></a></li>
								<li><a href="administrar_mensajes.php"><i class="icon-comment"></i><span class="hidden-tablet"> Administrar espacio de Discuci&oacute;n</span></a></li>
							</ul>

						</div><!--/.well -->
					</div><!--/span-->
					<!-- FIN DEL MENU ADMIN -->
					<?php } elseif ($sesion_valida && $_SESSION['tipo']==2) /*MENU DEL JEFE CONSULTOR*/
					 { ?>
					<!-- INICIO DEL MENU IZQUIERDO POR DEFECTO -->
					<div class="span2 main-menu-span">
						<div class="well2 nav-collapse ">
							<ul class="nav nav-tabs nav-stacked main-menu">
								<li class="nav-header box-header"><h5>Men&uacute; </h5></li>
								<li><a href="home_consultor_jefe.php"><i class="icon-home"></i><span class="hidden-tablet"> Home <?php echo $tipo ?></span></a></li>
								<li><a href="info_consultor.php?value=2"><i class="icon-edit"></i><span class="hidden-tablet"> Informaci&oacute;n del usuario</span></a></li>
								<li><a href="subir_consultor_jefe.php"><i class="icon-pencil"></i><span class="hidden-tablet"> Publicar Avisos</span></a></li>
								<li><a href="subir_contrato.php"><i class="icon-list-alt"></i><span class="hidden-tablet"> Publicar Documentos</span></a></li>
								<li><a href="administrar_archivos.php"><i class="icon-folder-close"></i><span class="hidden-tablet"> Administrar archivos</span></a></li>
								<li><a href="planificacion.php"><i class="icon-calendar"></i><span class="hidden-tablet"> Planificar actividades</span></a></li>
								<li><a href="administrar_grupo.php"><i class="icon-check"></i><span class="hidden-tablet"> Administrar mis Grupo Empresas</span></a></li>
								<li><a href="notificaciones.php"><i class="icon-globe"></i><span class="hidden-tablet"> Notificaciones</span></a></li>
								<li><a href="mensajes.php"><i class="icon-comment"></i><span class="hidden-tablet"> Espacio de Discuci&oacute;n</span></a></li>
							</ul>


						</div><!--/.well -->
					</div><!--/span-->
					<!-- FIN DEL MENU ADMIN -->
					<?php }
					elseif ($sesion_valida && $_SESSION['tipo']==3) /*MENU DEL CONSULTOR COMUN*/
						{ ?>
							<div class="span2 main-menu-span">
							<div class="well2 nav-collapse ">
							<ul class="nav nav-tabs nav-stacked main-menu">
								<li class="nav-header box-header"><h5>Men&uacute; </h5></h5></li>
								<li><a href="home_consultor.php"><i class="icon-home"></i><span class="hidden-tablet"> Home <?php echo $tipo ?></span></a></li>
								<li><a href="info_consultor.php?value=3"><i class="icon-edit"></i><span class="hidden-tablet"> Informaci&oacute;n del usuario</span></a></li>
								<li><a href="subir_contrato.php"><i class="icon-list-alt"></i><span class="hidden-tablet"> Publicar Documentos</span></a></li>
								<li><a href="administrar_archivos.php"><i class="icon-folder-close"></i><span class="hidden-tablet"> Administrar archivos</span></a></li>
								<li><a href="administrar_grupo.php"><i class="icon-check"></i><span class="hidden-tablet"> Administrar mis Grupo Empresas</span></a></li>
								<li><a href="notificaciones.php"><i class="icon-globe"></i><span class="hidden-tablet"> Notificaciones</span></a></li>
								<li><a href="mensajes.php"><i class="icon-comment"></i><span class="hidden-tablet"> Espacio de Discuci&oacute;n</span></a></li>
							</ul>

						</div><!--/.well -->
					</div><!--/span-->
					<?php }
					elseif ($sesion_valida && $_SESSION['tipo']==4) /*MENU DE LA GRUPO EMPRESA*/
					{ ?>
						<div class="span2 main-menu-span">
						<div class="well2 nav-collapse ">
							<ul class="nav nav-tabs nav-stacked main-menu">
								<li class="nav-header box-header"><h5>Men&uacute; </h5></li>
								<li><a href="home_grupo.php"><i class="icon-home"></i><span class="hidden-tablet"> Home <?php echo $tipo ?></span></a></li>
								<li><a href="info_grupo.php"><i class="icon-edit"></i><span class="hidden-tablet"> Informaci&oacute;n de la Grupo Empresa</span></a></li>
								<li><a href="administrar_integrante.php"><i class="icon-check"></i><span class="hidden-tablet"> Administrar Integrantes</span></a></li>
								<li><a href="subir_grupo_empresa.php"><i class="icon-list-alt"></i><span class="hidden-tablet"> Documentos</span></a></li>
                                <li><a href="entrega_prod.php"><i class="icon-calendar"></i><span class="hidden-tablet"> Cronograma de Pagos y de Subsistemas  </span></a></li>
                                <li><a href="actividades_grupo.php"><i class="icon-edit"></i><span class="hidden-tablet"> Planificar Actividades de Subsistemas</span></a></li>
                                <li><a href="formulario_entrega_producto.php"><i class="icon-star"></i><span class="hidden-tablet"> Entrega de Subsistemas</span></a></li>
                                <li><a href="mis_tareas_grupo_integra.php"><i class="icon-briefcase"></i><span class="hidden-tablet"> Gestionar mis Tareas</span></a></li>
                                <li><a href="cronograma_grupo_integra.php"><i class="icon-tasks"></i><span class="hidden-tablet"> Reporte general de la Grupo Empresa </span></a></li>

								<li><a href="notificaciones.php"><i class="icon-globe"></i><span class="hidden-tablet"> Notificaciones</span></a></li>
								<li><a href="mensajes.php"><i class="icon-comment"></i><span class="hidden-tablet"> Espacio de Discuci&oacute;n</span></a></li>
							</ul>
						</div><!--/.well -->
					</div><!--/span-->
					<?php }
					elseif ($sesion_valida && $_SESSION['tipo']==5) /*MENU DE LA GRUPO EMPRESA*/
					{ ?>
						<div class="span2 main-menu-span">
						<div class="well2 nav-collapse ">
							<ul class="nav nav-tabs nav-stacked main-menu">
								<li class="nav-header box-header"><h5>Men&uacute; </h5></li>
								<li><a href="home_integrante.php"><i class="icon-home"></i><span class="hidden-tablet"> Home <?php echo $tipo ?></span></a></li>
								<li><a href="info_grupo.php"><i class="icon-edit"></i><span class="hidden-tablet"> Informaci&oacute;n del integrante</span></a></li>
								<li><a href="mis_tareas_grupo_integra.php"><i class="icon-briefcase"></i><span class="hidden-tablet"> Gestionar mis tareas</span></a></li>
                                <li><a href="cronograma_grupo_integra.php"><i class="icon-tasks"></i><span class="hidden-tablet"> Reporte general de la Grupo Empresa </span></a></li>

								<li><a href="mensajes.php"><i class="icon-comment"></i><span class="hidden-tablet"> Espacio de Discuci&oacute;n</span></a></li>
							</ul>
						</div><!--/.well -->
					</div><!--/span-->
					<?php }
					else{ ?>

						<div class="span2 main-menu-span">
						<div class="well2 nav-collapse ">
							<ul class="nav nav-tabs nav-stacked main-menu">
								<li class="nav-header box-header"><h5>Men&uacute; principal</h5></li>
								<li><a href="index.php"><i class="icon-home"></i><span class="hidden-tablet"> Inicio</span></a></li>
								<li><a href="iniciar_sesion_grupo.php"><i class="icon-check"></i><span class="hidden-tablet"> Grupo Empresa</span></a></li>
								<li><a href="iniciar_sesion_consultor.php"><i class="icon-briefcase"></i><span class="hidden-tablet"> Consultor TIS</span></a></li>
								<li><a href="ayuda.php"><i class="icon-question-sign"></i><span class="hidden-tablet"> Ayuda</span></a></li>
								<li><a href="login.php"><i class="icon-lock"></i></i><span class="hidden-tablet"> Administrar Sistema</span></a></li>
							</ul>

						</div><!--/.well -->
						</div><!--/span-->

					<?php } ?>
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Alerta!</h4>
					<p>Necesitas tener habilitado <a href="http://es.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> para utilizar el sistema.</p>
				</div>
			</noscript>

			<div id="content" class="span8">
			<!-- content starts -->
			<?php }
			?>
