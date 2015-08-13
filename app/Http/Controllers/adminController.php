<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PrincipalController;
use Session;

class adminController extends Controller
{
     private $verSesion;
   
    function __construct()
  {   
      $this->verSesion = new VerificadorDeSesiones;
      $this->verSesion->sesionIniciado();
  }



   public function home_admin()
   {
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
      return view('/paginas/administrador/info_admin')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$this->verSesion->getGestion(),
        'datos'=>$this->verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);

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
}// fin class adminController
