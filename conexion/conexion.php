<?php
/*CONEXION CON LA BASE DE DATOS USUARIO:jimmy PASS:201101027 BASEDEDATOS:sistema_tis*/
	$conn = mysql_connect("localhost","munisoft","WSVBtmXg") or die("Error en conexion");
	mysql_select_db("tis_munisoft", $conn) or die("Error en base de datos");
	mysql_query("SET NAMES 'utf8'");
?>
