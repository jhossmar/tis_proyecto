<?php
    include('conexion.php');
    $c = new Conexion;
    $c->EstablecerConexion();
    $conn = $c->GetConexion(); 
		session_start();
		$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn) or die ("Error no se pudo realizar cambios.");
    
    $c = "SELECT COUNT(*) as numer
          FROM usuario
          WHERE  tipo_usuario ='2' || tipo_usuario ='3'";
    $r = mysql_query($c,$conn);
    $res = mysql_fetch_array( $r);
    $num=  $res['numer'];
    $counta=0;
    while($counta < $num)
    {
      $a=  $_POST["a".$counta];
      $b=  2;
      $c=  0;
      if(!$_POST["b".$counta])
      {
         $b=  3;
      }
      if($_POST["c".$counta])
      {
         $c=  1;
      }
    $sql = "UPDATE usuario SET  tipo_usuario='$b',habilitado='$c' WHERE id_usuario = '$a'";
    mysql_query($sql,$conn);
    $counta++;
    }
    header("Location:../administrar_consultor.php");
?>
