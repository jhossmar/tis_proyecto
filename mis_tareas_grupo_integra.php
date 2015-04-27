<?php
$titulo="Mis tareas";
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
if($gestion_valida){
$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
or die("Error no se pudo realizar cambios.");
}
$consulta_id_ge = mysql_query("SELECT ge.id_grupo_empresa ,ge.nombre_corto
                               FROM integrante i,grupo_empresa ge
                               WHERE i.usuario=".$_SESSION['id']." and i.grupo_empresa=ge.id_grupo_empresa",$conn)  or die("Could not execute the select query.");
$resultado_id_ge = mysql_fetch_assoc($consulta_id_ge);
$id_ge=$resultado_id_ge['id_grupo_empresa'];
$no_ge=$resultado_id_ge['nombre_corto'];

  if(isset($_POST['enviar'])){
    $ta=$_POST['entreprod'];
	$url=$_POST['co_url'];
	$avance=$_POST['avance'];
        $sql = "UPDATE tarea SET  porcentaje_completado='$avance', resultado_obtenido='$url' WHERE id_tarea ='$ta'";
                      $result = mysql_query($sql);
                             $consulta = mysql_query("SELECT t.actividad
                                                        FROM tarea t
                                                        WHERE t.id_tarea=$ta",$conn)  or die("Could not execute the select query.");
                            $resultado = mysql_fetch_assoc($consulta);
                            $id_act=$resultado['actividad'];
                            $consulta = mysql_query("SELECT COUNT(*) as n,SUM( t.porcentaje_completado) as s
                                                      FROM tarea t
                                                      WHERE t.actividad =$id_act",$conn)  or die("Could not execute the select query.");
                            $resultado = mysql_fetch_assoc($consulta);
                            $porseActividad=$resultado['s'];
							$numActividad=$resultado['n'];
							$porseActividad=$porseActividad/$numActividad;

                      $sql = "UPDATE actividad_grupo_empresa SET  porcentaje_completado='$porseActividad' WHERE id_actividad = '$id_act'";
                      $result = mysql_query($sql);


    // header("Location: mis_tareas_grupo_integra.php");

  }
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
						<a href='mis_tareas_grupo_integra.php'> Mis Tareas </a>
					</li>
				</ul>
			</div>
			<center><h3> Grupo empresa <?php echo "".$no_ge;  ?></h3></center>
      <?php if($gestion_valida){
      ?>
			<div class="row-fluid">
				<div class="box span12 " id="print">
						<div class="box-header well">
							<h2><i class="icon-calendar"></i> Tareas asignadas</h2>
						</div>
						<div class="box-content padding-in" style="text-align:left;" >
						 <div class="row-fluid">
						   <!--	 <div class="span12" style="padding:10px;"> </div>    -->
                             <?php

                              $entregas ="SELECT t.descripcion as ta,t.fecha_inicio,t.fecha_fin,t.porcentaje_completado ,age.descripcion as act,ep.descripcion as enp ,t.id_tarea,t.resultado_obtenido
                                          FROM tarea t,actividad_grupo_empresa age,entrega_producto ep
                                          WHERE t.responsable=".$_SESSION['id']." and t.actividad=age.id_actividad and age.entrega_producto=ep.id_entrega_producto";
                              $resultado = mysql_query($entregas);
                              $num_entre=mysql_num_rows($resultado);
                                if($num_entre>0){    ?>
                                    <!--    <form name="form-data" class="form-horizontal cmxform" method="POST" action="conexion/validar_grupo.php" accept-charset="utf-8">     -->
                    							<table class="table table-striped table-bordered  datatable" >
                            							  <thead >
                            								  <tr >
                                                                  <th>Subsistema</th>
                                                                  <th>Actividad</th>
                          									 	  <th>Descripci&oacute;n  </th>
                          										  <th>Fecha inicio</th>
                          										  <th>Fecha conclusi&oacute;n </th>
                          										  <th>Porcentaje completado  </th>
                                                                  <th>Documentos</th>
                            								  </tr>
                            							  </thead>
                            							  <tbody >
                                                             <?php
                                                               $identi=0;
                                                                while($row = mysql_fetch_array($resultado)) {
                                                               echo "
                                                                <tr>
                                                                       <td>".$row["enp"]."</td>
                                                                       <td>".$row["act"]."</td>
                                    								   <td>".$row["ta"]."</td>
                                    								   <td>".$row["fecha_inicio"]."</td>
                                    								   <td>".$row["fecha_fin"]."</td>
                                                                       <td>".$row["porcentaje_completado"]."</td>  ";
                                                                       $arx=$row["resultado_obtenido"];
                                                                      if(strcmp($arx," ")==0 || $arx==NULL){echo "<td>No existe registro</td>";          }
                                                                      else{
                                                                      echo " <td > <a href= ".$row["resultado_obtenido"]."> <i class=\"icon-zoom-in\"></i> Ver Avance</a></td>
                                                                       ";}
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
				                          Usted no tiene tareas asignadas</h4></center>

                               <?php
                                 }
                              ?>
						</div>
		                </div>
				</div>
			</div>


                      <?php
                      if($num_entre>0
                        ){
                        ?>

            <div class="row-fluid">
				        <div class="box span12 " id="print">
        						<div class="box-header well">
        							<h2><i class="icon-check"></i> Registrar avance de tarea  </h2>
        						</div>
        						<div class="box-content padding-in" style="text-align:left;" >
            						 <div class="row-fluid">
                                      <form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="mis_tareas_grupo_integra.php" accept-charset="utf-8">

                                                          <br>
                                       <div class="control-group">


                                   <label class="control-label">  Tarea : </label>

                                    <div class="controls">
                                                  <?php    echo "     <select id=\"entreprod\" name=\"entreprod\" data-rel=\"chosen\">   ";
                                                                                //busca todas las emtregas de producto de la grupo empresa
                                                                                       $resultado = mysql_query($entregas);
                                                                                  while($row = mysql_fetch_array($resultado)) {
                                                                                            echo "<option value=\"".$row['id_tarea']."\">".$row['ta']."</option>";
                                                                                  }
                                                                         echo "	</select>  ";
                                                  ?>
                                    </div>

                                   </div>
                                   <div class="control-group">
								  <label class="control-label" for="co_url">Enlace Avance:</label>
								  <div class="controls">
									<input id="co_url" class="required defaultInvalid url" name="co_url" type="text" value="http://" />
								  </div>
								</div>
                                <div class="control-group">
								  <label class="control-label" for="co_url">Avance:</label>
								  <div class="controls">
                                   <select id="avance" name="avance"   data-rel="chosen">
                                           <option value="10">       10  % </option>
                                           <option value="20">       20  % </option>
                                           <option value="30">       30  % </option>
                                           <option value="40">       40  % </option>
                                           <option value="50">       50  % </option>
                                           <option value="60">       60  % </option>
                                           <option value="70">       70  % </option>
                                           <option value="80">       80  % </option>
                                           <option value="90">       90  % </option>
                                           <option value="100">       100 % </option>
                                   </select>
								  </div>
								</div>


                                            <div class="control-group">
								<div class="controls">

                                 <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Registrar</button>
								 <button type="reset" class="btn">Restablecer</button>
								 </div>
								 </div>

                                         </form>

                                      </div>
                                 </div>
                         </div>
                </div>

                   <?php }
                   }else{ ?>
                      <div class="row-fluid">
        <div class="box span12">
            <div class="box-header well">
              <h2><i class="icon-calendar"></i> Tareas asignadas</h2>
            </div>
            <div class="box-content alerts">
                <center><h4><i class="icon-info-sign"></i> La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4></center>
            </div>
          </div><!--/span-->
        </div><!-- fin row -->
              <?php     }  ?>


<?php include('footer.php'); ?>
