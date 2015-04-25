<?php
$titulo="Administrar Grupo Empresas";
include('conexion/verificar_gestion.php');
session_start();
/*------------------VERIFICAR QUE SEAL EL ADMINISTRADOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && ($_SESSION['tipo']!=2 && $_SESSION['tipo']!=3))
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
	                    break;
	            case (4) :
	                	$home="home_grupo.php";
	                    break;
	            case (2) :
	                	$home="home_consultor_jefe.php";
	                    break;
	            case (3) :
	                	$home="home_consultor.php";
	                    break;
	            case (1) :
	                    $home="home_admin.php";
	                    break;
	          }
		header("Location: ".$home);
}
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
/*----------------------FIN VERIFICACION------------------------------------*/
include_once('reporte.php');
 
    //recepcion del id grupo empresa
    $id_grupoem=$_GET['value'];
 
    //Recibimos dentro de una cadena la fecha
    //$fecha="México D.F. a ".$_POST['dia']." de ". $_POST['mes']. " de ".$_POST['anio'];
    $fecha=date("Y-m-d");
    //Se crea un objeto de PDF
    //Para hacer uso de los métodos
    $pdf = new PDF();
    $pdf->AddPage('P', 'Letter'); //Vertical, Carta
    $pdf->SetFont('Arial','B',12); //Arial, negrita, 12 puntos
    $pdf->Cell(0,10,$fecha,0,1,'R'); //Imprime en el pdf la cadena $fecha
    $pdf->Ln();
 
    $texto="Esta es un reporte de la grupo empresa x";
    //$pdf->ImprimirTexto('textoFijo.txt'); //Texto fijo
 
    //Creamos objeto de la clase myDBC
    //para hacer uso del método seleccionar_persona()
    $consulta = "SELECT ep.descripcion,ep.fecha_inicio,ep.fecha_fin,ep.pago_establecido,ep.pago_recibido ,ep.id_entrega_producto
                 FROM entrega_producto ep
                 WHERE ep.grupo_empresa=$id_grupoem " ;
    //En una variable guardamos el array que regresa el método
    $datos = mysql_query($consulta,$conn) or die("Error");
    $row = mysql_fetch_array($datos);
    //(result)
    //mysql_fetch_array(result)
    //Array de cadenas para la cabecera
    $cabecera = array("Descripcion","Fecha Inicio","Fecha Fin", "Pago Establecido", "Pago Recibido","ID Subsistema");
    $pdf->cabecera($cabecera);
    //while ($row = mysql_fetch_array($datos)) {
        $pdf->FancyTable($cabecera,$row);
    //}
     //Método que integra a cabecera y datos
    $pdf->Output(); //Salida al navegador del pdf
?>