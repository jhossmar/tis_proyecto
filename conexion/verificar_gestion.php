<?php
	date_default_timezone_set("America/La_Paz");
	include('conexion.php');
	/*----------DEFINICION DE VARIABLES CONTROL-----------------*/
	$gestion_valida=false;
	$nombre_gestion="no definida";
	$id_gestion=-1;
	$gestion_espera=false;
	$act_1=0;
	$act_2=0;
	$act_3=0;
	$act_4=0;
	$act_5=0;
	$act_6=0;
	$act_7=0;
	$date = date("Y-m-d");
	$hora=date("H:i:s");
	$fecha_actual=strtotime($date);
	/*---------FIN DEFINICION DE VARIABLES--------------*/
	$consulta_sql="SELECT id_gestion, gestion,fecha_ini_gestion,fecha_fin_gestion
				   from gestion_empresa_tis
				   WHERE gestion_activa=1 AND gestion!='Permanente'";
	$consulta = mysql_query($consulta_sql,$conn)
		or die("Could not execute the select query.");
	$resultado = mysql_fetch_assoc($consulta);
	if (!empty($resultado['id_gestion'])){ //SI NO ESTA VACIO ENTONCES CONTROLAR LA GESTION ACTUAL
		/*--------------------------VERIFICAR FECHAS DE GESTION------------------------*/
		$fin_gestion=$resultado['fecha_fin_gestion'];
		$ini_gestion=$resultado['fecha_ini_gestion'];
		$id_gestion=(int)$resultado['id_gestion'];
		$fecha_fin=strtotime($fin_gestion);
		$fecha_ini=strtotime($ini_gestion);
		if ($fecha_actual<=$fecha_fin) {
			if ($fecha_actual<$fecha_ini) {
				$id_gestion=-1;
				$nombre_gestion="inicia el ".$ini_gestion;
				$gestion_valida=false;
				$gestion_espera=true;
			}
			else{/*-------------------------ALL RIGHT------------------------------*/
				$nombre_gestion=$resultado['gestion'];
				$gestion_valida=true;
				$gestion_espera=false;
			/*------------------------------ACTIVIDAD 1------------------------------*/
				$consulta_1="SELECT activo, fecha_inicio, fecha_fin
							from fase_convocatoria
							WHERE tipo_fase_convocatoria=1 AND gestion=$id_gestion";
				$query_1 = mysql_query($consulta_1,$conn)
					or die("Could not execute the select query 1.");
				$res_1 = mysql_fetch_assoc($query_1);
				$act_1=$res_1['activo'];
				$act_1_espera=false;
				$act_ini_1=$res_1['fecha_inicio'];
				$act_fin_1=$res_1['fecha_fin'];
				$fecha_ini_1=strtotime($act_ini_1);
				$fecha_fin_1=strtotime($act_fin_1);
				if ($act_1==1) {//si se ha activado la actividad 1
					if ($fecha_actual<=$fecha_fin_1) {//si la fecha actual es menor o igual a la fecha fin
						if ($fecha_actual<$fecha_ini_1) {
							$act_1_espera=true;
						}
						else{
							$act_1=1;
							$act_1_espera=false;
						}
					}else{//si es mayor ya se tiene que desactivar
						$consulta_sql="UPDATE fase_convocatoria
						   			   set activo=0
						   			   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=1";
						$consulta = mysql_query($consulta_sql,$conn)
						or die(mysql_error());
						$act_1=0;
						$act_1_espera=false;
					}
				}
			/*------------------------------ACTIVIDAD 2------------------------------*/
				$consulta_2="SELECT activo, fecha_inicio, fecha_fin
							from fase_convocatoria
							WHERE tipo_fase_convocatoria=2 AND gestion=$id_gestion";
				$query_2 = mysql_query($consulta_2,$conn)
					or die("Could not execute the select query 3.");
				$res_2 = mysql_fetch_assoc($query_2);
				$act_2=$res_2['activo'];
				$act_2_espera=false;
				$act_ini_2=$res_2['fecha_inicio'];
				$act_fin_2=$res_2['fecha_fin'];
				$fecha_ini_2=strtotime($act_ini_2);
				$fecha_fin_2=strtotime($act_fin_2);
				if ($act_2==1) {//si se ha activado la actividad 1
					if ($fecha_actual<=$fecha_fin_2) {//si la fecha actual es menor o igual a la fecha fin
						if ($fecha_actual<$fecha_ini_2) {
							$act_2_espera=true;
						}
						else{
							$act_2=1;
							$act_2_espera=false;
						}
					}else{//si es mayor ya se tiene que desactivar
						$consulta_sql="UPDATE fase_convocatoria
						   			   set activo=0
						   			   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=2";
						$consulta = mysql_query($consulta_sql,$conn)
						or die("Could not execute the select query 4.");
						$act_2=0;
						$act_2_espera=false;
					}
				}
				/*---------------------------------ACTIVIDAD 3-------------------------------------*/
				$consulta_3="SELECT activo, fecha_inicio, fecha_fin
							from fase_convocatoria
							WHERE tipo_fase_convocatoria=3 AND gestion=$id_gestion";
				$query_3 = mysql_query($consulta_3,$conn)
					or die("Could not execute the select query 5.");
				$res_3 = mysql_fetch_assoc($query_3);
				$act_3=$res_3['activo'];
				$act_3_espera=false;
				$act_ini_3=$res_3['fecha_inicio'];
				$act_fin_3=$res_3['fecha_fin'];
				$fecha_ini_3=strtotime($act_ini_3);
				$fecha_fin_3=strtotime($act_fin_3);
				if ($act_3==1) {//si se ha activado la actividad 1
					if ($fecha_actual<=$fecha_fin_3) {//si la fecha actual es menor o igual a la fecha fin
						if ($fecha_actual<$fecha_ini_3) {
							$act_3_espera=true;
						}
						else{
							$act_3=1;
							$act_3_espera=false;
						}
					}else{//si es mayor ya se tiene que desactivar
						$consulta_sql="UPDATE fase_convocatoria
						   			   set activo=0
						   			   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=3";
						$consulta = mysql_query($consulta_sql,$conn)
						or die("Could not execute the select query 6.");
						$act_3=0;
						$act_3_espera=false;
					}
				}
				/*--------------------------------ACTIVIDAD 4----------------------------*/
				$consulta_4="SELECT activo, fecha_inicio, fecha_fin
							from fase_convocatoria
							WHERE tipo_fase_convocatoria=4 AND gestion=$id_gestion";
				$query_4 = mysql_query($consulta_4,$conn)
					or die("Could not execute the select query 7.");
				$res_4 = mysql_fetch_assoc($query_4);
				$act_4=$res_4['activo'];
				$act_4_espera=false;
				$act_ini_4=$res_4['fecha_inicio'];
				$act_fin_4=$res_4['fecha_fin'];
				$fecha_ini_4=strtotime($act_ini_4);
				$fecha_fin_4=strtotime($act_fin_4);
				if ($act_4==1) {//si se ha activado la actividad 4
					if ($fecha_actual<=$fecha_fin_4) {//si la fecha actual es menor o igual a la fecha fin
						if ($fecha_actual<$fecha_ini_4) {
							$act_4_espera=true;
						}
						else{
							$act_4=1;
							$act_4_espera=false;
						}
					}else{//si es mayor ya se tiene que desactivar
						$consulta_sql="UPDATE fase_convocatoria
						   			   set activo=0
						   			   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=4";
						$consulta = mysql_query($consulta_sql,$conn)
						or die("Could not execute the select query 8.");
						$act_4=0;
						$act_4_espera=false;
					}
				}
				/*-----------------------------ACTIVIDAD 5-----------------------------------*/
				$consulta_5="SELECT activo, fecha_inicio, fecha_fin
							from fase_convocatoria
							WHERE tipo_fase_convocatoria=5 AND gestion=$id_gestion";
				$query_5 = mysql_query($consulta_5,$conn)
					or die("Could not execute the select query 9.");
				$res_5 = mysql_fetch_assoc($query_5);
				$act_5=$res_5['activo'];
				$act_5_espera=false;
				$act_ini_5=$res_5['fecha_inicio'];
				$act_fin_5=$res_5['fecha_fin'];
				$fecha_ini_5=strtotime($act_ini_5);
				$fecha_fin_5=strtotime($act_fin_5);
				if ($act_5==1) {//si se ha activado la actividad 5
					if ($fecha_actual<=$fecha_fin_5) {//si la fecha actual es menor o igual a la fecha fin
						if ($fecha_actual<$fecha_ini_5) {
							$act_5_espera=true;
						}
						else{
							$act_5=1;
							$act_5_espera=false;
						}
					}else{//si es mayor ya se tiene que desactivar
						$consulta_sql="UPDATE fase_convocatoria
						   			   set activo=0
						   			   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=5";
						$consulta = mysql_query($consulta_sql,$conn)
						or die("Could not execute the select query 10.");
						$act_5=0;
						$act_5_espera=false;
					}
				}
				/*------------------------------------ACTIVIDAD 6---------------------------------*/
				$consulta_6="SELECT activo, fecha_inicio, fecha_fin
							from fase_convocatoria
							WHERE tipo_fase_convocatoria=6 AND gestion=$id_gestion";
				$query_6 = mysql_query($consulta_6,$conn)
					or die("Could not execute the select query 11.");
				$res_6 = mysql_fetch_assoc($query_6);
				$act_6=$res_6['activo'];
				$act_6_espera=false;
				$act_ini_6=$res_6['fecha_inicio'];
				$act_fin_6=$res_6['fecha_fin'];
				$fecha_ini_6=strtotime($act_ini_6);
				$fecha_fin_6=strtotime($act_fin_6);
				if ($act_6==1) {//si se ha activado la actividad 1
					if ($fecha_actual<=$fecha_fin_6) {//si la fecha actual es menor o igual a la fecha fin
						if ($fecha_actual<$fecha_ini_6) {
							$act_6_espera=true;
						}
						else{
							$act_6=1;
							$act_6_espera=false;
						}
					}else{//si es mayor ya se tiene que desactivar
						$consulta_sql="UPDATE fase_convocatoria
						   			   set activo=0
						   			   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=6";
						$consulta = mysql_query($consulta_sql,$conn)
						or die("Could not execute the select query 12.");
						$act_6=0;
						$act_6_espera=false;
					}
				}
				/*------------------------ACTIVIDAD 7-----------------------------------*/
				$consulta_7="SELECT activo, fecha_inicio, fecha_fin
							from fase_convocatoria
							WHERE tipo_fase_convocatoria=7 AND gestion=$id_gestion";
				$query_7 = mysql_query($consulta_7,$conn)
					or die("Could not execute the select query 13.");
				$res_7 = mysql_fetch_assoc($query_7);
				$act_7=$res_7['activo'];
				$act_7_espera=false;
				$act_ini_7=$res_7['fecha_inicio'];
				$act_fin_7=$res_7['fecha_fin'];
				$fecha_ini_7=strtotime($act_ini_7);
				$fecha_fin_7=strtotime($act_fin_7);
				if ($act_7==1) {//si se ha activado la actividad 7
					if ($fecha_actual<=$fecha_fin_7) {//si la fecha actual es menor o igual a la fecha fin
						if ($fecha_actual<$fecha_ini_7) {
							$act_7_espera=true;
						}
						else{
							$act_7=1;
							$act_7_espera=false;
						}
					}else{//si es mayor ya se tiene que desactivar
						$consulta_sql="UPDATE fase_convocatoria
						   			   set activo=0
						   			   WHERE gestion=$id_gestion AND tipo_fase_convocatoria=7";
						$consulta = mysql_query($consulta_sql,$conn)
						or die("Could not execute the select query 14.");
						$act_7=0;
						$act_7_espera=false;
					}
				}
				/*----------------------------FIN COMPROBACIONES Y ACTUALIZACIONES--------------------*/
			}
		}
		else{
			$cerrar_gestion="UPDATE gestion_empresa_tis
							set gestion_activa=0
							WHERE id_gestion=$id_gestion";
			$consulta_cerrar = mysql_query($cerrar_gestion,$conn)
			or die("Could not execute the select query 15.");
			$id_gestion=-1;
			$nombre_gestion="no definida";
			$gestion_valida=false;
			$gestion_espera=false;
		}
		/*-------------------------FIN VERIFICAR FECHAS DE GESTION---------------------*/
	}
?>
