<?php
            include('conexion.php');
            session_start();
			$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
			or die("Error no se pudo realizar cambios.");
              $c = "SELECT COUNT(*) as numer
                  FROM notificacion
                  WHERE  tipo_notificacion=1";
               $r = mysql_query($c);
               $res = mysql_fetch_array( $r);
               $num=  $res['numer'];
               $counta=0;
               while($counta < $num){
                       $a=$_POST["a".$counta];
                       
                       $c=$_POST["c".$counta];
                       //$sql = "SELECT * FROM usuario WHERE nombre_usuario = '$a'" ;
                       //$result = mysql_query($sql);
                       if($_POST["b".$counta]){
                           $sql = "INSERT INTO notificacion(tipo_notificacion, usuario, leido)
                                   VALUES (2, '$a', 0)";
                           $result = mysql_query($sql,$conn) or die(mysql_error());

                           $sql = "DELETE FROM notificacion
                                   WHERE usuario='$a' 
                                   AND tipo_notificacion=1";
                           $result = mysql_query($sql,$conn) or die(mysql_error());                           
                       }
                       else{
                          if($_POST["c".$counta]){
                              $sql = "INSERT INTO notificacion(tipo_notificacion, usuario, leido)
                                     VALUES (3, '$a', 0)";
                             $result = mysql_query($sql,$conn) or die(mysql_error());

                             $sql = "DELETE FROM notificacion
                                     WHERE usuario='$a' 
                                     AND tipo_notificacion=1 ";
                             $result = mysql_query($sql,$conn) or die(mysql_error());  
                          }
                       }
                 $counta++;
               }
               header("Location:../notificaciones_consultor.php");
              
?>