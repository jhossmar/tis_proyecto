<?php
$titulo="Administrar Archivos del Consultor TIS";

  session_start();
  require_once("conexion/verificar_gestion.php");
  require_once("conexion/conexion.php");

  $VerificarG = new VerificarGestion;
  $GestionValida = $VerificarG->GetGestionValida();

  $conexion = new Conexion;
  $conexion->EstablecerConexion();
  $conn = $conexion->GetConexion();

include('header.php');
 ?>
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
						<?php if($GestionValida) {                              
                               $integrantes ="SELECT id_documento_consultor, nombre_documento,descripsion_documento,fecha_documento,g.gestion,habilitado,ruta_documento
								FROM documento_consultor d, gestion_empresa_tis g
								WHERE g.id_gestion=d.gestion AND consultor_tis=$id_usuario AND d.documento_jefe=0";
                               $resultado = mysql_query($integrantes,$conn);
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
                                while($row = mysql_fetch_array($resultado)){

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