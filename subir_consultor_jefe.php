<?php
session_start();
include('conexion/verificar_gestion.php');
$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
							or die("Error no se pudo realizar cambios.");
/*------------------VERIFICAR QUE SEAL EL JEFE CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=2)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
	                    break;
	            case (4) :
	                	$home="home_grupo.php";
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
if(isset($_POST['enviar'])){
	include('conexion/conexion.php');	
	$descripcion=$_POST['descripcion'];
	$usuario=$_SESSION['nombre_usuario'];
	$tituloD=$_POST['tituloD'];
	$error=false;
	include ('conexion/anuncioSubir.php') ;
	/*SUBIDA DEL ARCHIVO ADJUNTO*/
	$documento="";
   	$tiene_doc=0;
    $ext_permitidas = array('.pdf','.doc','.docx','.xls','.xlsx','.ppt','.pptx');
	   if(!empty($_FILES['documento']['name'])){
	   		$idUnico = time();

            $nombre_archivo = $_FILES['documento']['name'];
            $nombre_tmp = $_FILES['documento']['tmp_name'];
            $ext = substr($nombre_archivo, strpos($nombre_archivo, '.'));
            $tamano = $_FILES['documento']['size'];             
            $limite = 1000 * 1024;
            if(in_array($ext, $ext_permitidas)){
            	if( $tamano <= $limite ){
                    if( $_FILES['documento']['error'] <= 0 ){
                    	if( file_exists( 'archivos/'.$idUnico.'-'.$nombre_archivo) ){
                              $error_doc='El archivo ya existe';
                              $error=true;
                        }
                        else{ 
                        	 move_uploaded_file($nombre_tmp,'archivos/'.$idUnico.'-'.$nombre_archivo);
                             $documento='archivos/'.$idUnico.'-'.$nombre_archivo;
                             $tiene_doc=1;
                        }
                      
                     }
                     else{
                     		$error_doc='Error al subir el archivo';
                      		$error=true;

                       }
                    }
                else{
                      $error_doc='El archivo debe un tama&ntilde;o menor a 1 Mega Byte';
                      $error=true;
                    }
            }
            else{
            	$error=true;
            	$error_doc='El formato del archivo no esta permitido';
            }

   	}


	/*FIN ARCHIVO ADJUNTO*/

	if(!$error){

            $sql = "INSERT INTO documento_consultor(nombre_documento, descripsion_documento, ruta_documento, fecha_documento, documento_jefe, consultor_tis, gestion)
	                VALUES ('$tituloD','$descripcion','$documento', NOW(), 1,'".$_SESSION['id']."',$id_gestion)";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	        header("Location: index.php");
	    }
	}
	else{
		$tituloD=NULL;
		$descripcionA=NULL;
		$descripcion=NULL;
		$usuario=NULL;
	}

$titulo="Publicar avisos Jefe Consultor TIS";
include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					
					<li>
						<a href="subir_consultor_jefe.php">Publicar avisos</a>
					</li>
				</ul>
			</div>
			<center><h3>Publicar Avisos</h3></center>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> Formulario de publicaci&oacute;n de avisos</h2>
					</div>
					<div class="box-content">
						<?php if ($gestion_valida){
						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="subir_consultor_jefe.php" accept-charset="utf-8">
								<fieldset>
								<div class="control-group">
								  <label class="control-label" for="tituloD">T&iacute;tulo: </label>
								  <div class="controls">
									<input type="text" placeholder="T&iacute;tulo del aviso" name="tituloD" id="tituloD" value='<?php echo $tituloD; ?>'>
								  </div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Descripci&oacute;n:</label>
									<div class="controls">
										<textarea id="descripcion" placeholder="Descripci&oacute;n del aviso" name="descripcion" ><?php echo $descripcion; ?></textarea>
									</div>
								</div>
                                    <label class="ayudas"> El archivo a subir debe ser de 1 Mb maximo :</label>
								<div class="control-group">
								  <label class="control-label" for="fileInput">Documento:</label>
								  <div class="controls">
									<input class="input-file uniform_on" name="documento" id="documento"  type="file" />
									<label class="error"><?php if(isset($error_doc)){ echo $error_doc; } ?></label>
								  </div>
								</div>
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Publicar</button>
								 <button type="reset" class="btn">Cancelar</button>
								 </div>
								 </div>
						        </fieldset>
							</form>
							<?php
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
			</div><!-- fin row -->
<?php include('footer.php'); ?>