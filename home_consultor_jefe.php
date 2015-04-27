<?php 
$titulo="P&aacute;gina de inicio Jefe Consultor TIS";
include("conexion/verificar_gestion.php");
session_start();
/*------------------VERIFICAR QUE SEAL EL JEFE CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=2)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
	                    break;
	            case (4) :
	                	$home="home_grupo.php";
	                    break;
	            case (3) :
	                	$home="home_consultor.php";
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
						<a href="home_consultor_jefe.php">Home Jefe Consultor TIS</a>
					</li>				
				</ul>
			</div>
			<center><h3>Bienvenido Jefe Consultor TIS</h3></center>
			<?php 
			if (!$gestion_valida) { ?>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Importante</h2>
					</div>
					<div class="box-content alerts">
					<?php if ($gestion_espera) {
						echo "En estos momentos el sistema no se encuentra disponible. Ya se habilit&oacute; una nueva gesti&oacute;n pero el inicio de la misma 
						esta programada para la fecha <b>".$ini_gestion."</b>. Favor tomar nota.";
					}
					else{
						echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				                      	</div>";
					 } ?>							
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
									
							Bienvenido Jefe Consultor TIS a la <b>Gesti&oacute;n <?php echo $nombre_gestion; ?></b>, en este sitio usted podr&aacute; realizar la publicaci&oacute;n de avisos
							 y documentos, realizar el seguimiento de las Grupo Empresas que se inscribieron con usted, enviar mensajes a cualquier usuario
							 del sistema y tambi&eacute;n podr&aacute; participar del espacio de discuci&oacute;n donde las grupo empresas
							 inscritas con usted dejaran preguntas o dudas esperando su respuesta.
							<br>						
					</div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<?php } ?>
				
			
			
<?php include('footer.php'); ?>