<?php
   $img= '1' ;
   $dirimg= '' ;
if( !isset($_FILES['foto']) ){
     $img= '0' ;
}else{
   $au=    $_REQUEST['usuario'];
  $nombre = $_FILES['foto']['name'];
  $nombre_tmp = $_FILES['foto']['tmp_name'];
  $tipo = $_FILES['foto']['type'];
  $tamano = $_FILES['foto']['size'];

  $ext_permitidas = array('jpg','jpeg','gif','png');
  $partes_nombre = explode('.', $nombre);
  $extension = end( $partes_nombre );
  $ext_correcta = in_array($extension, $ext_permitidas);
  $limite = 1000 * 1024;

  if( $ext_correcta &&  $tamano <= $limite ){
          if( $_FILES['foto']['error'] > 0 ){
                echo 'Error: ' . $_FILES['foto']['error'] . '<br/>';
                                               }
          else{

                if( file_exists( '../foto_consul/'.$nombre) ){
                    echo '<br/>El foto ya existe: ' . $nombre;
                  }


                else{ move_uploaded_file($nombre_tmp,"../foto_consul/" . $au . ".".  $extension);
                       $img= "../foto_consul/" . $au . ".".  $extension ;
                }
             }
  }
  else{
     echo “<script languaje=’javascript’>alert(‘la image debe ser de formato jpg,jpeg,gif o png y su tamaño menor o igual a 1 Mg‘)</script>”;

  }
}
?>