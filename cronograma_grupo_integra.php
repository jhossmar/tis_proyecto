<?php
$titulo="Reporte general de la Grupo Empresa";
include('conexion/verificar_gestion.php');
session_start();
$quien_ingresa="Grupo Empresa";
$pag_ini="home_grupo.php";

/*------------------VERIFICAR QUE SEAL EL CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && ($_SESSION['tipo']==1 || $_SESSION['tipo']==2 || $_SESSION['tipo']==3))
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
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


    $consulta_id_ge = mysql_query("SELECT ge.id_grupo_empresa ,ge.nombre_corto
                                                             FROM integrante i,grupo_empresa ge
                                                             WHERE i.usuario=".$_SESSION['id']." and i.grupo_empresa=ge.id_grupo_empresa",$conn)  or die("Could not execute the select query.");
                              $resultado_id_ge = mysql_fetch_assoc($consulta_id_ge);
                              $id_ge=$resultado_id_ge['id_grupo_empresa'];
                              $no_ge=$resultado_id_ge['nombre_corto'];

 ?>
<script type="text/javascript">
	function imprimir(){
  var objeto=document.getElementById('print');  //obtenemos el objeto a imprimir
  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
  ventana.document.close();  //cerramos el documento

  	var css = ventana.document.createElement("link");
	css.setAttribute("href", "css/style.css");
	css.setAttribute("rel", "stylesheet");
	css.setAttribute("type", "text/css");
	ventana.document.head.appendChild(css);


  ventana.print();  //imprimimos la ventana
  ventana.close();  //cerramos la ventana
}

</script>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a><span class="divider">/</span>
					</li>
					<li>
						<a href='cronograma_grupo_integra.php'> Reporte General de la Grupo Empresa </a>
					</li>
				</ul>
			</div>
			<center><h3> Grupo empresa <?php echo "".$no_ge;  ?></h3></center>
      <?php if($gestion_valida){ ?>
			<div class="row-fluid">
				<div class="box span12 " id="print">
						<div class="box-header well">
							<h2><i class="icon-calendar"></i> Cronograma de entrega de subsistemas</h2>
						</div>
						<div class="box-content padding-in" style="text-align:left;" >
						 <div class="row-fluid">
						   <!--	 <div class="span12" style="padding:10px;"> </div>    -->
                             <?php

                              $entregas ="SELECT ep.descripcion,ep.fecha_inicio,ep.fecha_fin,ep.pago_establecido,ep.pago_recibido ,ep.id_entrega_producto,ep.observacion,u.nombre,u.apellido
                                          FROM entrega_producto ep, usuario u
                                          WHERE ep.grupo_empresa=$id_ge
										  AND ep.id_responsable=u.id_usuario
										  ";
                              $resultado = mysql_query($entregas);
                              $num_entre=mysql_num_rows($resultado);
							  $id_subsistema;
							  $nombre_subsistema;
                                if($num_entre>0){    ?>
                                    <!--    <form name="form-data" class="form-horizontal cmxform" method="GET" action="conexion/validar_grupo.php" accept-charset="utf-8">     -->
                    							<table class="table table-striped table-bordered datatable" >
                            							  <thead >
                            								  <tr >
                          									 	  <th>Descripci&oacute;n  </th>
                          										  <th>Responsable </th>
                          										  <th>Fecha inicio</th>
                          										  <th>Fecha Conclusi&oacute;n </th>
                                                                  <th>Observaciones </th>
                                                                  
                            								  </tr>
                            							  </thead>
                            							  <tbody >
                                                             <?php
                                                               $identi=0;
                                                                while($row = mysql_fetch_array($resultado)) {
                                                               echo "
                                                                <tr>
                                    								   <td>".$row["descripcion"]."</td>
                                                                       <td>".$row["nombre"]." ".$row["apellido"]."</td>
                                    								   <td>".$row["fecha_inicio"]."</td>
                                    								   <td>".$row["fecha_fin"]."</td>
																	   <td>".$row["observacion"]."</td>";
                                                        		 echo "	</tr> ";
																 $id_subsistema[$identi]=$row["id_entrega_producto"];
																 $nombre_subsistema[$identi]=$row["descripcion"];
                                                                 $identi++;
                                                                }
                                                             ?>
                                                          </tbody>
                                               </table>
                                       <!--     </form>    -->
                              <?php
                                }
                                else{ ?>
                                    <center><h4><i class="icon-info-sign"></i>
                                No se encontr&oacute; ning&uacute;n registro</h4></center>

                               <?php
                                 }
                              ?>
						</div>
		                </div>
				</div>
			</div>


             <div class="row-fluid">
				<div class="box span12 " id="print">
						<div class="box-header well">
							<h2><i class="icon-edit"></i> Evaluaci&oacute;n de subsistemas</h2>
						</div>
						<div class="box-content padding-in" style="text-align:left;" >
						 <div class="row-fluid">
						   <!--	 <div class="span12" style="padding:10px;"> </div>    -->
                             <?php

                              $en ="SELECT ep.descripcion,ep.id_entrega_producto ,ep.enlace_producto,ep.pago_establecido,ep.pago_recibido
                                          FROM entrega_producto ep
                                          WHERE ep.grupo_empresa=$id_ge";
                              $resu = mysql_query($en);
                              $num_entre=mysql_num_rows($resu);
                                if($num_entre>0){    ?>
                                    <!--    <form name="form-data" class="form-horizontal cmxform" method="GET" action="conexion/validar_grupo.php" accept-charset="utf-8">     -->
                    							<table class="table table-striped table-bordered datatable" >
                            							  <thead >
                            								  <tr >
																	<th>Descripci&oacute;n  </th>
																	<th>Pago establecido </th>
																	<th>Pago recibido </th>
																	<th>Ver Subsistema   </th>
                            								  </tr>
                            							  </thead>
                            							  <tbody >
                                                             <?php
                                                               $identi=0;
                                                                while($row = mysql_fetch_array($resu)) {
                                                               echo "
                                                                <tr>
                                    								   <td>".$row["descripcion"]."</td>
																	   <td>".$row["pago_establecido"]."</td>
                                                                       <td>".$row["pago_recibido"]."</td>
																	   ";
                                                                       $arx=$row["enlace_producto"];
                                                                         if($arx==""||$arx==NULL){
                                                                              echo "<td>No existe registro</td>";
                                                                          }
                                                                          else{
                                                                           echo"<td class=\"center\"> <a href= ".$arx."> <i class=\"icon-zoom-in\"></i> Ver Avance</a></td>";
                                                                          }

                                                        		 echo "	</tr> ";
                                                                 $identi++;
                                                                }
                                                             ?>
                                                          </tbody>
                                               </table>
                                       <!--     </form>    -->
                              <?php
                                }
                                else{ ?>
                                    <center><h4><i class="icon-info-sign"></i>
				                        No se encontr&oacute; ning&uacute;n registro</h4></center>

                               <?php
                                 }
                              ?>
						</div>
		                </div>
				</div>
			</div>

<!--DESDE AQUI EMPIEZAN LAS MODIFICACIONES PARA MOSTRAR TAREAS, ACTIVIDADES Y SUBSISTEMAS EN UNA SOLA PANTALLA-->

				<div class="row-fluid">
				        <div class="box span12 " id="print">
        						<div class="box-header well">
        							<h2><i class="icon-check"></i> Ver actividades del subsistema </h2>
        						</div>
        						<div class="box-content padding-in" style="text-align:left;" >
            						 <div class="row-fluid">
									 
								<?php
									$i = 0;
									while($i < $identi){
										$entregas = "SELECT age.descripcion,age.fecha_inicio,age.fecha_fin,age.porcentaje_completado,us.nombre,us.apellido
                                                    FROM actividad_grupo_empresa age, usuario us
                                                    WHERE age.entrega_producto = ".$id_subsistema[$i]." and age.id_responsable = us.id_usuario";
										$resultado = mysql_query($entregas);
										$num_entre=mysql_num_rows($resultado);
									?>
									
									<div class="row-fluid">
										<div class="box span12">
											<div class="box-header well">
												<h2><i class="icon-check"></i> <?php echo $nombre_subsistema[$i];?> </h2>
												<div class="box-icon">
													<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
												</div>
											</div>
											<div class="box-content">
												<div class="control-group">
												
													<?php
										
										if($num_entre>0){    ?>
                                            <br>
                                            <center><h4>Actividades</h4></center>
                                            <br>
                                            <table class="table table-striped table-bordered datatable" >
												<thead >
													<tr >
														<th>Descripci&oacute;n</th>
														<th>Responsable</th>
														<th>Fecha inicio</th>
														<th>Fecha Conclusi&oacute;n </th>
                          								<th>Porcentaje completado  </th>
                            						</tr>
                            					</thead>
                            					<tbody >
													<?php
														$identi_actividad=0;
														while($row = mysql_fetch_array($resultado)) {
															echo "
																<tr>
																	<td>".$row["descripcion"]."</td>
																	<td>".$row["nombre"]." ".$row["apellido"]."</td>
																	<td>".$row["fecha_inicio"]."</td>
																	<td>".$row["fecha_fin"]."</td>
																	<td>".$row["porcentaje_completado"]."</td>";
															echo "	</tr> ";
															$identi_actividad++;
														}
													?>
												</tbody>
											</table>
                                            <br>
											<center><h4>Tareas</h4></center>
                                            <br>
													<?php
														$entregas = "SELECT t.id_tarea, u.id_usuario, t.descripcion, u.nombre, u.apellido, t.fecha_inicio, t.fecha_fin, t.porcentaje_completado, t.resultado_obtenido, age.id_actividad, age.entrega_producto
                                                                    FROM tarea t, usuario u, actividad_grupo_empresa age
                                                                    WHERE t.responsable = u.id_usuario
                                                                    AND t.actividad = age.id_actividad
                                                                    AND age.entrega_producto =".$id_subsistema[$i];
														$resultado = mysql_query($entregas);
														$num_entre=mysql_num_rows($resultado);
														if($num_entre>0){    ?>
															<table class="table table-striped table-bordered datatable" >
																<thead >
																	<tr >
                                                                        <th>Actividad</th>
																		<th>Descripci&oacute;n  </th>
																		<th>Responsable</th>
																		<th>Fecha inicio</th>
																		<th>Fecha conclusi&oacute;n </th>
																		<th>Porcentaje completado  </th>
																		<th>Documentos  </th>
																	</tr>
																</thead>
																<tbody >
																	<?php
																		$identi_tarea=0;
																		while($row = mysql_fetch_array($resultado)) {

                                                                            $separador = "SELECT t.id_tarea, u.id_usuario, age.id_actividad, age.entrega_producto, age.descripcion
                                                                                        FROM tarea t, usuario u, actividad_grupo_empresa age
                                                                                        WHERE t.responsable = u.id_usuario
                                                                                        AND u.id_usuario =".$row["id_usuario"]."
                                                                                        AND t.actividad = age.id_actividad
                                                                                        AND age.id_actividad =".$row["id_actividad"]."
                                                                                        AND age.entrega_producto =".$id_subsistema[$i]."
                                                                                        AND t.id_tarea =".$row["id_tarea"];
                                                                            $descri = mysql_query($separador);
                                                                            $des = mysql_fetch_array($descri);
																			echo "
																			<tr>
                                                                                <td>".$des["descripcion"]."</td>
																				<td>".$row["descripcion"]."</td>
																				<td>".$row["nombre"]." ".$row["apellido"]."</td>
																				<td>".$row["fecha_inicio"]."</td>
																				<td>".$row["fecha_fin"]."</td>
																				<td>".$row["porcentaje_completado"]."</td>";
																				$arx=$row["resultado_obtenido"];
																				if(strcmp($arx," ")==0 || $arx==NULL){
																					echo "<td>No existe registro</td>";          }
																				else{
																					echo " <td > <a href= ".$row["resultado_obtenido"]."> <i class=\"icon-zoom-in\"></i> Ver Avance</a></td>";
																				}
																			echo "	</tr> ";
																			$identi_tarea++;
																		}
																	?>
																</tbody>
															</table>
															<?php
														}
														else{ ?>
															<center><h4><i class="icon-info-sign"></i>
															No se encontr&oacute; ning&uacute;n registro</h4></center>
															<?php
														}
													?>
												
											<?php
										}
										else{ ?>
											<center><h4><i class="icon-info-sign"></i>
											No se encontr&oacute; ning&uacute;n registro</h4></center>
											<?php
										}
									?>
									</div>
									</div>
									</div>
									</div>
								<?php
									$i++; }
								?>
							</div>
						</div>
                    </div>
                </div>

<!--AQUI TERMINA LAS MODIFICACIONES PARA MOSTRAR TAREAS, ACTIVIDADES Y SUBSISTEMAS EN UNA SOLA PANTALLA-->
                   <?php 
                   }else{ ?>
                    <div class="row-fluid">
        <div class="box span12">

            <div class="box-header well">
              <h2><i class="icon-calendar"></i> Cronograma de entrega de subsistemas</h2>
            </div>
            <div class="box-content alerts">
                <center><h4><i class="icon-info-sign"></i> La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4></center>
            </div>
          </div><!--/span-->
        </div><!-- fin row -->
               <?php    }  ?>


<?php include('footer.php'); ?>
