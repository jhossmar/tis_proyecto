<?php
$titulo="Recuperar Contrasena Sistema de Apoyo a la Empresa TIS";
include('header.php');
?>

    <div>
		<ul class="breadcrumb">
	    	<li>
				<a href="home_consultor.php">Inicio</a>
				<span class="divider">/</span>
			</li>
			<li>
				<a href="contrasena2.php">recuperar contrasenia</a>
			</li>
		</ul>
	</div>
		<center><h3>Recuperar contrasenia Sistema de apoyo TIS</h3></center>		
           <div class="row-fluid">
		   <div class="box span12">
			  <div class="box-header well">
			  	 <h2><i class="icon-lock"></i> Ayuda recuperar contrasenia</h2>
			  </div>
			<div class="box-content">
<?php 

     if(isset($_POST['direccion']))
     {
        include("conexion/conexion.php");
        $correo=$_POST['direccion'];        
        $consulta = mysql_query("SELECT email,clave FROM usuario WHERE email='".$correo."'",$conn) or die("Could not execute the select query.");

       $resultado = mysql_fetch_assoc($consulta);

       $pass= $resultado['clave'];         
       echo "<p>su clave es: ".$pass."</p>";  
              
       $subject = "Email enviado desde la pagina web Sistema TIS"; 
       $mensaje = "del Sistema tis su contraseña es: ".$pass;
      
       mail($correo, $subject, $mensaje);
       echo "<legend>Tu email ha sido enviado de forma exitosa a $correo!</legend>";   
       echo "<script type='text/javascript'>"; 
       echo "alert('su contrasena se le envio a su correo electronico');";
       echo "</script>";
       echo"<META HTTP-EQUIV='Refresh' CONTENT='3; URL=index.php'> ";
     }
     else
     {      
?>			
					<div class="alert alert-success">							
							ingrese su correo electronico al que le enviaremos su contraseña!
					</div>
					<form action='contrasena.php' method='post'>
                        <legend>correo electronico: </legend>
                        <div class="input-prepend">
                        	<span class=="add-on">@</span>
                        	<input type="text" name="direccion">		
                        </div>                        
                        <br>
                        <input type="submit" name="aceptar" class="btn" value="enviar">
                    </form>

					</div>
		    </div><!--/span-->
			</div><!-- fin row -->
<?php 
      }
?>