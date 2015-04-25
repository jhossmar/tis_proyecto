<?php
	session_start();
	if(isset($_SESSION['nombre_usuario']))
	{
		$home="";
		switch ($_SESSION['tipo']){
			 	case (5) :
                        $home="home_integrante.php";
                        break; 
	            case (4) :
	                	$home="home_grupo.php";
	                    break;
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
		header("Location: ../".$home);
	}
	$id_gestion=-1;
	include('verificar_gestion.php');
	/*VALORES A BUSCAR*/
	$nombre=trim($_POST['username']);
	$clave=trim($_POST['password']); /*$clave = md5($pass); QUITADO ==> CONTRASEÑA SIMPLE*/
	$tipo=$_POST['tipo'];

	$consulta_sql="select * from usuario where nombre_usuario='$nombre' and clave='$clave' and ";

	if ($tipo==3 || $tipo==2) {
		$consulta_sql=$consulta_sql."(tipo_usuario=2 OR tipo_usuario=3) AND gestion=1";
	}
	elseif($tipo==4) {
		$consulta_sql=$consulta_sql."(tipo_usuario=4 OR tipo_usuario=5) AND gestion=$id_gestion";
	}
	elseif($tipo==1){
		$consulta_sql=$consulta_sql."tipo_usuario=1";
	}
	
	else{
		header('location:../index.php');
	}
	$consulta_sql=$consulta_sql." AND habilitado=1";
	$consulta = mysql_query($consulta_sql,$conn)
		or die("Could not execute the select query.");

	$resultado = mysql_fetch_assoc($consulta);
	
	if(is_array($resultado) && !empty($resultado))
		{	
			$_SESSION['id'] = $resultado['id_usuario'];
			$_SESSION['tipo']= $resultado['tipo_usuario'];
			$nombre_valido = $resultado['nombre_usuario'];
			$_SESSION['nombre_usuario'] = $nombre_valido;//nombre del usuario						
		}
	else{	
			/*ACA MANEJAR LOS ERRORES SI ES ADMIN MOSTRAR ACCESO DENEGADO
			SI ES GRUPO EMPRESA O CONSULTOR MOSTRAR EL ERROR EN LA MISMA PAGINA*/

			/*NO EXISTE EL USUARIO*/
			echo "<center><h1>Acceso denegado</h1></center>"."<br />";
			echo "<center><h3>Por favor espera 3 segundos mientras te redirigimos al inicio.</h3></center>"."<br />";
			header('Refresh: 3; url=../index.php');

		}
	if(isset($_SESSION['nombre_usuario']))
	{
		$bitacora = mysql_query("INSERT into bitacora_sesion(usuario,fecha_hora,operacion)
								VALUES (".$_SESSION['id'].",CURRENT_TIMESTAMP,0)",$conn)
		or die("Error en la bitacora.");
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
	                    break;
	            case (4) :
	                	$home="home_grupo.php";
	                    break;
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
		header("Location: ../".$home);
	}
	mysql_free_result($consulta);
?>
