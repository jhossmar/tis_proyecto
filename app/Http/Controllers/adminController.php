<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PrincipalController;
use Session;

class adminController extends Controller
{
   
   public function home()
   {
      $verSesion = new VerificadorDeSesiones;
      $verSesion->sesionIniciado();
     
     if($verSesion==true)
     {
        //$principalController->mostrarVista("/paginas/administrador/home_admin",0); no funciona(???)
       return view('/paginas/administrador/home_admin')->with([
        'titulo' => 'Administrador',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
        'gestion'=>$verSesion->getGestion(),
        'datos'=>$verSesion->getDatos(),
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);



      }else{
       
         return redirect('/');
       }
   }


}
