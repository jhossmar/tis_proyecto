<?php
session_start();
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
include('conexion/verificar_gestion.php');
if($gestion_valida){
  $bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
  			or die("Error no se pudo realizar cambios.");
  //captura el id del grupo empresa
  $consulta_id_ge = mysql_query("SELECT ge.id_grupo_empresa
                                 FROM usuario u,integrante i,grupo_empresa ge
                                 WHERE u.id_usuario='".$_SESSION['id']."' and u.id_usuario=i.usuario and i.grupo_empresa =ge.id_grupo_empresa",$conn)
                                  or die("Could not execute the select query.");
  $resultado_id_ge = mysql_fetch_assoc($consulta_id_ge);
  $rep_id_ge=(int)$resultado_id_ge['id_grupo_empresa'];
  $fecha = date("Y-m-d");
  $rep_fgi= $fecha;
  $rep_fgi= $fecha;
  $rep_fgi=$ini_gestion;
  $rep_fgf=$fin_gestion;
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
		$fin_year = substr($fin, 0,4);                 //$_SESSION['id']
       if(@checkdate($ini_mes, $ini_dia, $ini_year)){
			if (@checkdate($fin_mes, $fin_dia, $fin_year)) {
				if($inicio>=$fecha){//corecto
					if ($fin>$inicio) {//corecto sobreescribir base de datos
                     if($inicio>=$rep_fgi&&$inicio<=$rep_fgf){
                                 if($fin<=$rep_fgf){
										$descripcion=$_POST['descripcionG'];
										$pago=$_POST['pagos'];
										$responsable=$_POST['responsable'];
                                          // ingresa un new entrga producto
											 $sql = "INSERT INTO entrega_producto(id_entrega_producto,descripcion,fecha_inicio,fecha_fin,pago_establecido,grupo_empresa,id_responsable)
                                                                        	VALUES (' ','$descripcion','$inicio','$fin','$pago',$rep_id_ge,$responsable)";
                                             $result = mysql_query($sql,$conn) or die(mysql_error());
                                              header('Location: entrega_prod.php');
                                 }
                                 else{
                                    $error = true;
					                 $error_fecha_fin = "La fecha de finalizaci&oacute;n debe encontrarse dentro de la gesti&oacute;n ".$rep_fgi." al ".$rep_fgf."";
                                 }
                     } else{
                         $error = true;
					     $error_fecha_ini = "La fecha de inicio debe encontrarse dentro de la gesti&oacute;n ".$rep_fgi." al ".$rep_fgf."";
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
if(isset($_POST['guardar'])){
$contCEP=(int) $_POST['CEP'];
$ccep=0;
while($ccep<$contCEP){
   $ide=$_POST["A0".$ccep];
        if(isset( $_POST["A1".$ccep] )){
                                    //busca el ide de las actividades q pertenecen a entrega_produc de ide
                                    $consulta_idac = "SELECT age.id_actividad
                                                        FROM actividad_grupo_empresa age
                                                        WHERE age.entrega_producto='$ide'";
                                    $resultado_idac = mysql_query($consulta_idac);
                                    while($row_idac = mysql_fetch_array($resultado_idac)){
                                                   mysql_query("DELETE FROM tarea  WHERE actividad='".$row_idac['id_actividad']."'");
                                                   mysql_query("DELETE FROM actividad_grupo_empresa  WHERE id_actividad='".$row_idac['id_actividad']."'");
                                    }
                                    mysql_query("DELETE FROM entrega_producto  WHERE id_entrega_producto='".$ide."'");
                                    header('Location: entrega_prod.php');
        }
        else{

                        $fecha = date("Y-m-d");
                        $inicio = $fecha;
                        $fin = $fecha;
                        //$inicio = $_POST["A3".$ccep];
                		//$fin = $_POST["A4".$ccep];
                		$ini_dia = substr($inicio, 8);
                		$ini_mes = substr($inicio, 5,2);
                		$ini_year = substr($inicio, 0,4);
                		$fin_dia = substr($fin, 8);
                		$fin_mes = substr($fin, 5,2);
                		$fin_year = substr($fin, 0,4);
                        //$pago=(int)$_POST["A5".$ccep];
                        //$descrip=(String) $_POST["A2".$ccep];
                        if(@checkdate($ini_mes, $ini_dia, $ini_year)){
                			if (@checkdate($fin_mes, $fin_dia, $fin_year)) {
                        $a_dia = substr($inicio, 8);
                		$a_mes = substr($inicio, 5,2);
                		$a_year = substr($inicio, 0,4);
                         //if(strlen($descrip)>10){}
                            if($inicio>=$fecha)                  //(int)$ini_year>=(int)$a_year&&(int)$ini_mes>=(int)$a_mes&&(int)$ini_dia>=(int)$a_dia)
                            {//corecto
                					if ($fin>$inicio) {//corecto sobreescribir base de datos
                                             if($pago<1000){
                                               if(strlen ( $descrip )>10){
                                                     if($inicio>=$rep_fgi&&$inicio<=$rep_fgf){
                                                           if($fin<=$rep_fgf){
                                                                                 mysql_query("UPDATE entrega_producto SET descripcion='$descrip',fecha_inicio='$inicio',fecha_fin='$fin',pago_establecido='$pago'
                                                                                      WHERE id_entrega_producto='$ide'");
                                                                                      header('Location: entrega_prod.php');
                                                           }
                                                           else{
                                                                //   $error = true;
                              					              //   $error_fecha_fin = "La fecha de finalizaci&oacute;n debe encontrarse dentro de la gesti&oacute;n ".$rep_fgi." al ".$rep_fgf."";
                                                               }
                                                       }
                                                      else{
                                                         //  $error = true;
                                  					     //$error_fecha_ini = "La fecha de inicio debe encontrarse dentro de la gesti&oacute;n ".$rep_fgi." al ".$rep_fgf."";
                                                       }
                                               }
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
                		//	$error = true;
                		//	$error_fecha_ini = "La fecha de inicio no es valida";
                		}
                }
               $ccep++;
	}




}

 



$titulo="Cronograma de entrega de subsistemas";
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
						<a href="entrega_prod.php">Entrega De Subsistemas </a>

					</li>
				</ul>
			</div>
			<center><h3>Cronograma de entrega de Subsistemas </h3></center>
             <?php 
            if($gestion_valida){
             if ($cantidad_valida) { 
              if ($act_5==1 && !$act_5_espera) {
                ?>
			<div class="row-fluid">
				<div class="box span12 center" id="print">
						<div class="box-header well">
							<h2><i class="icon-calendar"></i> Cronograma en entrega de subsistema</h2>
						</div>
						<div class="box-content padding-in" style="text-align:left;" >
						<?php
                            //busca todas las emtregas de producto de la grupo empresa
                                $consulta_entrega_empresa = "SELECT ep.id_entrega_producto,ep.descripcion,ep.fecha_inicio,ep.fecha_fin,ep.pago_establecido,u.nombre,u.apellido
                                                             FROM entrega_producto ep, usuario u
                                                             WHERE ep.grupo_empresa='$rep_id_ge'
															 AND ep.id_responsable=u.id_usuario
															 ";
                                $resultado_entrega_empresa = mysql_query($consulta_entrega_empresa);
                        		$num_registros = mysql_num_rows($resultado_entrega_empresa);
                        		if ($num_registros>0) {
                        ?>
                        <form name="activi" class="form-horizontal cmxform" method="POST" id="activi" action="entrega_prod.php" accept-charset="utf-8"  >
                                       <TABLE id="dataTable" name="dataTable pagos" class="table table-striped table-bordered"  >
                                          <thead>
                                            <TR  >
                                            <TH>Descripci&oacute;n</TH>
											<TH>Responsable</TH>
                                            <TH>Fecha Inicio</th>
                                            <TH>Fecha Conclusi&oacute;n </th>
                                            <TH>Pago Asociado </th>
                                            <TH style="text-align:center;">Eliminar</TH>
                                            </TR>
                                           </thead  >
                                            <tbody>
                                       	<?php

                                        $CEP=0;
                                         while($row_entrega_empresa = mysql_fetch_array($resultado_entrega_empresa))
                                          {     echo "  <TR > ";
                                                echo "
                                                <TD>".$row_entrega_empresa['descripcion'] ."</TD>
												<TD>".$row_entrega_empresa['nombre']." ".$row_entrega_empresa['apellido']."</TD>
                                                <TD>".$row_entrega_empresa['fecha_inicio'] ."</TD>
                                                <TD>".$row_entrega_empresa['fecha_fin'] ."</TD>
                                                <TD>".$row_entrega_empresa['pago_establecido'] ."</TD>
                                                 ";
                                                echo " <TD style=\"text-align:center;\"><input type=\"checkbox\" id=\"A1".$CEP."\" name=\"A1".$CEP."\" value=\"Eliminar\" class=\"btn btn-primary\" onclick=\"roly\" /></TD> ";
                                                echo "<input  type=\"hidden\" id=\"A0".$CEP."\"  name=\"A0".$CEP."\"  value=\"".$row_entrega_empresa['id_entrega_producto']."\" />";
                                                echo      "</TR>";
                                                $CEP++;
                                          }
                                          echo "<input  type=\"hidden\" id=\"CEP\"  name=\"CEP\"  value=\"".$CEP."\"  />";

                                        if($CEP==0){
                                          echo "<center><h4>No existe Entrega De Producto Programada.</h4></center>";
                                        }
                                      ?> 

                                                 </tbody>

                                                  </TABLE>




								
                                  <button type="submit" id="guardar" name="guardar" value="Guardar Cambios" class="btn btn-primary"  ><i class="icon-ok"></i> Guardar Cambios</button>
                                  <a href="entrega_prod.php" rel="activi"><button type="button" class="btn" ><i class="icon-remove"></i> Restablecer</button></a>


		                	  </form>
		                	 <?php
		                	 }else{
		                	 	echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No se ha programado ninguna entrega de subsistema.</h4>
				                      	</div>";
				                      }

		                	 ?>
		                </div>
				</div>
			</div>
            <br>
            <center><h3> Agregar nueva entrega de subsistema </h3></center>
            <div class="row-fluid">
				<div class="box span12">
						<div class="box-header well">
							<h2><i class="icon-plus-sign"></i> Agregar nueva entrega de subsistema</h2>
						</div>
						<div class="box-content alerts">
                        <br>
						<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" action="entrega_prod.php" accept-charset="utf-8">

								<div class="control-group">
								  <label class="control-label" >Descripci&oacute;n: </label>
								  <div class="controls">
									<input type="text" name="descripcionG" id="descripcionG" placeholder="Ingrese una descripci&oacute;n"/>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" >Responsable: </label>
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
								  <label class="control-label" for="tituloD">Pago ($us): </label>
								  <div class="controls">
									<input type="text" class ="pagos" name="pagos" id="pagos" placeholder="Ingresar pago"/>
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
                 else{ ?>
                <div class="row-fluid">
        <div class="box span12">
            <div class="box-header well">
              <h2><i class="icon-calendar"></i> Cronograma en entrega de subsistema</h2>
            </div>
            <div class="box-content alerts">
                <center><h4><i class="icon-info-sign"></i> El Cronograma de Pagos y de Subsistemas no est&aacute; disponible, contacte con el Jefe Consultor TIS. </h4></center>
            </div>
          </div><!--/span-->
        </div><!-- fin row -->
                <?php }
                 }
                 else{ ?>
                <div class="row-fluid">
				<div class="box span12">
						<div class="box-header well">
							<h2><i class="icon-calendar"></i> Cronograma en entrega de subsistema</h2>
						</div>
						<div class="box-content alerts">
								<center><h4><i class="icon-info-sign"></i> Debe habilitar m&aacute;s integrantes. </h4></center>
						</div>
					</div><!--/span-->
				</div><!-- fin row -->
                <?php }
              }else{
                 ?>
                    <div class="row-fluid">
        <div class="box span12">
            <div class="box-header well">
              <h2><i class="icon-calendar"></i> Cronograma en entrega de subsistema</h2>
            </div>
            <div class="box-content alerts">
                <center><h4><i class="icon-info-sign"></i> La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4></center>
            </div>
          </div><!--/span-->
        </div><!-- fin row -->
                 <?php } ?>
<?php include('footer.php'); ?> 
