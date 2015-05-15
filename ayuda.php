<?php
$titulo="Ayuda del Sistema de Apoyo a la Empresa TIS";
include("conexion/verificar_gestion.php");
session_start();
include('header.php');

?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="home_consultor.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="ayuda.php">Ayuda</a>
					</li>
				</ul>
			</div>
			<center><h3>Ayuda del Sistema de Apoyo a la Empresa TIS</h3></center>
			
		
	<div class="row-fluid">
	 <div class="box span12">
	       <div class="box-header well">
		     <h2><i class="icon-info-sign"></i> Ayuda</h2>
		   </div>
	    <div class="box-content">		
	  <div id = "menu">
		<ul>
			<li><a href="ayuda.php?nom_arch=002#modal1">INTRODUCCION</a></li>
			<li><a href="ayuda.php?nom_arch=003#modal1">VISTA PRINCIPAL</a></li>
			<li><a href="ayuda.php?nom_arch=004#modal1">FUNCIONES DEL ADMINISTRADOR</a></li>
			<li><a href="ayuda.php?nom_arch=005#modal1">FUNCIONES DEL CONSULTOR TIS</a></li>
		    
            <li><a href="ayuda.php?nom_arch=007#modal1">FUNCIONES DEL GRUPO EMPRESA E INTEGRANTES </a></li>		
		    <li><a href="ayuda.php?nom_arch=008#modal1">FUNCIONES DE LOS INTEGRANTES</a></li>
		    <li><a href="ayuda.php?nom_arch=009#modal1">FUNCIONES ADICIONALES</a></li>
		</ul>
		
	
	</div>
	<!---- ---------------VISOR DE PDF  ------------------------>
	<div class="center">
	  <div id="modal1" class="modalmask">
		<div class="modalbox movedown">
			<a href="#close" title="Close" class="close">X</a>
		<?php
			error_reporting(E_ALL ^ E_NOTICE); //para que no muestre el error la primera vez que se ingrese a ayuda
			
			$id=$_GET['nom_arch'];
			//echo($id);
			//echo "<h2>".$id."</h2>";
			echo "<embed src='archivos/".$id.".pdf' width=900 height=500 />";
	      ?>
		
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


