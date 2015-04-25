<?php
session_start();
include('conexion/verificar_gestion.php');
$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
      or die("Error no se pudo realizar cambios.");
/*------------------VERIFICAR QUE SEAL LA GRUPO EMPRESA------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4)
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
include("conexion/verificar_integrantes.php");

//captura el id del grupo empresa
//captura el id del grupo empresa
if($gestion_valida){
  $consulta_id_ge = mysql_query("SELECT ge.id_grupo_empresa
                                 FROM usuario u,integrante i,grupo_empresa ge
                                 WHERE u.id_usuario='".$_SESSION['id']."' and u.id_usuario=i.usuario and i.grupo_empresa =ge.id_grupo_empresa",$conn)
                                  or die("Could not execute the select query.");
  $resultado_id_ge = mysql_fetch_assoc($consulta_id_ge);
  $rep_id_ge=(int)$resultado_id_ge['id_grupo_empresa'];
  $fecha = date("Y-m-d");
  $inicio = $fecha;
  $fin = $fecha;
}
if (isset($_POST['enviar'])) {
	$error=false;
	if (isset($_POST['inicio']) && isset($_POST['fin'])) {

		$inicio = $_POST['inicio'];
		$fin = $_POST['fin'];

		$ini_dia = substr($inicio, 8);
		$ini_mes = substr($inicio, 5,2);
		$ini_year = substr($inicio, 0,4);

		$fin_dia = substr($fin, 8);
		$fin_mes = substr($fin, 5,2);
		$fin_year = substr($fin, 0,4);
        $id_entrega_p=0;
         if (isset($_POST['entreprod'])) {
                     $id_entrega_p=$_POST['entreprod'];

         }
		if (isset($_POST['responsable'])) {
                     $id_integrante=$_POST['responsable'];

         }

		if(@checkdate($ini_mes, $ini_dia, $ini_year)){
			if (@checkdate($fin_mes, $fin_dia, $fin_year)) {
				if($inicio>=$fecha){//corecto
					if ($fin>$inicio) {//corecto sobreescribir base de datos
                                         //busca la fecha de entrega de producto
                                           $ep_feini=$fecha;
                                           $ep_fefin=$fecha;
                                        $consulta = mysql_query("SELECT ep.fecha_inicio,ep.fecha_fin
                                                                  FROM entrega_producto ep
                                                                  WHERE ep.id_entrega_producto='$id_entrega_p'",$conn)
                                		                         or die("Could not execute the select query.");
                                		        $resultado = mysql_fetch_assoc($consulta);
                                		        $ep_feini=$resultado['fecha_inicio'];
                                                $ep_fefin=$resultado['fecha_fin'];
                                                  /*  $epfid = substr($ep_feini, 8);
                                              		$epfim = substr($ep_feini, 5,2);
                                              		$epfia = substr($ep_feini, 0,4);

                                              		$epffd = substr($ep_fefin, 8);
                                              		$epffm = substr($ep_fefin, 5,2);
                                              		$epffa = substr($ep_fefin, 0,4);   */
                                    if($inicio>=$ep_feini&&$inicio<=$ep_fefin&&$fin<=$ep_fefin){
                                         $descripcion=$_POST['descripcionG'];
                                         /*
                                          //cuenta las actividades
                                               $sql = "SELECT COUNT(DISTINCT age.id_actividad)  as n
                                                        FROM actividad_grupo_empresa age";
                                               $resulta = mysql_query($sql,$conn) or die(mysql_error());
											   $resultado_nage = mysql_fetch_assoc($resulta);
		       								   $rep_nage=(int)$resultado_nage['n'];
                                               $rep_nage+=1;                 */
                                           // inset un new  Actividad grupo empresa
                                            $sql2 = "INSERT INTO actividad_grupo_empresa (id_actividad,fecha_inicio,fecha_fin,descripcion,entrega_producto,id_responsable)
                                                     VALUES (' ','$inicio','$fin','$descripcion','$id_entrega_p',$id_integrante)";
                                            $result2 = mysql_query($sql2,$conn) or die(mysql_error());
                                            header('Location: actividades_grupo.php');
                                      }
                                      else{
                                               $error = true;
                                               $error_ep  ="Las fechas seleccionadas  no corresponden a las fechas de inicio y fin de la entrega de producto deben de estar dentro de las fechas ".$ep_feini." al ".$ep_fefin ;
                                        }

					}
					else{
						$error = true;
						$error_fecha_fin = "La fecha de finalizaci&oacute;n no debe ser menor o igual a la fecha de inicio";
					}
				}
				else{
					$error = true;
					$error_fecha_ini = "La fecha de inicio no debe ser menor a la fecha presente";
				}
			}
			else{
				$error = true;
				$error_fecha_fin = "La fecha de finalizacion no es valida";
			}
		}
		else{
			$error = true;
			$error_fecha_ini = "La fecha de inicio no es valida";
		}
	}
}
 //guardar cambios
