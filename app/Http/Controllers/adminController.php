<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PrincipalController;
use Session;
use App\Usuario;

class adminController extends Controller
{
     private $verSesion;
   
    function __construct()
  {   
      $this->verSesion = new VerificadorDeSesiones;
     
  }



   public function home_admin()
   {
      $gest=$this->verSesion->getGestion();
      $gestion_nuevo="";
    if(!$gest['gestion_valida'])
    {
     $fecha = date("Y-m-d");
     $inicio = $fecha;
     $descripcion=NULL;
     $year = date('Y');
     $mes = date('m');
     if($mes >=1 && $mes <=6)
     {
     $gestion_nuevo = "1-".$year;
     $fin_max = $year."-07-31";
     }
     else
     {
       $gestion_nuevo = "2-".$year;
        $fin_max = $year."-12-31";
     }
      $fin=$fin_max;
    }
  
     
   $this->verSesion->sesionIniciado();
     if( $this->verSesion==true)
     {
       
       return view('/paginas/administrador/home_admin')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario'),
        'gestion_nuevo'=>$gestion_nuevo ]);



      }else{
       
         return redirect('index');
       }
   }
    public function home_admin_nueva_gestion(){

      if(isset($_POST['enviar']))
      {
        $error=false;
        $fecha = date("Y-m-d");
        $error_fecha_fin="";
        $error_fecha_ini="";

        $inicio = $_POST['inicio'];
        $descripcion = $_POST['descripcionG'];
        $gestion=$_POST['gestion'];
        $fin = $_POST['fin'];

        if(!empty($fin))
        {
           if($inicio>=$fecha)
           {
             if($fin>$inicio)
             {
                   $usuario= new Usuario;
                   $usuario->iniciarNuevaGestion($gestion,$inicio,$fin,$descripcion);
                
              
               
               
             }
             else
             {
               $error = true;
               $error_fecha_fin = "La fecha de finalizaci&oacute;n no debe ser menor o igual a la fecha de inicio";
             }
           }
           else
           {
              $error = true;
              $error_fecha_ini = "La fecha de inicio no debe ser menor a la fecha presente";
           }
        }
       else
       {
         $error = true;
         $error_fecha_ini = "ingrese una fecha final";
       }
     }

     return view('/paginas/administrador/home_admin')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario'),
        'gestion_nuevo'=>$gestion_nuevo,
        'error_fecha_fin'=>$error_fecha_fin,
        'error_fecha_ini'=>$error_fecha_ini ]);
}

  public function info_admin(){
   

    $pag_ini="home_admin";
    $titulo="Informacion del usuario Administrador del sistema"; 
    $user = new Usuario;       
      $infUser = $user->getInformacionAdministrador(Session::get('id'));
    if(is_array($infUser) && !empty($infUser))
    { 
      $nombre= $infUser[0]->nombre;
      $apellido= $infUser[0]->apellido;
      $telefono= $infUser[0]->telefono;
      $email= $infUser[0]->email;
        if($infUser[0]->habilitado=1)
        {
           $habilitado= "Si";  }
         else{
              $habilitado="No";
            }   
        }
    else{
        echo "<h4>No se Encontro ning&uacute;n registro";
        } 

         $this->verSesion->sesionIniciado();

     if( $this->verSesion==true)
     {
      return view('/paginas/administrador/info_admin')->with([
        'titulo' => $titulo,
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario'),
        'pag_ini'=>$pag_ini,
        'nombre'=>$nombre,
        'apellido'=>$apellido,
        'telefono'=>$telefono,
        'email'=>$email,
        'habilitado'=>$habilitado,
        'quien_ingresa'=>"Administrador del sistema"]);
       }
       else{
           return redirect('index');

       }
  }
 
  public function administrar_consultor(){
     
     $titulo="Administrar Consultores TIS";
     $usuario= new Usuario;
     $lista_consultores=$usuario->getConsultoresTis(); // $consulta
     $num_res=count($lista_consultores);

    if( $this->verSesion==true)
     {
        return view('/paginas/administrador/administrar_consultor')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario'),
        'lista_consultores'=>  $lista_consultores,
        'num_res'=>$num_res ]);
        
        }
       else{

           return redirect('index');
          }

  }
   function guardarCambios_consultor(){
     $usuario= new Usuario;
     $lista_consultores=$usuario->getConsultoresTis(); // $consulta
     $hubo_cambios=false;
     foreach ( $lista_consultores as $consultor) {
         $id_consultor=$consultor->id_usuario;
         $nombre_usuario=$consultor->nombre_usuario;
        
        /******cambios del la casilla "jefeConsultor" ******/
         if(!(empty($_POST['tipo'.$id_consultor]))){
        
           if($consultor->tipo_usuario==3){
              $hubo_cambios=true;
              $usuario->cambiarAJefeConsultor($id_consultor);
           }
         }else{
         
            if($consultor->tipo_usuario==2){
               $hubo_cambios=true;
             $usuario->cambiarAConsultor($id_consultor);
            }
         }
  
       /******cambios del la casilla "habilitado" ******/
         if(!(empty($_POST['habilitado'.$id_consultor]))){
        
           if($consultor->habilitado==0){
                  $hubo_cambios=true;
              $usuario->habilitarUsuario($id_consultor);
           }
         }else{
          
            if($consultor->habilitado==1){
                   $hubo_cambios=true;
               $usuario->deshabilitarUsuario($id_consultor);
            }
         }

       

     } // endforeach

        if($hubo_cambios){
          echo "<script type='text/javascript'>
            alert('Tus datos se han modificado de forma exitosa!. ')
            </script>
            <META HTTP-EQUIV='Refresh' CONTENT='1; URL=administrar_consultor'> ";

        }else{
          echo "<script type='text/javascript'>
            alert('No has hecho ningun cambio!')
            </script>
            <META HTTP-EQUIV='Refresh' CONTENT='1; URL=administrar_consultor'> ";
        }
   
  }

  public function administrar_grupo_empresa(){
     
    $titulo="Administrar Consultores TIS";
 
     $usuario= new Usuario;
     $lista_grupo_empresas=$usuario->getListaGrupoEmpresas(); // $consulta
     $num_res=count($lista_grupo_empresas);

    if( $this->verSesion==true)
     {

      return view('/paginas/administrador/administrar_grupo_empresa')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario'),
        'lista_grupo_empresas'=> $lista_grupo_empresas,
        'num_res'=>$num_res ]);
     
     }else{

           return redirect('index');
          }
  

  }
  public function guardarCambios_grupo_empresa(){
     $usuario= new Usuario;
     $lista_grupo_empresas=$usuario->getListaGrupoEmpresas();
     $hubo_cambios=false;
      foreach ( $lista_grupo_empresas as $grupo) {
         $id_usuario_grupo=$grupo->id_usuario;
         //$nombre_grupo=$consultor->nombre_usuario;
            
        /******cambios del la casilla "habilitado" ******/
         if(!(empty($_POST[$id_usuario_grupo]))){
        
           if($grupo->habilitado==0){
              $hubo_cambios=true;
              $usuario->habilitarUsuario($id_usuario_grupo);
           }
         }else{
         
            if($grupo->habilitado==1){
               $hubo_cambios=true;
               $usuario->deshabilitarUsuario($id_usuario_grupo);
            }
         }

      }

        if($hubo_cambios){
          echo "<script type='text/javascript'>
            alert('Tus datos se han modificado de forma exitosa!. ')
            </script>
            <META HTTP-EQUIV='Refresh' CONTENT='1; URL=administrar_grupo_empresa'> ";

        }else{
          echo "<script type='text/javascript'>
            alert('No has hecho ningun cambio!')
            </script>
            <META HTTP-EQUIV='Refresh' CONTENT='1; URL=administrar_grupo_empresa'> ";
        }

    
  }

  public function bitacoras_usuario(){

    $titulo="Bit&aacute;coras de usuario";
    $usuario = new Usuario;
    $condicion_vacio="";
   
    $listaDeGestiones=$usuario->getListadeGestiones();
    $listaDeUsuarios=$usuario->getListadeUsuarios();
    $datos_bitacora1=$usuario->getBitacorasSesion($condicion_vacio);
    $datos_bitacora2=$usuario->getBitacorasBD($condicion_vacio);
    
   if( $this->verSesion==true)
    {
      return view('/paginas/administrador/bitacoras_usuario')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario'),
        'ini_filtro'=>"",
        'fin_filtro'=>"",
        'ini_filtro_2'=>"",
        'fin_filtro_2'=>"",
        'listaDeGestiones'=>$listaDeGestiones,
        'listaDeUsuarios'=>$listaDeUsuarios, 
        'error_fecha_ini'=>"",
        'error_fecha_fin'=>"",
        'error_fecha_ini2'=>"",
        'error_fecha_fin2'=>"",
        'datos_bitacora1'=>$datos_bitacora1,
        'datos_bitacora2'=>$datos_bitacora2 ]);
      }else
      {

           return redirect('index');
      }

  }
   public function filtrar_bitacoras_usuario(){
       

       $ini_filtro=NULL;
       $fin_filtro=NULL;
       $filtro_gestion=-1;
       $filtro_tipo=-1;
       $fecha = date("Y-m-d");
       $ini_filtro=NULL;
       $fin_filtro=NULL;
       $error=false;
       $ini_filtro_2=NULL;
       $fin_filtro_2=NULL;
       $filtro_gestion_2=-1;
       $filtro_tipo_2=-1;
       $error_2=false;

       $error_fecha_ini="";
       $error_fecha_fin="";
       $error_fecha_ini_2="";
       $error_fecha_fin_2="";

   $consulta="";
   $consulta_2="";


if(isset($_POST['filtrar']))
{
  if(!empty($_POST['fecha_ini']) && !empty($_POST['fecha_fin']))
  {
    $ini_filtro=$_POST['fecha_ini'];
    $fin_filtro=$_POST['fecha_fin'];
    if($ini_filtro<=$fecha)
    {
        if($fin_filtro>=$ini_filtro && $fin_filtro<=$fecha)
        {
           $consulta=$consulta." AND (fecha_hora>='".$ini_filtro." 00:00:00' AND fecha_hora<='".$fin_filtro." 23:59:59')";
        }
        else
        {
          $error = true;
          $error_fecha_fin = "La fecha de finalizaci&oacute;n no es v&aacute;lida";
        }
    }
    else
    {
        $error = true;
        $error_fecha_ini = "La fecha de inicio no debe ser mayor a la fecha presente";
    }    

  }
  elseif(!empty($_POST['fecha_ini']))
  {
    $ini_filtro=$_POST['fecha_ini'];
    
    if($ini_filtro<=$fecha)
    {
        $consulta=$consulta." AND (fecha_hora>='".$ini_filtro." 00:00:00')";
    }
    else
    {
       $error=true;
       $error_fecha_ini = "La fecha de inicio no debe ser mayor a la fecha presente";
    }    
  }
  elseif(!empty($_POST['fecha_fin']))
  {
    $fin_filtro=$_POST['fecha_fin'];
    if($fin_filtro<=$fecha)
    {
       $consulta=$consulta." AND (fecha_hora<='".$fin_filtro." 23:59:59')";
    }
    else
    {
      $error = true;
      $error_fecha_fin = "La fecha de finalizaci&oacute;n no debe ser mayor a la fecha presente";
    }   
  }  
  if($_POST['gestion']!=-1)
  {
    $filtro_gestion=$_POST['gestion'];
    $consulta=$consulta." AND u.gestion=$filtro_gestion";
  }
  if($_POST['usuario']!=-1) 
  {
    $filtro_tipo=$_POST['usuario'];
    $consulta=$consulta." AND tipo_usuario=$filtro_tipo";
  }
  if(!$error)
  {
          //header('Location: modificar_registro_consultor.php?value='.$quien);    
  }
}

if(isset($_POST['filtrar_2']))
{
    if(!empty($_POST['fecha_ini_2']) && !empty($_POST['fecha_fin_2']))
    {
        $ini_filtro_2=$_POST['fecha_ini_2'];
        $fin_filtro_2=$_POST['fecha_fin_2'];
  
        if($fin_filtro_2>=$ini_filtro_2 && $fin_filtro_2<=$fecha)
        {
            $consulta_2=$consulta_2." AND (fecha_hora>='".$ini_filtro_2." 00:00:00' AND fecha_hora<='".$fin_filtro_2." 23:59:59')";
        }
        else
        {
           $error_2 = true;
           $error_fecha_fin_2 = "La fecha de finalizaci&oacute;n no es v&aacute;lida";
        }
    }    
elseif (!empty($_POST['fecha_ini_2']))
{
    $ini_filtro_2=$_POST['fecha_ini_2'];
    if($ini_filtro_2<=$fecha)
    {
       $consulta_2=$consulta_2." AND (fecha_hora>='".$ini_filtro_2." 00:00:00')";
    }
    else
    {
      $error_2=true;
      $error_fecha_ini_2 = "La fecha de inicio no debe ser mayor a la fecha presente";
    }    

}
elseif(!empty($_POST['fecha_fin_2']))
{
    $fin_filtro_2=$_POST['fecha_fin_2'];
    if ($fin_filtro_2<=$fecha) 
    {
        $consulta_2=$consulta_2." AND (fecha_hora<='".$fin_filtro_2." 23:59:59')";
    }
    else
    {
        $error_2 = true;
        $error_fecha_fin_2 = "La fecha de finalizaci&oacute;n no debe ser mayor a la fecha presente";
    }    
}
    if($_POST['gestion_2']!=-1){
    $filtro_gestion_2=$_POST['gestion_2'];
    $consulta_2=$consulta_2." AND u.gestion=$filtro_gestion_2";
  }
  if ($_POST['usuario_2']!=-1) {
    $filtro_tipo_2=$_POST['usuario_2'];
    $consulta_2=$consulta_2." AND tipo_usuario=$filtro_tipo_2";
  }
  if(!$error)
  {
      //header('Location: modificar_registro_consultor.php?value='.$quien);     
  }
}
  


    $titulo="Bit&aacute;coras de usuario";
    $usuario = new Usuario;
  $listaDeGestiones=$usuario->getListadeGestiones();
    $listaDeUsuarios=$usuario->getListadeUsuarios();
    $datos_bitacora1=$usuario->getBitacorasSesion($consulta);
    $datos_bitacora2=$usuario->getBitacorasBD($consulta_2);
   if( $this->verSesion==true)
    {
      return view('/paginas/administrador/bitacoras_usuario')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario'),
        'ini_filtro'=>$ini_filtro,
        'fin_filtro'=>$fin_filtro,
        'ini_filtro_2'=>"",
        'fin_filtro_2'=>"",
        'listaDeGestiones'=>$listaDeGestiones,
        'listaDeUsuarios'=>$listaDeUsuarios, 
        'error_fecha_ini'=>$error_fecha_ini,
        'error_fecha_fin'=>$error_fecha_fin,
        'error_fecha_ini2'=>$error_fecha_ini_2,
        'error_fecha_fin2'=>$error_fecha_fin_2,
        'datos_bitacora1'=>$datos_bitacora1,
        'datos_bitacora2'=>$datos_bitacora2 ]);
      }else
      {

           return redirect('index');
      }




   }

  public function backup(){
    $titulo="Respaldo y Restauraci&oacute;n de la Base de Datos";
    $mensaje="";
    $archivos=array(); //array de los archivos en el directorio /backup
    $cantidadCambios=0;


   if( $this->verSesion==true)
    {
     return view('/paginas/administrador/backup')->with([
        'titulo' =>$titulo,
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario'),
        'mensaje'=>$mensaje,
        'archivos'=>$archivos,
        'cantidadCambios'=>$cantidadCambios  ]);
    }else
    {

           return redirect('index');
    }
  }

  public function administrar_mensajes(){
      $num_mensajes=0;
      if( $this->verSesion==true)
      {
        return view('/paginas/administrador/administrar_mensajes')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario'),
        'num_mensajes'=>$num_mensajes ]);
      }else
       {

           return redirect('index');
        }
  }

  public function modificar_registro_admin()
  {
  
        $quien_ingresa="Administrador del sistema";
        $pag_ini="home_admin";
        $quien=1;
        $titulo="Modificar datos ".$quien_ingresa;
        $user = new Usuario;       
        $infUser = $user->getInformacionAdministrador(Session::get('id'));
     
        $nom=$infUser[0]->nombre;
        $ape=$infUser[0]->apellido;
        $telf=$infUser[0]->telefono;
        $mail=$infUser[0]->email;

       if( $this->verSesion==true)
       {
          return view('/paginas/administrador/modificar_registro_admin')->with([
          'titulo' => 'Administrador',
          'sesion_valida' => true,
          'tipo_usuario'=> 1,
          'gestion'=>$this->verSesion->getGestion(),
          'datos'=>$this->verSesion->getDatos(),
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario'), 
          'nom'=>$nom,
          'ape'=>$ape,
          'telf'=>$telf,
          'mail'=>$mail,
          'error_email'=>'' ]);

        }else{
           return redirect('index');
         }
 }


