<?php
if(isset($_GET['entreprod'])){
  $id_sub=$_GET['entreprod'];
}else{
  header('Location: cronograma_grupo_integra.php');
}
$titulo="Actividades del subsistema";
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

$consulta_no_sub = mysql_query("SELECT ep.descripcion
                                FROM entrega_producto ep
                                WHERE ep.id_entrega_producto=".$id_sub."",$conn)  or die("Could not execute the select query.");
$resultado_no_sub = mysql_fetch_assoc($consulta_no_sub);
$no_sub=$resultado_no_sub['descripcion'];
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
						<a href='cronograma_grupo_integra.php'> Cronograma de entrega de subsistemas </a> <span class="divider">/</span>
					</li>
                    <li>
						<a href='actividades_grupo_integra.php?entreprod=<?php echo $id_sub;?>'> Actividades </a>
					</li>
				</ul>
			</div>
			<center><h3> Grupo empresa <?php echo "".$no_ge;  ?></h3></center>
			<div class="row-fluid">
				<div class="box span12 " id="print">
						<div class="box-header well">
							<h2><i class="icon-calendar"></i> Actividades del subsistema: <?php echo "".$no_sub;  ?></h2>
						</div>
						<div class="box-content padding-in" style="text-align:left;" >
						 <div class="row-fluid">
						   <!--	 <div class="span12" style="padding:10px;"> </div>    -->
                             <?php

                              $entregas ="SELECT ac.descripcion,ac.fecha_inicio,ac.fecha_fin,ac.porcentaje_completado,ac.id_actividad
                                          FROM actividad_grupo_empresa ac
                                          WHERE ac.entrega_producto=$id_sub";
                              $resultado = mysql_query($entregas);
                              $num_entre=mysql_num_rows($resultado);
                                if($num_entre>0){    ?>
                                    <!--    <form name="form-data" class="form-horizontal cmxform" method="GET" action="conexion/validar_grupo.php" accept-charset="utf-8">     -->
                    							<table class="table table-striped table-bordered datatable" >
                            							  <thead >
                            								  <tr >
                          									 	  <th>Descripci&oacute;n  </th>
                          										  <th>Fecha inicio</th>
                          										  <th>Fecha Conclusi&oacute;n </th>
                          										  <th>Porcentaje completado  </th>
                            								  </tr>
                            							  </thead>
                            							  <tbody >
                                                             <?php
                                                               $identi=0;
                                                                while($row = mysql_fetch_array($resultado)) {
                                                               echo "
                                                                <tr>
                                    								   <td>".$row["descripcion"]."</td>
                                    								   <td>".$row["fecha_inicio"]."</td>
                                    								   <td>".$row["fecha_fin"]."</td>
                                                                       <td>".$row["porcentaje_completado"]."</td>";
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


                      <?php
                      if($num_entre>0){
                        ?>

            <div class="row-fluid">
				        <div class="box span12 " id="print">
        						<div class="box-header well">
        							<h2><i class="icon-check"></i> Ver tareas de la actividad </h2>
        						</div>
        						<div class="box-content padding-in" style="text-align:left;" >
            						 <div class="row-fluid">
                                      <form name="form-data" class="form-horizontal cmxform" method="GET" action="tareas_grupo_integra.php" accept-charset="utf-8">

                                                          <br>
                                       <div class="control-group">


                                   <label class="control-label">  Actividad &emsp;</label>

                                    <div class="controls">
                                                  <?php    echo "     <select id=\"entreprod\" name=\"entreprod\" data-rel=\"chosen\">   ";
                                                                                //busca todas las emtregas de producto de la grupo empresa
                                                                                       $resultado = mysql_query($entregas);
                                                                                  while($row = mysql_fetch_array($resultado)) {
                                                                                            echo "<option value=\"".$row['id_actividad']."\">".$row['descripcion']."</option>";
                                                                                  }
                                                                         echo "	</select>  ";
                                                  ?>
                                        	</div>

                                   </div>


                                  <div class="control-group">
								<div class="controls">
                                  <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Ver tareas</button>
								 </div>
								 </div>






                                         </form>

                                      </div>
                                 </div>
                         </div>
                </div>

                   <?php }  ?>


<?php include('footer.php'); ?>
