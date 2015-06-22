<?php 
$titulo="P&aacute;gina de inicio Consultor TIS";
include("conexion/verificar_gestion.php");
$verificarG = new VerificarGestion;
$gestionValida = $verificarG->GetGestionValida();
session_start();

include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="home_consultor.php">Home Consultor TIS</a>
					</li>				
				</ul>
			</div>
			<center><h3>Bienvenido Consultor TIS</h3></center>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Informacion</h2>
					</div>
					<div class="box-content alerts">
					<?php if ($gestionValida) { ?>
					<span class="pull-left">					
							Bienvenido Consultor TIS a la <b>Gesti&oacute;n <?php echo $verificarG->nombre_gestion; ?></b>, en este sitio usted podr&aacute; realizar el seguimiento las grupo empresas que se inscribieron con usted, enviar mensajes a cualquier usuario
							 del sistema y tambi&eacute;n podr&aacute; participar del espacio de discuci&oacute;n donde las grupo empresas
							 inscritas con usted dejaran preguntas o dudas esperando su respuesta.
							<br><br>
					</span>					
					<?php }
					else { 
							echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				                      	</div>";

						 }	?>						
					</div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			 	
<?php include('footer.php'); ?>