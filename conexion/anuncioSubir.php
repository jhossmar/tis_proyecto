<?php
   $pdf="";
   $tiene_curriculum=0;
    if(isset($_FILES['pdf']) ){
            $nombre_archivo = $_FILES['pdf']['name'];
            $nombre_tmp = $_FILES['pdf']['tmp_name'];
            $tipo = $_FILES['pdf']['type'];
            $tamano = $_FILES['pdf']['size'];
            $ext_permitidas = array('pdf', 'doc', 'docx');
            $partes_nombre = explode('.', $nombre_archivo);
            $extension = end($partes_nombre);
            $limite = 1000 * 1024;
            $ext_correcta = in_array($extension, $ext_permitidas);
            $c =  "SELECT COUNT(*) as cont
                   FROM anuncio
                   WHERE usuario='$usuario'";
            $r = mysql_query($c);
            $res = mysql_fetch_array($r);
            $num=  $res['cont'];

            if ($ext_correcta) {
              if( $tamano <= $limite ){
                    if( $_FILES['pdf']['error'] > 0 ){
                     ?>

                          <script language="javascript">
                          alert("Error al subir aviso");
                         </script>
                    <?php   }
                     else{
                             move_uploaded_file($nombre_tmp,"archivos/".$usuario.".".$num.".".$extension);
                             $pdf="archivos/".$usuario.".".$num.".".$extension;
                             ?>
                             <script language="javascript">
                              alert("Archivo enviado satisfactoriamente");
                            </script>                  
                          <?php }
                       }
                    }
                else{  ?>
                    
               <?php  }
            }                
   ?>