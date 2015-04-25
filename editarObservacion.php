<?php
$titulo="Observaciones sub sistema";
include("conexion/verificar_gestion.php");
session_start();
/*------------------VERIFICAR QUE SEAL EL JEFE CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && ($_SESSION['tipo']!=2) && ($_SESSION['tipo']!=3))
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
include('header.php');
$obs=$_REQUEST['value'];
$grupoEmpresa=$_REQUEST['value2'];
$select="select * from entrega_producto where id_entrega_producto='$obs'";
$q=mysql_query($select) or die("error");
$observacion=mysql_fetch_array($q);
 ?>
 <div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					
					<li>
						<a href="editarObservacion.php?value=<?php echo $obs;?>&value2=<?php echo $grupoEmpresa;?>">Observacion</a>
					</li>
				</ul>
			</div>
<center><h3>Observaciones de subsistema</h3></center>
			<div class="row-fluid">
			<div class="box span12">
					<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> Observaciones al Subsistema "<?php echo $observacion['descripcion'] ?>"</h2>
					</div>
					<div class="box-content">
						<?php if ($gestion_valida){
						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="guardarObservacion.php" accept-charset="utf-8">
								<fieldset>
								<div class="control-group">
									<label class="control-label" for="descripcion">Descripci&oacute;n:</label>
									<div class="controls">
										<textarea id="descripcion"  name="descripcion" placeholder="escriba aca la observacion al subsistema" ><?php echo $observacion['observacion']?></textarea>
									</div>
								</div>
                               
								<div class="control-group">
									<div class="controls">
                                    <input type="hidden" name="id" value="<?php echo $obs ?>"  />
                                    <input type="hidden" name="empresa" value="<?php echo $grupoEmpresa?>"  />
						         		<button name="enviar"type="submit" class="btn btn-primary" id="enviar">Guardar</button>
								        <a href="<?php echo "ver_cronograma.php?entreprod=".$grupoEmpresa ?>"><button type="button" class="btn " style="margin-left:10px">&nbsp;Cancelar</button></a> 
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
			</div><!--/span-->
			</div><!-- fin row -->






















<?php include('footer.php'); ?>