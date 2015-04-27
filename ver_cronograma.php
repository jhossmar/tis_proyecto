<?php
$titulo="Administrar Grupo Empresas";
include('conexion/verificar_gestion.php');
session_start();
if(isset($_GET['entreprod'])){
	$id_grupoem=$_GET['entreprod'];
}else{header("Location: administrar_grupo.php");}
$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
			or die("Error no se pudo realizar cambios.");
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
$consulta_id_ge = mysql_query("SELECT g.nombre_corto,g.nombre_largo
                                FROM grupo_empresa g
                                WHERE g.id_grupo_empresa =$id_grupoem",$conn)  or die("Could not execute the select query.");
$resultado_no_ge = mysql_fetch_assoc($consulta_id_ge);
$rep_no_ge=$resultado_no_ge['nombre_largo'];
if (isset($_GET['enviar_10'])) {
    if (!isset($_GET['newsletter_10'])) { //si no ha sido validado
        $observacion=$_GET['observacion'];
        $sobre_a_env=$_GET['sobre_a'];
        $sobre_b_env=$_GET['sobre_b'];
        $sql = "UPDATE grupo_empresa
        SET  sobre_a=NULL, sobre_b=NULL, observacion='$observacion',habilitado=0
        WHERE id_grupo_empresa=$id_grupoem ";
        $result = mysql_query($sql,$conn);
        ///BORRAR ARCHIVOS
        unlink($sobre_a_env);
        unlink($sobre_b_env);
        header("Location: administrar_grupo.php");
    }
    elseif (isset($_GET['newsletter_10'])) {
        $sql = "UPDATE grupo_empresa
        SET  observacion=NULL,habilitado=1
        WHERE id_grupo_empresa=$id_grupoem";
        $result = mysql_query($sql,$conn);
         header("Location: administrar_grupo.php");
    }
}
   if(isset( $_GET["guardar"] )){
           $count=$_GET['count'];
           $co=0;
           while($co<$count){
                  $id_entre_up=$_GET["ni".$co];
                  $id_pago=$_GET["".$co];
                  $sql = "UPDATE entrega_producto SET  pago_recibido='$id_pago' WHERE id_entrega_producto= $id_entre_up ";
                  $result = mysql_query($sql);
                  $co+=1;
           }

   }

    if(isset( $_GET["enviar2"] )){
           $count=$_GET['cou'];
           $co=0;
           while($co<$count){           //ep.doc,ep.artefactos,ep.metodologia,ep.sistema,ep.id_entrega_producto
                  $id_entre_up=$_GET["ei".$co];
                  $pagoreal=$_GET["pagoreal".$co];
                  $sql = "UPDATE entrega_producto SET  pago_recibido='$pagoreal'  WHERE id_entrega_producto= $id_entre_up ";
                  $result = mysql_query($sql);
                  $co+=1;
           }

   }

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
						<a href="administrar_grupo.php">Administrar Grupo Empresas</a>
                        <span class="divider">/</span>
					</li>
					<li>
						<a href="ver_cronograma.php?entreprod=<?php echo $id_grupoem;?>">Cronograma de entrega de subsistemas</a>
					</li>
				</ul>
			</div>
			<center><h3>Grupo Empresa: <?php echo " ".$rep_no_ge;  ?></h3></center>
     <div class="row-fluid">
        <div class="box span12" id="print">
          <div class="box-header well" data-original-title>
            <h2><i class="icon-check"></i> Documentaci&oacute;n de la Grupo Empresa</h2>
          </div>
          <div class="box-content">
            <?php
              $consulta = "SELECT id_grupo_empresa,sobre_a,sobre_b,observacion,habilitado
                                FROM grupo_empresa g
                                WHERE id_grupo_empresa=$id_grupoem";
              $res = mysql_query($consulta);
              $row= mysql_fetch_array($res);
              $validado=NULL;
              if ($row['habilitado']==1) {
                      $validado="checked";
                      echo "<p class='control-label'>Los siguientes documentos han sido aceptados:</p>";
                }
               if (!is_null($row['sobre_a']) && !is_null($row['sobre_b'])) {

            ?>
            <form name="form-data" class="form-horizontal cmxform" method="GET" id="signupForm" action="ver_cronograma.php" accept-charset="utf-8">
              <input type="hidden" id="entreprod" name="entreprod" value="<?php echo $id_grupoem; ?>" ></input>
              <input type="hidden" id="sobre_a" name="sobre_a" value="<?php echo $row['sobre_a']; ?>" ></input>
              <input type="hidden" id="sobre_b" name="sobre_b" value="<?php echo $row['sobre_b']; ?>" ></input>
              <div class="control-group">
                  <label class="control-label">Sobre A: </label>
                  <div class="controls">
                  <label class="control-label2"><a href="<?php echo $row['sobre_a']; ?>"><i class="icon-download-alt"></i> Descargar</a> </label>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Sobre B: </label>
                  <div class="controls">
                  <label class="control-label2"><a href="<?php echo $row['sobre_b']; ?>"><i class="icon-download-alt"></i> Descargar</a></label>
                  </div>
                </div>
                <?php if ($row['habilitado']==0) {
                 ?>
                <div class="control-group">
                  <label class="control-label">Aceptar documentos: </label>
                  <div class="controls">
                  <input type="checkbox" value="actividad_10" class="checkbox" id="actividad_10" name="newsletter_10" <?php echo $validado; ?> />
                  </div>
                </div>
                <fieldset id="actividad_10_topics">
                <div class="control-group">
                  <label class="control-label">Observaci&oacute;n:</label>
                  <div class="controls">
                    <textarea id="observacion" name="observacion" placeholder="Realizar observacion"><?php echo $row['observacion']; ?></textarea>
                  </div>
                </div>
                </fieldset>
                <div class="control-group">
                  <div class="controls">
                     <button name="enviar_10"type="submit" class="btn btn-primary" id="enviar_10"><i class="icon-ok"></i> Aceptar</button>
                 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
                 </div>
                 </div>
                    <?php  # code...
                } ?>
              </form>
              <?php if ($row['habilitado']==0) {
                 ?>
              <label><b>Nota:</b> Una vez aceptada la documentaci&oacute;n la Grupo Empresa correspondiente podr&aacute; realizar la planificaci&oacute;n de sus actividades.</label>
              <?php
              }
            }
              else{
                echo "<div align=\"center\">
                                <h4><i class=\"icon-info-sign\"></i>
                                La Grupo Empresa no cuenta con ning&uacute;n documento.</h4>
                                </div>";
                              }
              ?>
          </div>
        </div>
      </div>


			<div class="row-fluid">
		            <div class="box span12" id="print">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-check"></i> Cronograma de entrega de subsistemas y pagos</h2>

					</div>
					<div class="box-content">
						<?php if($gestion_valida) {
                              include('conexion/conexion.php');
                               $integrantes ="SELECT ep.descripcion,u.nombre,u.apellido,ep.fecha_inicio,ep.fecha_fin,ep.pago_recibido ,ep.id_entrega_producto,ep.enlace_producto
                                              FROM entrega_producto ep, usuario u
                                              WHERE ep.grupo_empresa=$id_grupoem
											  AND ep.id_responsable=u.id_usuario
											  ";
                               $resultado = mysql_query($integrantes);
                               $num_res=mysql_num_rows($resultado);
                              if ($num_res>0) {
							?>
							<form name="form-data" class="form-horizontal cmxform" method="GET" action="ver_cronograma.php" accept-charset="utf-8">
              <input type="hidden" id="entreprod" name="entreprod" value=<?php echo $id_grupoem; ?> ></input>
							<table class="table table-striped table-bordered" >
							  <thead >
								  <tr >
									 	  <th>Descripci&oacute;n  </th>
										  <th>Responsable</th>
										  <th>Fecha inicio</th>
										  <th>Fecha Conclusi&oacute;n </th>
										  <th >Avance</th>

								  </tr>
							  </thead>
							  <tbody >

                            <?php
                               $identi=0;
                                while($row = mysql_fetch_array($resultado)) {

                                $arx=$row["enlace_producto"];
                               echo "
                                <tr>
    								  <td >".$row["descripcion"]."</td>
									  <td >".$row["nombre"].' '.$row["apellido"]."</td>
    								   <td>".$row["fecha_inicio"]."</td>
    								  <td>".$row["fecha_fin"]."</td>
                                       ";

									   if($arx==""||$arx==NULL){
									echo "<td>No existe registro</td>";
								}
								else{
									echo"<td class=\"center\"> <a href= ".$arx."> <i class=\"icon-zoom-in\"></i> Ver Avance</a></td>";
								}
                                     echo "<input type=\"hidden\" id=\"ni".$identi."\" name=\"ni".$identi."\" value=\"".$row["id_entrega_producto"]."\"></input>";
                        		 echo "	</tr> ";
                                 $identi++;
                                }
                             ?>

                               <input type="hidden" id="count" name="count" value=<?php echo $identi; ?> ></input>
						  </tbody>
					  </table>

                    </form>
                    <?php 	}
                            else{
                            	echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No existe ningun cronograma de la Grupo Empresa.</h4>
				                      	</div>";
                            }
                        }
                   		 else{
                   		 	echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        Debe habilitar una gestion.</h4>
				                      	</div>";
                   		 }
                    ?>
					</div>
				</div><!--/span-->
				</div>

                <?php
                 if($gestion_valida && $num_res>0){
                  ?>
                  <div class="row-fluid">
        		            <div class="box span12" id="print">
        					<div class="box-header well" data-original-title>
        						<h2><i class="icon-check"></i> Evaluaci&oacute;n de Subsistemas</h2>
                            </div>
        					<div class="box-content">
                            <form name="form1" class="form-horizontal cmxform" method="GET" action="ver_cronograma.php" accept-charset="utf-8" >
                            <br>

                            <input type="hidden" id="id_gep" name="id_gep"   value=<?php echo $id_grupoem; ?> ></input>
						  	<input type="hidden" id="no_gru" name="no_gru" value=<?php echo $rep_no_ge; ?> ></input>
                            <table class="table table-striped table-bordered" >
							  <thead >
								  <tr >
										<th>Descripci&oacute;n  </th>
										<th>Porcentaje estimado</th>
										<th >Porcentaje real</th>
										<th>Pago establecido</th>

										<th>Pago real</th>
										<th>Obsevaciones</th>
                                  </tr>
							  </thead>
							  <tbody >
                                                                       <?php
                                                                       $cal ="SELECT ep.descripcion,ep.id_entrega_producto,ep.enlace_producto,ep.pago_establecido,ep.pago_recibido
                                                                                      FROM entrega_producto ep
                                                                                      WHERE ep.grupo_empresa=$id_grupoem";
                                                                         $eva = mysql_query($cal);
                                                                         $cou=0;
                                                                          while($row = mysql_fetch_array( $eva )) {
																		  $id_entre=$row["id_entrega_producto"];
																		$consulta2 = mysql_query("SELECT COUNT(*) as n,SUM(age.porcentaje_completado) as s
																									FROM actividad_grupo_empresa age
																									WHERE age.entrega_producto= $id_entre",$conn)  or die("Could not execute the select query.");
																		$resultado2 = mysql_fetch_assoc($consulta2);
																		$resn=(int)$resultado2['n'];
																		$ress=(int)$resultado2['s'];
																		$pagorecibido = $row["pago_recibido"];
																		$porcentaje=0;
																		if($resn>0&$ress>0){
																			$porcentaje = number_format(($ress/$resn), 2, '.', '');
																		}

																			$pagosugerido="pagosugerido";
                                                                            	 echo "	<tr> ";
                                                                         echo "<td>".$row["descripcion"]."</input></td>";
																		 echo "<td>".$porcentaje."</td>
																				<td><input type='text' id=miCampo2".$cou." name=\"$porcentaje\" value=\"".$porcentaje."\"    style=\"width: 80px; !important\" onkeyup=calcula(".$row["pago_establecido"].",".$cou.") />  </td>";
                                                                         echo "<td>".$row["pago_establecido"]."</td>";

                                                                         echo "<td><input style=\"width: 50px;\"  type=\"text\" id=\"pagoreal".$cou."\" name=\"pagoreal".$cou."\" value=\"".$pagorecibido."\"  ></input></td>";

																		  //--------------------------LUGAR MODIFICADO PARA EDITAR OBSERVACIONES



																		  echo "<td><center><a class=\"btn btn-success\" href=\"editarObservacion.php?value=".$row["id_entrega_producto"]."&value2=".$id_grupoem."\">
																	<i class=\"icon-check icon-white\"></i>
																	Observación
																	</a></center></td>";

                                                                          echo "<input type=\"hidden\" id=\"ei".$cou."\" name=\"ei".$cou."\" value=\"".$row["id_entrega_producto"]."\"></input>";

                                                                          echo "	</tr> ";
                                                                        $cou++;

                                                                       }
                                                                        echo "<input type=\"hidden\" id=\"cou\" name=\"cou\" value=\"".$cou."\"></input>";
                                                                        echo "<input type=\"hidden\" id=\"entreprod \" name=\"entreprod\" value=\"".$id_grupoem."\"></input>";

                                                                        ?>

                                    </tbody>
					         </table>
                                  <button name="enviar2"type="submit" class="btn btn-primary" id="enviar2"><i class="icon-ok"></i> Guardar cambios</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>



                            </form>
                            </div>
        				</div><!--/span-->
                </div>


<!--AQUI EMPIEZA LA SEGUNDA ALTERNATIVA (TAREAS Y ACTIVIDADES JUNTAS)-->

<div class="row-fluid">
<div class="box span12">
    <div class="box-header well">
        <h2><i class="icon-check"></i> Ver Actividades y Tareas por Subsistema </h2>
        <div class="box-icon">
		    <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
		</div>
    </div>
    <div class="box-content">
    <div class="control-group">
    <?php
        $subsistemas = "SELECT ep.descripcion, ep.id_entrega_producto
                    FROM entrega_producto ep
                    WHERE ep.grupo_empresa=$id_grupoem";
        $cons = mysql_query($subsistemas);
        $num_subs=mysql_num_rows($cons);
        if($num_subs > 0){
            while($rows = mysql_fetch_array($cons)){
    ?>
                <div class="row-fluid">
		        <div class="box span12">
                    <div class="box-header well">
                        <h2><i class="icon-check"></i> <?php echo $rows["descripcion"];?> </h2>
                    <div class="box-icon">
		                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
		            </div>
                    </div>

                    <div class="box-content">
                    <div class="control-group">
                    <?php
                        $actividades = "SELECT age.descripcion,age.fecha_inicio,age.fecha_fin,age.porcentaje_completado,us.nombre,us.apellido
                                        FROM actividad_grupo_empresa age, usuario us
                                        WHERE age.entrega_producto = ".$rows['id_entrega_producto']." and age.id_responsable = us.id_usuario";
                        $consac = mysql_query($actividades);
                        $num_act = mysql_num_rows($consac);
                        if($num_act > 0){
                    ?>
                            <div align="center">
                                <h4>Actividades</h4>
                                <br>
                            </div>
                                <table class="table table-striped table-bordered datatable" >
                                <thead>
                                    <tr>
                                        <th>Descripci&oacute;n </th>
                                        <th>Responsable</th>
                                        <th>Fecha inicio</th>
                                        <th>Fecha Conclusi&oacute;n</th>
                                        <th>Avance (%)</th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $identi = 0;
                                    while( $rowsac = mysql_fetch_array($consac)){
                                    echo "<tr>";
                                    echo "<td >".$rowsac["descripcion"]."</td>
									    <td >".$rowsac["nombre"].' '.$rowsac["apellido"]."</td>
    								    <td>".$rowsac["fecha_inicio"]."</td>
    								    <td>".$rowsac["fecha_fin"]."</td>
                                        <td>".$rowsac["porcentaje_completado"]."</td>";
                                    echo "</tr>";
                                    $identi++;
                                    }
                                ?>
                                </tbody>
                                </table>
                                <br>
                                <?php
                                    $tareas = "SELECT t.id_tarea, u.id_usuario, t.descripcion, u.nombre, u.apellido, t.fecha_inicio, t.fecha_fin, t.porcentaje_completado, t.resultado_obtenido, age.id_actividad, age.entrega_producto
                                                FROM tarea t, usuario u, actividad_grupo_empresa age
                                                WHERE t.responsable = u.id_usuario
                                                AND t.actividad = age.id_actividad
                                                AND age.entrega_producto =".$rows['id_entrega_producto'];
                                    $conta = mysql_query($tareas) or die ("no se puede ejecutar conta");
                                    $num_tar = mysql_num_rows($conta);
                                    if($num_tar > 0){
                                ?>
                                        <div align="center">
                                            <h4>Tareas</h4>
                                        <br>
                                        </div>
                                        <table class="table table-striped table-bordered datatable">
                                            <thead>
                                                <tr>
                                                    <th>Actividad</th>
                                                    <th>Descripci&oacute;n</th>
                                                    <th>Responsable</th>
                                                    <th>Fecha inicio</th>
                                                    <th>Fecha Conclusi&oacute;n</th>
                                                    <th>Avance (%)</th>
                                                    <th>Documentos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    <?php
                                        $identia = 0;
                                            while($rowsta = mysql_fetch_array($conta)){

                                            $descri = "SELECT t.id_tarea, u.id_usuario, age.id_actividad, age.entrega_producto, age.descripcion
                                                        FROM tarea t, usuario u, actividad_grupo_empresa age
                                                        WHERE t.responsable = u.id_usuario
                                                        AND u.id_usuario =".$rowsta["id_usuario"]."
                                                        AND t.actividad = age.id_actividad
                                                        AND age.id_actividad =".$rowsta["id_actividad"]."
                                                        AND age.entrega_producto =".$rows["id_entrega_producto"]."
                                                        AND t.id_tarea =".$rowsta["id_tarea"];
                                            $descr = mysql_query($descri);
                                            $des = mysql_fetch_array($descr);
                                                echo "<tr>

                                                    <td>".$des["descripcion"]."</td>
    								                <td>".$rowsta["descripcion"]."</td>
									                <td>".$rowsta["nombre"]." ".$rowsta["apellido"]."</td>
    								                <td>".$rowsta["fecha_inicio"]."</td>
    								                <td>".$rowsta["fecha_fin"]."</td>
                                                    <td>".$rowsta["porcentaje_completado"]."</td>";

                                           $arx=$rowsta["resultado_obtenido"];
                                      if(strcmp($arx," ")==0 || $arx==NULL){
                                            echo "<td>No existe registro</td>";
                                      }else{
                                        echo"<td class=\"center\"> <a href= ".$arx."> <i class=\"icon-zoom-in\"></i> Ver Avance</a></td>  ";
                                      }
                                        echo "	</tr> ";
                                            $identia++;
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                <?php
                                    }else{
                                ?>
                                    <center><h4><i class="icon-info-sign"></i>
			                        Subsistema <?php echo $rows["descripcion"];?> no cuenta con Tareas</h4></center>
                                <?php
                                    }
                        }else{
                    ?>
                        <center><h4><i class="icon-info-sign"></i>
			            Subsistema <?php echo $rows["descripcion"];?> no cuenta con Actividades</h4></center>
                    <?php
                        }
                    ?>
                    </div>
                    </div>
                </div>
                </div>
        <?php
            }
        }else{
        ?>
            <center><h4><i class="icon-info-sign"></i>
			No se encontr&oacute; ning&uacute;n registro de subsistemas</h4></center>
        <?php
        }
    ?>
    </div>
    </div>
</div>
</div>
<!--AQUI TERMINA LA SEGUNDA ALTERNATIVA DE ENTABULADO (TAREAS Y ACTIVIDADES EN UNA SOLA PLANA)-->

        <div class="row-fluid">
        <div class="box span12">
            <div class="box-header well">
              <h2><i class="icon-tasks"></i> Gr&aacute;ficos de Pagos de Subsistemas</h2>
            </div>
            <div class="box-content alerts">
                <div id="chartdiv" style="width: 100%; height: 600px;"></div>
            </div>
          </div><!--/span-->
        </div><!-- fin row -->




                    <?php
                    }
            $consulta = "SELECT descripcion, pago_establecido, pago_recibido
                  FROM entrega_producto
                  WHERE grupo_empresa = $id_grupoem";
                  $resultado = mysql_query($consulta);?>
        <script src="js/amcharts.js" type="text/javascript"></script>
        <script src="js/serial.js" type="text/javascript"></script>

        <!-- scripts for exporting chart as an image -->
        <!-- Exporting to image works on all modern browsers except IE9 (IE10 works fine) -->
        <!-- Note, the exporting will work only if you view the file from web server -->
        <!--[if (!IE) | (gte IE 10)]> -->
        <script src="js/exporting/amexport.js" type="text/javascript"></script>
        <script src="js/exporting/rgbcolor.js" type="text/javascript"></script>
        <script src="js/exporting/canvg.js" type="text/javascript"></script>
        <script src="js/exporting/jspdf.js" type="text/javascript"></script>
        <script src="js/exporting/filesaver.js" type="text/javascript"></script>
        <script src="js/exporting/jspdf.plugin.addimage.js" type="text/javascript"></script>
        <script src="js/light.js" type="text/javascript"></script>
        <!-- <![endif]-->

        <script type="text/javascript">
            var chart;

            chart = AmCharts.makeChart("chartdiv", {
                type: "serial",
                pathToImages:"img/",
                theme: "light",
                dataProvider: [<?php
                  while($row = mysql_fetch_array($resultado)) {
                    echo"{
                      \"year\": '".$row['descripcion']."',
                        \"income\": '".$row['pago_establecido']."',
                        \"expenses\": '".$row['pago_recibido']."'
                      },";
            }
                ?>],
                categoryField: "year",
                startDuration: 1,

                categoryAxis: {
                   // as our data is date-based, we set parseDates to true
                  dashLength : 1,
                  gridAlpha : 0.15,
                  axisColor : "#DADADA",
                    gridPosition: "start",
                    labelRotation: 45
                },
                valueAxes: [{
                    title: "Dólares ($)"
                }],
                graphs: [{
                    type: "column",
                    title: "Pago Establecido",
                    valueField: "income",
                    lineAlpha: 0,
                    fillAlphas: 0.8,
                    balloonText: "[[title]] en [[category]]:<b>[[value]] $</b>"
                }, {
                    type: "line",
                    title: "Pago Recibido",
                    valueField: "expenses",
                    lineThickness: 2,
                    fillAlphas: 0,
                    bullet: "round",
                    balloonText: "[[title]] en [[category]]:<b>[[value]] $</b>",
                    bulletBorderColor : "#FFFFFF",
                  bulletBorderThickness : 2,
                  bulletBorderAlpha : 1,
                  lineThickness : 2,
                  lineColor : "#5fb503",
                  negativeLineColor : "#efcc26",
                  hideBulletsCount : 50
                }],

                legend: {
                    useGraphSettings: true
                },
                amExport: {
                    top: 21,
                    right: 21,
                    buttonColor: '#EFEFEF',
                    buttonRollOverColor:'#DDDDDD',
                    exportPNG:true,
                    exportJPG:true,
                    exportPDF:true,
                    exportSVG:true
                }
            });

            // column chart
        </script>
		<!-- script para calcular precio automaticamente -->
		<script language="javascript">
        function calcula(pago,fila){
        if(document.getElementById('miCampo2'+fila).value<=100 && document.getElementById('miCampo2'+fila).value>=0 ){
        var cant=document.getElementById('miCampo2'+fila).value
        var res = (cant*0.01)*pago;
         document.getElementById('pagoreal'+fila).value=res;

		}
        }
</script>
<?php include('footer.php'); ?>