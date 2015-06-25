<?php
$titulo="Modificacion de foto de perfil";
include("conexion/conexion.php");  
    $c = new Conexion;
    $c->EstablecerConexion();
    $conn = $c->GetConexion();
session_start();
include('header.php');
?>
 <!---- ---------------VISOR DE PDF  ------------------------>
	<div class="center">
	  <div id="modal1" class="modalmask">
		<div class="modalbox movedown">
			<a href="#close" title="Close" class="close">X</a>
		
		
		 </div>
	   </div>
	</div>	
	
	</div>
</div><!--/span-->
</div><!-- fin row -->				
			
			
			
			
				
        <div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Ayuda</h2>
					</div>
					<div class="box-content">
					
					<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							Si necesita ayuda, o tiene problemas con el uso del sistema puede contactarse con el <b>Administrador</b>, sus datos se encuentran a continuaci&oacute;n.
						</div>
					<?php
						
							$c = "SELECT nombre,apellido,telefono,email
								FROM usuario
								WHERE tipo_usuario=1";
	               			$r = mysql_query($c,$conn);
	               			$resultado = mysql_fetch_assoc($r);
								if(is_array($resultado) && !empty($resultado))
								{	
										$nombre= $resultado['nombre'];
										$apellido= $resultado['apellido'];
										$telefono= $resultado['telefono'];
										$email= $resultado['email'];
										?>
										<table class="table table-bordered">
								  		<tbody>
											<tr>
												<td><b>Nombre: </b></td>
												<td class="center"><?php echo $nombre." ".$apellido; ?></td>                                       
											</tr>
											<tr>
												<td><b>Tel&eacute;fono: </b></td>
												<td class="center"><?php echo $telefono; ?></td>                                     
											</tr>
											<tr>
												<td><b>Correo electr&oacute;nico: </b></td>
												<td class="center"><?php echo $email; ?></td>                          
											</tr>
											                                    
										  </tbody>
								 		</table>
								<?php }
								else{
									echo "<h4>No se Encontro ning&uacute;n registro";
								}
                      ?>
					</div>
				</div><!--/span-->
			</div><!-- fin row -->



<?php
   include('footer.php');
 ?>

