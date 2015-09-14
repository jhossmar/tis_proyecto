<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Gestion;
use App\noticias;
use App\Actividades;
use App\Usuario;
use App\Archivos;
use App\GrupoEmpresa;
use App\Http\Controllers\VerificadorDeSesiones;
use Response;

class consultorController extends Controller
{

   public function homeConsultor()
  {

    $principal = new VerificadorDeSesiones;
    if($principal->getTipoDeUsuario()==3){
    return view('/paginas/consultor/home_consultor')->with([
          'titulo' => 'homeConsultor',
          'sesion_valida' => true,
          'tipo_usuario'=> 3,
          'gestion'=>$principal->getGestion(),
          'datos'=>$principal->getDatos(),
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
     }else{

     	  return redirect('index');
     }

  }

    
}
