<?php
	if(!isset($titulo))
	{
		header('Location: index.php');
	}
	if(isset($_SESSION['nombre_usuario']))
	{
		$sesion_valida=true;
		$nombre_usuario=$_SESSION['nombre_usuario'];
		$id_usuario=$_SESSION['id'];
		switch ($_SESSION['tipo'])
		{
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
	else
	{
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
    <link rel="stylesheet" type="text/css" href="css/letras.css">
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
	<link href='css/ayuda_indice.css' rel='stylesheet'>
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
<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{; ?>
	<!-- topbar starts -->
	<div class="container-fluid" id="top">
	<div class="navbar">
        <div class="row-fluid navegacion">
           <div class="span2 logo" >	                
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
	                        <li><a href="conexion/salir.php"><i class= "icon-off"></i> Salir</a></li>
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
                    <?php if(!isset($_SESSION['nombre_usuario'])) {?>
                    <li class="dropdown">

                        <a href="iniciar_sesion.php?value=4" data-toggle="dropdown" class="dropdown-toggle" id="link_grupo">Grupo Empresa <b class="caret"></b></a>
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
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" id="link_consultor">Consultor TIS <i class="caret"></i></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a tabindex="-1" href="iniciar_sesion_consultor.php" id="link_consultor_ingresar">Ingresar</a>
                                </li>
                                 <li>
                                    <a tabindex="-1" href="registro_consultor.php" id="link_consultor_registro">Registrarse</a>
                                </li>
                             </ul>
                    </li>
                    <?php } ?>
                    <li class="dropdown">
                        <a href="ayuda.php" id="link_ayuda">Ayuda </a>
                    </li>
                    <li>
                        <a href="contrasena.php" >Recuperar contrasenia </a>
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
		<?php if(!isset($no_visible_elements) || !$no_visible_elements) 
		{
			require_once('menu.php');
			$menu1 = new Menu;  
			if(isset($_SESSION['tipo']))
			{
              $menu1-> ControlMenu($_SESSION['tipo']);
			}
			else
			{
				$menu1-> ControlMenu(0);
			}            
		}?>
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Alerta!</h4>
					<p>Necesitas tener habilitado <a href="http://es.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> para utilizar el sistema.</p>
				</div>
			</noscript>
		<div id="content" class="span8">
		<!-- content starts -->