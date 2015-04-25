<?php
session_start();
$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
or die("Error no se pudo realizar cambios.");
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
	include('conexion/conexion.php');	
	$descripcionA=$_POST['descripcionA'];
	$url=$_POST['co_url'];
	$usuario=$_SESSION['nombre_usuario'];
	$id_usuario=$_SESSION['id'];

			$sql = "SELECT g.id_grupo_empresa
					FROM grupo_empresa g, integrante i
					WHERE i.usuario = '$id_usuario'
					AND i.grupo_empresa=g.id_grupo_empresa";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	        $arreglo = mysql_fetch_array($result);
	        $id_grupo = $arreglo['id_grupo_empresa'];

            $sql = "UPDATE avance_semanal
					SET enlace_entregable = '$url'
					WHERE fecha_revision = CURDATE()";
	        $result = mysql_query($sql,$conn) or die(mysql_error());  

	        $sql = "UPDATE avance_semanal
					SET desc_avance = '$descripcionA'
					WHERE fecha_revision = CURDATE()";
	        $result = mysql_query($sql,$conn) or die(mysql_error()); 

	        $sql = "UPDATE avance_semanal
					SET presentado = 1
					WHERE fecha_revision = CURDATE()";
	        $result = mysql_query($sql,$conn) or die(mysql_error());  

	        header("Location: modificar_avance.php");

	}
	else{
		$descripcionA=NULL;
		$co_url=NULL;
	}
			$sql = "SELECT fecha_revision
			FROM avance_semanal
			WHERE fecha_revision = CURDATE()";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	        $arreglo = mysql_fetch_array($result);
	        $fecha = $arreglo['fecha_revision'];

$titulo="Avance Semanal Grupo Empresa";
include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					
					<li>
						<a href="avance_semanal_grupo.php">Avance Semanal</a>
					</li>				
				</ul>
			</div>
			<center><h3>Avance Semanal <?php echo "$fecha";?></h3></center>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> Formulario de Avance Semanal</h2>
					</div>
					<div class="box-content">
						<?php if (!empty($id_gestion) ){
								if ($cantidad_valida) {
								
						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="avance_semanal_grupo.php" accept-charset="utf-8">
								<fieldset>

								<div class="control-group">
								  <label class="control-label" for="fileInput">Enlace Avance:</label>
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