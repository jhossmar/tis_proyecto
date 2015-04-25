<?php
include("verificar_gestion.php");
session_start();
               $usuario=$_SESSION['id'];
               $consulta = "SELECT id_mensaje, asunto, de_usuario, contenido, fecha_hora
                            FROM mensaje
                            WHERE visible = 1
                            ORDER BY fecha_hora DESC";
               $resultado = mysql_query($consulta);
               $numero = 0;

               $c = "SELECT COUNT(*) as numer
                     FROM mensaje
                     WHERE visible = 1";
               $r = mysql_query($c);
               $res = mysql_fetch_array($r);
               $num=  $res['numer'];

               /*$row_Recordset1 = mysql_fetch_assoc($Recordset1);*/
               /*$totalRows_Recordset1 = mysql_num_rows($Recordset1);*/
               if ($num==0) {
                 echo "<div align=\"center\">
                        <h4><i class=\"icon-info-sign\"></i>
                        No existen comentarios disponibles para mostrar.</h4>
                      </div>";
               }
               else{
                    
                          echo "
                          
                            <table style=\"overflow:hidden; width:100%; max-height=390px;\">";
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
                                          <div class=\"alert alert-info\">
                                            
                                              <input type=\"hidden\" name =\"id_msg\" value=\"".$row['id_mensaje']."\">
                                              
                                            
                                                  <h4>Asunto: ".$row['asunto']." </h4>
                                                  <h4>Por : ".$de." </h4>
                                                  <div class=\"letra_aviso\">".$row["contenido"]." <br></div>
                                                  <div class=\"pie_aviso\">
                                                  <span style=\" text-align:left;\">".$u."</span>";
                                                  echo "<span style=\"float:right;\">Publicado el  ".$row["fecha_hora"]."</span> </div>

                                            </div>
                                                  
                                          </div>
                                          
                                      </td>
                                    </tr>";
                                  $numero++;
                               }
                           echo "</table>";
               
               
        }
?>
