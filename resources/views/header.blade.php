<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>{{ $titulo or 'sistema de apoyo tis' }}</title>
	<meta name="description" content="Sistema de Apoyo a la Empresa TIS">
	<meta name="author" content="TIS">
 
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
	 <link href='css/noticias.css' rel='stylesheet'>
	 <link href='css/ayuda_indice.css' rel='stylesheet'>
     <!-- calendario -->
     <link rel="stylesheet" type="text/css" href="css/frontierCalendar/jquery-frontier-cal-1.3.2.css" />
     <link rel="stylesheet" type="text/css" href="css/colorpicker/colorpicker.css" />
     <link href="css/jquery.alerts.css" rel="stylesheet" type="text/css">
	
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
<div class="container-fluid" id="top">
    <div class="navbar">
        <div class="row-fluid navegacion">
            <div class="span2 logo">	                
       	        <img class="logo" alt="Logo Sistema de Apoyo a la Empresa TIS" src="img/umssd.png" height="120px"/>
            </div>
            <div class="span10">
                <div class="row-fluid contenido-navegacion">
       	            <div class="span10 title">
          	            <img src={{asset("img/titulo2.png")}} height="80px" width="100%" />
                    </div>
                    @if($sesion_valida==true)
                    <div class="span2 usuarios">          
		                <div class="btn-group pull-right">
			                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">				  
			                    <img src= {{asset($nombre_foto)}} WIDTH=60 HEIGHT=60><span class="hidden-phone"> {{ $nombre_usuario }}</span>
		                        <span class="caret"></span>
			                </a>
			                <ul class="dropdown-menu">
	                            <li><a href="#modal2"><i  class="icon-edit"></i>cambiar foto</a></li>
	                            <li><a href="#salir.php"><i class= "icon-off"></i>Salir</a></li>	                        
	                        </ul>
			            </div>
    	            </div>
    	            @endif          
                </div>              
                <div class="row-fluid">
                    <div class="menu">
                        <ul class="nav">
                            <li class="hidden-tablet">
                                <a href="index" id="link_inicio">Inicio</a>
                            </li>
                            @if(!isset($nombre_usuario))
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
                            @endif
                            <li class="dropdown">
                                <a href="ayuda.php" id="link_ayuda">Ayuda </a>
                            </li>
                            <li>
                                <a href="contrasena.php" >Recuperar contrasenia </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row-fluid">
       <div class="span2 main-menu-span"> 
            <div class="well2 nav-collapse">
  		        @if($tipo_usuario==1)
                <ul class="nav nav-tabs nav-stacked main-menu">
                    <li class="nav-header box-header"><h5>Men&uacute; </h5></li>
                    <li><a href="home_admin.php"><i class="icon-home"></i><span class="hidden-tablet"> Home </span></a></li>
                    <li><a href="info_admin.php"><i class="icon-edit"></i><span class="hidden-tablet"> Informaci&oacute;n del Administrador</span></a></li>
                    <li><a href="administrar_consultor.php"><i class="icon-briefcase"></i><span class="hidden-tablet"> Administrar Consultores TIS</span></a></li>
                    <li><a href="administrar_grupo_empresa.php"><i class="icon-edit"></i><span class="hidden-tablet"> Administrar Grupo Empresas</span></a></li>
                    <li><a href="bitacoras_usuario.php"><i class="icon-eye-open"></i><span class="hidden-tablet"> Bit&aacute;coras de usuario</span></a></li>
                    <li><a href="backup.php"><i class="icon-hdd"></i><span class="hidden-tablet"> Respaldo y Restauraci&oacute;n de la Base de Datos</span></a></li>
                    <li><a href="administrar_mensajes.php"><i class="icon-comment"></i><span class="hidden-tablet"> Administrar espacio de Discuci&oacute;n</span></a></li>						
                </ul>
            </div>
        </div>	        
		        @elseif($tipo_usuario==2)
		    	<ul class="nav nav-tabs nav-stacked main-menu">
					<li class="nav-header box-header"><h5>Men&uacute; </h5></li>
					<li><a href="home_consultor_jefe.php"><i class="icon-home"></i><span class="hidden-tablet"> Home </span></a></li>
					<li><a href="info_consultor.php"><i class="icon-edit"></i><span class="hidden-tablet"> Informaci&oacute;n del usuario</span></a></li>
					<li><a href="subir_consultor_jefe.php"><i class="icon-pencil"></i><span class="hidden-tablet"> Publicar Avisos</span></a></li>
					<li><a href="subir_contrato.php"><i class="icon-list-alt"></i><span class="hidden-tablet"> Publicar Documentos</span></a></li>
					<li><a href="administrar_archivos.php"><i class="icon-folder-close"></i><span class="hidden-tablet"> Administrar archivos</span></a></li>
					<li><a href="planificacion.php"><i class="icon-calendar"></i><span class="hidden-tablet"> Planificar actividades</span></a></li>
					<li><a href="calificar_grupo_empresa.php"><i class="icon-edit"></i><span class="hidden-tablet"> calificar actividades</span></a></li>
					<li><a href="administrar_grupo.php"><i class="icon-check"></i><span class="hidden-tablet"> Administrar mis Grupo Empresas</span></a></li>
					<li><a href="notificaciones.php"><i class="icon-globe"></i><span class="hidden-tablet"> Notificaciones</span></a></li>
					<li><a href="mensajes.php"><i class="icon-comment"></i><span class="hidden-tablet"> Espacio de Discuci&oacute;n</span></a></li>
				</ul>
			</div>
		</div>				
			@elseif($tipo_usuario==3)		
			    <ul class="nav nav-tabs nav-stacked main-menu">
					<li class="nav-header box-header"><h5>Men&uacute; </h5></h5></li>
					<li><a href="home_consultor.php"><i class="icon-home"></i><span class="hidden-tablet"> Home </span></a></li>
					<li><a href="info_consultor.php"><i class="icon-edit"></i><span class="hidden-tablet"> Informaci&oacute;n del usuario</span></a></li>
					<li><a href="subir_contrato.php"><i class="icon-list-alt"></i><span class="hidden-tablet"> Publicar Documentos</span></a></li>
					<li><a href="administrar_archivos.php"><i class="icon-folder-close"></i><span class="hidden-tablet"> Administrar archivos</span></a></li>
					<li><a href="administrar_grupo.php"><i class="icon-check"></i><span class="hidden-tablet"> Administrar mis Grupo Empresas</span></a></li>
					<li><a href="notificaciones.php"><i class="icon-globe"></i><span class="hidden-tablet"> Notificaciones</span></a></li>
					<li><a href="mensajes.php"><i class="icon-comment"></i><span class="hidden-tablet"> Espacio de Discuci&oacute;n</span></a></li>
				</ul>
			</div>
		</div>						
			@elseif($tipo_usuario==4)
				<ul class="nav nav-tabs nav-stacked main-menu">
					<li class="nav-header box-header"><h5>Men&uacute; </h5></li>
					<li><a href="home_grupo.php"><i class="icon-home"></i><span class="hidden-tablet"> Home</span></a></li>
					<li><a href="info_grupo.php"><i class="icon-edit"></i><span class="hidden-tablet"> Informaci&oacute;n de la Grupo Empresa</span></a></li>
					<li><a href="administrar_integrante.php"><i class="icon-check"></i><span class="hidden-tablet"> Administrar Integrantes</span></a></li>
					<li><a href="subir_grupo_empresa.php"><i class="icon-list-alt"></i><span class="hidden-tablet"> Documentos</span></a></li>
                    <li><a href="entrega_prod.php"><i class="icon-calendar"></i><span class="hidden-tablet"> Cronograma de Pagos y de Subsistemas  </span></a></li>
                    <li><a href="actividades_grupo.php"><i class="icon-edit"></i><span class="hidden-tablet"> Planificar Actividades de Subsistemas</span></a></li>
                    <li><a href="calificacion_grupo.php"><i class="icon-check"></i><span class="hidden-tablet"> Ver las notas de las actividades</span></a></li>
                    <li><a href="formulario_entrega_producto.php"><i class="icon-star"></i><span class="hidden-tablet"> Entrega de Subsistemas</span></a></li>
                    <li><a href="mis_tareas_grupo_integra.php"><i class="icon-briefcase"></i><span class="hidden-tablet"> Gestionar mis Tareas</span></a></li>
                    <li><a href="cronograma_grupo_integra.php"><i class="icon-tasks"></i><span class="hidden-tablet"> Reporte general de la Grupo Empresa </span></a></li>
					<li><a href="notificaciones.php"><i class="icon-globe"></i><span class="hidden-tablet"> Notificaciones</span></a></li>
					<li><a href="mensajes.php"><i class="icon-comment"></i><span class="hidden-tablet"> Espacio de Discuci&oacute;n</span></a></li>
				</ul>
			</div>
		</div>
		    @elseif($tipo_usuario==5)
				<ul class="nav nav-tabs nav-stacked main-menu">
					<li class="nav-header box-header"><h5>Men&uacute </h5></li>
					<li><a href="home_integrante.php"><i class="icon-home"></i><span class="hidden-tablet"> Home </span></a></li>
					<li><a href="info_grupo.php"><i class="icon-edit"></i><span class="hidden-tablet"> Informaci&oacute;n del integrante</span></a></li>
					<li><a href="mis_tareas_grupo_integra.php"><i class="icon-briefcase"></i><span class="hidden-tablet"> Gestionar mis tareas</span></a></li>
                    <li><a href="cronograma_grupo_integra.php"><i class="icon-tasks"></i><span class="hidden-tablet"> Reporte general de la Grupo Empresa </span></a></li>
					<li><a href="mensajes.php"><i class="icon-comment"></i><span class="hidden-tablet"> Espacio de Discuci&oacute;n</span></a></li>
				</ul>
			</div>
		</div>
			@else
				<ul class="nav nav-tabs nav-stacked main-menu">
					<li class="nav-header box-header"><h5>Men&uacute principal</h5></li>
					<li><a href="index.php"><i class="icon-home"></i><span class="hidden-tablet"> Inicio</span></a></li>
					<li><a href="iniciar_sesion.php"><i class="icon-check"></i><span class="hidden-tablet"> Grupo Empresa</span></a></li>
					<li><a href="iniciar_sesion.php"><i class="icon-briefcase"></i><span class="hidden-tablet"> Consultor TIS</span></a></li>
					<li><a href="ayuda.php"><i class="icon-question-sign"></i><span class="hidden-tablet"> Ayuda</span></a></li>
					<li><a href="login.php"><i class="icon-lock"></i></i><span class="hidden-tablet"> Administrar Sistema</span></a></li>
				</ul>
			</div>
	    </div>
		    @endif	       
       <div class="span8" id="content">
          <noscript>
		 	  <div class="alert alert-block">
			  	 <h4 class="alert-heading">Alerta!</h4>
				 <p>Necesitas tener habilitado <a href="http://es.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> para utilizar el sistema.</p>
			  </div>
		  </noscript>                
       	  @yield('contenido')
        </div>
        </div>
       <div class="span2">   
       @yield('nav-derecha')
       
       <h2>hola</h2>
       </div>   
   </div>
</div>
</body>
</html>	    
<!--
	        <	    	    	    -->