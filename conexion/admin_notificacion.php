<?php
    if(!isset($titulo)){
        header('Location: ../index.php');
    }
    $usuario=$_POST['id_usuario'];
    $num=$_POST['numero'];
            include('conexion.php');
              
               $counta=0;
               while($counta < $num){
                      
                      $c=  0;
                       $a=  $_POST["a".$counta];
                       if($_POST["c".$counta])     {
                           $c=  1;
                        }
                       //$sql = "SELECT * FROM usuario WHERE nombre_usuario = '$a'" ;
                       //$result = mysql_query($sql);
                       $sql = "UPDATE notificacion SET  leido='$c' WHERE id_notificacion = '$a'";
                       $result = mysql_query($sql);

                 $counta++;
               }
               header("Location:../notificaciones.php");
?>