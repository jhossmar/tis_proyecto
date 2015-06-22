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
			<a href="calificar_grupo_empresa.php">calificar las actividades a la grupo empresa</a>
		</li>				
	</ul>
</div>
	<center><h3>calificar las actividades de la grupo empresa</h3></center>
	<div class="row-fluid">
	<div class="span10">
<?php
$consulta_consultor = mysql_query("SELECT id_usuario from usuario 
		                          where nombre_usuario='$usuario' AND (gestion=1 OR gestion=$verificarA->id_gestion)",$conn) or die("Could not execute the select query.");
$resultado_consultor = mysql_fetch_assoc($consulta_consultor);
		    
	if(!empty($resultado_consultor))
	{     		
		$consultor=	$resultado_consultor['id_usuario'];
		$consulta_grupo = mysql_query("SELECT nombre_largo,id_grupo_empresa 
			                           FROM grupo_empresa 			
		                               WHERE consultor_tis='$consultor'",$conn)
		                               or die("Could not execute the select query.");
      while($resultado_grupo = mysql_fetch_array($consulta_grupo))
      {
	    $aux=0;
	    if(!empty($resultado_grupo))
	    { 
	    	if($aux==0)
	    	{
	    	  echo "<br>
	    	        <center><h3>estas son las grupo empresa registradas con el consultor Tis: $usuario</h3></center>
	    	        <br>
	    	        <table class='table table-bordered table-striped table-hover'>
	    	        <tr> 
	    	        <td><center><h4>NRO GRUPO EMPRESA</h4></center></td>
	    	        <td><center><h4>GRUPO EMPRESA</h4></center></td>
	    	        </tr>";	
	    	    $aux=1;
	    	}
	    	$idGrupo = (int) $resultado_grupo['id_grupo_empresa'];
	    	$nombre = $resultado_grupo['nombre_largo'];
	    	echo "<tr> 
	    	      <td>$idGrupo</td>	    	      
	    	      <td><a href='calificar_grupo_empresa.php?value=$idGrupo'><i class='icon-edit'></i> $nombre</a></td>
	    	      </tr>";
	    }//
	    else
	    {
            echo "<h3> ACTUALMENTE NO SIENTE NINGUN GRUPO EMPRESA REGISTRADO CON USTED</h3>";
	    }
	  }	                  
	}
	echo"</div>
	     </div>";
//include("footer.php");
		
?>