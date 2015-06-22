<?php
  include('conexion.php');
    $c = new Conexion;
    $c->EstablecerConexion();
    $conn = $c->GetConexion();
	session_start();
	$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)or die("Error no se pudo realizar cambios.");
              
              $u=$_POST["grupo"];
              $c ="SELECT count(*) as numer
                              from integrante i, usuario u, carrera c
                               where grupo_empresa='$u' and  u.id_usuario=i.usuario AND i.carrera=c.id_carrera";
               $r = mysql_query($c,$conn);
               $res = mysql_fetch_array($r);
               $num=  $res['numer'];
               $counta=0;
               while($counta < $num)
               {
                       $a=$_POST["a".$counta];
                       $b=0;

                       if($_POST["b".$counta]=="on")
                       {
                         $b=1;
                       }
                        $sql = "UPDATE usuario
                        SET habilitado='$b'
                        WHERE id_usuario = '$a'";
                        $result = mysql_query($sql,$conn);
                   $counta++;
               }
               header("Location:../administrar_integrante.php");
              
?>
