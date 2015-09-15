<?php

namespace App\Http\Controllers;

use Request;
use Session;
use App\functionLogin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\funcionLogin;
use App\noticias;
use App\Usuario;
use App\Http\Controllers\FormularioController;
use App\GrupoEmpresa;
class PrincipalController extends Controller
{
  public function loginAdministrador()
  {    
    $principal = new VerificadorDeSesiones;

    return view('loginAdministrador')->with([
                'titulo' => 'Iniciar sesi&oacute;n Administrador del Sistema',
                'sesion_valida' => false,
                'tipo_usuario'=>0,
                'gestion'=>$principal->GetGestion(),
                'datos'=>$principal->GetDatos()]);
  }
  public function inicio()
  {
    $principal = new VerificadorDeSesiones;        
    if($principal->getTipoDeUsuario()!=0)
    {
      return view('index')->with([
          'titulo' => 'inicio ',
          'sesion_valida' => true,
          'tipo_usuario'=> Session::get('tipo'),
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'nombre_foto' => Session::get('nombre_foto'),
          'nombre_usuario' => Session::get('nombre_usuario')]);
     }
     else
     {
      return view('index')->with([
          'titulo' => 'inicio ',
          'sesion_valida' => false,
          'tipo_usuario'=> 0,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos()]);
     } 
  }
    /**
    * Verifica si el Usuario Existe en la Base de Datos
    *  retorna true si existe o false  si no. 
    * 
    * si existe EL usuario. inisia las variables de session
    *  e inseta en la base de datos la operacion??
    */
  private function existeUsuario($nombre,$pass)
  {
    $user = new Usuario;
    $usuario = $user->GetUsuario($nombre,$pass);
    $respuesta = false;        
    if($usuario!=null)
    {       
      Session::put('id',(int)$usuario[0]->id_usuario);
      Session::put('tipo',(int)$usuario[0]->tipo_usuario);
      Session::put('nombre_usuario',$usuario[0]->nombre_usuario);  
      Session::put('nombre_foto',$usuario[0]->foto);// OJO

      $user->SetBitacora($usuario[0]->id_usuario);
      $respuesta = true;
    }
        return $respuesta;
  }
  public function verificarAdministrador()
  {
    $nombre = $_POST['username'];
    $pass = $_POST['password'];
    //$nom = Request::get('password');
    $principal = new VerificadorDeSesiones;
    if(isset($nombre) && isset($pass))
    { 
      if( $this->existeUsuario($nombre,$pass))
      {
        return view('/paginas/administrador/home_admin')->with([
        'titulo' => 'Iniciar sesi&oacute;n Administrador del Sistema',
        'sesion_valida' => true,
        'tipo_usuario'=>1,
        'gestion'=>$principal->GetGestion(),
        'datos'=>$principal->GetDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);//------>>>?????
      }
      else
      {
        return
            "<center><h1>Acceso denegado</h1></center><br>
             <center><h3>Por favor espera 3 segundos mientras te redirigimos al inicio</h3></center><br>
            <META HTTP-EQUIV='Refresh' CONTENT='3; URL=index'>";
      }
    }       
  }          
  public function iniciarSesion()
  {     
    $principal = new VerificadorDeSesiones;
    return view('iniciar_sesion')->with([
        'titulo' => 'Iniciar sesi&oacute;n Administrador del Sistema',
        'sesion_valida' => false,
        'tipo_usuario'=>0,
        'error_sesion'=>"",
        'gestion'=>$principal->GetGestion(),
        'datos'=>$principal->GetDatos()]);
  }  
  public function verificarUsuario()
  {          
    $nombre = $_POST['username'];
    $pass = $_POST['password'];
    $error_sesion="";
    $principal = new VerificadorDeSesiones; 
    if($this->existeUsuario($nombre,$pass))
    {                   
      if(Session::get('tipo')==2)
      {
          return view('/paginas/consultor/homeJefeConsultor')->with([
          'titulo' => 'home Jefe Consultor',
          'sesion_valida' => true,
          'tipo_usuario'=> 2,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'nombre_foto' => Session::get('nombre_foto'),
          'nombre_usuario' => Session::get('nombre_usuario')]);
      } 
      if(Session::get('tipo')==3)
      {
        return view('/paginas/consultor/home_consultor')->with([
          'titulo' => 'home Consultor',
          'sesion_valida' => true,
          'tipo_usuario'=> 3,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),          
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
      }
      if(Session::get('tipo')==4)
      {
        $grupo = new GrupoEmpresa;
        $id_grupo = $grupo->getIdGrupo(Session::get('id'));
        $numIntegrantes = $grupo->getNumeroIntegrantes($id_grupo[0]->id_grupo_empresa);       
        $roles=$grupo->getMetodologias($id_grupo[0]->id_grupo_empresa);
        
        return view('/paginas/grupo_Empresa/home_grupo_empresa')->with([
          'titulo' => 'home del representate de la grupo empresa',
          'sesion_valida' => true,
          'tipo_usuario'=> 4,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'idGrupo'=>$id_grupo,
          'numIntegrantes'=>$numIntegrantes[0]->numero,
          'roles'=>$roles,
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
       } 
       if(Session::get('tipo')==5)
       {
          return view('/paginas/grupo_Empresa/home_integrante')->with([
          'titulo' => 'home del integrante de la grupo empresa',
          'sesion_valida' => true,
          'tipo_usuario'=> 5,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
       }  
      }
      else
      {
        $error_sesion="Los datos incorrectos o usted no esta habilitado para esta gesti&oacute;n";
        return view('iniciar_sesion')->with([
        'titulo' => 'Jefe Consultor',
        'sesion_valida' => false,
        'tipo_usuario'=> 0,
        'gestion'=>$principal->GetGestion(),
        'datos'=>$principal->GetDatos(),
        'error_sesion'=>$error_sesion]);

      }
    } 



    public function guardar_foto()
    { 
      $ruta = "img/profiles/";
      $formatos = $arrayName = array('.jpg','.png'); 
      if (isset($_POST['btn_upload'])) {
        if(!empty($_FILES['foto']['name'])){
             opendir($ruta);
             $destino = $ruta.$_FILES['foto']['name'];
             $ext= substr($destino, strrpos($destino, '.'));
             if (in_array($ext, $formatos)) {
                copy($_FILES['foto']['tmp_name'],$ruta.Session::get('id').Session::get('nombre_usuario').$ext); //  Si el archivo ya existe este se remplaza .Recoradar que la carpeta debe tener permisos de escritura. 
                $id_usuario =Session::get('id');
                $destinio2 =   'img/profiles/'.Session::get('id').Session::get('nombre_usuario').$ext;
                $usuario=new Usuario;
                $usuario->cambiarFoto($id_usuario,$destinio2);
                return redirect('index');
            }else
               {
                 echo( "<center><h1>escoger un archivo del tipo jpg o png solamente</h1></center><br>
                 <META HTTP-EQUIV='Refresh' CONTENT='1; URL=index'>");
               }
         }else
          {
            echo( "<center><h1>selecciona un archivo por favor</h1></center><br>
            <META HTTP-EQUIV='Refresh' CONTENT='1; URL=index'>");
           }
       } 

     }

     public function ayuda(){

      if(isset($_GET['nom_arch'])){
      $numpdf =$_GET['nom_arch'];
          }else{
            $numpdf=NULL;
      }

      $usuario=new Usuario;
      $resultado=$usuario->getAdministradorSistema();


      $principal = new VerificadorDeSesiones;        
       if($principal->getTipoDeUsuario()!=0)
       {
         return view('ayuda')->with([
          'titulo' => 'inicio ',
          'sesion_valida' => true,
          'tipo_usuario'=> Session::get('tipo'),
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'nombre_foto' => Session::get('nombre_foto'),
          'nombre_usuario' => Session::get('nombre_usuario'),
          'numpdf' =>$numpdf,
          'resultado'=>$resultado ]);
      }
       else
      {
      return view('ayuda')->with([
          'titulo' => 'inicio ',
          'sesion_valida' => false,
          'tipo_usuario'=> 0,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'numpdf'=>$numpdf,
          'resultado'=>$resultado  ]);
     }


      
     }


     public function contrasena(){
       $principal = new VerificadorDeSesiones;        
       $error_email="";
       if($principal->getTipoDeUsuario()!=0)
       {
         return view('contrasena')->with([
          'titulo' => 'Recuperar Contrasena Sistema de Apoyo a la Empresa TIS ',
          'sesion_valida' => true,
          'tipo_usuario'=> Session::get('tipo'),
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'nombre_foto' => Session::get('nombre_foto'),
          'nombre_usuario' => Session::get('nombre_usuario'),
          'error_email'=> $error_email   ]);
      }
       else
      {
      return view('contrasena')->with([
          'titulo' => 'Recuperar Contrasena Sistema de Apoyo a la Empresa TIS',
          'sesion_valida' => false,
          'tipo_usuario'=> 0,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'error_email'=> $error_email ]);
     }



     }
      public function enviarCorreoDeContrasena(){
         $principal = new VerificadorDeSesiones;   
        $error_email="";
        if(isset($_POST['direccion']))
        {
          $correo=$_POST['direccion'];   
            if($correo!=""){
                $usuario = new Usuario;
                $resultado = $usuario->getMailYClave($correo);
                if(count($resultado)!=0){
                 $pass= $resultado[0]->clave;         
                 
                 echo "<p>su clave es: ".$pass."</p>";  
              
                 $subject = "Email enviado desde la pagina web Sistema TIS"; 
                 $mensaje = "del Sistema tis su contraseña es: ".$pass;
      
                 mail($correo, $subject, $mensaje);
                 echo "<legend>Tu email ha sido enviado de forma exitosa a $correo!</legend>";   
                 echo "<script type='text/javascript'>"; 
                 echo "alert('su contrasena se le envio a su correo electronico. Espere mientras le redireccionamos al inicio por favor');";
                 echo "</script>";
                 echo"<META HTTP-EQUIV='Refresh' CONTENT='3; URL=index'> ";
                }else{
                  $error_email="el mail ingresado no existe ";
                  return view('contrasena')->with([
                    'titulo' => 'Recuperar Contrasena Sistema de Apoyo a la Empresa TIS',
                    'sesion_valida' => false,
                    'tipo_usuario'=> 0,
                    'gestion'=>$principal->GetGestion(),
                    'datos'=>$principal->GetDatos(),
                    'error_email'=> $error_email ]); 
                }

            }else{
                   $error_email="Ingrese una direccion de correo porfavor";
                   return view('contrasena')->with([
                    'titulo' => 'Recuperar Contrasena Sistema de Apoyo a la Empresa TIS',
                    'sesion_valida' => false,
                    'tipo_usuario'=> 0,
                    'gestion'=>$principal->GetGestion(),
                    'datos'=>$principal->GetDatos(),
                    'error_email'=> $error_email ]);           
                  }
          }else{
            return redirect('index');
         }

   }




}


