<?php
  if(!isset($titulo)){
    header('Location: ../index.php');
  }

               $usuario=$_SESSION['id'];
               $consulta = "SELECT  id_notificacion,usuario, descripcion, enlace, fecha, leido
                            FROM notificacion, tipo_notificacion
                            WHERE (tipo_notificacion = id_tipo_notificacion
                            AND usuario_destino = $usuario) AND fecha <= '$fin_gestion 23:59:59' AND fecha>='$ini_gestion 00:00:01'
                            ORDER BY fecha DESC";
               $resultado = mysql_query($consulta);
               $numero = 0;

                $resultado = mysql_query($consulta);
                $num_res=mysql_num_rows($resultado);
                 if ($num_res>0) {
              ?>
            <form method="post" action="conexion/admin_notificacion.php" accept-charset="utf-8">
            <table class="table table-striped table-bordered  datatable">
              <thead>
                <tr>
                  <th><center>Notificaciones de la gesti&oacute;n : <?php echo $nombre_gestion; ?></center></th>
                  
                </tr>
              </thead> 
             
              <tbody>
              <?php
                              $identi=0;
                              while($row = mysql_fetch_array($resultado))
                                {
                                  $x = $row['usuario'];
                                  $ci = "SELECT nombre, apellido
                                        FROM usuario
                                        WHERE id_usuario = '$x'";
                                  $ri = mysql_query($ci);
                                  $resi = mysql_fetch_array($ri);
                                  $de = $resi['nombre']." ". $resi['apellido'];

                                  $ci = "SELECT i.descripcion
                                        FROM usuario u, tipo_usuario i
                                        WHERE u.id_usuario = '$x'
                                        AND u.tipo_usuario = i.id_tipo_usuario";
                                  $ri = mysql_query($ci);
                                  $resi = mysql_fetch_array($ri);
                                  $u = $resi['descripcion'];

                         echo "  <tr>
                                     <td>
                                          <div class=\"alert alert-info\"><span style=\"float: right;\" >Leido: ";
                                                  echo "<input type=\"hidden\" id=a".$identi." name=a".$identi." value=".$row['id_notificacion'].">";
                                                 $aux= $row["leido"];
                                                  if($aux=="1"){
                                                     echo "<input type=\"checkbox\" id=c".$identi." name=c".$identi." checked>";
                                                   }
                                                   else{
                                                      echo "<input type=\"checkbox\" id=c".$identi." name=c".$identi.">";
                                                  }
                                                  echo "</span>
                                                  
                                                  <h4>Por : ".$de." </h4>
                                                  <div class=\"letra_aviso\">".$row["descripcion"]." <br></div>
                                                  <div class=\"pie_aviso\">
                                                  <span style=\" text-align:left;\">".$u."</span>";
                                                  echo "<span style=\"float:right;\">Realizado el ".$row["fecha"]."</span> </div>

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