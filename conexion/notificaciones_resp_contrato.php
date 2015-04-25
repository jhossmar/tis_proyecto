<?php
            include('conexion.php');
            session_start();
			$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
			or die("Error no se pudo realizar cambios.");
                       $a=$_POST["usuario"];
                       $b=0;
                       $c=$_POST["c0"];
                       //$sql = "SELECT * FROM usuario WHERE nombre_usuario = '$a'" ;
                       //$result = mysql_query($sql);
                       if($_POST["b0"]){
                          $b=1;                         
                       }
                       if($c == 2){
                         $sql = "UPDATE notificacion
                                     SET leido = '$b'
                                     WHERE usuario= '$a' 
                                     AND tipo_notificacion=2";
                          $result = mysql_query($sql,$conn) or die(mysql_error());
                        }
                        elseif ($c == 3) {
                          $sql = "DELETE FROM notificacion
                                     WHERE usuario= '$a' 
                                     AND tipo_notificacion=3";
                          $result = mysql_query($sql,$conn) or die(mysql_error());

                          $sql = "SELECT enlace_entregable
                                  FROM avance_semanal
                                  WHERE titulo_avance = 'Sobre A' 
                                  AND grupo_empresa='$a'";
                          $result = mysql_query($sql,$conn) or die(mysql_error());
                          $row = mysql_fetch_array($result);
                          unlink("../".$row["enlace_entregable"]);

                          $sql = "DELETE FROM avance_semanal
                                  WHERE titulo_avance = 'Sobre A'
                                  AND grupo_empresa = '$a'";
                          $result = mysql_query($sql,$conn) or die(mysql_error());

                          $sql = "SELECT enlace_entregable
                                  FROM avance_semanal
                                  WHERE titulo_avance = 'Sobre B' 
                                  AND grupo_empresa='$a'";
                          $result = mysql_query($sql,$conn) or die(mysql_error());
                          $row = mysql_fetch_array($result);
                          unlink("../".$row["enlace_entregable"]);

                          $sql = "DELETE FROM avance_semanal
                                  WHERE titulo_avance = 'Sobre B'
                                  AND grupo_empresa = '$a'";
                          $result = mysql_query($sql,$conn) or die(mysql_error());
                        }

               header("Location:../notificaciones_grupo_empresa.php");
?>