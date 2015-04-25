<?php
include("conexion/verificar_gestion.php");
include('conexion/conexion.php');
session_start();
$id=$_POST['id'];
$observacion=$_POST['descripcion'];
$empresa=$_POST['empresa'];
$usuario=$_SESSION['nombre_usuario'];


$update="update entrega_producto set observacion='$observacion' where id_entrega_producto='$id'";
mysql_query($update) or die("error");
//..........Notificacion de observacion ......//
	$int="select * from integrante i, usuario u where i.usuario=u.id_usuario and i.grupo_empresa='$empresa' and u.tipo_usuario=4";
	$q=mysql_query($int) or die("error");
	$us=mysql_fetch_array($q) or die("error usuario");
	$numUS=$us['id_usuario'];


$nroCons="select * from usuario where nombre_usuario='$usuario'";
$q2=mysql_query($nroCons) or die("error");
$cons=mysql_fetch_array($q2) or die("error usuario");
$nroC=$cons['id_usuario'];

$noti="insert into notificacion(leido,tipo_notificacion,fecha,usuario,usuario_destino) values ('0','17',now(),'$nroC','$numUS') ";
mysql_query($noti) or die("error al crear noticia");




  header("Location: ver_cronograma.php?entreprod=".$empresa);


?>