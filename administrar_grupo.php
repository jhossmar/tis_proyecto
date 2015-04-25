<?php
$titulo="Administrar Grupo Empresas";
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
						<a href="administrar_grupo.php">Administrar Grupo Empresas</a>
					</li>
				</ul>
			</div>
			<center><h3>Administrar Grupo Empresas</h3></center>
			<div class="row-fluid">
		            <div class="box span12" id="print">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-check"></i> Grupo Empresas registradas con usted</h2>

					</div>
					<div class="box-content">
						<?php if($gestion_valida) {
                              include('conexion/conexion.php');
                               $integrantes ="SELECT id_usuario,nombre_largo,nombre_corto,nombre,apellido,u.habilitado, u.nombre_usuario,g.id_grupo_empresa
											from grupo_empresa g, usuario u, integrante i
											where g.consultor_tis=$id_usuario AND i.grupo_empresa=g.id_grupo_empresa AND
											i.usuario=u.id_usuario AND u.tipo_usuario=4 AND u.gestion=$id_gestion";
                               $resultado = mysql_query($integrantes);
                               $num_res=mysql_num_rows($resultado);
                              if ($num_res>0) {
							?>
							<form name="form-data" class="form-horizontal cmxform" method="GET" action="conexion/validar_grupo.php" accept-charset="utf-8">
								<input type="hidden" id="consultor" name="consultor" value=<?php echo $id_usuario; ?> ></input>
						  	<input type="hidden" id="gestion" name="gestion" value=<?php echo $id_gestion; ?> ></input>
							<table class="table table-striped table-bordered  datatable" >
							  <thead >
								  <tr >
									 	  <th>Nombre Largo</th>
										  <th>Nombre Corto</th>
										  <th>Representante Legal</th>
										  <th>Nombre de usuario</th>
										  <th style="text-align:center">Habilitado</th>
										  <th style="text-align:center">Reporte</th>
                                          <th>Habilitar Integrantes</th>

								  </tr>
							  </thead>
							  <tbody >
						  	
                            <?php
                               $identi=0;
                                while($row = mysql_fetch_array($resultado)) {

                               echo "
                                <tr>
    								  <td >".$row["nombre_largo"]."</td>
    								  <td><input type=\"hidden\" id=a".$identi." name=a".$identi." value=".$row["id_usuario"]."></input>".$row["nombre_corto"]."</td>

    								  <td>".$row["nombre"]." ".$row["apellido"]."</td>
    								  <td>".$row["nombre_usuario"]."</td>";

                                 $aux= $row["habilitado"];
                                        if($aux=="1"){
                                           echo "<td ><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi."  checked></center></td>";
                                         }
                                         else{
                                            echo "<td class=\"center\"><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi."></center></td>";
                                        }
                                echo    "<td><center><a class=\"btn btn-success\" href=\"reporte.php?value=".$row["id_grupo_empresa"]."\" >
										<i class=\"icon-zoom-in icon-white\"></i>  
										Ver                                           
										</a></center></td>";
//--------------------------LUGAR MODIFICADO PARA HABILITAR INTEGRANTES
                                      echo "<td><center><a class=\"btn btn-success\" href=\"habilitar_integrantes.php?value=".$row["id_grupo_empresa"]."\">
                                        <i class=\"icon-check icon-white\"></i>
                                        Revisar
                                        </a></center></td>";
//--------------------------FIN DE LAS MODIFICACIONES
                        		 echo "	</tr> ";
                                 //echo $identi;
                                 $identi++;
                                }
                             ?>

						  </tbody>
					  </table>




								<div style="padding-left:10px;">
                                  <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar Cambios</button>
                                  <a href="administrar_grupo.php" rel="activi"><button type="button" class="btn" ><i class="icon-remove"></i> Restablecer</button></a>
								 </div>



                    </form>
                    <?php 	}
                            else{
                            	echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No existe ninguna Grupo Empresa registrada con usted.</h4>
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
                <?php
                 if(isset($num_res) && $num_res>0){
                  ?>
                <div class="row-fluid">
        		            <div class="box span12" id="print">
        					<div class="box-header well" data-original-title>
        						<h2><i class="icon-check"></i> Cronograma y documentaci&oacute;n de las Grupo Empresas</h2>
                            </div>
                            

        					<div class="box-content">
                            <label>Ingrese aqui para revisar la documentación, pagos y actividades de cada Grupo Empresa</label>
                            <form name="form1" class="form-horizontal cmxform" method="GET" action="ver_cronograma.php" accept-charset="utf-8" >
                            <br>
                            <div class="control-group">

                                   <label class="control-label">  Grupo Empresa &emsp;</label>

                                    <div class="controls">
                                                  <?php    echo "     <select id=\"entreprod\" name=\"entreprod\" data-rel=\"chosen\">   ";
                                                                                //busca todas las emtregas de producto de la grupo empresa
                                                                                  $integrantes ="SELECT id_usuario,nombre_largo,nombre_corto,nombre,apellido,u.habilitado, u.nombre_usuario , g.id_grupo_empresa
                                                        											from grupo_empresa g, usuario u, integrante i
                                                        											where g.consultor_tis=$id_usuario AND i.grupo_empresa=g.id_grupo_empresa AND
                                                        											i.usuario=u.id_usuario AND u.tipo_usuario=4 AND u.gestion=$id_gestion";
                                                                                       $resultado = mysql_query($integrantes);
                                                                                  while($row = mysql_fetch_array($resultado)) {
                                                                                            echo "<option value=\"".$row['id_grupo_empresa']."\">".$row['nombre_largo']."</option>";
                                                                                  }
                                                                         echo "	</select>  ";
                                                  ?>
                                        	</div>

                                   </div>
                                   	<div class="control-group">
									<div class="controls">
                                 <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Aceptar</button>
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