<?php
class Menu 
{
	
	function __construct()
	{		
	}
	function ControlMenu($usuario)
    {
	switch ($usuario)
	 {
		case 1:
			echo '
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
				</div>
			</div>		
		';
		break;
		case 2:
		echo '
			<div class="span2 main-menu-span">
				<div class="well2 nav-collapse ">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header box-header"><h5>Men&uacute; </h5></li>
						<li><a href="home_consultor_jefe.php"><i class="icon-home"></i><span class="hidden-tablet"> Home <?php echo $tipo ?></span></a></li>
						<li><a href="info_consultor.php"><i class="icon-edit"></i><span class="hidden-tablet"> Informaci&oacute;n del usuario</span></a></li>
						<li><a href="subir_consultor_jefe.php"><i class="icon-pencil"></i><span class="hidden-tablet"> Publicar Avisos</span></a></li>
						<li><a href="subir_contrato.php"><i class="icon-list-alt"></i><span class="hidden-tablet"> Publicar Documentos</span></a></li>
						<li><a href="administrar_archivos.php"><i class="icon-folder-close"></i><span class="hidden-tablet"> Administrar archivos</span></a></li>
						<li><a href="planificacion.php"><i class="icon-calendar"></i><span class="hidden-tablet"> Planificar actividades</span></a></li>
						<li><a href="calificar_actividades.php"><i class="icon-edit"></i><span class="hidden-tablet"> calificar actividades</span></a></li>
						<li><a href="administrar_grupo.php"><i class="icon-check"></i><span class="hidden-tablet"> Administrar mis Grupo Empresas</span></a></li>
						<li><a href="notificaciones.php"><i class="icon-globe"></i><span class="hidden-tablet"> Notificaciones</span></a></li>
						<li><a href="mensajes.php"><i class="icon-comment"></i><span class="hidden-tablet"> Espacio de Discuci&oacute;n</span></a></li>
					</ul>
				</div>
			</div>	
		';		
		break;
		case 3:
		   echo'
		     <div class="span2 main-menu-span">
				<div class="well2 nav-collapse ">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header box-header"><h5>Men&uacute; </h5></h5></li>
						<li><a href="home_consultor.php"><i class="icon-home"></i><span class="hidden-tablet"> Home <?php echo $tipo ?></span></a></li>
						<li><a href="info_consultor.php"><i class="icon-edit"></i><span class="hidden-tablet"> Informaci&oacute;n del usuario</span></a></li>
						<li><a href="subir_contrato.php"><i class="icon-list-alt"></i><span class="hidden-tablet"> Publicar Documentos</span></a></li>
						<li><a href="administrar_archivos.php"><i class="icon-folder-close"></i><span class="hidden-tablet"> Administrar archivos</span></a></li>
						<li><a href="administrar_grupo.php"><i class="icon-check"></i><span class="hidden-tablet"> Administrar mis Grupo Empresas</span></a></li>
						<li><a href="notificaciones.php"><i class="icon-globe"></i><span class="hidden-tablet"> Notificaciones</span></a></li>
						<li><a href="mensajes.php"><i class="icon-comment"></i><span class="hidden-tablet"> Espacio de Discuci&oacute;n</span></a></li>
					</ul>
				</div>
			</div>
		   ';
		break;
		case 4:			
		echo'
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
				</div>
			</div>';
		break;
		case 5:
		echo'
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
				</div>
			</div>
		';
		break;
		default:
		echo
		'
		<div class="span2 main-menu-span">
			<div class="well2 nav-collapse ">
				<ul class="nav nav-tabs nav-stacked main-menu">
					<li class="nav-header box-header"><h5>Men&uacute; principal</h5></li>
					<li><a href="index.php"><i class="icon-home"></i><span class="hidden-tablet"> Inicio</span></a></li>
					<li><a href="iniciar_sesion.php"><i class="icon-check"></i><span class="hidden-tablet"> Grupo Empresa</span></a></li>
					<li><a href="iniciar_sesion.php"><i class="icon-briefcase"></i><span class="hidden-tablet"> Consultor TIS</span></a></li>
					<li><a href="ayuda.php"><i class="icon-question-sign"></i><span class="hidden-tablet"> Ayuda</span></a></li>
					<li><a href="login.php"><i class="icon-lock"></i></i><span class="hidden-tablet"> Administrar Sistema</span></a></li>
				</ul>
			</div>
		</div><
		';
		break;
	}	
    }
}
?>