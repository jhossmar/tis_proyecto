<?php
    include('conexion/conexion.php');
    session_start();
            $bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
              or die("Error no se pudo realizar cambios.");
    $operacion=$_POST['operacion'];
    $grupoempresa=$_POST['grupoEmpresa'];
	$decripsion=$_POST['descripsion'];
    $fechaini=$_POST['fechaini'];
    $fechafin=$_POST['fechafin'];
    $di = date('Y/m/d', strtotime($fechaini));
    $df = date('Y/m/d', strtotime($fechafin));
    if($operacion=="update"){
                  $idac= $_POST['idac'];
               /* $consulta_a = "SELECT age.id_actividad_grupo_empresa, ep.id_entrega_producto
                                FROM entrega_producto ep,actividad_grupo_empresa age
                                WHERE ep.grupo_empresa='".$grupoempresa."' AND ep.id_entrega_producto=age.entrega_producto";
                $resultado_a = mysql_query($consulta_a);
                                    while($row_a = mysql_fetch_array($resultado_a))  {  */
                                      $sql = "UPDATE actividad_grupo_empresa set 				                                              descripcion='$decripsion',fecha_inicio= '$di',fecha_fin='$df'
                                              WHERE   id_actividad_grupo_empresa='$idac'";         //entrega_producto='".$row_a['id_entrega_producto']."' and
                                            $result = mysql_query($sql,$conn) or die(mysql_error());

                                  // }




    }
    if($operacion=="inset"){


    }
    if($operacion=="delete"){


    }

?>