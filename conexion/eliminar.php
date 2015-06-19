<?php	
	$id=$_POST['id_msg'];

			$sql = "DELETE FROM mensaje
					WHERE id_mensaje = '$id'";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	}
//echo '<meta http-equiv="REFRESH" content="0;url=../mensajes_consultor.php">';
?>
