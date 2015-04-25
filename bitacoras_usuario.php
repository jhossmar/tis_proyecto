<?php
$titulo="Bit&aacute;coras de usuario";
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
$consulta = "SELECT id_bitacora_sesion, fecha_hora, operacion, nombre_usuario,g.gestion,descripcion
              FROM bitacora_sesion b, usuario u, gestion_empresa_tis g,tipo_usuario
              WHERE id_usuario=usuario AND u.gestion=g.id_gestion  AND tipo_usuario=id_tipo_usuario";

$consulta_2 = "SELECT id_bitacora,fecha_hora,u.nombre_usuario,viejo,nuevo,g.gestion, t.descripcion,tabla
               FROM bitacora_bd b, usuario u, gestion_empresa_tis g, tipo_usuario t
               WHERE u.id_usuario=b.usuario AND g.id_gestion=u.gestion AND u.tipo_usuario=t.id_tipo_usuario";

$ini_filtro=NULL;
$fin_filtro=NULL;
$filtro_gestion=-1;
$filtro_tipo=-1;
$fecha = date("Y-m-d");
$ini_filtro=NULL;
$fin_filtro=NULL;
$error=false;

$ini_filtro_2=NULL;
$fin_filtro_2=NULL;
$filtro_gestion_2=-1;
$filtro_tipo_2=-1;
$error_2=false;

if(isset($_POST['filtrar'])){
  /*VALORES DE FORMULARIO*/
  if (!empty($_POST['fecha_ini']) && !empty($_POST['fecha_fin'])) {
    $ini_filtro=$_POST['fecha_ini'];
    $fin_filtro=$_POST['fecha_fin'];
    $ini_dia = substr($ini_filtro, 8);
    $ini_mes = substr($ini_filtro, 5,2);
    $ini_year = substr($ini_filtro, 0,4);

    $fin_dia = substr($fin_filtro, 8);
    $fin_mes = substr($fin_filtro, 5,2);
    $fin_year = substr($fin_filtro, 0,4);
    if(@checkdate($ini_mes, $ini_dia, $ini_year)){
      if (@checkdate($fin_mes, $fin_dia, $fin_year)) {
        if($ini_filtro<=$fecha){//corecto
          if ($fin_filtro>=$ini_filtro && $fin_filtro<=$fecha) {//ALL RIGHT
              $consulta=$consulta." AND (fecha_hora>='".$ini_filtro." 00:00:00' AND fecha_hora<='".$fin_filtro." 23:59:59')";
          }
          else{
            $error = true;
            $error_fecha_fin = "La fecha de finalizaci&oacute;n no es v&aacute;lida";
          }
        }
        else{
          $error = true;
          $error_fecha_ini = "La fecha de inicio no debe ser mayor a la fecha presente";
        }
      }
      else{
            $error = true;
            $error_fecha_fin = "La fecha de finalizaci&oacute;n no es v&aacute;lida";
          }
    }
    else{
          $error = true;
          $error_fecha_ini = "La fecha de inicio no es v&aacute;lida";
      }

  }elseif (!empty($_POST['fecha_ini'])) {
    $ini_filtro=$_POST['fecha_ini'];
    
    $ini_dia = substr($ini_filtro, 8);
    $ini_mes = substr($ini_filtro, 5,2);
    $ini_year = substr($ini_filtro, 0,4);
    if(@checkdate($ini_mes, $ini_dia, $ini_year)){
      if($ini_filtro<=$fecha){//corecto
        $consulta=$consulta." AND (fecha_hora>='".$ini_filtro." 00:00:00')";
      }
     else{
        $error=true;
        $error_fecha_ini = "La fecha de inicio no debe ser mayor a la fecha presente";
      }
    }
    else{
          $error = true;
          $error_fecha_ini = "La fecha de inicio no es v&aacute;lida";
      }

  }elseif(!empty($_POST['fecha_fin'])){
    $fin_filtro=$_POST['fecha_fin'];

    $fin_dia = substr($fin_filtro, 8);
    $fin_mes = substr($fin_filtro, 5,2);
    $fin_year = substr($fin_filtro, 0,4);
    if (@checkdate($fin_mes, $fin_dia, $fin_year)) {
      if ($fin_filtro<=$fecha) {//ALL RIGHT
          $consulta=$consulta." AND (fecha_hora<='".$fin_filtro." 23:59:59')";
      }
      else{
            $error = true;
            $error_fecha_fin = "La fecha de finalizaci&oacute;n no debe ser mayor a la fecha presente";
          }
    }else{
      $error = true;
      $error_fecha_fin = "La fecha de finalizaci&oacute;n no es v&aacute;lida";
    }
}
  
  if ($_POST['gestion']!=-1) {
    $filtro_gestion=$_POST['gestion'];
    $consulta=$consulta." AND u.gestion=$filtro_gestion";
  }
  if ($_POST['usuario']!=-1) {
    $filtro_tipo=$_POST['usuario'];
    $consulta=$consulta." AND tipo_usuario=$filtro_tipo";
  }
  if(!$error){
          //header('Location: modificar_registro_consultor.php?value='.$quien);
      
  }
}

