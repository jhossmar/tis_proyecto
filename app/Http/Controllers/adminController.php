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
      //falta addicionar mas controles: ()
      $this->verSesion->sesionIniciado();
     if( $this->verSesion==true)
     {
        //$principalController->mostrarVista("/paginas/administrador/home_admin",0); no funciona(???)
       return view('/paginas/administrador/home_admin')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);



      }else{
       
         return redirect('index');
       }
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


       }

  }

  public function administrar_grupo_empresa(){
      return view('/paginas/administrador/administrar_grupo_empresa')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);

  }

  public function bitacoras_usuario(){
      return view('/paginas/administrador/bitacoras_usuario')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);

  }

  public function backup(){

     return view('/paginas/administrador/backup')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);

  }

  public function administrar_mensajes(){
      return view('/paginas/administrador/administrar_mensajes')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);
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
  /*----------------------FIN VALIDAR REGISTRO------------------------*/
     



}// fin class adminController