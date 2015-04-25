<?php
  include('conexion.php');
	session_start();
	$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
	or die("Error no se pudo realizar cambios.");
              $usuario=(int)$_POST['consultor'];
              $c ="SELECT COUNT(id_documento_consultor) as numer
                    FROM documento_consultor d, gestion_empresa_tis g
                    WHERE g.id_gestion=d.gestion AND consultor_tis=$usuario";
               $r = mysql_query($c);
               $res = mysql_fetch_array($r);
               $num=  $res['numer'];
               $counta=0;
               while($counta < $num){
                       $a = $_POST["a".$counta];
                       $b=0;

                       if($_POST["b".$counta]){
                           $b=1;                     
                       }
                        $sql = "UPDATE documento_consultor
                        SET habilitado='$b'
                        WHERE id_documento_consultor ='$a'";
                        $result = mysql_query($sql);      
                 $counta++;
               }
               header("Location:../administrar_archivos.php");
              
?>
