<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FormulariosController extends Controller
{
    public function controlDatosFormulario()
    {    	
	   if(strcmp($mail,$eMail)!=0) 
	{ 
		$sql = "SELECT email
				FROM usuario
				WHERE email='$eMail' AND (gestion=1 OR gestion=$verificarG->id_gestion)";
		$auxiliar = mysql_query($sql,$conn);
		$result = mysql_fetch_array($auxiliar);
		if(is_array($result) && !empty($result))//ya existe usuario o email
		{
			if (strcmp($result['email'],$eMail)==0)
			{ 
			        $error_email="El e-mail ya esta registrado";
			        $mail=$eMail;
			        $error=true;
			}   
	      
		}
	}
    if(strcmp($user,$usuario)!=0)
    {
        $sql_user= "SELECT nombre_usuario
                    FROM usuario
                    WHERE nombre_usuario='$usuario' AND (gestion=1 OR gestion=$verrificarG->id_gestion)";
        $auxiliar_usuario = mysql_query($sql_user,$conn);
        $result_user = mysql_fetch_array($auxiliar_usuario) or die("no esta ejecutando los datos");
        if(is_array($result_user) && !empty($result_user))
        {
            if(strcmp($result_user['nombre_usuario'],$usuario)==0)
            {
                $error_usuario="El nombre de usuario ya esta registrado";
                $user=$usuario;
                $error = true;
            }
        }
    }
	if(!$error)
	{/*SI NO HAY NINGUN ERROR REGISTRO*/
	 	$bitacora = mysql_query("CALL iniciar_sesion(".$_SESSION['id'].")",$conn)
							or die("Error no se pudo realizar cambios.");
	        $sql = "UPDATE usuario as u
					SET nombre_usuario='$usuario', clave='$clave', nombre='$nombre',apellido='$apellido', telefono='$telfFijo',email='$eMail'
					WHERE u.id_usuario=$id_usuario";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	        
            echo "<script type='text/javascript'>"; 
            echo "alert('Tus datos se han modificado de forma exitosa!');";
            echo "</script>";
            echo"<META HTTP-EQUIV='Refresh' CONTENT='1; URL=index.php'> ";
     }	
}
       
    }
}