if(isset($_POST['filtrar_2'])){
  /*VALORES DE FORMULARIO*/
  if (!empty($_POST['fecha_ini_2']) && !empty($_POST['fecha_fin_2'])) {
    $ini_filtro_2=$_POST['fecha_ini_2'];
    $fin_filtro_2=$_POST['fecha_fin_2'];
    $ini_dia_2 = substr($ini_filtro_2, 8);
    $ini_mes_2 = substr($ini_filtro_2, 5,2);
    $ini_year_2 = substr($ini_filtro_2, 0,4);

    $fin_dia_2 = substr($fin_filtro_2, 8);
    $fin_mes_2 = substr($fin_filtro_2, 5,2);
    $fin_year_2 = substr($fin_filtro_2, 0,4);
    if(@checkdate($ini_mes_2, $ini_dia_2, $ini_year_2)){
      if (@checkdate($fin_mes_2, $fin_dia_2, $fin_year_2)) {
        if($ini_filtro_2<=$fecha){//corecto
          if ($fin_filtro_2>=$ini_filtro_2 && $fin_filtro_2<=$fecha) {//ALL RIGHT
              $consulta_2=$consulta_2." AND (fecha_hora>='".$ini_filtro_2." 00:00:00' AND fecha_hora<='".$fin_filtro_2." 23:59:59')";
          }
          else{
            $error_2 = true;
            $error_fecha_fin_2 = "La fecha de finalizaci&oacute;n no es v&aacute;lida";
          }
        }
        else{
          $error_2 = true;
          $error_fecha_ini_2 = "La fecha de inicio no debe ser mayor a la fecha presente";
        }
      }
      else{
            $error_2 = true;
            $error_fecha_fin_2 = "La fecha de finalizaci&oacute;n no es v&aacute;lida";
          }
    }
    else{
          $error_2 = true;
          $error_fecha_ini_2 = "La fecha de inicio no es v&aacute;lida";
      }

  }elseif (!empty($_POST['fecha_ini_2'])) {
    $ini_filtro_2=$_POST['fecha_ini_2'];
    
    $ini_dia_2 = substr($ini_filtro_2, 8);
    $ini_mes_2 = substr($ini_filtro_2, 5,2);
    $ini_year_2 = substr($ini_filtro_2, 0,4);
    if(@checkdate($ini_mes_2, $ini_dia_2, $ini_year_2)){
      if($ini_filtro_2<=$fecha){//corecto
        $consulta_2=$consulta_2." AND (fecha_hora>='".$ini_filtro_2." 00:00:00')";
      }
     else{
        $error_2=true;
        $error_fecha_ini_2 = "La fecha de inicio no debe ser mayor a la fecha presente";
      }
    }
    else{
          $error_2 = true;
          $error_fecha_ini_2 = "La fecha de inicio no es v&aacute;lida";
      }

  }elseif(!empty($_POST['fecha_fin_2'])){
    $fin_filtro_2=$_POST['fecha_fin_2'];

    $fin_dia_2 = substr($fin_filtro_2, 8);
    $fin_mes_2 = substr($fin_filtro_2, 5,2);
    $fin_year_2 = substr($fin_filtro_2, 0,4);
    if (@checkdate($fin_mes_2, $fin_dia_2, $fin_year_2)) {
      if ($fin_filtro_2<=$fecha) {//ALL RIGHT
          $consulta_2=$consulta_2." AND (fecha_hora<='".$fin_filtro_2." 23:59:59')";
      }
      else{
            $error_2 = true;
            $error_fecha_fin_2 = "La fecha de finalizaci&oacute;n no debe ser mayor a la fecha presente";
          }
    }else{
      $error_2 = true;
      $error_fecha_fin_2 = "La fecha de finalizaci&oacute;n no es v&aacute;lida";
    }
}
  
  if ($_POST['gestion_2']!=-1) {
    $filtro_gestion_2=$_POST['gestion_2'];
    $consulta_2=$consulta_2." AND u.gestion=$filtro_gestion_2";
  }
  if ($_POST['usuario_2']!=-1) {
    $filtro_tipo_2=$_POST['usuario_2'];
    $consulta_2=$consulta_2." AND tipo_usuario=$filtro_tipo_2";
  }
  if(!$error){
          //header('Location: modificar_registro_consultor.php?value='.$quien);
      
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
						<a href="bitacoras_usuario.php">Bit&aacute;coras de usuario</a>
					</li>
				</ul>
			</div>
			<center><h3>Bit&aacute;coras de usuario</h3></center>
			<div class="row-fluid" id="bitacora1">   
        <div class="box span12">
          <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Bit&aacute;coras de sesi&oacute;n de usuario</h2>
          </div>
          <div class="box-content">
          <form class="form-inline" name="form-data" method="POST" id="form_8" action="bitacoras_usuario.php#bitacora1" accept-charset="utf-8">
          <div class="row-fluid">
            <div class="span4">
              <div class="control-group">
                  <label class="control-label" >Desde: </label>
                  <div class="controls">
                  <input type="text" class="datepicker" name="fecha_ini" placeholder="Mostrar desde" value="<?php echo $ini_filtro; ?>">
                  </div>
              </div>
              <div class="control-group">
                  <label class="control-label" >Hasta: </label>
                  <div class="controls">
                  <input type="text" class="datepicker" name="fecha_fin" placeholder="Mostrar hasta" value="<?php echo $fin_filtro; ?>">
                  </div>
              </div>
            </div>
          <div class="span5">
            <div class="control-group">
                  <label class="control-label" >Gesti&oacute;n: </label>
                  <div class="controls">
                    <select name="gestion" data-rel="chosen">
                      <option value="-1">-- Todas las Gestiones --</option>
                      <?php
                          $gestion = "SELECT id_gestion,gestion FROM gestion_empresa_tis";//and gestion=$id_gestion
                          $res_gestion = mysql_query($gestion,$conn);
                          if (isset($_POST['gestion']) && $_POST['gestion']!=-1){
                            while($row = mysql_fetch_array($res_gestion)){
                            echo "<option ".(($row['id_gestion']==$_POST['gestion'])?"selected":"")." value=\"".$row['id_gestion']."\">".$row['gestion']."</option>";
                            }
                          }else{
                            while($row = mysql_fetch_array($res_gestion)) {
                            echo "<option value=\"".$row['id_gestion']."\">".$row['gestion']."</option>";
                            } 
                          }                        
                       ?>
                    </select>
                  </div>
              </div>
           <div class="control-group">
                  <label class="control-label" >Tipo de usuario: </label>
                  <div class="controls">
                    <select name="usuario" data-rel="chosen">
                    <option value="-1">-- Todos los usuarios --</option>
                    <?php
                          $tipo_user = "SELECT id_tipo_usuario,descripcion from tipo_usuario";//and gestion=$id_gestion
                          $res_tipo = mysql_query($tipo_user,$conn);
                          if (isset($_POST['usuario']) && $_POST['usuario']!=-1){
                            while($row = mysql_fetch_array($res_tipo)){
                            echo "<option ".(($row['id_tipo_usuario']==$_POST['usuario'])?"selected":"")." value=\"".$row['id_tipo_usuario']."\">".$row['descripcion']."</option>";
                            }
                          }else{
                            while($row = mysql_fetch_array($res_tipo)) {
                            echo "<option value=\"".$row['id_tipo_usuario']."\">".$row['descripcion']."</option>";
                            } 
                          }    

                       ?>
                  </select>
                  </div>
              </div>
          </div>
          <div class="span3">
            <div class="control-group">
                <label class="control-label" ></label>
                  <div class="controls">
                   <button type="submit" name="filtrar" value="Filtrar" class="btn btn-primary"><i class="icon-search"></i> Filtrar resultados</button>
                  </div>
            </div>
            <div class="control-group">
                <label class="error"><?php if(isset($error_fecha_ini)){ echo $error_fecha_ini; } ?></label>
                <label class="error"><?php if(isset($error_fecha_fin)){ echo $error_fecha_fin; } ?></label>
                
            </div>
          </div>
        </div>
        </form>
            <table class="table table-striped table-bordered  datatable">
              <thead>
                <tr>
                  <th>ID Bit&aacute;cora</th>
                  <th>Nombre de usuario</th>
                  <th>Tipo de usuario</th>
                  <th>Fecha del evento</th>
                  <th>Evento</th>
                  <th>Gesti&oacute;n</th>
                </tr>
              </thead>   
              <tbody>
              <?php
                $num_res=0;
                $resultado = mysql_query($consulta);
                $num_res=mysql_num_rows($resultado);
                if ($num_res>0) {
                  while($row = mysql_fetch_array($resultado)) {
                    if ($row['operacion']==0) {
                      $evento="Ingreso al sistema";
                    }
                    else{
                      $evento="Salio del sistema";
                    }
                               echo "
                                <tr>
                                <td>".$row["id_bitacora_sesion"]."</td>
                                <td >".$row["nombre_usuario"]."</td>
                                 <td >".$row["descripcion"]."</td>
                                <td >".$row["fecha_hora"]."</td>
                                <td >".$evento."</td>
                                <td >".$row["gestion"]."</td>     
                                </tr>";
                              }
                      }
              ?>
              </tbody>
            </table>            
          </div>
        </div><!--/span-->
      </div><!--/row-->
      <div class="row-fluid" id="bitacora2">   
        <div class="box span12">
          <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Bit&aacute;coras de (algun nombre)</h2>
          </div>
          <div class="box-content">
          <form class="form-inline" name="form-data" method="POST" id="form" action="bitacoras_usuario.php#bitacora2" accept-charset="utf-8">
          <div class="row-fluid">
            <div class="span4">
              <div class="control-group">
                  <label class="control-label" >Desde: </label>
                  <div class="controls">
                  <input type="text" class="datepicker" name="fecha_ini_2" placeholder="Mostrar desde" value="<?php echo $ini_filtro_2; ?>">
                  </div>
              </div>
              <div class="control-group">
                  <label class="control-label" >Hasta: </label>
                  <div class="controls">
                  <input type="text" class="datepicker" name="fecha_fin_2" placeholder="Mostrar hasta" value="<?php echo $fin_filtro_2; ?>">
                  </div>
              </div>
            </div>
          <div class="span5">
            <div class="control-group">
                  <label class="control-label" >Gesti&oacute;n: </label>
                  <div class="controls">
                    <select name="gestion_2" data-rel="chosen">
                      <option value="-1">-- Todas las Gestiones --</option>
                      <?php
                          $gestion_2 = "SELECT id_gestion,gestion FROM gestion_empresa_tis";//and gestion=$id_gestion
                          $res_gestion_2 = mysql_query($gestion_2,$conn);
                          if (isset($_POST['gestion_2']) && $_POST['gestion_2']!=-1){
                            while($row_2 = mysql_fetch_array($res_gestion_2)){
                            echo "<option ".(($row_2['id_gestion']==$_POST['gestion_2'])?"selected":"")." value=\"".$row_2['id_gestion']."\">".$row_2['gestion']."</option>";
                            }
                          }else{
                            while($row_2 = mysql_fetch_array($res_gestion_2)) {
                            echo "<option value=\"".$row_2['id_gestion']."\">".$row_2['gestion']."</option>";
                            } 
                          }                        
                       ?>
                    </select>
                  </div>
              </div>
           <div class="control-group">
                  <label class="control-label" >Tipo de usuario: </label>
                  <div class="controls">
                    <select name="usuario_2" data-rel="chosen">
                    <option value="-1">-- Todos los usuarios --</option>
                    <?php
                          $tipo_user_2 = "SELECT id_tipo_usuario,descripcion from tipo_usuario";//and gestion=$id_gestion
                          $res_tipo_2 = mysql_query($tipo_user_2,$conn);
                          if (isset($_POST['usuario_2']) && $_POST['usuario_2']!=-1){
                            while($row_2 = mysql_fetch_array($res_tipo_2)){
                            echo "<option ".(($row_2['id_tipo_usuario']==$_POST['usuario_2'])?"selected":"")." value=\"".$row_2['id_tipo_usuario']."\">".$row_2['descripcion']."</option>";
                            }
                          }else{
                            while($row_2 = mysql_fetch_array($res_tipo_2)) {
                            echo "<option value=\"".$row_2['id_tipo_usuario']."\">".$row_2['descripcion']."</option>";
                            } 
                          }    

                       ?>
                  </select>
                  </div>
              </div>
          </div>
          <div class="span3">
            <div class="control-group">
                <label class="control-label" ></label>
                  <div class="controls">
                   <button type="submit" name="filtrar_2" value="Filtrar_2" class="btn btn-primary"><i class="icon-search"></i> Filtrar resultados</button>
                  </div>
            </div>
            <div class="control-group">
                <label class="error"><?php if(isset($error_fecha_ini_2)){ echo $error_fecha_ini_2; } ?></label>
                <label class="error"><?php if(isset($error_fecha_fin_2)){ echo $error_fecha_fin_2; } ?></label>
                
            </div>
          </div>
        </div>
        </form>
            <table class="table table-striped table-bordered  datatable">
              <thead>
                <tr>
                  <th>ID Bit&aacute;cora</th>
                  <th>Nombre de usuario</th>
                  <th>Tipo de usuario</th>
                  <th>Fecha del evento</th>
                  <th>Evento</th>
                  <th>Tabla afectada</th>
                  <th>Gesti&oacute;n</th>
                </tr>
              </thead>   
              <tbody>
              <?php
                $num_res_2=0;
                $resultado_2 = mysql_query($consulta_2);
                $num_res_2=mysql_num_rows($resultado_2);
                if ($num_res_2>0) {
                  while($row_2= mysql_fetch_array($resultado_2)) {
                    if (is_null($row_2['viejo'])) {
                      $evento_2="Inserci&oacute;n";
                    }
                    elseif(!is_null($row_2['viejo']) && !is_null($row_2['nuevo'])){
                      $evento_2="Modificaci&oacute;n";
                    }else{
                      $evento_2="Eliminaci&oacute;n";
                    }
                               echo "
                                <tr>
                                <td>".$row_2["id_bitacora"]."</td>
                                <td >".$row_2["nombre_usuario"]."</td>
                                 <td >".$row_2["descripcion"]."</td>
                                <td >".$row_2["fecha_hora"]."</td>
                                <td >".$evento_2."</td>
                                <td >".$row_2["tabla"]."</td>
                                <td >".$row_2["gestion"]."</td>     
                                </tr>";
                              }
                      }
              ?>
              </tbody>
            </table>            
          </div>
        </div><!--/span-->
      </div><!--/row-->
<?php include('footer.php'); ?>