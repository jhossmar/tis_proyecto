<?php
    if(!isset($titulo)){
        header('Location: ../index.php');
    }
    
    include("conexion.php");
    $men =1;
    $consulta_sql="SELECT COUNT(*) as num
                    FROM usuario
                    WHERE (tipo_usuario = '2' || tipo_usuario = '3') AND habilitado = '0'";
    $consulta = mysql_query($consulta_sql,$conn)
		or die("Could not execute the select query 1.");
	$resultado = mysql_fetch_assoc($consulta);

    if($resultado['num']>0 ){
       echo "<ul class=\"dashboard-list\">
	         <li>Hay ".$resultado['num']." nuevo(s) Consultore(s)</li>
	         </ul>";
             $men =0;
             }

           $consulta_sql="SELECT COUNT(*) as num
                    FROM usuario
                    WHERE tipo_usuario = '4'  AND habilitado = '0'";
            $consulta = mysql_query($consulta_sql,$conn)
        		or die("Could not execute the select query 2.");
        	$resultado = mysql_fetch_assoc($consulta);

            if($resultado['num']>0 ){
               echo "<ul class=\"dashboard-list\">
        	         <li>Hay ".$resultado['num']." nuevo(s) Grupo(s) Empresa</li>
        	         </ul>";
                     $men =0;

             }

          
            if($men=='1')   {
                echo "<ul class=\"dashboard-list\">
        	         <li>No hay notificaciones </li>
        	         </ul>";
            }


?>
             