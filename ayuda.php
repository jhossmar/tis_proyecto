<?php
$titulo="Ayuda del Sistema de Apoyo a la Empresa TIS";
include("conexion/verificar_gestion.php");
session_start();
include('header.php');

?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="home_consultor.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="ayuda.php">Ayuda</a>
					</li>
				</ul>
			</div>
			<center><h3>Ayuda del Sistema de Apoyo a la Empresa TIS</h3></center>
			
			
	   <div class="menu_ayuda" alioverflow: scroll  >
		
		<h1>INDICE</h1>
		<h2><a href="ayuda.php?nom_arch=004">Introducción</a></h2>
		<h2>Vista principal</h2>
		<h2>Funciones del administrador</h2>
		<h4>Definir gestion</h3>
		<h4>Información y Modificación de datos de registro de administrador </h3>
		<h4>Administrar consultores TIS</h3>
		<h4>Administrar grupo empresas</h3>
		<h4>Bitacoras de usuarios</h3>
		<h4>Respaldo y restauración de la base de datos </h3>
		<h4>Administración del espacio de discución</h3>
		<h2> Funciones del consultor TIS</h2>
		<h4>Registro del consultor TIS </h2>
		<h4>Información y modificacion de los datos de Registro del consultos TIS</h4>	
		<h4>Publicar documentos </h4>
		<h4>Administrar archivos </h4>
		<h4>Administrar grupo empresa </h4>
		<h6>Habilitación de grupo empresa y reportes </h6>
		<h6> Cronograma y documentación de los grupo empresas</h6>
		<h2>Funciones exclusivas del consultor TIS </h2>
		<h4> Publicar avisos </h4>
		<h4>Planificar actividades </h4>
		<h2>Funciones de grupo empresasa e integrantes  </h2>
		<h4>Información y modificación de datos de registro de grupo empresa </h4>
		<h4>Administrar integrantes  </h4>
		<h4>Documentos </h4>	
        <h4>Cronograma de entrega de subsistema</h4>
        <h4>Planificación Actividades de Subsistema </h4>
        <h6>Registro de actividades</h6>
        <h6>Planificar tareas </h6>
        <h4> Entrega de subsistema </h4>
        <h4>Gestionar tareas </h4>
        <h4>Reporte General de los grupo empresa</h4>
        <h2>Funciones del integrante</h2>
        <h2>Funciones adicionales</h2>
        <h4>Notificaciones</h4>
        <h4>Espacio de discución</h4>
            
	</div>
	
	<div class="container-fluid">
	<div class="row-fluid">
       <div class="span12">
       	<div class="visor">
    	<?php
			
			
			$id=$_GET['nom_arch'];
			echo($id);
			echo "<embed src='archivos/".$id.".pdf' width=800 height=500 />";//no id si no nombre del archivo
			
	  	?>
	    </div>
	   </div>
	  </div>	

   </div>
				
				
        <div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Ayuda</h2>
					</div>
					<div class="box-content">
					
					<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							Si necesita ayuda, o tiene problemas con el uso del sistema puede contactarse con el <b>Administrador</b>, sus datos se encuentran a continuaci&oacute;n.
						</div>
					<?php
						
							$c = "SELECT nombre,apellido,telefono,email
								FROM usuario
								WHERE tipo_usuario=1";
	               			$r = mysql_query($c,$conn);
	               			$resultado = mysql_fetch_assoc($r);
								if(is_array($resultado) && !empty($resultado))
								{	
										$nombre= $resultado['nombre'];
										$apellido= $resultado['apellido'];
										$telefono= $resultado['telefono'];
										$email= $resultado['email'];
										?>
										<table class="table table-bordered">
								  		<tbody>
											<tr>
												<td><b>Nombre: </b></td>
												<td class="center"><?php echo $nombre." ".$apellido; ?></td>                                       
											</tr>
											<tr>
												<td><b>Tel&eacute;fono: </b></td>
												<td class="center"><?php echo $telefono; ?></td>                                     
											</tr>
											<tr>
												<td><b>Correo electr&oacute;nico: </b></td>
												<td class="center"><?php echo $email; ?></td>                          
											</tr>
											                                    
										  </tbody>
								 		</table>
								<?php }
								else{
									echo "<h4>No se Encontro ning&uacute;n registro";
								}
                      ?>
					</div>
				</div><!--/span-->
			</div><!-- fin row -->


<?php
   include('footer.php');
 ?>