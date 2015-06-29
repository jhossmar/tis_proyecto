<?php
$pag=0;
$titulo="modificar calificacion";
$opcion=0;

if(isset($_GET['value']) && isset($_GET['id']))
{
   $opcion =$_GET['value'];
   $aux =$_GET['id'];
   
   $pag=1;
}
elseif(isset($_POST['dinero']))
{
  $monto=$_POST['dinero'];
  $idGrupo=$_POST['idgrupo'];
  $idEntrega=$_POST['identrega'];

  include('conexion/conexion.php');
  
  $conexion = new Conexion;
  $conexion->EstablecerConexion();
  $conn = $conexion->GetConexion();
  mysql_query("UPDATE entrega_producto 
               SET pago_recibido=$monto
                WHERE id_entrega_producto=$idEntrega AND grupo_empresa=$idGrupo",$conn) or die(mysql_error());

   echo "<script type='text/javascript'>
         alert('se ha realizado el pago por la actividad de forma correcta')
         </script>
        <META HTTP-EQUIV='Refresh' CONTENT='1; URL=calificar_grupo_empresa.php'> ";
}
elseif(isset($_POST['observaciones']))
{
  $obs=$_POST['observaciones'];
  $idGrupo=$_POST['idgrupo'];
  $idEntrega=$_POST['identrega'];
  
  include('conexion/conexion.php');
   $conexion = new Conexion;
   $conexion->EstablecerConexion();
   $conn = $conexion->GetConexion();
  
   mysql_query("UPDATE entrega_producto 
                SET observacion='$obs'
                WHERE id_entrega_producto=$idEntrega AND grupo_empresa=$idGrupo",$conn) or die(mysql_error());

   echo "<script type='text/javascript'>
         alert('se ha realizado el pago por la actividad de forma correcta')
         </script>
        <META HTTP-EQUIV='Refresh' CONTENT='1; URL=calificar_grupo_empresa.php'> ";
}
  include("header.php");
?>
 <div>
  <ul class="breadcrumb">
    <li>
      <a href="index.php">Inicio</a>
      <span class="divider">/</span>
    </li>
    <li>
      <a href="calificar_grupo_empresa.php">calificar las actividades a la grupo empresa</a>
    </li>       
  </ul>
</div>
  <center><h3><?php if($pag==1){if($opcion==1){echo "califica la actividad a la grupo empresa";}else{echo "escribir las observaciones sobre la actividad";}}?></h3></center>
  <div class="row-fluid">
  <div class="span10">
<?php
if($pag==1)
{
   if($opcion==1)
   {
     $establecido = $_GET['pago'];
     $recibido = $_GET['recibido'];
     $idGrupo = $_GET['id'];
     $identrega = $_GET['identrega'];
     echo"
     <div class='well'>
        <p> el precio establecido establecido para la actividad es : $establecido</p>     
        <br>
        <p>hasta ahora se le ha cancelado a la grupo empresa el monto de: $recibido</p>
        <br>        
        <label> escriba el monto que se le pagara por la actividad:</label>
        <br>
         <form action='funcion_calificar.php' method=post> 
          <div class='input-append'>
           <input type='hidden' name='idgrupo' value='$idGrupo'>
           <input type='hidden' name='identrega' value='$identrega'>
            <input type='text' value='' name='dinero'>
            <span class='add-on'>$</span>
            <input type='submit' class='btn btn-primary' value='aceptar'>
          </div>          
         </form>
     </div>";
   }
   elseif($opcion==2)
   {   
      $idGrupo = $_GET['id'];
      $identrega = $_GET['identrega'];
     echo"
     <div class='well'>        
        <p>aqui puede ingresar las observaciones que tuvo respecto a la entrega del producto</p>
        <br>                
         <form action='funcion_calificar.php' method=post>  
           <input type='hidden' name='idgrupo' value='$idGrupo'>
           <input type='hidden' name='identrega' value='$identrega'>         
           <center> <textarea name='observaciones' rows='10' cols='40'></textarea>
            <br>
            <input type='submit' class='btn btn-primary' value='aceptar'></center>
         </form>
     </div>";
   }
}   
   echo"</div>
        </div>";
include("footer.php");
?>