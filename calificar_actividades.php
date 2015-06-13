<?php
include("conexion/verificar_gestion.php");
$verificarG = new VerificarGestion();
$gestionValida = $verificarG->VerificarFechasGestion();
$verificarG->Actividad1();
$verificarG->Actividad2();
$verificarG->Actividad3();
$verificarG->Actividad4();
$verificarG->Actividad5();
$verificarG->Actividad6();
$verificarG->Actividad7();
$conn = $verificarG->GetConexion();
$titulo="calificar actividades";
session_start();
$usuario=$_SESSION['nombre_usuario'];
include("header.php");
?>
<div>
	<ul class="breadcrumb">
		<li>
			<a href="index.php">Inicio</a>
			<span class="divider">/</span>
		</li>
		<li>
			<a href="calificar_actividades.php">calificar actividades</a>
		</li>				
	</ul>
</div>
	<center><h3>calificar las actividades de la grupo empresa</h3></center>
<?php
$consulta_consultor = mysql_query("SELECT id_usuario from usuario 
		                          where nombre_usuario='$usuario' AND (gestion=1 OR gestion=$verificarG->id_gestion)",$conn)
		                          or die("Could not execute the select query.");//unico para la gestion
$resultado_consultor = mysql_fetch_assoc($consulta_consultor);
		    
	if(!empty($resultado_consultor))
	{     
		//echo "<center><h3>".$resultado_consultor['id_usuario']."</center></h3>";
		$consultor=	$resultado_consultor['id_usuario'];
		$consulta_grupo = mysql_query("SELECT nombre_largo 
			                           FROM grupo_empresa 			
		                               WHERE consultor_tis='$consultor'",$conn)
		                               or die("Could not execute the select query.");
        $resultado_grupo = mysql_fetch_assoc($consulta_grupo);
        if(!empty($resultado_grupo))
	    { 
	    	echo "<h3>".$resultado_grupo['nombre_largo']."</h3>";
	    }
	}

		
?>