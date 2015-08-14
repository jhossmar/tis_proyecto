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


       }
  }
 
  public function administrar_consultor(){
      return view('/paginas/administrador/administrar_consultor')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);


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
         
    









       if( $this->verSesion==true)
       {
          return view('/paginas/administrador/modificar_registro_admin')->with([
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


}// fin class adminController
