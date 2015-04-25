<?php
session_start();
include('conexion/verificar_gestion.php');
/*------------------VERIFICAR INGRESO A ESTA SECCION------------------------*/
if(isset($_SESSION['nombre_usuario']))
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
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
/*----------------------FIN VERIFICACION------------------------------------*/

if(isset($_GET['value'])){
	$quien=$_GET['value'];
}
else{
	header('Location: index.php');
}
$quien_ingresa="";
$home="";
switch($quien){
                case (4) :
                	$quien_ingresa="Grupo Empresa";
                    break;
                case (3) :
                	$quien_ingresa="Consultor TIS";
                    break;                                                             		
 } 
$titulo="Registro ".$quien_ingresa; 
include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">					
					<li>
						<a href="index.php">Inicio</a><span class="divider">/</span>
					</li>
					<li>
						<a href="registro_consultor.php">Registro <?php echo $quien_ingresa; ?></a>
					</li>				
				</ul>
			</div>

			<div class="row-fluid">
				<div class="box span12">
						<div class="box-header well">
							<h2><i class="icon-info-sign"></i> Registro exitoso</h2>					
						</div>
						<div class="box-content">
							<?php if ($quien==3) {
								echo "Sus datos se han registrado satisfactoriamente. Para poder acceder a su
		                  			 cuenta debera esperar que el <strong>Administrador del sistema</strong> valide su registro.
		                  			 <br>Para volver al inicio haga click <a href=\"index.php\">aqui</a>";
							}
							elseif ($quien==4) {
								echo "Sus datos se han registrado satisfactoriamente. Para poder acceder a su
		                  			  cuenta debera esperar que el <strong>Consultor TIS</strong> elegido valide su registro.
		                  			  <br>Para volver al inicio haga click <a href=\"index.php\">aqui</a>";
							}?>
		                  	
		                </div>
				</div>
			</div>

<?php include('footer.php'); ?>
