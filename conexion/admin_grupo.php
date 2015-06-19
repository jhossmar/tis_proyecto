<?php
    include('conexion.php');
    $co = new Conexion;
    $co->EstablecerConexion();
    $conn = $co->GetConexion();
    session_start();
		$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)or die("Error no se pudo realizar cambios.");
    $c = "SELECT COUNT(*) as numer
          FROM usuario
          WHERE  tipo_usuario ='4'";
    $r = mysql_query($c,$conn);
    $res = mysql_fetch_array( $r);
    $num= $_POST["count"];
    $counta=0;
    while($counta < $num)
    {
      $a=$_POST["a".$counta];
      $c=0;
      if($_POST["c".$counta])
      {
         $c=1;
      }      
      $sql = "UPDATE usuario SET habilitado='$c' WHERE id_usuario = '$a'"; 
      mysql_query($sql,$conn);
      $counta++;
    }
    header("Location:../administrar_grupo_empresa.php");
?>