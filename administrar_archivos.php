<?php
$titulo="Administrar Archivos del Consultor TIS";
include('conexion/verificar_gestion.php');
session_start();
/*------------------VERIFICAR QUE SEAL EL ADMINISTRADOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && ($_SESSION['tipo']!=2 && $_SESSION['tipo']!=3))
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
						<a href="administrar_archivos.php">Administrar Archivos</a>
					</li>
				</ul>
			</div>
			<center><h3>Administrar Archivos</h3></center>
			<div class="row-fluid">
		            <div class="box span12" id="print">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-check"></i> Mis Archivos</h2>

					</div>
					<div class="box-content">
						<?php if($gestion_valida) {
                              include('conexion/conexion.php');
                               $integrantes ="SELECT id_documento_consultor, nombre_documento,descripsion_documento,fecha_documento,g.gestion,habilitado,ruta_documento
								FROM documento_consultor d, gestion_empresa_tis g
								WHERE g.id_gestion=d.gestion AND consultor_tis=$id_usuario AND d.documento_jefe=0";
                               $resultado = mysql_query($integrantes);
                               $num_res=mysql_num_rows($resultado);
                              if ($num_res>0) {
							?>
							<form name="form-data" class="form-horizontal cmxform" method="POST" action="conexion/validar_archivos.php" accept-charset="utf-8">
							<input type="hidden" id="consultor" name="consultor" value=<?php echo $id_usuario; ?> ></input>
							<table class="table table-striped table-bordered  datatable" >
							  <thead >
								  <tr >
									 	  <th>Archivo</th>
										  <th>Descripci&oacute;n</th>
										  <th>Fecha de creaci&oacute;n</th>
										  <th>Gesti&oacute;n</th>
										  <th style="text-align:center">Visible</th>
								  </tr>
							  </thead>
							  <tbody >
						  
						  	
                            <?php
                               $identi=0;
                                while($row = mysql_fetch_array($resultado)) {

                               echo "
                                <tr>
    								  <td ><a href='".$row['ruta_documento']."' >".$row["nombre_documento"]."<a></td>

    								  <td>".$row['descripsion_documento']."<input type=\"hidden\" id=a".$identi." name=a".$identi." value=".$row["id_documento_consultor"]."></input></td>

    								  <td>".$row["fecha_documento"]."</td>
    								  <td>".$row["gestion"]."</td>";

                                 $aux= $row["habilitado"];
                                        if($aux=="1"){
                                           echo "<td ><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi."  checked></center></td>";
                                         }
                                         else{
                                            echo "<td class=\"center\"><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi."></center></td>";
                                        }
                        		 echo "	</tr> ";
                                 $identi++;
                                }
                             ?>

						  </tbody>
					  </table>
					    


                                
                                  <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar Cambios</button>
                                  <a href="administrar_archivos.php" rel="activi"><button type="button" class="btn"><i class="icon-remove"></i> Restablecer</button></a>

								 



                    </form>
                    <?php 	}
                            else{
                            	echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        Usted no tiene ning&uacute;n archivo.</h4>
				                      	</div>";
                            }
                        }
                   		 else{
                   		 	echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				                      	</div>";
                   		 }
                    ?>
					</div>
				</div><!--/span-->
				</div>
               

<?php include('footer.php'); ?>