<?php
    if(!isset($titulo)){
        header('Location: ../index.php');
    }
            include('conexion.php');
              $c = "SELECT COUNT(*) as numer
                  FROM mensaje
                 ";
               $r = mysql_query($c);
               $res = mysql_fetch_array( $r);
               $num=  $res['numer'];
               $counta=0;
               while($counta < $num){
                      
                      $c=  0;
                       $a=  $_POST["a".$counta];
                       if($_POST["c".$counta])     {
                           $c=  1;
                        }
                       //$sql = "SELECT * FROM usuario WHERE nombre_usuario = '$a'" ;
                       //$result = mysql_query($sql);
                       $sql = "UPDATE mensaje SET  visible='$c' WHERE id_mensaje = '$a'";
                       $result = mysql_query($sql);

                 $counta++;
               }
               header("Location:../administrar_mensajes.php");
?>