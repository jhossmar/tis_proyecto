<?php 
$titulo="P&aacute;gina de inicio Consultor TIS";
include("conexion/verificar_gestion.php");
session_start();
/*------------------VERIFICAR QUE SEAL EL CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=3)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
	                    break;
	            case (4) :
	                	$home="home_grupo.php";
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
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
/*----------------------FIN VERIFICACION------------------------------------*/
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
					<?php if ($gestion_valida) { ?>
					<span class="pull-left">					
							Bienvenido Consultor TIS a la <b>Gesti&oacute;n <?php echo $nombre_gestion; ?></b>, en este sitio usted podr&aacute; realizar el seguimiento las grupo empresas que se inscribieron con usted, enviar mensajes a cualquier usuario
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