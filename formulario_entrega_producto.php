<?php
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
include('conexion/verificar_gestion.php');
if(isset($_POST['enviar'])){	
	$url=$_POST['co_url'];
	$usuario=$_SESSION['nombre_usuario'];
	$id_usuario=$_SESSION['id'];
	$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
      or die("Error no se pudo realizar cambios.");
			$sql = "SELECT g.id_grupo_empresa
					FROM grupo_empresa g, integrante i
					WHERE i.usuario = '$id_usuario'
					AND i.grupo_empresa=g.id_grupo_empresa";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	        $arreglo = mysql_fetch_array($result);
	        $id_grupo = $arreglo['id_grupo_empresa'];

            $sql = "UPDATE entrega_producto
					SET enlace_producto = '$url',fecha_real_entrega = CURDATE()
					WHERE fecha_fin = CURDATE()
					AND grupo_empresa='$id_grupo'";
	        $result = mysql_query($sql,$conn) or die(mysql_error());  

	        header("Location: cronograma_grupo_integra.php");

	}
	else{
		$descripcionA=NULL;
		$co_url=NULL;
	}
			$sql = "SELECT descripcion
			FROM entrega_producto
			WHERE fecha_fin = CURDATE()";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	        $arreglo = mysql_fetch_array($result);
	        $fecha = $arreglo['descripcion'];

$titulo="Entrega de Productos";
include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					
					<li>
						<a href="formulario_entrega_producto.php">Entrega Producto</a>
					</li>				
				</ul>
			</div>
			<center><h3>Entrega Producto: <?php echo "$fecha";?></h3></center>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> Formulario de Entrega de Producto</h2>
					</div>
					<div class="box-content">	
							<?php
								if($gestion_valida){
								if ($cantidad_valida) {
									if ($act_5==1 && !$act_5_espera){
								$consulta_grupo= mysql_query("SELECT id_grupo_empresa
															FROM integrante i, grupo_empresa g
															WHERE i.usuario = '$id_usuario' 
															AND i.grupo_empresa = g.id_grupo_empresa");
								$resultado_grupo = mysql_fetch_assoc($consulta_grupo);
								$grupo = $resultado_grupo['id_grupo_empresa'];

								$consulta_producto = mysql_query("SELECT descripcion, fecha_inicio, fecha_fin, enlace_producto
												FROM entrega_producto
												WHERE fecha_fin = CURDATE()
												AND grupo_empresa = '$grupo'",$conn)
	                          					or die("Could not execute the select query.");
								$resultado = mysql_fetch_assoc($consulta_producto);
								if(is_array($resultado) && !empty($resultado))
								{	
										$des_prod=$resultado['descripcion'];
										$fecha_inicio=$resultado['fecha_inicio'];
										$fecha_fin=$resultado['fecha_fin'];
										$enlace_1=$resultado['enlace_producto'];
										?>
										<br>
							<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="formulario_entrega_producto.php" accept-charset="utf-8">
								<fieldset>
									<div class="control-group">
								  		<label class="control-label">Descripci&oacute;n: </label>
								  		<div class="controls">	
											<input class="disabled" type="text" name="descripcion" value='<?php echo $des_prod; ?>' disabled=""/>
										</div>
									</div>
									<div class="control-group">
								  		<label class="control-label">Fecha Inicio: </label>
								  		<div class="controls">	
											<input class="disabled" type="text" name="fecha_ini" value='<?php echo $fecha_inicio; ?>' disabled=""/>
										</div>
									</div>
									<div class="control-group">
								  		<label class="control-label">Fecha Fin: </label>
								  		<div class="controls">	
											<input class="disabled" type="text" name="fecha_fin" value='<?php echo $fecha_fin; ?> ' disabled=""/>
										</div>
									</div>
									<div class="control-group">
								  		<label class="control-label">Enlace Producto: </label>
								  		<div class="controls">	
											<input id="co_url" class="required defaultInvalid url" name="co_url" type="text" <?php if(!is_null($enlace_1)){ echo "value=".$enlace_1; }else{echo "value='http://'"; }?> />
										</div>
									</div>

								<div class="control-group">
								<div class="controls">	
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Enviar</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								 </div>
								 </div>
						        </fieldset>
						        <?php if(!is_null($enlace_1)){ 
								echo "<b>Nota: </b>Ya fue registrada una entrega para este Subsistema, si desea puede actualizar el enlace de su producto en el transcurso del d&iacute;a de hoy.</br>"; 
								}
							?>
							</form>
							

								<?php }
								else{
				                      echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No se encontr&oacute; ning&uacute;na Entrega de Producto para hoy.</h4>
				                      	</div>";	
								} ?>
							<?php 
							}

							else{
									echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        La entrega de Subsistemas no est&aacute; disponible, contacte con el Jefe Consultor TIS.</h4>
				                      	</div>";
								}
							}
							else{
									echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No puede enviar sus archivos, faltan integrantes.</h4>
				                      	</div>";
								}
							}else{
								echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				                      	</div>";
							}
							?>
		                </div>	
				</div><!--/span-->  
			</div><!-- fin row -->
<?php include('footer.php'); ?>