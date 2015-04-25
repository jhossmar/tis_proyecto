<?php
$titulo="Enviar Documentos Grupo Empresa";
include('conexion/verificar_gestion.php');
session_start();
$quien_ingresa="Grupo Empresa";
$pag_ini="home_grupo.php";
/*------------------VERIFICAR QUE SEAL EL CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
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
include("conexion/verificar_integrantes.php");
if(isset($_POST['enviar'])){
	$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
      or die("Error no se pudo realizar cambios.");
	$sobreA=$_FILES['documentoA'];
	$sobreB=$_FILES['documentoB'];
	$usuario=$_SESSION['nombre_usuario'];
	$errorA=false;
	/*SUBIDA DEL ARCHIVO ADJUNTO SOBRE A*/
	$documentoA="";
   	$tiene_doc=0;
    $ext_permitidas = array('.pdf','.doc','.docx','.xls','.xlsx','.ppt','.pptx','.zip','.rar');
	   if(!empty($_FILES['documentoA']['name'])){
	   		$idUnico = time();

            $nombre_archivo = $_FILES['documentoA']['name'];
            $nombre_tmp = $_FILES['documentoA']['tmp_name'];
            $ext = substr($nombre_archivo, strpos($nombre_archivo, '.'));
            $tamano = $_FILES['documentoA']['size'];             
            $limite = 1000 * 1024;
            if(in_array($ext, $ext_permitidas)){
            	if( $tamano <= $limite ){
                    if( $_FILES['documentoA']['error'] <= 0 ){
                    	if( file_exists( 'archivos/'.str_replace(" ", "_", $usuario).'-'.'sobreA'.$ext) ){
                              $error_docA='El archivo ya existe';
                              $errorA=true;
                        }
                        else{ 
                        	 $nombre_tmp_A=$nombre_tmp;
                             $documentoA='archivos/'.$usuario.'-'.'sobreA'.$ext;
                             $tiene_doc=1;
                        }
                     }
                     else{
                     		$error_docA='Error al subir el archivo';
                      		$errorA=true;
                       }
                    }
                else{  
                      $error_docA='El archivo debe un tama&ntilde;o menor a 1 Mega Byte';
                      $errorA=true;
                    }
            }
            else{
            	$errorA=true;
            	$error_docA='El formato del archivo no esta permitido';
            }

   	}
   	else
   	{
   		$error_docA='No se subio el sobre A';
   		$errorA=true;
   	}


	/*FIN ARCHIVO ADJUNTO*/

	/*SUBIDA DEL ARCHIVO ADJUNTO SOBRE B*/
	$errorB=false;
	$documentoB="";
   	$tiene_doc=0;
	   if(!empty($_FILES['documentoB']['name'])){
	   		$idUnico = time();

            $nombre_archivo = $_FILES['documentoB']['name'];
            $nombre_tmp = $_FILES['documentoB']['tmp_name'];
            $ext = substr($nombre_archivo, strpos($nombre_archivo, '.'));
            $tamano = $_FILES['documentoB']['size'];             
            $limite = 1000 * 1024;
            if(in_array($ext, $ext_permitidas)){
            	if( $tamano <= $limite ){
                    if( $_FILES['documentoB']['error'] <= 0 ){
                    	if( file_exists( 'archivos/'.str_replace(" ", "_", $usuario).'-'.'sobreB'.$ext) ){
                              $error_docB='El archivo ya existe';
                              $errorB=true;
                        }
                        else{ 
                        	 if(!$errorA)
                        	 {
                        	 	$documentoA = str_replace(" ", "_", $documentoA);
                        	 	$documentoB='archivos/'.$usuario.'-'.'sobreB'.$ext;
                        	 	$documentoB = str_replace(" ", "_", $documentoB);
                        	 	move_uploaded_file($nombre_tmp_A, $documentoA);
                        	 	move_uploaded_file($nombre_tmp, $documentoB);
                             	$tiene_doc=1;
                             	header("Location: subir_grupo_empresa.php");
                             	$sql = "UPDATE grupo_empresa
										SET sobre_a = '$documentoA', sobre_b = '$documentoB',observacion=NULL
										WHERE id_grupo_empresa = $rep_id_ge";
						        $result = mysql_query($sql,$conn);
                             }
                        }
                     }
                     else{
                     		$error_docB='Error al subir el archivo';
                      		$errorB=true;
                       }
                    }
                else{  
                      $error_docB='El archivo debe un tama&ntilde;o menor A 1 Mega Byte';
                      $errorB=true;
                    }
            }
            else{
            	$errorB=true;
            	$error_docB='El formato del archivo no esta permitido';
            }

   	}
   	else
   	{
   		$error_docB='No se subio el sobre B';
   		$errorB=true;
   	}
	/*FIN ARCHIVO ADJUNTO*/
	}
	else{
		$descripcionA=NULL;
		$descripcionB=NULL;
		$sobreA=NULL;
		$sobreB=NULL;
		$usuario=NULL;
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
						<a href="subir_grupo_empresa.php">Documentos</a>
					</li>				
				</ul>
			</div>
			<center><h3>Documentos</h3></center>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> Formulario de env&iacute;o de Documentos</h2>
					</div>
					<div class="box-content">
						<?php if($gestion_valida){
								if ($cantidad_valida) {
									if($act_3==1 && !$act_3_espera){
								$consulta_producto = mysql_query("SELECT sobre_a, sobre_b,observacion,habilitado
																FROM grupo_empresa
																WHERE id_grupo_empresa = $rep_id_ge",$conn);
								$resultado = mysql_fetch_assoc($consulta_producto);
								if(is_null($resultado['sobre_a']) && is_null($resultado['sobre_a']) ){//si se envio y yarespondio mostrar
									if (!is_null($resultado['observacion'])) {
									?>
									<div class="alert alert-info">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Documentos no aceptados: </strong><?php echo $resultado['observacion']; ?>
									</div> 
									<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="subir_grupo_empresa.php" accept-charset="utf-8">
									<fieldset>
									<div class="control-group">
									  <label class="control-label" for="fileInput">Sobre A:</label>
									  <div class="controls">
										<input class="input-file uniform_on" name="documentoA" id="documento"  type="file" />
										<label class="error"><?php if(isset($error_docA)){ echo $error_docA; } ?></label>
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="fileInput">Sobre B:</label>
									  <div class="controls">
										<input class="input-file uniform_on" name="documentoB" id="documento"  type="file" />
										<label class="error"><?php if(isset($error_docB)){ echo $error_docB; } ?></label>
									  </div>
									</div>
									<div class="control-group">
										<div class="controls">
							         <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Enviar</button>
									 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
									 </div>
									 </div>
							        </fieldset>
							        <b>Nota: </b>Las extensiones permitidas son: pdf, doc, docx, xls, xlsx, ppt, pptx, zip, rar.
									</form>	
									<?php }else
									{ ?>
										<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="subir_grupo_empresa.php" accept-charset="utf-8">
								<fieldset>
								<div class="control-group">
								  <label class="control-label" for="fileInput">Sobre A:</label>
								  <div class="controls">
									<input class="input-file uniform_on" name="documentoA" id="documento"  type="file" />
									<label class="error"><?php if(isset($error_docA)){ echo $error_docA; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="fileInput">Sobre B:</label>
								  <div class="controls">
									<input class="input-file uniform_on" name="documentoB" id="documento"  type="file" />
									<label class="error"><?php if(isset($error_docB)){ echo $error_docB; } ?></label>
								  </div>
								</div>
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Enviar</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								 </div>
								 </div>
						        </fieldset>
						        <b>Nota: </b>Las extensiones permitidas son: pdf, doc, docx, xls, xlsx, ppt, pptx, zip, rar.
							</form>
							<?php		}
									}elseif (is_null($resultado['observacion']) && !is_null($resultado['sobre_a']) && !is_null($resultado['sobre_a']) && $resultado['habilitado']==0) {
										echo "<div align=\"center\">
					                        <h4><i class=\"icon-info-sign\"></i>
					                        Usted ya envi&oacute; sus documentos, debe esperar la validaci&oacute;n del Consultor TIS asignado</h4>
					                      	</div>";
									}elseif ($resultado['habilitado']==1) {
										?>
											<div class="alert alert-success">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Documentos aceptados: </strong>Su Consultor TIS asignado ha aceptados sus documentos
											</div>
											<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="subir_grupo_empresa.php" accept-charset="utf-8">
											<div class="control-group">
							                  <label class="control-label">Sobre A: </label>
							                  <div class="controls">
							                  <label class="control-label2"><a href="<?php echo $resultado['sobre_a']; ?>"><i class="icon-download-alt"></i> Descargar</a> </label>
							                  </div>
							                </div>
							                <div class="control-group">
							                  <label class="control-label">Sobre B: </label>
							                  <div class="controls">
							                  <label class="control-label2"><a href="<?php echo $resultado['sobre_b']; ?>"><i class="icon-download-alt"></i> Descargar</a></label>
							                  </div>
							                </div>
							            </form>
										<?php } 
								}
								else{
									echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        El env&iacute;o de documentos no est&aacute; disponible, contacte con el Jefe Consultor TIS.</h4>
				                      	</div>";
									
									}
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
				                        La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				                      	</div>";
						}
							?>
		                </div>	
				</div><!--/span-->  
			</div><!-- fin row -->

			<div class="row-fluid">
		            <div class="box span12" id="print">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-check"></i> Documentos Compartidos por el Consultor TIS</h2>

					</div>
					<div class="box-content">
						<?php if($gestion_valida) {
                               $consulta ="SELECT g.consultor_tis, nombre_documento,ruta_documento,descripsion_documento,fecha_documento
											FROM grupo_empresa g , documento_consultor d
											WHERE id_grupo_empresa=$rep_id_ge AND g.consultor_tis=d.consultor_tis AND d.habilitado=1 AND d.documento_jefe=0";
                               $resultado = mysql_query($consulta);
                               $num_res=mysql_num_rows($resultado);

                              if ($num_res>0) {
							?>
							<table class="table table-striped table-bordered  datatable" >
							  <thead>
								  <tr >
									 	  <th>Archivo</th>
										  <th>Descripci&oacute;n</th>
										  <th>Fecha de creaci&oacute;n</th>
										  
								  </tr>
							  </thead>
							  <tbody >
						  
						  	
                            <?php
                                while($row = mysql_fetch_array($resultado)) {
                               echo "
                                <tr>
    								  <td ><a href='".$row['ruta_documento']."' >".$row["nombre_documento"]."</a></td>

    								  <td>".$row['descripsion_documento']."</td>

    								  <td>".$row["fecha_documento"]."</td>";
                                 
                        		 echo "</tr> ";
                                }
                             ?>
						  </tbody>
					  </table>
                    <?php 	}
                            else{
                            	echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No existe ning&uacute;n archivo disponible.</h4>
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



<?php include('footer.php'); ?>