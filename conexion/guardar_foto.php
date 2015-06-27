<?php

$ruta = "../img/profiles/";
$formatos = $arrayName = array('.jpg','.png'); 
session_start();
include_once('../conexion/conexion.php');
 if (isset($_POST['btn_upload'])) {
	  if(!empty($_FILES['foto']['name'])){
       opendir($ruta);
       $destino = $ruta.$_FILES['foto']['name'];
       $ext= substr($destino, strrpos($destino, '.'));
       if (in_array($ext, $formatos)) {
       copy($_FILES['foto']['tmp_name'],$ruta.$_SESSION['id'].$_SESSION['nombre_usuario'].$ext); //  Si el archivo ya existe este se remplaza .Recoradar que la carpeta debe tener permisos de escritura. 

       $conexion = new Conexion;
       $conexion->EstablecerConexion();
       $conn=$conexion->GetConexion();
       
      $id_Ususario = $_SESSION['id']; 
      $destinio2 =   'img/profiles/'.$_SESSION['id'].$_SESSION['nombre_usuario'].$ext;
     
      $consulta =" UPDATE usuario 
                    SET   foto =  '$destinio2'
                     WHERE id_usuario = '$id_Ususario'";
      
      mysql_query($consulta ,$conn) or die(mysql_error());
      
       header("location:../index.php");
     }else
     {
      echo("<h1>escoger un archivo del tipo jpg o png solamente</h1>");
      }
   }else
   {
       echo("<h1>selecciona un archivo por favor</h1>");
    }
  } 
?>
