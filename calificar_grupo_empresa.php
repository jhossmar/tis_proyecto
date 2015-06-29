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
  if (isset($_GET['nombre']) and isset($_GET['id'])) 
  {
  	$nom_g =$_GET['nombre'];
  	$idEmpresa =$_GET['id'];
  	echo "<br><h3> ESCOGIO LA GRUPO EMPRESA: $nom_g </h3><br>";	  	

  	$consulta_integrantes = mysql_query("SELECT usuario FROM integrante WHERE grupo_empresa=$idEmpresa",$conn) or die("Could not execute the select query.");
    $resultado_integrante = mysql_fetch_assoc($consulta_integrantes);
  
	echo"<h3>estos son los productos planificados a entregar: </h3>
	     <br>
	     <table class='table table-bordered  table-striped table-hover'>
	     <tr>
	     <td>ID</dt>
	     <td>DESCRIPCION</dt>
	     <td>FECHA INICIO</dt>
	     <td>FECHA FIN</dt>
	     <td>FECHA REAL DE ENTREGA</dt>
	     <td>PAGO ESTABLECIDO</dt>
	     <td>PAGO ENVIADO</dt>
	     <td>OBSERVACIONES</dt>
	     <td>ENLACE AL PRODUCTO</dt>
	     <td>RESPONSABLE</dt>
	     </tr>";
    $consulta_producto = mysql_query(" SELECT id_entrega_producto, descripcion, fecha_inicio, fecha_fin, fecha_real_entrega, pago_establecido, pago_recibido, observacion, enlace_producto, id_responsable
  	                                   FROM entrega_producto
  	                                   WHERE grupo_empresa=$idEmpresa",$conn) or die("Could not execute the select query.");
    while($resultado_producto = mysql_fetch_array($consulta_producto))
    {
        $id = $resultado_producto['id_entrega_producto'];
        $des = $resultado_producto['descripcion'];
        $ini = $resultado_producto['fecha_inicio'];
        $fin = $resultado_producto['fecha_fin'];
        $real = $resultado_producto['fecha_real_entrega'];
        $establecido = $resultado_producto['pago_establecido'];
        $recibido = $resultado_producto['pago_recibido'];
        $obs = $resultado_producto['observacion'];
        $enlace = $resultado_producto['enlace_producto'];
        $usr = $resultado_producto['id_responsable'];
        $consulta_usr = mysql_query(" SELECT nombre,apellido
  	                                   FROM usuario
  	                                   WHERE id_usuario=$usr",$conn) or die("Could not execute the select query.");
        $res = mysql_fetch_array($consulta_usr);
        $user= $res['nombre']." ".$res['apellido'];
        echo"<tr>
        <td>$id</td>
        <td>$des</td>
        <td>$ini</td>
        <td>$fin</td>
        <td>$real</td>
        <td>$establecido</td>
        <td><center>$recibido <a href='funcion_calificar.php?value=1&id=$idEmpresa&identrega=$id&pago=$establecido&recibido=$recibido' class='btn btn-primary btn-small'><i class='icon-edit'></i> editar</a></center></td>
        <td><center>$obs<br><a href='funcion_calificar.php?value=2&id=$idEmpresa&identrega=$id' class='btn btn-primary btn-small'><i class='icon-edit'></i> editar</a></center></td>
        <td>$enlace</td>
        <td>$user</td>
        </tr>";

    }
	echo"</table>
	     </div>
	      </div>";
  }
  else
  {
  		$consultor=	$_SESSION['id'];
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
	    	      <td><a href='calificar_grupo_empresa.php?nombre=$nombre&id=$idGrupo'><i class='icon-edit'></i> $nombre</a></td>
	    	      </tr>";
	    }//
	    else
	    {
            echo "<h3> ACTUALMENTE NO SIENTE NINGUN GRUPO EMPRESA REGISTRADO CON USTED</h3>";
	    }
	  }                  	
	echo"</table>
	     </div>
	     </div>";

  }
include("footer.php");	
?>