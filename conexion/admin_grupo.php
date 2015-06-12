<?php
    if(!isset($titulo)){
        //header('Location: ../index.php');
    }
            include('conexion.php');
            session_start();
			$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
			or die("Error no se pudo realizar cambios.");
             /* $c = "SELECT COUNT(*) as numer
                  FROM usuario
                  WHERE  tipo_usuario ='4' ";
               $r = mysql_query($c);
               $res = mysql_fetch_array( $r); */
               $num= $_POST["count"];// $res['numer'];
               $counta=0;
               while($counta < $num){
                      $a=  $_POST["a".$counta]; //ide usus
                        $c=  0; //habilitado ?
                        if($_POST["c".$counta])     {
                           $c=  1;
                        }

                       $sql = "UPDATE usuario SET habilitado='$c' WHERE id_usuario = '$a'";
                       $result = mysql_query($sql);

                 $counta++;
               }
               header("Location:../administrar_grupo_empresa.php");
?>