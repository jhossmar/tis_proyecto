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
		$nombre_foto=$_SESSION['foto'];

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

	<link rel="shortcut icon" href="img/favicon.png">
	
<style type="text/css">
  
  .modalmask {
	position: fixed;
	font-family: Arial, sans-serif;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background: rgba(0,0,0,0.8);
	z-index: 99999;
	opacity:0;
	-webkit-transition: opacity 400ms ease-in;
	-moz-transition: opacity 400ms ease-in;
	transition: opacity 400ms ease-in;
	pointer-events: none;
}
.modalmask:target {
	opacity:1;
	pointer-events: auto;
}
.modalbox{
	width: 950px;
	position: relative;
	padding: 5px 20px 13px 20px;
	background: #fff;
	border-radius:3px;
	-webkit-transition: all 500ms ease-in;
	-moz-transition: all 500ms ease-in;
	transition: all 500ms ease-in;
	
}

.movedown {
	margin: 0 auto;
}
.rotate {
	margin: 10% auto;
	-webkit-transform: scale(-5,-5); 
	transform: scale(-5,-5);
}
.resize {
	margin: 10% auto;
	width:0;
	height:0;

}
.modalmask:target .movedown{		
	margin:10% auto;
}
.modalmask:target .rotate{		
	transform: rotate(360deg) scale(1,1);
    -webkit-transform: rotate(360deg) scale(1,1);
}

.modalmask:target .resize{
	width:400px;
	height:200px;
}

.close {
	background: #606061;
	color: #FFFFFF;
	line-height: 25px;
	position: absolute;
	right: 1px;
	text-align: center;
	top: 1px;
	width: 24px;
	text-decoration: none;
	font-weight: bold;
	border-radius:3px;
	font-size:16px;
}

.close:hover { 
	background: #FAAC58; 
	color:#222;
}
  	
  	
  	div#menu{
  		width: 450px;
  		margin-top 20px;
  		//background-color:red;
  	 }
  	 div#menu ul {
  	 	list-style: none ;
  	 }
  	 
  	 div#menu ul li {
  	 	margin-top: 15px;
  	 	font-family: tahoma;
  	 	font-size: 18 px;
  	 	background-color: #F4F4F4;
  	 	width :450 px;
  	 	padding-top:10px;
  	 	//padding-botton: 10px;
  	 	border-radius:0px 20px 20px 0px;
  	    padding-left:20px;
  	    box-shadow: 5px 0px 10px #939393;
  	 -webkit-transition: padding-left 0.6s;
  	 color: white;
  	 } 
  	 
  	 div#menu ul li:hover{
  	 	padding-left: 100px;
        color: black;
  	 }  	   	 
}  	   
</style>
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
						   
						    <img src= <?php echo $nombre_foto;  ?> WIDTH=60 HEIGHT=60><span class="hidden-phone"> <?php echo $nombre_usuario;  ?></span>
						    <span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
	                        <li><a href="#modal2"><i  class="icon-edit"></i>combiar foto</a></li>
	                        <li><a href="conexion/salir.php"><i class= "icon-off"></i>Salir</a></li>
	                        
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
                                   <a href="iniciar_sesion.php" id="link_grupo_ingresar">Ingresar </a>
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
                                    <a tabindex="-1" href="iniciar_sesion.php" id="link_consultor_ingresar">Ingresar</a>
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

	   <div class="center">
	     <div id="modal2" class="modalmask">
		   <div class="modalbox movedown">
			<a href="#close" title="Close" class="close">X</a>
              <?php if ($sesion_valida) {?>
               
               <div>
                  <img src= <?php echo $nombre_foto;  ?> WIDTH=150 HEIGHT=150><span class="hidden-phone"> <?php echo $nombre_usuario;  ?></span>
                  
                  <form action="conexion/guardar_foto.php" method="post" enctype="multipart/form-data">
                     <input type="file" name="foto"/>
                    <input type="submit" value="Subir Foto" name="btn_upload"/>
	              </form>
	          </div>  
             <?php } ?>
           
            </div>
	   </div>
	</div>
	