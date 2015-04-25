<?php
$titulo="Respaldo y Restauraci&oacute;n de la Base de Datos";
include('conexion/verificar_gestion.php');
session_start();
/*------------------VERIFICAR QUE SEAL EL ADMINISTRADOR------------------------*/
    if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=1)
    {/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
            $home="";
            switch  ($_SESSION['tipo']){

                    case (2) :
                        $home="home_consultor_jefe.php";
                        break;
                    case (3) :
                         $home="home_consultor.php";
                         break;
                    case (4) :
                         $home="home_grupo.php";
                         break;
                    case (5) :
                        $home="home_integrante.php";
                        break;
                  }
            header("Location: ".$home);
    }
    elseif(!isset($_SESSION['nombre_usuario'])){
        header("Location: index.php");
    }
/*----------------------FIN VERIFICACION------------------------------------*/
$directorio='../public_html';//LINUX
//$directorio='backups';//WINDOWS
$mensaje=NULL;
if(isset($_GET['backup']) && isset($_GET['file'])){
	$file=$directorio."/".$_GET['file'];
	$tipo_backup="";
	if($_GET['backup']==1 && file_exists($file)){
		$tipo_backup="<strong>Restauraci&oacute;n de la Base de Datos correcta:</strong> EL archivo <b>".$_GET['file']." </b>correspondiente a la fecha <b>".(strftime("%d/%m/%y %X",filemtime($file)))." </b>fue restaurado exitosamente.";
	}elseif($_GET['backup']==2){
		$tipo_backup="<strong>Nuevo archivo de respaldo creado:</strong> Se ha creado el archivo <b>".$_GET['file']." </b>en fecha <b>".(strftime("%d/%m/%y %X",filemtime($file)))." </b> exitosamente.";
    }else{
		header("Location: index.php");
	}
	$mensaje="<br/><div class=\"row-fluid\">
      <div class=\"alert alert-success\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>".$tipo_backup."</div></div>";
}
if(isset($_GET['error'])){
	$tipo_error="";
	if($_GET['error']==1){
		$tipo_error="No se especif&oacute; ning&uacute;n archivo para realizar la restauraci&oacute;n de la Base de Datos.";
	}elseif($_GET['error']==2){
		$tipo_error="El archivo seleccionado para la restauraci&oacute;n de la base de datos no se encuentra disponible, intente otra vez.";
	}elseif($_GET['error']==3){
		$tipo_error="Ocurri&oacute; un problema mientras se restauraba la Base de Datos seleccionada, porvafor intente otra vez.";
	}elseif($_GET['error']==4){
		$tipo_error="No se pudo crear un nuevo archivo de respaldo del sistema.";
	}else{
		header("Location: index.php");
	}
	$mensaje="<br/><div class=\"row-fluid\">
			<div class=\"alert alert-error\">
      			<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
			<strong>Error: </strong>".$tipo_error."
		  </div></div>";
}
if(isset($_POST['nuevo'])){
	$fechaDeLaCopia = date("dmY-His");
	$name_file="mysql-tis-".$fechaDeLaCopia.".sql";
	$ficheroDeLaCopia =$directorio."/".$name_file;
	$sistema="show variables where variable_name= 'basedir'";
	$restore=mysql_query($sistema);
	$DirBase=mysql_result($restore,0,"value");
	$primero=substr($DirBase,0,1);
	if ($primero=="/") {
	    $DirBase=$DirBase."bin/mysqldump";

	}
	else
	{
	    $DirBase=$DirBase."bin\mysqldump";

	}
    $executa="$DirBase -h webtisdb.cs.umss.edu.bo -u munisoft -pWSVBtmXg tis_munisoft > ".$name_file;
    system($executa,$resultado);
	if ($resultado)  //si hay error
	{
		header('Location: backup.php?error=4&dirbase='.$DirBase);//error al crear
	} else  //si no hay error
	{
			$sql = "INSERT INTO backup_log(nombre_backup, fecha_creacion, observacion)
					VALUES ('$name_file',CURRENT_TIMESTAMP,'Respaldo creado por el administrador exitosamente')";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
            system("mv ../prueba.sql ../backups/archivos.");
			header('Location: backup.php?backup=2&file='.$name_file);
	}
}
if(isset($_POST['aceptar'])){
	if(isset($_POST['archivo'])){
		$backup_file=$directorio."/".$_POST['archivo'];
		if(file_exists($backup_file) && is_readable($backup_file)){
			$sistema="show variables where variable_name= 'basedir'";
			$restore=mysql_query($sistema);
			$DirBase=mysql_result($restore,0,"value");
			$primero=substr($DirBase,0,1);
			if ($primero=="/") {
			    $DirBase=$DirBase."/bin/mysql";
			}
			else
			{
			    $DirBase=$DirBase."\bin\mysql";
			}
			$executa = "$DirBase -h webtisdb.cs.umss.edu.bo -u munisoft -pWSVBtmXg  tis_munisoft < $backup_file";
			system($executa,$resultado);
			if ($resultado)  //si hay error
			{
				header('Location: backup.php?error=3');//error al recuperar
			}
			else  //si no hay error
			{
			    	header('Location: backup.php?backup=1&file='.$_POST['archivo']);
			}
		}else{
			header('Location: backup.php?error=2');//archivo incorrecto
		}
	}else{//no se realizó el respaldo
		header('Location: backup.php?error=1');//no hay ningun archivo
	}
}
include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="backup.php">Respaldo y Restauraci&oacute;n de la Base de Datos</a>
					</li>
				</ul>
			</div>
			<center><h3>Respaldo y Restauraci&oacute;n de la Base de Datos</h3></center>
	<?php
		if($mensaje!=NULL){ echo $mensaje; }
	?>
	<div class="row-fluid">
        <div class="box span12">
          <div class="box-header well" data-original-title>
            <h2><i class="icon-book"></i> Archivos de Restauraci&oacute;n de la Base de Datos disponibles</h2>
          </div>
          <div class="box-content">
	    <form name="form-data" method="POST" id="form_8" action="backup.php" accept-charset="utf-8">
            <table class="table table-striped table-bordered  datatable">
              <thead>
                <tr>
                  <th>N&uacute;mero</th>
                  <th>Nombre del archivo</th>
                  <th>Fecha de creaci&oacute;n</th>
                  <th>Tama&ntilde;o del archivo</th>
                  <th style="text-align:center;">Restaurar Base de Datos</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $cantidad=0;
                if (@$dir=opendir($directorio)) {
                  while ($archivo=readdir($dir)) {
                    if (strcmp($archivo,'.')!=0 && strcmp($archivo, '..') && strcmp(end(explode('.',$archivo)),'sql')==0) {
                      //if (@$descriptor=fopen($directorio."/".$archivo, 'r')) {
                        $cantidad++;
                        $fecha_archivo=strftime("%d/%m/%y %X",filemtime($directorio."/".$archivo));
                        $tam=((int)(filesize($directorio."/".$archivo)))/1024;
                        $size_archivo=round($tam,'2');
                         echo "<tr>
                              <td>".$cantidad."</td>
                              <td >".$archivo."</td>
                              <td >".$fecha_archivo."</td>
                              <td >".$size_archivo." KB</td>
                              <td style=\"text-align:center;\">
                                <label class=\"radio\">
                        					<input type=\"radio\" name=\"archivo\" value=".$archivo." />
				                        </label>
			                        </td>
                              </tr>";
                        //fclose($descriptor);
                      //}
                    }
                  }
                }
             ?>
              </tbody>
            </table></br>
		<button class="btn btn-success btn-setting"><i class="icon-backward"></i> Restaurar</button>  <button class="btn btn-primary btn-setting2" id="enviar_3"><i class="icon-plus"></i> Nuevo archivo de respaldo</button> <a href="javascript:history.back();" class="btn"><i class="icon-arrow-left"></i> Volver Atras</a>
	    <div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Restaurar Base de Datos</h3>
			</div>
			<div class="modal-body">
				<p>Usted va ha realizar la restauraci&oacute;n de la base de datos. La base de datos seleccionada puede no contener la informaci&oacute;n mas reciente del sistema.<br> <b>Nota:</b> Esta operaci&oacute;n no puede deshacerce.</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancelar</a>
				<button type="submit" name="aceptar" value="aceptar" class="btn btn-primary"><i class="icon-ok"></i> Aceptar</button>
			</div>
		</div>
