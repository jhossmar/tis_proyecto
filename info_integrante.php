<?php
session_start();

$quien_ingresa="Grupo Empresa";
$pag_ini="home_grupo.php";

/*------------------VERIFICAR QUE SEAL EL CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
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

$titulo="Informacion de la Grupo Empresa"; 
include('header.php');
 ?>
<script type="text/javascript">
	function imprimir(){
  var objeto=document.getElementById('print');  //obtenemos el objeto a imprimir
  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
  ventana.document.close();  //cerramos el documento

  	var css = ventana.document.createElement("link");
	css.setAttribute("href", "css/style.css");
	css.setAttribute("rel", "stylesheet");
	css.setAttribute("type", "text/css");
	ventana.document.head.appendChild(css);


  ventana.print();  //imprimimos la ventana
  ventana.close();  //cerramos la ventana
}

</script>


			<div>
				<ul class="breadcrumb">					
					<li>
						<a href="index.php">Inicio</a><span class="divider">/</span>
					</li>
					<li>
						<a href='info_integrante.php'> Integrantes de la Grupo Empresa </a>
					</li>				
				</ul>
			</div>
			<center><h3>Informaci&oacute;n de los integrantes de la Grupo Empresa</h3></center>
			<div class="row-fluid">
				<div class="box span12 center" id="print">
					<?php if($_SESSION['tipo']==4) { ?>
		                	<div class="box-header well">
							<h2><i class="icon-info-sign"></i> Integrantes de la Grupo Empresa</h2>					
						</div>
						<div class="box-content padding-in" style="text-align:left;" >
							<table class="table table-striped">
							  <thead>
								  <tr>
									  <th>Nombre de Usuario</th>
									  <th>Nombre</th>
									  <th>Apellido</th>
									  <th>Tel&eacute;fono</th>
									  <th>Correo Electr&oacute;nico</th>
									  <th>C&oacute;digo SIS</th>
									  <th>Habilitado</th>
								  </tr>
							  </thead>
							  <tbody> 
							<?php 
								include('conexion/conexion.php');
								$integrantes ="SELECT id_integrante,nombre, apellido, telefono, codigo_sis, nombre_carrera, usuario.nombre_usuario, email,habilitado from integrante, usuario, carrera where grupo_empresa='$nombre_usuario' and  usuario.nombre_usuario=integrante.nombre_usuario AND carrera=carrera.id_carrera";
								$resultado = mysql_query($integrantes,$conn);
			                    while($fila = mysql_fetch_array($resultado)) { ?>
									<tr>
										<td class="center"><?php echo $fila['nombre_usuario']; ?></td>
										<td class="center"><?php echo $fila['nombre']; ?></td>                                      
										<td class="center"><?php echo $fila['apellido']; ?></td>                                       
										<td class="center"><?php echo $fila['telefono']; ?></td>                                      
										<td class="center"><?php echo $fila['email']; ?></td>                                     
										<td class="center"><?php echo $fila['codigo_sis']; ?></td>                          
										<td class="center"><?php if($fila['habilitado']=1){
															echo "Si";	}
															else{
																echo "No";
															} ?>
										</td>                          
									</tr>                                     
			                    <?php } ?>
			                    </tbody>
			                    </table>					
							 <div class="row-fluid">
							 <div class="span12" style="padding:10px;">  
							 	<button type="button" class="btn btn-primary" onclick="imprimir();">Imprimir</button>
								
							</div>
						</div>
		                </div>
		               <?php } ?>
				</div>
			</div>
<?php include('footer.php'); ?>
