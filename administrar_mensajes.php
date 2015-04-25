<?php
$titulo="Administrar Consultores TIS";
include('conexion/verificar_gestion.php');
session_start();
/*------------------VERIFICAR QUE SEAL EL ADMINISTRADOR------------------------*/
    if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=1)
    {/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
            $home="";
            switch  ($_SESSION['tipo']){
                    
                    case (2) :
                        $home="home_consultor_jefe.php";
                        break;
                    case (3) :
                         $home="home_consultor.php";
                         break;
                    case (4) :
                         $home="home_grupo.php";
                         break;
                    case (5) :
                        $home="home_integrante.php";
                        break;                                                                     
                  }   
            header("Location: ".$home);
    }
    elseif(!isset($_SESSION['nombre_usuario'])){
        header("Location: index.php");
    }
/*----------------------FIN VERIFICACION------------------------------------*/
include('header.php');
 ?>
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
						<a href="administrar_mensajes.php">Administrar Espacio de Discuci&oacute;n</a>
					</li>
				</ul>
			</div>
			<center><h3>Administrar Espacio de Discuci&oacute;n</h3></center>
			<div class="row-fluid">
		            <div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Administrar Espacio de Discuci&oacute;n</h2>

					</div>
					<div class="box-content">
            <?php 
                include('conexion/conexion.php');
                 $consulta = "SELECT *
                              FROM mensaje
                              ORDER BY fecha_hora DESC";
                 $resultado = mysql_query($consulta);
                $num_res=mysql_num_rows($resultado);
                 if ($num_res>0) {
              ?>
            <form method="post" action="conexion/admin_msg.php" accept-charset="utf-8">
						<table class="table table-striped table-bordered  datatable">
              <thead>
                <tr>
                  <th><center>Comentarios Disponibles</center></th>
                  
                </tr>
              </thead> 
						 
						  <tbody>
              <?php
                              $identi=0;
                              while($row = mysql_fetch_array($resultado))
                                {
                                  $x = $row['de_usuario'];
                                  $ci = "SELECT nombre, apellido
                                        FROM usuario
                                        WHERE id_usuario = '$x'";
                                  $ri = mysql_query($ci);
                                  $resi = mysql_fetch_array($ri);
                                  $de = $resi['nombre']." ". $resi['apellido'];

                                  $x = $row['de_usuario'];
                                  $ci = "SELECT i.descripcion
                                        FROM usuario u, tipo_usuario i
                                        WHERE u.id_usuario = '$x'
                                        AND u.tipo_usuario = i.id_tipo_usuario";
                                  $ri = mysql_query($ci);
                                  $resi = mysql_fetch_array($ri);
                                  $u = $resi['descripcion'];

                         echo "  <tr>
                                     <td>
                                          <div class=\"alert alert-info\"><span style=\"float: right;\" >Visible: ";
                                                  echo "<input type=\"hidden\" id=a".$identi." name=a".$identi." value=".$row['id_mensaje'].">";
                                                 $aux= $row["visible"];
                                                  if($aux=="1"){
                                                     echo "<input type=\"checkbox\" id=c".$identi." name=c".$identi." checked>";
                                                   }
                                                   else{
                                                      echo "<input type=\"checkbox\" id=c".$identi." name=c".$identi.">";
                                                  }
                                                  echo "</span>
                                                  <h4>Asunto: ".$row['asunto']." </h4>
                                                  <h4>Por : ".$de." </h4>
                                                  <div class=\"letra_aviso\">".$row["contenido"]." <br></div>
                                                  <div class=\"pie_aviso\">
                                                  <span style=\" text-align:left;\">".$u."</span>";
                                                  echo "<span style=\"float:right;\">Publicado el ".$row["fecha_hora"]."</span> </div>

                                            </div>
                                                  
                                          </div>
                                          
                                      </td>
                                    </tr>
                                    ";
                                    $identi++;
                               }
                             ?>

						  </tbody>
					  </table>
					  <div style="padding-left:10px;">
                      <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar cambios</button>
                      </div>
                    </form>
                   <?php }
                            else{
                              echo "<div align=\"center\">
                                <h4><i class=\"icon-info-sign\"></i>
                                No existe ninguna Publicacion</h4>
                                </div>";
                            }

                  ?>
					</div>
				</div><!--/span-->
				</div>
<?php include('footer.php'); ?>