<div class="modal hide fade" id="myModal2">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Crear nuevo archivo de Respaldo</h3>
			</div>
			<div class="modal-body">
				<?php
					$ayer=date("Y-m-d");
					$consulta_verifica="SELECT COUNT('id_bitacora') as cantidad from bitacora_bd where fecha_hora >= '$ayer 00:00:01'";
					$res = mysql_query($consulta_verifica,$conn);
					$row = mysql_fetch_array($res);
					$cantidad=$row['cantidad'];
					if ($cantidad>0) {
						echo "Se ha registrado ".$cantidad." cambio(s) en la base de datos desde las 12:00 a.m. del d&iacute;a de hoy.</br>
							Est&aacute; de acuerdo con generar un nuevo archivo de respaldo de la base de datos actual.</br>
							<b>Presione en Aceptar si usted desea crear una nueva copia de seguridad de la base de datos actual.</b>";
					}else{
						echo "<p>No se ha registrado nig&uacute;n cambio en la base de datos desde las 12:00 a.m. del d&iacute;a de hoy.</br>
						 Un archivo de respaldo ser&aacute; de utilidad si ocurre alg&uacute;n error con el sistema.<br>
						<b>Presione en Aceptar si usted desea crear una nueva copia de seguridad de la base de datos actual.</b>";
					}

				?>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancelar</a>
				<button type="submit" name="nuevo" value="nuevo" class="btn btn-primary"><i class="icon-ok"></i> Aceptar</button>
			</div>
		</div>
	    </form>
          </div>
        </div><!--/span-->
      </div><!--/row-->

<?php include('footer.php'); ?>