if (isset($_POST['guardar']))
{
$ccaa=(int) $_POST['CAA'];
$counta=0;
    while($counta<$ccaa){
              $id_ac=$_POST["A0".$counta];
              $id_ep=$_POST["A1".$counta];
              if(isset( $_POST["A5".$counta] )){
                    mysql_query("DELETE FROM tarea  WHERE actividad='$id_ac'");
                    mysql_query("DELETE FROM actividad_grupo_empresa  WHERE id_actividad='$id_ac'");
                    header('Location: actividades_grupo.php');
                   }
               else{
                      	$error=false;
                      	if (isset($_POST["A3".$counta]) && isset($_POST["A4".$counta])) {
                      		$inicio = $_POST["A3".$counta];
                      		$fin = $_POST["A4".$counta];

                      		$ini_dia = substr($inicio, 8);
                      		$ini_mes = substr($inicio, 5,2);
                      		$ini_year = substr($inicio, 0,4);

                      		$fin_dia = substr($fin, 8);
                      		$fin_mes = substr($fin, 5,2);
                      		$fin_year = substr($fin, 0,4);
                              $id_entrega_p=$id_ep;
                      		if(@checkdate($ini_mes, $ini_dia, $ini_year)){
                      			if (@checkdate($fin_mes, $fin_dia, $fin_year)) {
                      				if($inicio>=$fecha){//corecto
                      					if ($fin>$inicio) {//corecto sobreescribir base de datos
                                                               //busca la fecha de entrega de producto
                                                                 $ep_feini=$fecha;
                                                                 $ep_fefin=$fecha;
                                                              $consulta = mysql_query("SELECT ep.fecha_inicio,ep.fecha_fin
                                                                                        FROM entrega_producto ep
                                                                                        WHERE ep.id_entrega_producto='$id_entrega_p'",$conn)
                                                      		                         or die("Could not execute the select query.");
                                                      		        $resultado = mysql_fetch_assoc($consulta);
                                                      		        $ep_feini=$resultado['fecha_inicio'];
                                                                      $ep_fefin=$resultado['fecha_fin'];
                                                                        /*  $epfid = substr($ep_feini, 8);
                                                                    		$epfim = substr($ep_feini, 5,2);
                                                                    		$epfia = substr($ep_feini, 0,4);

                                                                    		$epffd = substr($ep_fefin, 8);
                                                                    		$epffm = substr($ep_fefin, 5,2);
                                                                    		$epffa = substr($ep_fefin, 0,4);   */
                                                          if($inicio>=$ep_feini&&$inicio<=$ep_fefin&&$fin<=$ep_fefin){
                                                               $descripcion=$_POST["A2".$counta];
                                                                 if(strlen ( $descripcion )>10){
                                                                     mysql_query("UPDATE actividad_grupo_empresa SET fecha_inicio='$inicio',fecha_fin='$fin' ,descripcion='$descripcion',id_responsable=$id_integrante
                                                                                 WHERE id_actividad='$id_ac'");
                                                                    header('Location: actividades_grupo.php');
                                                                 }

                                                            }
                                                            else{
                                                                 //    $error = true;
                                                                //     $error_ep  ="Las fechas seleccionadas  no corresponden a las fechas de inicio y fin de la entrega de producto" ;
                                                              }

                      					}
                      					else{
                      					  //	$error = true;
                      					 //	$error_fecha_fin = "La fecha de finalizaci&oacute;n no debe ser menor o igual a la fecha de inicio";
                      					}
                      				}
                      				else{
                      				//	$error = true;
                      				  //	$error_fecha_ini = "La fecha de inicio no debe ser menor a la fecha presente";
                      				}
                      			}
                      			else{
                      			//	$error = true;
                      			  //	$error_fecha_fin = "La fecha de finalizacion no es valida";
                      			}
                      		}
                      		else{
                      			//$error = true;
                      			//$error_fecha_ini = "La fecha de inicio no es valida";

                      		}
                      	}
}
   $counta++;
            }


}

$titulo="Planificar actividades";
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
						<a href="actividades_grupo.php">Actividades Grupo Empresa</a>

					</li>
				</ul>
			</div>
			<center><h3>Cuadro de Actividades </h3></center>
             <?php 
             if($gestion_valida){
             if ($cantidad_valida) { 
              if ($act_5==1 && !$act_5_espera) {?>
			<div class="row-fluid">
				<div class="box span12 center" id="print">
						<div class="box-header well">
							<h2><i class="icon-calendar"></i> Actividades Programadas</h2>
						</div>
						<div class="box-content padding-in" style="text-align:left;" >
						<?php



                                $consulta_actividades_empresa = "SELECT age.id_actividad,age.fecha_inicio,age.fecha_fin,age.descripcion,age.entrega_producto ,ep.id_entrega_producto, u.nombre, u.apellido
                                                                FROM entrega_producto ep,actividad_grupo_empresa age,usuario u
                                                                WHERE ep.grupo_empresa='$rep_id_ge' 
																AND ep.id_entrega_producto= age.entrega_producto
																AND age.id_responsable=u.id_usuario";
                                $resultado_actividades_empresa = mysql_query($consulta_actividades_empresa);
                        		$num_registros = mysql_num_rows($resultado_actividades_empresa);
                                $num_ep =     mysql_query("SELECT ep.id_entrega_producto FROM entrega_producto ep");
                                $num_ep =     mysql_num_rows($num_ep);
                                if($num_ep==0){
                                        echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No existe ninguna entrega de subsistema programada <br> puede programar entregas de subsistema <a style=\"color:#000000; !important\" href=\"entrega_prod.php\">aqu&iacute;.</a> </h4>
				                      	</div>";
                                }
                                else if ($num_registros>0) {
                        ?>
                                          <form name="activi" class="form-horizontal cmxform" method="POST" id="activi" action="actividades_grupo.php" accept-charset="utf-8"  >
                                       <input type="hidden" id="ge" name="ge"value="<?php echo $_SESSION['nombre_usuario'];?>"/>
                                       <TABLE id="dataTable" name="dataTable" class="table table-striped table-bordered"  >
                                          <thead>


                                            <TR >
                                            <TH>Descripci&oacute;n</TH>
											<TH>Responsable</TH>
                                            <TH>Fecha Inicio</th>
                                            <TH>Fecha Conclusi&oacute;n </th>
                                          <!--  <TH>Entrega Producto </TH>  -->
                                            <TH style="text-align:center;">Eliminar </TH>
                                            </TR>
                                           </thead>
                                            <tbody>
                                            	<?php
                                                    $CAA=0;
                                                     while($row_actividades_empresa = mysql_fetch_array($resultado_actividades_empresa))
                                                      {         echo "  <TR> ";
                                                        echo "
                                                            <TD><input type=\"text\" id=\"A2".$CAA."\"  name=\"A2".$CAA."\" class=\"roly\" value=\"".$row_actividades_empresa['descripcion'] ."\" /> </TD>
															<TD><input type=\"text\" id=\"A2".$CAA."\"  name=\"A2".$CAA."\" class=\"roly\" value=\"".$row_actividades_empresa['nombre'] ." ".$row_actividades_empresa['apellido'] ."\" /> </TD>
                                                            <TD><input type=\"text\" id=\"A3".$CAA."\"  name=\"A3".$CAA."\" class=\"datepicker\" style=\"width:80px !important\" value=\"".$row_actividades_empresa['fecha_inicio'] ."\" /> </TD>
                                                            <TD><input type=\"text\" id=\"A4".$CAA."\"  name=\"A4".$CAA."\" class=\"datepicker\" style=\"width:80px !important\" value=\"".$row_actividades_empresa['fecha_fin'] ."\" /> </TD> ";
                                                            /*   echo " <TD>    <select id=\"A5".$CAA."\" name=\"A5".$CAA."\" data-rel=\"chosen\">   ";
                                                            //busca todas las emtregas de producto de la grupo empresa
                                                             $consulta_entrega_empresa = "SELECT ep.id_entrega_producto,ep.descripcion,ep.fecha_inicio,ep.fecha_fin,ep.pago_establecido
                                                                                           FROM entrega_producto ep
                                                                                           WHERE ep.grupo_empresa='$rep_id_ge'";
                                                              $resultado_entrega_empresa = mysql_query($consulta_entrega_empresa);
                                                              while($row_entrega_empresa = mysql_fetch_array($resultado_entrega_empresa)) {
                                                                        echo "<option value=\"".$row_entrega_empresa['id_entrega_producto']."\">".$row_entrega_empresa['descripcion']."</option>";
                                                              }
                                                             echo "	</select></TD>  ";*/
                                                     echo"  <TD style=\"text-align:center;\"><INPUT type=\"checkbox\" id=\"A5".$CAA."\"  name=\"A5".$CAA."\"  style=\"max-width: 80px !important \"  />  </TD>    ";
                                                     echo "<input  type=\"hidden\" id=\"A1".$CAA."\"  name=\"A1".$CAA."\"  value=\"".$row_actividades_empresa['entrega_producto']."\"  />";
                                                     echo "<input  type=\"hidden\" id=\"A0".$CAA."\"  name=\"A0".$CAA."\"  value=\"".$row_actividades_empresa['id_actividad']."\"  />";
                                                     //echo "</TR>";
                                                      $CAA++;
                                                      }
                                                    echo "<input  type=\"hidden\" id=\"CAA\"  name=\"CAA\"  value=\"".$CAA."\"  />";
                                                    if($CAA==0){
                                                      echo "<center><h4>No existe ninguna actividad programada.</h4></center>";
                                                    }
                                                    ?>
                                                 </tbody>
                                                  </TABLE>
                                                            
                                  <button type="submit" id="guardar" name="guardar" value="Guardar Cambios" class="btn btn-primary"><i class="icon-ok"></i> Guardar Cambios</button>
                                  <a href="calendario_grupo.php" class="btn"><i class="icon-briefcase"></i> Planificar Tareas</a>
                                  <a href="actividades_grupo.php" rel="activi"><button type="button" class="btn"><i class="icon-remove"></i> Restablecer</button></a>
								



		                	 </form>
		                	 <?php
		                	 }else{
		                	 	echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No existe ninguna actividad programada.</h4>
				                      	</div>";
				                      }

		                	 ?>
		                </div>
				</div>
			</div>
            <br>
            <?php $num_ep =     mysql_query("SELECT ep.id_entrega_producto FROM entrega_producto ep");
                                $num_ep =     mysql_num_rows($num_ep);
                                if($num_ep>0) { ?>
            <center><h3> Agregar actividades </h3></center>
            <div class="row-fluid">
				<div class="box span12">
						<div class="box-header well">
							<h2><i class="icon-plus-sign"></i> Agregar Actividad</h2>
						</div>
						<div class="box-content alerts">
                        <br>
						<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" action="actividades_grupo.php" accept-charset="utf-8">

								<div class="control-group">
								  <label class="control-label" >Descripci&oacute;n: </label>
								  <div class="controls">
									<input type="text" name="descripcionG" id="descripcionG" placeholder="Ingrese una descripci&oacute;n"/>
								  </div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="descripcion">Responsable</label>
                                    <div class="controls">
                              <?php    echo "     <select id=\"responsable\" name=\"responsable\" data-rel=\"chosen\">   ";
                                                            //busca todos los integrates de la grupo empresa
                                                              $consulta_entrega_empresa = "SELECT u.nombre_usuario, u.id_usuario
                                                                                           FROM integrante i, grupo_empresa ge, usuario u
                                                                                           WHERE ge.id_grupo_empresa='$rep_id_ge'
																							AND i.usuario = u.id_usuario
																							AND i.grupo_empresa = ge.id_grupo_empresa
																							";
                                                              $resultado_entrega_empresa = mysql_query($consulta_entrega_empresa);
                                                              while($row_entrega_empresa = mysql_fetch_array($resultado_entrega_empresa)) {
                                                                        echo "<option value=\"".$row_entrega_empresa['id_usuario']."\">".$row_entrega_empresa['nombre_usuario']."</option>";
                                                              }
                                                     echo "	</select>  ";      ?>
                                              <!--<label class="error"><?php if(isset($error_ep)){ echo $error_ep; } ?></label>-->
                                        	</div>
                                  	</div>

								<div class="control-group">
									<label class="control-label" >Fecha inicio:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="inicio" id="inicio" value="<?php echo $inicio; ?>">
										<label class="error"><?php if(isset($error_fecha_ini)){ echo $error_fecha_ini; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Fecha conclusi&oacute;n:</label>
									<div class="controls">
										<input type="text" class="datepicker" name="fin" id="fin" value="<?php echo $fin; ?>" >
										<label class="error"><?php if(isset($error_fecha_fin)){ echo $error_fecha_fin; } ?></label>
									</div>
								</div>
                                <div class="control-group">
									<label class="control-label" for="descripcion">Pertenece a la entrega de Producto</label>
                                    <div class="controls">
                              <?php    echo "     <select id=\"entreprod\" name=\"entreprod\" data-rel=\"chosen\">   ";
                                                            //busca todas las emtregas de producto de la grupo empresa
                                                              $consulta_entrega_empresa = "SELECT ep.id_entrega_producto,ep.descripcion,ep.fecha_inicio,ep.fecha_fin,ep.pago_establecido
                                                                                           FROM entrega_producto ep
                                                                                           WHERE ep.grupo_empresa='$rep_id_ge'";
                                                              $resultado_entrega_empresa = mysql_query($consulta_entrega_empresa);
                                                              while($row_entrega_empresa = mysql_fetch_array($resultado_entrega_empresa)) {
                                                                        echo "<option value=\"".$row_entrega_empresa['id_entrega_producto']."\">".$row_entrega_empresa['descripcion']."</option>";
                                                              }
                                                     echo "	</select>  ";      ?>
                                              <!--<label class="error"><?php if(isset($error_ep)){ echo $error_ep; } ?></label>-->
                                        	</div>
                                  	</div>
                                <div class="control-group">
                                    <label class="error"><?php if(isset($error_ep)){echo $error_ep;}?></label>
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
				</div><!-- fin row -->
        <?php }
      }
                 else{ ?>
                <div class="row-fluid">
        <div class="box span12">
            <div class="box-header well">
              <h2><i class="icon-calendar"></i> Actividades Programadas</h2>
            </div>
            <div class="box-content alerts">
                <center><h4><i class="icon-info-sign"></i> La Planificaci&oacute;n de actividades no est&aacute; disponible, contacte con el Jefe Consultor TIS. </h4></center>
            </div>
          </div><!--/span-->
        </div><!-- fin row -->
                <?php }

                } else{ ?>
                <div class="row-fluid">
				<div class="box span12">

						<div class="box-header well">
							<h2><i class="icon-info-sign"></i> Actividades Programadas</h2>
						</div>
						<div class="box-content alerts">
								<center><h4><i class="icon-info-sign"></i> Debe habilitar m&aacute;s integrantes. </h4></center>
						</div>
					</div><!--/span-->
				</div><!-- fin row -->
                <?php }
        }else{ ?>
            <div class="row-fluid">
        <div class="box span12">

            <div class="box-header well">
              <h2><i class="icon-calendar"></i> Actividades Programadas</h2>
            </div>
            <div class="box-content alerts">
                <center><h4><i class="icon-info-sign"></i> La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4></center>
            </div>
          </div><!--/span-->
        </div><!-- fin row -->

       <?php  } ?>
<?php include('footer.php'); ?>