function modificar_registro_admin_guardar(){
    /*VALORES DE FORMULARIO*/
  $apellido=$_POST['lastname'];
  $nombre=$_POST['firstname'];
  $telfFijo=trim($_POST['telf']);
  $eMail=trim($_POST['email']);
  $contrasena=$_POST['contrasenia'];
  $error=false;
   
  $usuario = new Usuario;
  $datos_admin=$usuario->getInformacionAdministrador(Session::get('id'));
   
  $mail=$datos_admin[0]->email; 

   
  if (strcmp($mail,$eMail)!=0) { 
    $result=$usuario->verificarEmail($eMail,$this->verSesion->getGestion());
    if(is_array($result) && !empty($result))//ya existe usuario o email
    {     $mail_aux=$result[0]->email;

      if (strcmp($mail_aux,$eMail)==0) { //volvemos a comparar?
              $error_email="El e-mail ya esta registrado";
              $mail=$eMail;
              $error=true;
       
         $nom=$datos_admin[0]->nombre;
        $ape=$datos_admin[0]->apellido;
        $telf=$datos_admin[0]->telefono;
        $mail=$datos_admin[0]->email;

        return view('/paginas/administrador/modificar_registro_admin')->with([
          'titulo' => 'Administrador',
          'sesion_valida' => true,
          'tipo_usuario'=> 1,
          'gestion'=>$this->verSesion->getGestion(),
          'datos'=>$this->verSesion->getDatos(),
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario'), 
          'nom'=>$nom,
          'ape'=>$ape,
          'telf'=>$telf,
          'mail'=>$mail,
          'error_email'=>$error_email ]);

      }   
        
    }
  }
    if(!$error){/*SI NO HAY NINGUN ERROR REGISTRO*/
     
    

    if($contrasena!=""){
     $usuario ->iniciarSesion(Session::get('id'));
     $usuario ->actualizarDatosAdmin(Session::get('id'), 'admin', $nombre, $apellido,  $telfFijo,  $eMail,$contrasena);
     
     echo "<script type='text/javascript'>
            alert('Tus datos se han modificado de forma exitosa!')
            </script>
            <META HTTP-EQUIV='Refresh' CONTENT='1; URL=index'> ";
    }else{

       $usuario ->iniciarSesion(Session::get('id'));
     $usuario ->actualizarDatos(Session::get('id'), 'admin', $nombre, $apellido,  $telfFijo, $eMail);
     
     echo "<script type='text/javascript'>
            alert('Tus datos se han modificado de forma exitosa!')
            </script>
            <META HTTP-EQUIV='Refresh' CONTENT='1; URL=index'> ";
    }

      
    }
  }
   

  

 
     
}// fin class adminController