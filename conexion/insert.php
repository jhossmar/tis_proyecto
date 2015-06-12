<?php
include("verificar_gestion.php");
session_start();
if(isset($_POST['enviar'])){	
	$mensaje=$_POST['mensaje'];
	$asunto=$_POST['tituloD'];
	$usuario=$_SESSION['nombre_usuario'];
	$id_usuario=$_SESSION['id'];

			$sql = "INSERT INTO mensaje(fecha_hora, contenido, leido, de_usuario, asunto, visible)
					VALUES (NOW(), '".$mensaje."', 0, $id_usuario,'".$asunto."', 1)";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	}
	else{
		$mensaje=NULL;
		$asunto= NULL;
	}
echo '<meta http-equiv="REFRESH" content="0;url=../mensajes.php">';
?>
