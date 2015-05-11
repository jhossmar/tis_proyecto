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
								  		<div class="span12">
  			<embed src="manual.pdf" width="500" height="375">
  		</div>
								<?php }
								else{
									echo "<h4>No se Encontro ning&uacute;n registro";
								}
                      ?>
					</div>
				</div><!--/span-->
			</div><!-- fin row -->


  <?php include('footer.php'); ?>