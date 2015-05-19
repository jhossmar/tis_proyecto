<?php
$titulo="Sistema de Apoyo a la Empresa TIS";
require_once("conexion/verificar_gestion.php");
    
  $VeriricarG = new VerificarGestion();
  $GestionValida = $VeriricarG->VerificarFechasGestion();

session_start();
include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">

					<li>
						<a href="index.php">Inicio</a>
					</li>
				</ul>
			</div>
			<center><h3>Bienvenidos al Sistema de Apoyo a la Empresa TIS</h3></center>

			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-bullhorn"></i> Avisos: Gesti&oacute;n <?php echo $VeriricarG->nombre_gestion; ?></h2>
					</div>
					<div class="box-content alerts">
					<?php
						if($GestionValida) 
						{
							 include('conexion/noticias.php');
                       }
                       else
                       {
                         	echo "<div align=\"center\">
	                        <h4><i class=\"icon-info-sign\"></i>
	                        No existe ning&uacute;n aviso para esta gesti&oacute;n.</h4>
	                      	</div>";
                        }
                    ?>

					</div>
				</div><!--/span-->
			</div><!-- fin row -->

<?php include('footer.php'); ?>
