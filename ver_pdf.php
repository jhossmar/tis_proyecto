<?php
$titulo="Ayuda del Sistema de Apoyo a la Empresa TIS";
include("conexion/verificar_gestion.php");
session_start();
include('header.php');
?>
<!--
<div class="container-fluid">
	<div class="row-fluid">
       <div class="span12">
       	<div class="visor">
    	<?php
			$id=$_GET['nom_arch'];
			//buscar por id en la tabla
			 echo "<embed src='archivos/".$id.".pdf' width=800 height=500 />"//no id si no nombre del archivo
	  	?>
	</div>
	</div>
	</div>	

</div>
-->
<?php
 // include('footer.php');
 ?>