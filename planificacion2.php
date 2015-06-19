<?php
if(!isset($control))
{
include('conexion.php');	
}
class Planificacion
{	
	public function DibujarFormulario($id,$titulo,$id_form,$actividad,$name_actividad,$topico,$inicio,$fin,$form)
	{
		echo'
		<div class="row-fluid" id="'.$id.'">
		<div class="box span12">
		<div class="box-header well">
		<h2><i class="icon-edit"></i>'.$titulo.'</h2>
		</div>
		<form name="form-data" class="form-horizontal cmxform" method="POST" id="'.$id_form.' action="planificacion2.php#'.$id.'" accept-charset="utf-8">
		<div class="control-group">
		<label class="control-label">Habilitado: </label>
		<div class="controls">
		<input type="checkbox" value="'.$actividad.'" class="checkbox" id="'.$actividad.'" name="'.$name_actividad.'"/>
		</div>
		</div>
		<fieldset id="'.$topico.'">
		<div class="control-group">
		<label class="control-label">Desde:</label>
		<div class="controls">	    
		<input type="text" class="datepicker" data-date-format="dd/mm/yyyy" etitable="false" name="'.$inicio.'" id="'.$inicio.'" value="Fecha sin definir">
		</div>
		</div>
		<div class="control-group">
		<label class="control-label">Hasta:</label>
		<div class="controls">
		<input type="text" class="datepicker" etitable="false" name="'.$fin.'" id="'.$fin.'" value="Fecha sin definir">
		</div>
		</div>
		</fieldset>
		<div class="control-group">
		<div class="controls">
		<button name="'.$form.'" type="submit" class="btn btn-primary" id="'.$form.'"><i class="icon-ok"></i> Aceptar</button>
		<button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
		</div>
		</div>
		</form>
		<label><b>Nota:</b> Esta actividad no restringe ninguna funcionalidad del sistema, solo se limita a la planificaci&oacute;n de la gesti&oacute;n actual .</label>
		</div>
		</div>';
	}
	public function ActualizarActividad($post1,$post2,$check,$fase,$activida)
	{
		$fecha = date("Y-m-d");
		$conexion = new Conexion;
		$conexion->EstablecerConexion();
		$conn=$conexion->GetConexion();
	    $error=false;
        $verificarG = new VerificarGestion;
	    if(isset($_POST[$post1]) && isset($_POST[$post2]) && isset($_POST[$check]))
	    {
		    $inicio = $_POST[$post1];
		    $fin = $_POST[$post2];
		    $actividad="checked";
			
			if($inicio >= $fecha && $fin >= $inicio)
			{					
				if(strtotime($fin) <= $verificarG->fecha_fin) 
				{
					$consulta_sql = "UPDATE fase_convocatoria
								     SET fecha_inicio='$inicio' , fecha_fin='$fin', activo=1
								     WHERE gestion=$verificarG->id_gestion AND tipo_fase_convocatoria=$fase";
					$consulta = mysql_query($consulta_sql,$conn)or die("Could not execute the select query.");							
                    echo "<script type='text/javascript'>"; 
                    echo "alert('la actividad $activida se ha actualizado correctamente');";
                    echo "</script>";
                    echo"<META HTTP-EQUIV='Refresh' CONTENT='1; URL=planificacion.php'> ";							
				}
			    else
				{
					$error = true;
					$error_fecha = "La gesti&oacute;n termina la fecha ".$verificarG->fin_gestion;
				}										
			}
			else
			{
				$error = true;
			    $error_fecha = "La fecha de finalizaci&oacute;n no debe ser menor que la fecha de inicio y La fecha de inicio no debe ser menor a la fecha presente";
			}							
		}
		else
		{
			$error = true;
			$error_fecha = "La fecha de inicio o de finalizacion no es v&aacute;lida";
		}
	}
	public function VerificarFormulario()
	{

	}
}
?>