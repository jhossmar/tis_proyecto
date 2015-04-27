<?php
include('conexion/verificar_gestion.php');
session_start();
if(isset($_SESSION['nombre_usuario']) && ($_SESSION['tipo']==1))
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
$titulo="Sistema de Apoyo a la Empresa TIS";
$asunto=NULL;
include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="mensajes.php">Espacio de Discuci&oacute;n</a>
					</li>
				</ul>
			</div>
			<center><h3>Espacio de Discuci&oacute;n</h3></center>
			<?php if($gestion_valida){ ?>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-check"></i> Publicar Comentario </h2>
					</div>
					<div class="box-content">
						<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="conexion/insert.php" accept-charset="utf-8">
								<fieldset>
								<div class="control-group">
								  <label class="control-label" for="tituloD">T&iacute;tulo </label>
								  <div class="controls">
									<input type="text" placeholder="Titulo del comentario" name="tituloD" id="tituloD" value='<?php echo $asunto; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="fileInput">Comentario:</label>
								  <div class="controls">
									<textarea id="mensaje" name="mensaje" placeholder="Escribir el comentario"></textarea>
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
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-check"></i> Comentarios</h2>
						<div class="box-icon">
								<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>	
					</div>
				
					<div class="box-content" id="ventanachat">

					</div>

				
				</div><!--/span-->
			</div><!-- fin row -->

<script stype="text/javascript">
			function ventanachat(){
				var xmlHttp;
				if (window.XMLHttpRequest)
				  {
				  xmlHttp=new XMLHttpRequest();
				  }
				else
				  {
				  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				  
				xmlHttp.onreadystatechange=function(){
						if(xmlHttp.readyState==4){
							document.getElementById("ventanachat").innerHTML=xmlHttp.responseText;
							setTimeout('ventanachat()', 1000);
						}
						
						}
						xmlHttp.open("POST","conexion/mensajes.php",true);
					xmlHttp.send(null);
			}
			window.onload = function startrefresh(){
					setTimeout('ventanachat()',1000);
				}
		</script>
		<?php 
		}else{ ?>
		<div class="row-fluid">
				<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-check"></i> Comentarios</h2>
					</div>
				
					<div class="box-content">
						<div align="center">
				                        <h4><i class="icon-info-sign"></i>
				                        La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				        </div>
					</div>	
				</div><!--/span-->
			</div><!-- fin row -->
		<?php }
include('footer.php'); ?>
