<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <title>  
  </title>
</head>
<body>
    <?php 
     echo '<div class="container">';
     echo '<div class="rowf-fluid">';
     echo '<div class="span12"> ';

     if(isset($_POST['direccion']))
     {
       include("conexion/conexion.php");
       $correo=$_POST['direccion'];
       echo"<p>".$correo."</p>";
       $consulta = mysql_query("SELECT email,clave FROM usuario WHERE email='".$correo."'",$conn) or die("Could not execute the select query.");

       $resultado = mysql_fetch_assoc($consulta);

       $pass= $resultado['clave'];  
       echo "<p>su clave es: ".$pass."</p>";       
     }
     else
     {
      echo "<form action='contrasena.php' method='post'";
      echo '<label>ingrese su correo electronico: </label>';
      echo '<input type="text" name="direccion">';
      echo '<input type="submit" name="aceptar" value="enviar">';
      echo '</form>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
     }
    ?>
</body>
</html>