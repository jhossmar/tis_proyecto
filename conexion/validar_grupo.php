<?php
            include('conexion.php');
	session_start();
	$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
	or die("Error no se pudo realizar cambios.");
              $usuario=(int)$_GET['consultor'];
              $gestion=(int)$_GET['gestion'];
              $c ="SELECT COUNT(u.id_usuario) as numer
                    from grupo_empresa g, usuario u, integrante i
                    where g.consultor_tis=$usuario AND i.grupo_empresa=g.id_grupo_empresa AND 
                    i.usuario=u.id_usuario AND u.tipo_usuario=4 AND u.gestion=$gestion";
               $r = mysql_query($c);
               $res = mysql_fetch_array($r);
               $num=  $res['numer'];
               $counta=0;
               while($counta < $num){
                       $a = $_GET["a".$counta];
                       $b=0;

                       if($_GET["b".$counta]){
                           $b=1;                     
                       }
                        $sql = "UPDATE usuario
                        SET habilitado='$b'
                        WHERE id_usuario ='$a'";
                        $result = mysql_query($sql);      
                 $counta++;
               }
               header("Location:../administrar_grupo.php");
              
?>
