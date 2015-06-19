<?php
session_start();
include("conexion/verificar_actividades.php");

$verificarA = new VerificarActividades;
$gestionValida = $verificarA->GetGestionvalida();
$verificarA->Actividad1();
$verificarA->Actividad2();
$verificarA->Actividad3();
$verificarA->Actividad4();
$verificarA->Actividad5();
$verificarA->Actividad6();
$verificarA->Actividad7();
$conexion = new Conexion;
$conexion->EstablecerConexion();
$conn = $conexion->GetConexion();
$titulo="calificar actividades";

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
		                          where nombre_usuario='$usuario' AND (gestion=1 OR gestion=$verificarA->id_gestion)",$conn) or die("Could not execute the select query.");
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