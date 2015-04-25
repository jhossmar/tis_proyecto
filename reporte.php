<?php
//$titulo="Administrar Grupo Empresas";
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
$id_grupoem=$_GET['value'];
require('lib/fpdf.php');
class PDF extends FPDF
{
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(90,90,90);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'',0,0,'L');
    }
 
    function Header()
    {	$id_grupoem=$_GET['value'];
    	$cons = "SELECT nombre,apellido ,nombre_largo
				FROM grupo_empresa, usuario
				WHERE id_grupo_empresa=$id_grupoem AND consultor_tis=id_usuario" ;
		$res_info = mysql_query($cons) or die("Error");
		$info = mysql_fetch_assoc($res_info);
        $this->Image('img/umss.png',13,10,25);
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(90,90,90);
        $this->Cell(80);
        $this->Cell(18,9,utf8_decode("Sistema de Apoyo a la Empresa TIS"),0,0,'C');
        $this->Image('img/fcyt.jpg',172,10,25);
        $this->Ln(20);

        $this->SetFont('Arial','B',10);
        $this->Cell(0,10,utf8_decode("Consultor TIS: ".$info['nombre']." ".$info['apellido']),0,'L');
        $this->Ln(4);
        $this->Cell(0,10,utf8_decode("Grupo Empresa: ".$info['nombre_largo']),0,'L');
        $this->Ln(4);
        $fech=date("d-m-Y");
        $this->Cell(0,10,utf8_decode("Fecha: ".$fech),0,'L');
        $this->Ln(15);
    }
}
    
    $pdf=new PDF();
    $pdf->SetMargins(15,18);
    $pdf->AliasNbPages();
    $pdf->AddPage();


    /*---------------------PRIMERA INFO----------------------------*/
    $pdf->SetFont('Arial','B',15);
    $pdf->SetTextColor(90,90,90);
    $pdf->Cell(0,10,utf8_decode("1.- Información de la Grupo Empresa"),0,0,'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,10,utf8_decode("1.1.- Subsistemas de la Grupo Empresa"),0,0,'L');
    $pdf->Ln(10);
    $consulta = "SELECT ep.descripcion,ep.fecha_inicio,ep.fecha_fin,ep.pago_establecido,ep.pago_recibido ,ep.id_entrega_producto
                 FROM entrega_producto ep
                 WHERE ep.grupo_empresa=$id_grupoem" ;
    //En una variable guardamos el array que regresa el método
    $res = mysql_query($consulta,$conn) or die("Error");
    /*COLORES*/
    $pdf->SetFillColor(255,255,0);
    $pdf->SetTextColor(90,90,90);
    $pdf->SetDrawColor(49,126,172);

    $pdf->Cell(80,7,utf8_decode('Descripción'),1,0,'C');
    $pdf->Cell(20,7,'Inicio',1,0,'C');
    $pdf->Cell(20,7,'Fin',1,0,'C');
    $pdf->Cell(32,7,'Pago Establecido',1,0,'C');
    $pdf->Cell(30,7,'Pago Recibido',1,0,'C');

    $pdf->Ln();
 	//$datos=NULL;
 	$pdf->SetFont('Arial','',10);
 	//$pdf->AddPage();
 	$num_res=mysql_num_rows($res);
 	if ($num_res>0) {
 	while ($datos = mysql_fetch_assoc($res)) {
 		$pdf->Cell(80,7,utf8_decode($datos['descripcion']),1,0,'C');
 		$pdf->Cell(20,7,utf8_decode($datos['fecha_inicio']),1,0,'C');
 		$pdf->Cell(20,7,utf8_decode($datos['fecha_fin']),1,0,'C');
 		$pdf->Cell(32,7,utf8_decode($datos['pago_establecido']),1,0,'C');
 		$pdf->Cell(30,7,utf8_decode($datos['pago_recibido']),1,0,'C');
 		$pdf->Ln();
 	}
 }
 else{
 	$pdf->Cell(182,7,utf8_decode("No existen registros para mostrar"),1,0,'C');
 }
 	$pdf->Ln(10);
/*---------------------FIN PRIMERA INFO -------------------*/
 	/*---------------------SEGUNDA INFO----------------------------*/
 	 $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(90,90,90);
    $pdf->Cell(0,10,utf8_decode("1.2.- Evaluación de Subsistemas de la Grupo Empresa"),0,0,'L');
    $pdf->Ln(10);
    $consulta = "SELECT ep.descripcion,ep.id_entrega_producto,ep.enlace_producto,ep.fecha_inicio,ep.fecha_fin,ep.pago_recibido,ep.pago_establecido
                 FROM entrega_producto ep
                 WHERE ep.grupo_empresa=$id_grupoem" ;
    //En una variable guardamos el array que regresa el método
    $res = mysql_query($consulta,$conn) or die("Error");
    /*COLORES*/
    $pdf->SetFillColor(255,255,0);
    $pdf->SetTextColor(90,90,90);
    $pdf->SetDrawColor(49,126,172);

    $pdf->Cell(122,7,utf8_decode('Descripción'),1,0,'C');
	$pdf->Cell(30,7,utf8_decode('Pago establecido'),1,0,'C');
	$pdf->Cell(30,7,utf8_decode('Pago recibido'),1,0,'C');

    $pdf->Ln();
 	//$datos=NULL;
 	$pdf->SetFont('Arial','',10);
 	//$pdf->AddPage();
 	$num_res=mysql_num_rows($res);
 	if ($num_res>0) {
 	while ($datos = mysql_fetch_assoc($res)) {
 		$pdf->Cell(122,7,utf8_decode($datos['descripcion']),1,0,'C');
		$pdf->Cell(30,7,utf8_decode($datos['pago_establecido']),1,0,'C');
		$pdf->Cell(30,7,utf8_decode($datos['pago_recibido']),1,0,'C');
 		$pdf->Ln();
 	}
 	}
	 else{
	 	$pdf->Cell(182,7,utf8_decode("No existen registros para mostrar"),1,0,'C');
	 }
 	$pdf->Ln(10);
 	/*---------------------FIN SEGUNDA INFO -------------------*/
 	/*---------------------TERCERA INFO----------------------------*/
     $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(90,90,90);
    $pdf->Cell(0,10,utf8_decode("1.3.- Actividades de todos los Subsistemas"),0,0,'L');
    $pdf->Ln(10);
    $consulta = "SELECT age.descripcion,age.fecha_inicio,age.fecha_fin,age.porcentaje_completado
				FROM actividad_grupo_empresa age, entrega_producto e
				WHERE age.entrega_producto=e.id_entrega_producto AND e.grupo_empresa=$id_grupoem" ;
    //En una variable guardamos el array que regresa el método
    $res = mysql_query($consulta,$conn) or die("Error");
    /*COLORES*/
    $pdf->SetFillColor(255,255,0);
    $pdf->SetTextColor(90,90,90);
    $pdf->SetDrawColor(49,126,172);

    $pdf->Cell(95,7,utf8_decode('Descripción'),1,0,'C');
    $pdf->Cell(20,7,'Inicio',1,0,'C');
    $pdf->Cell(20,7,'Fin',1,0,'C');
    $pdf->Cell(47,7,'Pocetaje completado (%)',1,0,'C');

    $pdf->Ln();
 	//$datos=NULL;
 	$pdf->SetFont('Arial','',10);
 	//$pdf->AddPage();
 	$num_res=mysql_num_rows($res);
 	if ($num_res>0) {
 	while ($datos = mysql_fetch_assoc($res)) {
 		$pdf->Cell(95,7,utf8_decode($datos['descripcion']),1,0,'C');
 		$pdf->Cell(20,7,utf8_decode($datos['fecha_inicio']),1,0,'C');
 		$pdf->Cell(20,7,utf8_decode($datos['fecha_fin']),1,0,'C');
 		$pdf->Cell(47,7,utf8_decode($datos['porcentaje_completado']),1,0,'C');
 		$pdf->Ln();
 	}
 	}
	 else{
	 	$pdf->Cell(182,7,utf8_decode("No existen registros para mostrar"),1,0,'C');
	 }
 	$pdf->Ln(10);
 	/*---------------------TERCERA INFO -------------------*/
 	/*---------------------cuarta INFO----------------------------*/
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(90,90,90);
    $pdf->Cell(0,10,utf8_decode("1.4.- Tareas de todos los Subsistemas"),0,0,'L');
    $pdf->Ln(10);
    $consulta = "SELECT t.descripcion,t.fecha_inicio,t.fecha_fin,u.nombre,u.apellido,t.porcentaje_completado,t.resultado_obtenido
				FROM tarea t,usuario u,actividad_grupo_empresa age, entrega_producto e
				WHERE t.actividad=age.id_actividad and t.responsable=u.id_usuario AND age.entrega_producto=e.id_entrega_producto AND e.grupo_empresa=$id_grupoem" ;
    //En una variable guardamos el array que regresa el método
    $res = mysql_query($consulta,$conn) or die("Error");
    /*COLORES*/
    $pdf->SetFillColor(255,255,0);
    $pdf->SetTextColor(90,90,90);
    $pdf->SetDrawColor(49,126,172);

    $pdf->Cell(70,7,utf8_decode('Descripción'),1,0,'C');
    $pdf->Cell(20,7,'Inicio',1,0,'C');
    $pdf->Cell(20,7,'Fin',1,0,'C');
    $pdf->Cell(47,7,'Responsable',1,0,'C');
    $pdf->Cell(25,7,'Avance (%)',1,0,'C');

    $pdf->Ln();
 	//$datos=NULL;
 	$pdf->SetFont('Arial','',10);
 	//$pdf->AddPage();
 	$num_res=mysql_num_rows($res);
 	if ($num_res>0) {
 	while ($datos = mysql_fetch_assoc($res)) {
 		$pdf->Cell(70,7,utf8_decode($datos['descripcion']),1,0,'C');
 		$pdf->Cell(20,7,utf8_decode($datos['fecha_inicio']),1,0,'C');
 		$pdf->Cell(20,7,utf8_decode($datos['fecha_fin']),1,0,'C');
 		$pdf->Cell(47,7,utf8_decode($datos['nombre']),1,0,'C');
 		$pdf->Cell(25,7,utf8_decode($datos['porcentaje_completado']),1,0,'C');
 		$pdf->Ln();
 	}
 	}else{
	 	$pdf->Cell(182,7,utf8_decode("No existen registros para mostrar"),1,0,'C');
	 }
 	$pdf->Ln(10);
 	/*---------------------FIN cuarta INFO -------------------*/

 	$pdf->SetFont('Arial','B',15);
    $pdf->SetTextColor(90,90,90);
    $pdf->Cell(0,10,utf8_decode("2.- Información de los Integrantes de la Grupo Empresa"),0,0,'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,10,utf8_decode("2.1.- Lista de Integrantes de la Grupo Empresa"),0,0,'L');
    $pdf->Ln(10);
    $consulta = "SELECT id_usuario,nombre,apellido,i.grupo_empresa,u.email,u.telefono,i.codigo_sis,c.nombre_carrera
				from usuario u, integrante i,carrera c
				where u.habilitado=1 AND i.usuario=u.id_usuario AND i.grupo_empresa=$id_grupoem AND c.id_carrera=i.carrera" ;
    //En una variable guardamos el array que regresa el método
    $res = mysql_query($consulta,$conn) or die("Error");
    /*COLORES*/
    $pdf->SetFillColor(255,255,0);
    $pdf->SetTextColor(90,90,90);
    $pdf->SetDrawColor(49,126,172);

    $pdf->Cell(55,7,utf8_decode('Nombre'),1,0,'C');
    $pdf->Cell(20,7,utf8_decode('Código SIS'),1,0,'C');
    $pdf->Cell(45,7,utf8_decode('Correo'),1,0,'C');
    $pdf->Cell(20,7,utf8_decode('Teléfono'),1,0,'C');
    $pdf->Cell(42,7,utf8_decode('Carrera'),1,0,'C');

    $pdf->Ln();
 	//$datos=NULL;
 	$pdf->SetFont('Arial','',10);
 	//$pdf->AddPage();
 	while ($datos = mysql_fetch_assoc($res)) {
 		$pdf->Cell(55,7,utf8_decode($datos['nombre']." ".$datos['apellido']),1,0,'C');
 		$pdf->Cell(20,7,utf8_decode($datos['codigo_sis']),1,0,'C');
 		$pdf->Cell(45,7,utf8_decode($datos['email']),1,0,'C');
 		$pdf->Cell(20,7,utf8_decode($datos['telefono']),1,0,'C');
 		$pdf->Cell(42,7,utf8_decode($datos['nombre_carrera']),1,0,'C');
 		$pdf->Ln();
 	}
 	$pdf->Ln(10);
 	$pdf->Output();
?>