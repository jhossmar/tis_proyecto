<?php
session_start();
$titulo="notas de la grupo empresa";
include("header.php");
?>
<div>
	<ul class="breadcrumb">
		<li>
			<a href="index.php">Inicio</a><span class="divider">/</span>
		</li>
		<li>
			<a href="calificacion_grupo.php">notas de la grupo empresa </a>
		</li>
	</ul>
	</div>
	<center><h3>notas de las actividades</h3></center>
	<div class="row-fluid">
		<div class="box span12 center">
<?php
    include("conexion/conexion.php");
    $c = new Conexion;
    $c->EstablecerConexion();
    $conn = $c->GetConexion();
    
  	$idUsuario =$_SESSION['id'];  	
  	$idEmpresa=0;
    echo"<table class='table table-bordered  table-striped table-hover'>
	     <tr>
	     <td>ID ENTREGA</dt>
	     <td>DESCRIPCION</dt>
	     <td>FECHA INICIO</dt>
	     <td>FECHA FIN</dt>
	     <td>FECHA REAL DE ENTREGA</dt>
	     <td>PAGO ESTABLECIDO</dt>
	     <td>PAGO RECIBIDO</dt>
	     <td>OBSERVACIONES POR PARTE DEL CONSULTOR</dt>	     
	     <td>RESPONSABLE</dt>
	     </tr>";
    $consulta_id_grupo = mysql_query(" SELECT grupo_empresa
  	                                   FROM integrante
  	                                   WHERE usuario=$idUsuario",$conn) or die("Could not execute the select query.");
    $resultado_id_grupo = mysql_fetch_array($consulta_id_grupo);

    $idEmpresa = $resultado_id_grupo['grupo_empresa'];

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
        <td><b>$recibido</b></td>
        <td>$obs</td>        
        <td>$user</td>
        </tr>";
    }
?>
        </table>
		</div>
	</div>	
<?php
include("footer.php");
?>