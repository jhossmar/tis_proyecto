<?php
	session_start();
	$valido = $_SESSION['nombre_usuario'];
	if(!$valido || $valido == ""){
	header("Location:../index.php");
	}

	//destruir sesion  y reistrarlo en la bitacora
	session_start();
	include("conexion.php");
	$bitacora = mysql_query("INSERT into bitacora_sesion(usuario,fecha_hora,operacion)
							VALUES (".$_SESSION['id'].",CURRENT_TIMESTAMP,1)",$conn)
	or die("Error en la bitacora.");
	session_destroy();
	//location is on index.php after logout
	header("Location:../index.php");
?>
