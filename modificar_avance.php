<?php
$titulo="Modificar Avance Semanal";
include('conexion/verificar_gestion.php');
session_start();

$quien_ingresa="Grupo Empresa";
$pag_ini="home_grupo.php";

/*------------------VERIFICAR QUE SEAL LA GRUPO EMPRESA------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
	                    break;
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
$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
or die("Error no se pudo realizar cambios.");
$id_usuario=$_SESSION['id'];

if(isset($_POST['enviar'])){
	
	$descripcionA=$_POST['descripcionA'];
	$url=$_POST['co_url'];
	$usuario=$_SESSION['nombre_usuario'];

			$sql = "SELECT COUNT(*) error
					FROM avance_semanal a, grupo_empresa g, integrante i
					WHERE i.usuario = 3
					AND i.grupo_empresa = g.id_grupo_empresa
					AND a.grupo_empresa = g.id_grupo_empresa
					AND a.fecha_revision <= CURDATE()
					AND a.presentado = 1";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	        $arreglo = mysql_fetch_array($result);
	        $error_s = false;

	        if ($arreglo["error"] == 0) {
									$error_s=true;
									$error_select = "No existe ninguna opci&oacute;n";
								}
								elseif($arreglo["error"] > 0)
								{
									$error_s = false;
									$avance=$_POST['avance'];
								}
	        if(!$error_s)
	        {
			$sql = "SELECT g.id_grupo_empresa
					FROM grupo_empresa g, integrante i
					WHERE i.usuario = '$id_usuario'
					AND i.grupo_empresa=g.id_grupo_empresa";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	        $arreglo = mysql_fetch_array($result);
	        $id_grupo = $arreglo['id_grupo_empresa'];

            $sql = "UPDATE avance_semanal
					SET enlace_entregable = '$url'
					WHERE fecha_revision = '$avance'";
	        $result = mysql_query($sql,$conn) or die(mysql_error());  

	        $sql = "UPDATE avance_semanal
					SET desc_avance = '$descripcionA'
					WHERE fecha_revision = '$avance'";
	        $result = mysql_query($sql,$conn) or die(mysql_error());  

	        header("Location: modificar_avance.php");
	    	}	
	    	
	
	}
	else{
		$descripcionA=NULL;
		$co_url=NULL;
		$error_s=NULL;
	}

include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					
					<li>
						<a href="avance_semanal_grupo.php">Modificar Avance Semanal</a>
					</li>				
				</ul>
			</div>
			<center><h3>Reporte Avance Semanal</h3></center>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> Reporte Avances</h2>
					</div>
					<div class="box-content">
                    	<?php if (!empty($id_gestion) ){
								if ($cantidad_valida) {

						?>
						<table class="table table-striped">
						  <thead >
							  <tr >
								 	  <th>Fecha Avance</th>
									  <th>Descripci&oacute;n</th>
									  <th>Enlace</th>
									  <th>Observaci&oacute;n</th>
									  
							  </tr>
						  </thead>
						  <tbody>

						<?php
                               $avances ="SELECT fecha_revision, desc_avance, enlace_entregable, observacion, presentado
										FROM avance_semanal a, grupo_empresa g, integrante i
										WHERE i.usuario = '$id_usuario'
										AND i.grupo_empresa = g.id_grupo_empresa
										AND a.grupo_empresa = g.id_grupo_empresa
										AND a.fecha_revision <= CURDATE()
                                        ORDER BY a.fecha_revision";
                               $resultado = mysql_query($avances);
                               	
                                while($row = mysql_fetch_array($resultado)) {
                                	if($row["presentado"] == 1){
		                                echo "
		                                    <tr>
		    								  <td>".$row["fecha_revision"]."</td>
		    								  <td>".$row["desc_avance"]."</td>
		    								  <td class=\"center\"> <a href= ".$row["enlace_entregable"]."> <i class=\"icon-zoom-in\"></i> Ver Avance</a></td>
		    								  <td>".$row["observacion"]."</td>";
		                        		echo "	</tr> ";
                                 	}
                                 	else{
                                 		echo "
		                                    <tr>
		    								  <td>".$row["fecha_revision"]."</td>
		    								  <td> No existe ninguna Descripci&oacute;n </td>
		    								  <td> No existe ning&uacute;n Enlace </td>
		    								  <td> No se present&oacute; el Avance Semanal</td>";
		                        		echo "	</tr> ";
                                 	}
                                }

                             ?>
                             </tbody>
					  </table>
                      	<?php
								}
								else{
									echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No puede enviar sus archivos, faltan integrantes.</h4>
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
					  </div><!--/span--> 
					    </div>
			</div><!-- fin row -->

						<div class="row-fluid">
						<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> Formulario de Modicaci&oacute;n Avance Semanal</h2>
					</div>
					<div class="box-content">
                    <?php if (!empty($id_gestion) ){
								if ($cantidad_valida) {

						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="modificar_avance.php" accept-charset="utf-8">
								<fieldset>

								<div class="control-group">
								<label class="control-label" for="avance">Avance:</label>
								<div class="controls">
								  <select id="avance" name="avance" class="avance" data-rel="chosen" value="1">
								  	<?php
                               $avances ="SELECT fecha_revision
										FROM avance_semanal a, grupo_empresa g, integrante i
										WHERE i.usuario = '$id_usuario'
										AND i.grupo_empresa = g.id_grupo_empresa
										AND a.grupo_empresa = g.id_grupo_empresa
										AND a.fecha_revision <= CURDATE()
										AND a.presentado = 1";
                               $resultado = mysql_query($avances);
                               
                                $verificar = 0;
                                while($row = mysql_fetch_array($resultado)) {
                                	
                    
		                               echo "
		    								  <option>".$row["fecha_revision"]."</option>";
		                            $verificar ++;  
								}
								
                             ?>
									
								  </select> 
								  <label class="error"><?php if(isset($error_select)){ echo $error_select; } ?></label>
								</div>
							  </div>

								<div class="control-group">
								  <label class="control-label" for="co_url">Enlace Avance:</label>
								  <div class="controls">
									<input id="co_url" class="required defaultInvalid url" name="co_url" type="text" value="http://" />
								  </div>
								</div>

								<div class="control-group">
									<label class="control-label" for="descripcion">Descripci&oacute;n Avance:</label>
									<div class="controls">
										<textarea id="descripcionA" placeholder="Descripci&oacute;n Avance" name="descripcionA" ><?php echo $descripcionA; ?></textarea>
									</div>
								</div>
								
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Enviar</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								 </div>
								 </div>
						        </fieldset>
							</form>
							<?php
								}
								else{
									echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No puede enviar sus archivos, faltan integrantes.</h4>
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
			</div><!-- fin row -->
<?php include('footer.php'); ?>