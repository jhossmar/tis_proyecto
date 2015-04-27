
<?php
   include('conexion/conexion.php');
   session_start();
            $bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
              or die("Error no se pudo realizar cambios.");
    $operacion=$_POST['operacion'];
    $grupoempresa=$_POST['grupoEmpresa'];
	$decripsion=$_POST['what'];

      $fechaini=date("Y-m-d");
      $fechafin=date("Y-m-d");
    $fechaini=$_POST['startDate'];
    $fechafin=$_POST['endDate'];
     if($operacion == "insert"){
	$responsable=$_POST['choose_responsable'];
    $colorTarea=$_POST['colorBackground'];
    $colorTexto=$_POST['colorForeground'];
    $res=$_POST['res'];
    $actividad=$_POST['choose_actividad'];
                                  $rep_fia=date("Y-m-d");
                                   $rep_fif=date("Y-m-d");
                                  $resultado = mysql_fetch_assoc(mysql_query("SELECT age.fecha_inicio,age.fecha_fin FROM actividad_grupo_empresa age WHERE age.id_actividad=$actividad"));
                                  $rep_fia=$resultado['fecha_inicio'];
                                  $rep_fif=$resultado['fecha_fin'];
              // $fia="".substr($rep_fia, 0,4)."".substr($rep_fia, 5,2)."".substr($rep_fia, 8); $fia=(int)$fia;
              // $ffa="".substr($rep_fif, 0,4)."".substr($rep_fif, 5,2)."".substr($rep_fif, 8); $ffa=(int)$ffa;
              // $fit="".substr($fechaini, 0,4)."".substr($fechaini, 5,2)."".substr($fechaini, 8);$fit=(int)$fit;
              // $fft="".substr($fechafin, 0,4)."".substr($fechafin, 5,2)."".substr($fechafin, 8);$fft=(int)$fft;
              // if($fechaini<$rep_fia||$fechaini>$rep_fif){$fechaini=$rep_fia; }
              // if($fechafin>$rep_fif){$fechafin=$rep_fif;}
               if(strlen($decripsion)!=0){
                         $sql = "INSERT INTO tarea (id_tarea,descripcion,fecha_inicio,fecha_fin,resultado_esperado,resultado_obtenido,color_tarea,color_texto,actividad,responsable)
                         VALUES (' ','$decripsion','$fechaini','$fechafin','$res',' ','$colorTarea','$colorTexto','$actividad','$responsable')";
            	         $result = mysql_query($sql,$conn) or die(mysql_error());


              }



          }
 if($operacion == "update"){ }

 if($operacion == "deletetarea"){

    $consulta_t = "SELECT t.id_tarea,t.fecha_inicio,t.fecha_fin,t.descripcion
                   FROM entrega_producto ep,actividad_grupo_empresa age,tarea t
                   WHERE ep.grupo_empresa='$grupoempresa'and ep.id_entrega_producto=age.entrega_producto
                   and age.id_actividad=t.actividad  and t.descripcion='$decripsion' and t.fecha_inicio = '$fechaini' and  t.fecha_fin='$fechafin'
                  ";
    $resultado_t = mysql_query($consulta_t);
     while($row_t = mysql_fetch_array($resultado_t)) {
                             $sql = "DELETE from tarea
                             WHERE id_tarea = '".$row_t['id_tarea']."'";
                             $result = mysql_query($sql,$conn) or die(mysql_error());
                             break;
                      }




    }
if($operacion == "deleteall"){


    $consulta_t = "SELECT t.id_tarea,t.fecha_inicio,t.fecha_fin,t.descripcion
                   FROM entrega_producto ep,actividad_grupo_empresa age,tarea t
                   WHERE ep.grupo_empresa='$grupoempresa'and ep.id_entrega_producto=age.entrega_producto
                   and age.id_actividad=t.actividad "; // and t.descripcion='$decripsion'";      // and t.fecha_inicio = '$dateiniold ' and  t.fecha_fin='$datefinold'
    $resultado_t = mysql_query($consulta_t);
     while($row_t = mysql_fetch_array($resultado_t)) {
                             $sql = "DELETE from tarea
                             WHERE id_tarea = '".$row_t['id_tarea']."'";
                             $result = mysql_query($sql,$conn) or die(mysql_error());
                      }




    }





















?>