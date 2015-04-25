<?php
	include('conexion.php');
	$cantidad_valida=false;
	$cantidad_faltante=0;
	$consulta_id_ge = mysql_query("SELECT grupo_empresa
								   FROM integrante
								   WHERE usuario =".$_SESSION['id'],$conn)
	or die("Could not execute the select query.");
    $resultado_id_ge = mysql_fetch_assoc($consulta_id_ge);
    $rep_id_ge=(int)$resultado_id_ge['grupo_empresa'];
	$nombre_usuario=$_SESSION['nombre_usuario'];
	$consulta_sql="SELECT COUNT(*) as numero
				   from  integrante
				   WHERE grupo_empresa=$rep_id_ge";
	$consulta = mysql_query($consulta_sql,$conn)
		or die("Could not execute the select query.");

	$resultado = mysql_fetch_assoc($consulta);
	if (!empty($resultado['numero'])){
		$numero_integrantes=$resultado['numero'];
		if ($numero_integrantes<3) {
			$cantidad_valida=false;
			$cantidad_faltante=3-$numero_integrantes;
		}
		elseif ($numero_integrantes>=3) 
		{
			$cantidad_valida=true;
			$cantidad_faltante=5-$numero_integrantes;
		}
	}
	mysql_free_result($consulta);
?>
