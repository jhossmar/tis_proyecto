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

   public function registro_consultor()
   {
    $titulo="Registro Consultor TIS";
    $quien_ingresa="Consultor TIS";

    $usuario=NULL;
    $apellido=NULL;
    $nombre=NULL;
    $telf=NULL;
    $eMail=NULL;

     $error_user="";
     $error_email="";
     $error_curriculum="";

     $principal = new VerificadorDeSesiones;        
    if($principal->getTipoDeUsuario()!=0)
    {
      return view('index')->with([
          'titulo' => $titulo,
          'sesion_valida' => true,
          'tipo_usuario'=> Session::get('tipo'),
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'nombre_foto' => Session::get('nombre_foto'),
          'nombre_usuario' => Session::get('nombre_usuario')]);
     }
     else
     {
      return view('registro_consultor')->with([
          'titulo' => $titulo,
          'quien_ingresa'=>$quien_ingresa,
          'usuario'=>$usuario,
          'apellido'=>$apellido,
          'nombre'=>$nombre,
          'telf'=>$telf,
          'eMail'=>$eMail,

          'error_user'=>$error_user,
          'error_email'=>$error_email,
          'error_curriculum'=>$error_curriculum,

          'sesion_valida' => false,
          'tipo_usuario'=> 0,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos()]);
     } 


   }
    
    public function validar_registro_consultor()
    {
     
     $titulo="Registro Consultor TIS";
     $quien_ingresa="Consultor TIS";
     $error_user="";
     $error_email="";
     $error_curriculum="";

    if(isset($_POST['enviar'])){

       $usuario=trim($_POST['username']);
       //$salt="$2x$07$./f4af7kJi1jdaxlswE34$";
       //$clave=crypt($_POST['password'], $salt);
       $clave=trim($_POST['password']);

       $apellido=$_POST['lastname'];
       $nombre=$_POST['firstname'];
       $telf=trim($_POST['telf']);
       $eMail=trim($_POST['email']);
       $foto='img/profiles/default.jpg'; // foto que se ingresa por defecto;
      
       $consulta_usuario=$this->verificarNombreUsuarioNuevo($usuario); 
       $consulta_email=$this->verificarEmailUsuarioNuevo($eMail);
     

     
     $error=false;
     $tiene_curriculum=0;
     $pdf=NULL;
    
    if ($consulta_usuario) { 
                  $error_user="El usuario ya esta registrado";
                  $error=true;
           }   
    if ($consulta_email) {
                  $error_email="El correo electr&oacute;nico ya esta registrado";
                  $error=true;
          } 
       
     $ext_permitidas = array('.pdf','.doc','.docx','.rar','.zip');

     if(!empty($_FILES['pdf']['name'])){
            $nombre_archivo = $_FILES['pdf']['name'];
            $nombre_tmp = $_FILES['pdf']['tmp_name'];
            $ext = substr($nombre_archivo, strpos($nombre_archivo, '.'));
            $tamano = $_FILES['pdf']['size'];             
            $limite = 1000 * 1024;
            if(in_array($ext, $ext_permitidas)){
              if( $tamano <= $limite ){
                    if( $_FILES['pdf']['error'] <= 0 ){
                      if( file_exists( 'curriculum/'.$usuario.'.pdf') ){
                              $error_curriculum='El archivo ya existe';
                              $error=true;
                        }
                        else{ 
                           move_uploaded_file($nombre_tmp,'curriculum/'.$usuario.'.pdf');
                             $pdf='curriculum/'.$usuario.'.pdf';
                             $tiene_curriculum=1;
                        }
                      
                     }
                     else{
                        $error_curriculum='Error al subir el archivo';
                          $error=true;

                       }
                    }
                else{  
                      $error_curriculum='El archivo debe un tama&ntilde;o menor a 1 Mega Byte';
                      $error=true;
                    }
            }
            else{
              $error=true;
              $error_curriculum='El archivo debe tener formato " pdf "';
            }

        }

       if(!$error){/*SI NO HAY NINGUN ERROR REGISTRO*/
          //$bitacora = mysql_query("CALL iniciar_sesion(1)",$conn)
           //or die("Error no se pudo realizar cambios.");
          $usuarioObj= new Usuario;
         $usuarioObj->insertarConsultor($usuario,$clave,$nombre,$apellido,$telf,$eMail,$foto);
          
          $id_consultor=$usuarioObj->getIdUsuarioSegunNombre($usuario);
          
          $id=$id_consultor[0]->id_usuario;
          
         $usuarioObj->insertarCurriculum($id,$pdf);

         echo( "<center><h1>Se ha registrado correctamente.</h1></center><br>
            <META HTTP-EQUIV='Refresh' CONTENT='1; URL=iniciar_sesion'>");
           
         
        
     }
  }
  else{
    $usuario=NULL;
    $apellido=NULL;
    $nombre=NULL;
    $telf=NULL;
    $eMail=NULL;
  $principal = new VerificadorDeSesiones;
  return view('registro_consultor')->with([
          'titulo' => $titulo,
          'quien_ingresa'=>$quien_ingresa,
          'usuario'=>$usuario,
          'apellido'=>$apellido,
          'nombre'=>$nombre,
          'telf'=>$telf,
          'eMail'=>$eMail,

          'error_user'=>$error_user,
          'error_email'=>$error_email,
          'error_curriculum'=>$error_curriculum,

          'sesion_valida' => false,
          'tipo_usuario'=> 0,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos()]);







  }

  

   }//fin de la clase Validar_registro_consultor

   /**
   *retorna TRUE si existe el usuario y false cas contrario 
   */
  public function  verificarNombreUsuarioNuevo($usuario){
    $usuario = new Usuario;
    $id_usuario=$usuario->getIdUsuarioSegunNombre($usuario);
    if(count($id_usuario)>0){
         return TRUE;
    } else{
          return FALSE;
    }    

   }
   
   /**
   *retorna TRUE si existe el emal y false cas contrario 
   */
  public function verificarEmailUsuarioNuevo($eMail){
     $usuario = new Usuario;
     $mail = $usuario->getMailYClave($eMail);
      if(count($mail)>0){
          return TRUE;
        } else{
          return FALSE;
        } 
  }

}//fin clase PricipalController




