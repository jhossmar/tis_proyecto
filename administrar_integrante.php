<?php
include('conexion/verificar_gestion.php');
session_start();
/*------------------VERIFICAR QUE SEAL EL ADMINISTRADOR------------------------*/
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

$titulo="Administrar Integrantes";

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
 			<!--PARTICIONAR
 			<li>
						<a href="#">Inicio</a> <span class="divider">/</span>
			</li>-->
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>

					<li>
						<a href="administrar_integrante.php">Administrar Integrantes</a>
					</li>
				</ul>
			</div>
			<center><h3>Administrar Integrantes</h3></center>
			<div class="row-fluid">
		            <div class="box span12" id="print">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-check"></i> Habilitar Integrantes</h2>

					</div>
					<div class="box-content">
						<?php if($gestion_valida){
						  /*de esta consulta, solo sale el id de la empresa a la cual pertenece el usuario de la sesion*/
                              $consulta_id_ge = mysql_query("SELECT ge.id_grupo_empresa
                               FROM usuario u,integrante i,grupo_empresa ge
                               WHERE u.id_usuario='".$_SESSION['id']."' and u.id_usuario=i.usuario and i.grupo_empresa=ge.id_grupo_empresa",$conn)
                                or die("Could not execute the select query.");
                               $resultado_id_ge = mysql_fetch_assoc($consulta_id_ge);
                               $rep_id_ge=(int)$resultado_id_ge['id_grupo_empresa'];
                          /*de esta consulta, salen todos los trabajadores de la empresa, la cual pertenece a la empresa que a su vez
                          pertenece al usuario de la sesion actual*/
                               $integrantes ="SELECT *
                               from integrante i, usuario u, carrera c
                               where grupo_empresa='$rep_id_ge' and  u.id_usuario=i.usuario AND i.carrera=c.id_carrera";
                               $resultado = mysql_query($integrantes);
                               $cantidad=mysql_num_rows($resultado);
                               if ($cantidad>0) {
							?>
						<form name="form-data" class="form-horizontal cmxform" method="POST" action="conexion/validar_integrante.php" accept-charset="utf-8">
						<table class="table table-striped table-bordered">
						  <thead >
							  <tr >
								 	  <th>Nombre de Usuario</th>
									  <th>Nombre</th>
									  <th>Apellido</th>
									  <th>Tel&eacute;fono</th>
									  <th>Correo Electr&oacute;nico</th>
									  <th>C&oacute;digo SIS</th>
									  <th><center>Habilitado</center></th>
									  <th><center>Roles</center></th>
							  </tr>
						  </thead>
						  <tbody>
                            <?php
                               $identi=0;
                                while($row = mysql_fetch_array($resultado)) {

                               echo "
                                <tr>
    								  <td ><input type=\"hidden\" id=a".$identi." name=a".$identi." value=\"".$row["id_usuario"]."\" ></input> ".$row["nombre_usuario"]."</td>
    								  <td>".$row["nombre"]."</td>
    								  <td>".$row["apellido"]."</td>
    								  <td>".$row["telefono"]."</td>
    								  <td>".$row["email"]."</td>
    								  <td>".$row["codigo_sis"]."</td> ";

                                 $aux= $row["habilitado"];
                                 if ($row['id_usuario']==$_SESSION['id']) {
                                 	if($aux=="1"){
                                           echo "<td ><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi." editable=FALSE checked></center></td>";
                                         }
                                         else{
                                            echo "<td class=\"center\"><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi." editable=FALSE></center></td>";
                                        }
                                 }else{
                                        if($aux=="1"){
                                           echo "<td ><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi."  checked ></center></td>";
                                         }
                                         else{
                                            echo "<td class=\"center\"><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi."></center></td>";
                                        }
                                    }
                                 echo "<td><center><a class=\"btn btn-success\" href=\"editar.php?value=".$row["id_usuario"]."\" >
										<i class=\"icon-edit icon-white\"></i>  
										Editar                                           
										</a></center></td>";
                        		 echo "	</tr> ";
                                 }
                                 $identi++;

                             ?>
                                      <input type="hidden" id="grupo" name="grupo" value=<?php echo $rep_id_ge ?> ></input>
						  </tbody>
					  </table>
					    <div class="control-group">

						         <button name="enviar" type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar Cambios</button>

								 <a href="agregar_integrante.php" class="btn"><i class="icon-user"></i> Agregar Integrantes</a>
								 <button type="button" class="btn" onclick="imprimir();"><i class="icon-print"></i> Imprimir</button>
							
						</div>
                    </form>
                    <?php
                    	}else{
                    	echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        La Grupo Empresa no tiene registrado m&aacute;s integrantes.</h4>
				                      	</div>";
				                      }
                	}else{
                    	echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				                      	</div>";
                    }
?>

					</div>
				</div><!--/span-->
				</div>

				<!-- EDICION DE ROLES DE INTEGRANTES-->
				<div class="modal hide fade" id="myModal3">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h3>Editar Roles del Integrante</h3>
					</div>
					<div class="modal-body">
						<p>Usted va ha realizar la restauraci&oacute;n de la base de datos. La base de datos seleccionada puede no contener la informaci&oacute;n mas reciente del sistema.<br> <b>Nota:</b> Esta operaci&oacute;n no puede deshacerce.</p>
						<?php 
							echo $_GET['value'];
						?>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancelar</a>
						<button type="submit" name="aceptar" value="aceptar" class="btn btn-primary"><i class="icon-ok"></i> Aceptar</button>
					</div>
				</div>



				
<?php include('footer.php'); ?>