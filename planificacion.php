<?php
  session_start();
  $titulo="Planificaion de las actividades";
  require_once("conexion/verificar_gestion.php");
  include("planificacion2.php");
  include("header.php");
  $verificarG = new VerificarGestion;
  $GestionValida = $verificarG->GetGestionValida();
  $p = new Planificacion;
  if(isset($_POST['enviar_1']))
  {
     $p->ActualizarActividad('inicio_1','fin_1','newsletter_1',1,'lanzamiento');	
  }
  if(isset($_POST['enviar_2']))
  {
     $p->ActualizarActividad('inicio_2','fin_2','newsletter_2',2,'registro');	
  }
  if(isset($_POST['enviar_3']))
  {
     $p->ActualizarActividad('inicio_3','fin_3','newsletter_3',3,'documentos');	
  }
  if(isset($_POST['enviar_4']))
  {
     $p->ActualizarActividad('inicio_4','fin_4','newsletter_4',4,'contratos');	
  }
  if(isset($_POST['enviar_5']))
  {
     $p->ActualizarActividad('inicio_5','fin_5','newsletter_5',5,'desarrollo');	
  }
  if(isset($_POST['enviar_6']))
  {
     $p->ActualizarActividad('inicio_6','fin_6','newsletter_6',6,'productos');	
  }
  if(isset($_POST['enviar_7']))
  {
     $p->ActualizarActividad('inicio_7','fin_7','newsletter_7',7,'cierre');	
  }
?>
	<div>
		<ul class="breadcrumb">
			<li>
				<a href="index.php">Inicio</a>
				<span class="divider">/</span>
			</li>
			<li>
				<a href="planificacion.php">Planificaci&oacute;n de actividades</a>
			</li>				
		</ul>
	</div>
	<center><h3>Planificar las actividades de la Empresa TIS</h3></center>
	<?php if($GestionValida && !$verificarG->gestion_espera){ ?>
			<div class="row-fluid" id="planificacion">
				<div class="span12">
					<ol>
						  <li><a class="lista" href="#lanzamiento">Lanzamiento Convocatoria P&uacute;blica</a></li>
						  <li><a class="lista" href="#registro">Registro de Grupo Empresas</a></li>
						  <li><a class="lista" href="#documentos">Entrega de Documentos</a></li>
						  <li><a class="lista" href="#contratos">Firma de Contratos</a></li>
						  <li><a class="lista" href="#desarrollo">Proceso de Desarrollo</a></li>
						  <li><a class="lista" href="#productos">Entrega de Productos</a></li>
						  <li><a class="lista" href="#cierre">Cierre de la Convocatoria</a></li>	  
						</ol> 
				</div>
			</div>

<?php }
$p = new Planificacion;
$p->DibujarFormulario("lanzamiento"," 1. Lanzamiento de la Convocatoria P&uacute;blica","form_1","actividad_1","newsletter_1","actividad_1_topics","inicio_1","fin_1","enviar_1");
$p->DibujarFormulario("registro"," 2. Habilitar registro de Grupo Empresas e Integrantes","form_2","actividad_2","newsletter_2","actividad_2_topics","inicio_2","fin_2","enviar_2");
$p->DibujarFormulario("documentos"," 3. Entrega de Documentos","form_3","actividad_3","newsletter_3","actividad_3_topics","inicio_3","fin_3","enviar_3");
$p->DibujarFormulario("contratos"," 4. Firma de Contratos","form_4","actividad_4","newsletter_4","actividad_4_topics","inicio_4","fin_4","enviar_4");
$p->DibujarFormulario("desarrollo"," 5. Proceso de Desarrollo","form_5","actividad_5","newsletter_5","actividad_5_topics","inicio_5","fin_5","enviar_5");
$p->DibujarFormulario("productos"," 6. Entrega de Producto Final","form_6","actividad_6","newsletter_6","actividad_6_topics","inicio_6","fin_6","enviar_6");
$p->DibujarFormulario("cierre"," 7. Cierre de la Convocatoria","form_7","actividad_7","newsletter_7","actividad_7_topics","inicio_7","fin_7","enviar_7");

include("footer.php");
?>