<?php
$titulo="P&aacute;gina de inicio Integrante Grupo Empresa";
include("conexion/verificar_gestion.php");
session_start();
/*------------------VERIFICAR QUE SEAL EL CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=5)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
	            case (4) :
	                	$home="home_grupo.php";
	                    break;
	            case (3) :
	                	$home="home_consultor.php";
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
						<a href="home_consultor.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="home_consultor.php">Home Integrante Grupo Empresa</a>
					</li>
				</ul>
			</div>
			<center><h3>Bienvenido Integrante Grupo Empresa</h3></center>
			

            <div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Informaci&oacute;n</h2>
					</div>
					<div class="box-content alerts">
					<?php
						if ($gestion_valida) { ?>
							Bienvenido Integrante de Grupo Empresa a la <b>Gesti&oacute;n <?php echo $nombre_gestion; ?></b>, en este sitio usted podr&aacute; administrar las
								tareas que le fueron asignadas por el Jefe de la Grupo Empresa a la cual pertenece y tambi&eacute;n podr&aacute; participar del <a href="mensajes.php">Espacio de discuci&oacute;n</a>.<br>	

                       <?php }
                         else{
                         	echo "<div align=\"center\">
	                        <h4><i class=\"icon-info-sign\"></i>
	                         La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
	                      	</div>";
                         }
                      ?>

					</div>
				</div><!--/span-->
			</div><!-- fin row -->


<?php include('footer.php'); ?>