<?php
    include("conexion.php");
	session_start();
	$valido = $_SESSION['nombre_usuario'];
	if(!$valido || $valido == "")
	{
     	header("Location:../index.php");
	}
	
	$conexion = new Conexion;
	$conexion-> EstablecerConexion();
	$conn= $conexion->GetConexion();
	$bitacora = mysql_query("INSERT into bitacora_sesion(usuario,fecha_hora,operacion)
							VALUES (".$_SESSION['id'].",CURRENT_TIMESTAMP,1)",$conn) or die("Error en la bitacora.");
	session_destroy();
	header("Location:../index.php");
?>
