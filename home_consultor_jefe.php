<?php 
  $titulo="P&aacute;gina de inicio Jefe Consultor TIS";
  require_once("conexion/verificar_gestion.php");

  $verificarG = new VerificarGestion();
  $GestionValida = $verificarG->GetGestionValida();
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
				<a href="home_consultor_jefe.php">Home Jefe Consultor TIS</a>			
			</li>				
		</ul>
	</div>
	<center><h3>Bienvenido Jefe Consultor TIS</h3></center>
	<?php 
		if(!$GestionValida){?>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Importante</h2>
					</div>
					<div class="box-content alerts">
					<?php if($GestionValida)
         				  {
						    echo "En estos momentos el sistema no se encuentra disponible. Ya se habilit&oacute; una nueva gesti&oacute;n pero el inicio de la misma 
						          esta programada para la fecha <b>".$verificarG->ini_gestion."</b>. Favor tomar nota.";
					      }
					      else
					      {
						    echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				                      	</div>";
	                       }?>							
					</div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<?php } 
			else{ ?>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Informaci&oacute;n</h2>
					</div>
					<div class="box-content alerts">
									
							Bienvenido Jefe Consultor TIS a la <b>Gesti&oacute;n <?php echo $verificarG->nombre_gestion; ?></b>, en este sitio usted podr&aacute; realizar la publicaci&oacute;n de avisos
							 y documentos, realizar el seguimiento de las Grupo Empresas que se inscribieron con usted, enviar mensajes a cualquier usuario
							 del sistema y tambi&eacute;n podr&aacute; participar del espacio de discuci&oacute;n donde las grupo empresas
							 inscritas con usted dejaran preguntas o dudas esperando su respuesta.
							<br>						
					</div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<?php } ?>
<?php include('footer.php'); ?>