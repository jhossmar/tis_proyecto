<?php
$titulo="Ver Actividades Grupo Empresas";
include('conexion/verificar_gestion.php');
session_start();
if(isset($_GET['id_gep']) && isset($_GET['no_gru']) && isset($_GET['entreprod'])){
	$id_grupoem=$_GET['id_gep'];
	$nom_grupoem=$_GET['no_gru'];
	$id_entre= $_GET['entreprod'];
}else{
	header("Location:administrar_grupo.php");
}
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

$consulta_id_ge = mysql_query("SELECT ep.descripcion
                                FROM entrega_producto ep
                                WHERE ep.id_entrega_producto=$id_entre",$conn)  or die("Could not execute the select query.");
$resultado_no_ge = mysql_fetch_assoc($consulta_id_ge);
$rep_no_ge=$resultado_no_ge['descripcion'];
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
						<a href="administrar_grupo.php">Cronograma de entrega de subsistemas</a>
                        <span class="divider">/</span>
					</li>
                    <li>
						<a href="administrar_grupo.php">Actividades</a>
					</li>


				</ul>
			</div>
			<center><h3>Grupo empresa <?php echo " ".$nom_grupoem;  ?></h3></center>
			<div class="row-fluid">
		            <div class="box span12" id="print">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-check"></i>Actividades del subsistema : <?php echo " ".$rep_no_ge;  ?></h2>

					</div>
					<div class="box-content">
						<?php if($gestion_valida) {
                              include('conexion/conexion.php');
                               $integrantes ="SELECT age.descripcion,u.nombre,u.apellido,age.fecha_inicio,age.fecha_fin,age.porcentaje_completado
                                                FROM actividad_grupo_empresa age, usuario u
                                                WHERE age.entrega_producto=$id_entre
												AND age.id_responsable = u.id_usuario
												";
                               $resultado = mysql_query($integrantes);
                               $num_res=mysql_num_rows($resultado);
                              if ($num_res>0) {
							?>
							<form name="form-data" class="form-horizontal cmxform" method="GET" action="conexion/validar_grupo.php" accept-charset="utf-8">
							<table class="table table-striped table-bordered  datatable" >
							  <thead >
								  <tr >
									 	  <th>Descripci&oacute;n</th>
										  <th>Responsable</th>
										  <th>Fecha inicio</th>
										  <th>Fecha Conclusi&oacute;n</th>
										  <th>Avance (%)</th>
                                          
								  </tr>
							  </thead>
							  <tbody >

                            <?php
                               $identi=0;
                                while($row = mysql_fetch_array($resultado)) {

                               echo "
                                <tr>
    								  <td >".$row["descripcion"]."</td>
									  <td >".$row["nombre"].' '.$row["apellido"]."</td>
    								   <td>".$row["fecha_inicio"]."</td>
    								  <td>".$row["fecha_fin"]."</td>
                                       <td>".$row["porcentaje_completado"]."</td>";
                        		 echo "	</tr> ";
                                 $identi++;
                                }
                             ?>

						  </tbody>
					  </table>

                    </form>
                    <?php 	}
                            else{
                            	echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No existe ninguna actividad programada .</h4>
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
                 if($num_res>0){
                  ?>
                <div class="row-fluid">
        		            <div class="box span12" id="print">
        					<div class="box-header well" data-original-title>
        						<h2><i class="icon-check"></i>Ver tareas de la actividad </h2>
                            </div>
        					<div class="box-content">
                            <form name="form1" class="form-horizontal cmxform" method="GET" action="ver_tarea.php" accept-charset="utf-8" >
                            <br>
                            <div class="control-group">

                            <input type="hidden" id="id_gep" name="id_gep" value=<?php echo $id_grupoem; ?> ></input>
						  	<input type="hidden" id="no_gru" name="no_gru" value=<?php echo $nom_grupoem; ?> ></input>

                                   <label class="control-label">  Actividad &emsp;</label>

                                    <div class="controls">
                                                  <?php    echo "     <select id=\"entreprod\" name=\"entreprod\" data-rel=\"chosen\">";
                                                                                //busca todas las emtregas de producto de la grupo empresa
                                                                                  $integrantes ="SELECT age.descripcion,age.fecha_inicio,age.fecha_fin,age.porcentaje_completado,age.id_actividad
                                                                                                  FROM actividad_grupo_empresa age
                                                                                                  WHERE age.entrega_producto=$id_entre";
                                                                                       $resultado = mysql_query($integrantes);
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
								 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								 </div>
								 </div>


                            </form>
                            </div>
        				</div><!--/span-->
                </div>
                    <?php
                    }
                    ?>

<?php include('footer.php'); ?>