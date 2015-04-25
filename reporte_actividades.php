<?php
session_start();
/*------------------VERIFICAR QUE SEAL EL ADMINISTRADOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
	            case (2) :
	                	$home="home_consultor_jefe.php";
	                    break;
	            case (3) :
	                    $home="home_consultor.php";
	                    break;
	          }
		header("Location: ".$home);
}
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
/*----------------------FIN VERIFICACION------------------------------------*/



$titulo="Reporte Actividades";
$usuario=$_SESSION['nombre_usuario'];
include('header.php');
include('conexion/verificar_gestion.php');
 ?>
 			<!--PARTICIONAR
 			<li>
						<a href="#">Inicio</a> <span class="divider">/</span>
			</li>-->
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="home_admin.php">Reporte Actividades</a>
					</li>
				</ul>
			</div>
			<center><h3>Reporte Actividades</h3></center>
			<div class="row-fluid">
		            <div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-check"></i> Reporte Actividades</h2>

					</div>
					<div class="box-content">
						<form name="form-data" class="form-horizontal cmxform" method="POST" action="conexion/notificaciones_resp_contrato.php" accept-charset="utf-8">

						<table class="table table-bordered table-striped">


						  	<input type="hidden" id="usuario" name="usuario" value=<?php echo $nombre_usuario ?> ></input>
                            <?php
                              include('conexion/conexion.php');
                              $consulta_id_ge = mysql_query("SELECT ge.id_grupo_empresa
                               FROM usuario u,integrante i,grupo_empresa ge
                               WHERE u.id_usuario='".$_SESSION['id']."' and u.id_usuario=i.usuario and i.grupo_empresa =ge.id_grupo_empresa",$conn)
                                or die("Could not execute the select query.");
                              $resultado_id_ge = mysql_fetch_assoc($consulta_id_ge);
                              $rep_id_ge=(int)$resultado_id_ge['id_grupo_empresa'];

                               $consulta = "SELECT a.descripcion, a.fecha_inicio, a.fecha_fin ,a.id_actividad
											FROM actividad_grupo_empresa a, entrega_producto e
											WHERE e.grupo_empresa = '$rep_id_ge'
											AND a.entrega_producto = e.id_entrega_producto";
                               $resultado = mysql_query($consulta);
                               $num_registros = mysql_num_rows($resultado);
                               $identi=0;


                               if($num_registros>0){

                                while($row = mysql_fetch_array($resultado)) {
                                	echo
                                	"<thead >
										  <tr >
											  <th colspan=\"2\"> <center>Actividad : "." ".$row["descripcion"]." <br>Duracion: ".$row["fecha_inicio"]." - ".$row["fecha_inicio"]." </center></th>
                                          </tr>
									  </thead>";
									  $des = $row["descripcion"];
									  	$tareas = "SELECT t.descripcion,t.fecha_inicio, t.fecha_fin , u.nombre
													FROM tarea t,integrante i ,usuario u
													WHERE t.actividad = '".$row["id_actividad"]."'
													AND i.usuario = t.responsable  AND u.id_usuario = i.usuario";

                               			$res_tareas = mysql_query($tareas);

                               			while($con = mysql_fetch_array($res_tareas)) {
                               				echo"
												  <tr >
													  <td colspan=\"1\"> <b>Tarea : "." </b>".$con["descripcion"]." <br><b>Duracion: </b>".$con["fecha_inicio"]." - ".$con["fecha_inicio"]."</td>
													  <td colspan=\"1\"><b>Responsable : </b> ".$con["nombre"]."</td>
												  </tr>
												  ";
                               			}
                                }       //fin while

                                }
                                else{
                                 echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No existe ninguna actividad programada  <br> puede programar sus actividaes <a style=\"color:#555555; !important\" href=\"actividades_grupo.php\">aqu&iacute;.</a> </h4>
				                      	</div>";

                                }

                             ?>


					  </table>

                    </form>



					</div>
				</div><!--/span-->
				</div>
<?php include('footer.php'); ?>