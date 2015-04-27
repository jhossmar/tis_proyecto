<?php
session_start();
/*------------------VERIFICAR QUE SEAL LA GRUPO EMPRESA------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO       */
		$home="";
		switch  ($_SESSION['tipo']){
	            case (3) :
	                	$home="home_consultor.php";
	                    break;
	            case (2) :
	                	$home="home_consultor_jefe.php";
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
include('conexion/verificar_gestion.php');
include("conexion/verificar_integrantes.php");
$titulo="Planificar Tareas Grupo Empresa";
include('header.php');
?>
 			<!--PARTICIONAR
 			<li>
						<a href="#">Inicio</a> <span class="divider">/</span>
			</li>-->
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="actividades_grupo.php">Actividades Grupo Empresa</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="calendario_grupo.php">Planificar Tareas</a>
					</li>
				</ul>
			</div>

                  	<center><h3>Planificaci&oacute;n de Tareas por Actividad</h3></center>



            <div class="row-fluid">
				<div class="box span center">
						<div class="box-header well">
							<h2><i class="icon-calendar"></i> Calendarion de Tareas Grupo Empresa</h2>
						</div>
						<div class="box-content">
						<?php
                                if($gestion_valida){
                                 /*BUSCAR  el id de la grupo empresa*/
                		        $consulta_id_ge = mysql_query("SELECT ge.id_grupo_empresa
                												FROM usuario u,integrante i,grupo_empresa ge
                	                                            WHERE u.nombre_usuario='".$_SESSION['nombre_usuario']."' and u.id_usuario=i.usuario and i.grupo_empresa =ge.id_grupo_empresa",$conn)
                		                         or die("Could not execute the select query.");
                		        $resultado_id_ge = mysql_fetch_assoc($consulta_id_ge);
                		        $rep_id_ge=(int)$resultado_id_ge['id_grupo_empresa'];
                                $consulta_actividades_empresa = "SELECT age.id_actividad,age.descripcion
                                                                            FROM entrega_producto ep,actividad_grupo_empresa age
                                                                            WHERE ep.grupo_empresa='$rep_id_ge' and ep.id_entrega_producto=age.entrega_producto";
                                $resultado_actividades_empresa = mysql_query($consulta_actividades_empresa);
                                $num_ep =     mysql_num_rows($resultado_actividades_empresa);


                          if  ($num_ep ==0){
                           echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No puede planificar sus tareas, no tiene ninguna actividad programada, <br> puede programar sus actividaes <a style=\"color:#555555; !important\" href=\"actividades_grupo.php\">aqu&iacute;.</a></h4>
				                      	</div>";

                          }

                        else if ($cantidad_valida) { ?>

						<div id="example" style="margin: auto; width:80%; height: 80%">

						<div id="toolbar" class="ui-widget-header ui-corner-all" style="">
							<button class="btn btn-primary" id="BtnPreviousMonth"><i class="icon-arrow-left"></i> Anterior</button>
							<button class="btn btn-primary" id="BtnNextMonth">Siguiente <i class="icon-arrow-right"></i></button>
							&nbsp;&nbsp;&nbsp;
							Fecha: <input type="text" id="dateSelect" size="10" style="margin-top: 10px"/>
							&nbsp;&nbsp;&nbsp;
							<!--<button class="btn btn-primary" id="BtnDeleteAll"><i class="icon-remove"></i> Eliminar Todo</button>   -->
						</div>

						<div id="mycal"></div>

						</div>

					<!-- debugging-->
					<div id="calDebug"></div>

		<!-- Add event modal form -->
		<style type="text/css">
			//label, input.text, select { display:block; }
			fieldset { padding:0; border:0; margin-top:25px; }
			.ui-dialog .ui-state-error { padding: .3em; }
			.validateTips { border: 1px solid transparent; padding: 0.3em; }
		</style>
		<div id="add-event-form" title="A&ntilde;adir Tarea">
        <!-- action="add_tarea.php" -->
        <form>
        <?php

                  $consulta_actividades_empresa = "SELECT age.id_actividad,age.fecha_inicio,age.fecha_fin,age.descripcion,age.entrega_producto
                                FROM entrega_producto ep,actividad_grupo_empresa age
                                WHERE ep.grupo_empresa='$rep_id_ge' AND ep.id_entrega_producto=age.entrega_producto";
                  $resultado_actividades_empresa = mysql_query($consulta_actividades_empresa);
                  $CTA=0;
                                             while($row_actividades_empresa = mysql_fetch_array($resultado_actividades_empresa))
                                              {
                                                 echo "<input  type=\"hidden\" id=\"A1".$CTA."\"  name=\"A1".$CTA."\"  value=\"".$row_actividades_empresa['id_actividad']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"A2".$CTA."\"  name=\"A2".$CTA."\"  value=\"".$row_actividades_empresa['fecha_inicio']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"A3".$CTA."\"  name=\"A3".$CTA."\"  value=\"".$row_actividades_empresa['fecha_fin']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"A4".$CTA."\"  name=\"A4".$CTA."\"  value=\"".$row_actividades_empresa['descripcion']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"A5".$CTA."\"  name=\"A5".$CTA."\"  value=\"".$row_actividades_empresa['entrega_producto']."\"  />";
                                             $CTA++;
                                              }
                                               echo "<input  type=\"hidden\" id=\"CTA\"  name=\"CTA\"  value=\"".$CTA."\"  />";
                                                 ?>
                                      </form >
                                     <form>
                                              <?php
                                                   $consulta_Tareas = "SELECT t.id_tarea,t.descripcion,t.responsable,t.actividad,t.fecha_inicio,t.fecha_fin,t.resultado_esperado,t.resultado_obtenido,t.color_tarea,t.color_texto																		FROM entrega_producto ep,actividad_grupo_empresa age,tarea t
												   WHERE ep.grupo_empresa='$rep_id_ge' AND ep.id_entrega_producto=age.entrega_producto AND age.id_actividad=t.actividad";
                                                                      $resultado_Tareas = mysql_query($consulta_Tareas);
                                                  $CTT=0;
                                             while($row_Tareas = mysql_fetch_array($resultado_Tareas))
                                              {
                                                 echo "<input  type=\"hidden\" id=\"T1".$CTT."\"  name=\"A1".$CTT."\"  value=\"".$row_Tareas['id_tarea']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T2".$CTT."\"  name=\"A2".$CTT."\"  value=\"".$row_Tareas['descripcion']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T3".$CTT."\"  name=\"A3".$CTT."\"  value=\"".$row_Tareas['responsable']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T4".$CTT."\"  name=\"A4".$CTT."\"  value=\"".$row_Tareas['actividad']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T5".$CTT."\"  name=\"A5".$CTT."\"  value=\"".$row_Tareas['fecha_inicio']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T6".$CTT."\"  name=\"A5".$CTT."\"  value=\"".$row_Tareas['fecha_fin']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T7".$CTT."\"  name=\"A5".$CTT."\"  value=\"".$row_Tareas['resultado_esperado']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T8".$CTT."\"  name=\"A5".$CTT."\"  value=\"".$row_Tareas['resultado_obtenido']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T9".$CTT."\"  name=\"A5".$CTT."\"  value=\"".$row_Tareas['color_tarea']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T10".$CTT."\"  name=\"A5".$CTT."\"  value=\"".$row_Tareas['color_texto']."\"  />";
                                             $CTT++;
                                              }
                                                echo "<input  type=\"hidden\" id=\"CTT\"  name=\"CTT\"  value=\"".$CTT."\"  />";
                                               ?>



                                     </form>


			<form   method="POST"  accept-charset="utf-8"  name="form-reser" id="form-reser">
			<fieldset>
                <input  type="hidden" id="grupoEmpresa"  name="grupoEmpresa" value='<?php  echo "".$rep_id_ge  ?>' />
				<label for="name">Descripci&oacute;n:</label>
				<input type="text" name="what" id="what" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>
                <label for="responsable">Responsable:</label>
                <select id="choose_responsable" name="choose_responsable" data-rel="chosen">
										<?php


			                               $consulta_integrante = "SELECT u.id_usuario,u.nombre,u.apellido
                                                                    FROM usuario u,integrante i
                                                                    WHERE  i.grupo_empresa='$rep_id_ge' and u.id_usuario=i.usuario";
			                              $resultado_integrante = mysql_query($consulta_integrante);
			                                while($row_integrante = mysql_fetch_array($resultado_integrante)) {
			                               		echo "<option value=\"".$row_integrante['id_usuario']."\">".$row_integrante['nombre']."  ".$row_integrante['apellido']."</option>";
			                                }

			                             ?>
								  	</select>
                 <label for="responsable">Pertenece a la actividad:</label>
                <select id="choose_actividad" name="choose_actividad" data-rel="chosen">
										<?php
                                         $consulta_actividades_empresa = "SELECT DISTINCT age.id_actividad,age.descripcion ,age.fecha_inicio,age.fecha_fin
                                                                            FROM entrega_producto ep,actividad_grupo_empresa age
                                                                            WHERE ep.grupo_empresa='$rep_id_ge' AND ep.id_entrega_producto=age.entrega_producto ";
                                                            $resultado_actividades_empresa = mysql_query($consulta_actividades_empresa);

                                             while($row_actividades_empresa = mysql_fetch_array($resultado_actividades_empresa))
                                              {  echo "<option value=\"".$row_actividades_empresa['id_actividad']."\">".$row_actividades_empresa['descripcion']."</option>";

                                              }
                                         ?>
								  	</select>
                               <?php
                                       $consulta_actividades_empresa = "SELECT DISTINCT age.id_actividad,age.descripcion ,age.fecha_inicio,age.fecha_fin
                                                                            FROM entrega_producto ep,actividad_grupo_empresa age
                                                                            WHERE ep.grupo_empresa='$rep_id_ge' AND ep.id_entrega_producto=age.entrega_producto ";
                                                            $resultado_actividades_empresa = mysql_query($consulta_actividades_empresa);
                               while($row_actividades_empresa = mysql_fetch_array($resultado_actividades_empresa))
                                              {
                                                 echo "<input type=\"hidden\" id=\"afi".$row_actividades_empresa['id_actividad']." \" name=\"afi".$row_actividades_empresa['id_actividad']." \" value=\"".$row_actividades_empresa['fecha_inicio']."\"   />  ";
                                                 echo "<input type=\"hidden\" id=\"aff".$row_actividades_empresa['id_actividad']." \" name=\"aff".$row_actividades_empresa['id_actividad']." \" value=\"".$row_actividades_empresa['fecha_fin']."\"   />  ";

                                              }

                                 ?>
                 <label for="name">Resultado de la Conclusi&oacute;n de la tarea:</label>
				<input type="text" name="res" id="res" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>
                <table style="width:100%; padding:5px;">
					<tr>
						<td>
							<label>Fecha de inicio:</label>
							<input type="text" name="startDate" id="startDate" value="" class="datepicker" style="margin-bottom:12px; width:95%; padding: .4em;"/>
						</td>
						<td>&nbsp;</td>
                        <td>
							<label>Fecha de Conclusi&oacute;n:</label>
							<input type="text" name="endDate" id="endDate" value="" class="datepicker" style="margin-bottom:12px; width:95%; padding: .4em;"/>
						</td>
						<td>&nbsp;</td>


					</tr>

				</table>
				<table>
					<tr>
						<td>
							<label>Color de Tarea: </label>
						</td>
						<td>
							<div id="colorSelectorBackground"><div style="background-color: #333333; width:30px; height:30px; border: 2px solid #000000;"></div></div>
							<input type="hidden" id="colorBackground" name="colorBackground" value="#333333">
						</td>
						<td>&nbsp;&nbsp;&nbsp;</td>
						<td>
							<label>Color de texto: </label>
						</td>
						<td>
							<div id="colorSelectorForeground"><div style="background-color: #ffffff; width:30px; height:30px; border: 2px solid #000000;"></div></div>
							<input type="hidden" id="colorForeground" name ="colorForeground" value="#ffffff">
						</td>
					</tr>
				</table>
			</fieldset>
			</form>
		</div>

		<div id="display-event-form" title="Informaci&oacute;n de Tarea">

		</div>

				<?php
				}else{
					echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No puede planificar sus tareas, faltan integrantes.</h4>
				                      	</div>";
				}
				?>



						<?php
		            }else{
		            	echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				                      	</div>";
		            }
		                 ?>
		                </div>

				</div><!--/FORMULARIO DE INGRESO-->
			</div>


            <!--fin div registro-->
<?php include('footer.php'); ?>