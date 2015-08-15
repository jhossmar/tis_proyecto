<?php

namespace App\Http\Controllers;

use Request;
use Session;
use App\functionLogin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Gestion;
use App\funcionLogin;
use App\noticias;
use App\Actividades;
use App\Usuario;
use App\Http\Controllers\FormularioController;

class PrincipalController extends Controller
{
  public $gestion;
  public $datos;
    public function controlGestion()
    {   
      $id_gestion=-1;
      $nombre_gestion='no definida';
      $gestion_valida=false;        
      $fecha_ini=0;//numero
      $fecha_fin=0;
      $resultado;
      $gestion_espera=false;
      $fecha_actual=0;
      $ini_gestion=0;//fecha
      $fin_gestion=0;

      $gest = new Gestion;
      $resultado=$gest->ConsultaGestion();
            
      $date = date("Y-m-d");
      $hora=date("H:i:s");

      $fecha_actual=strtotime($date);
      date_default_timezone_set("America/La_Paz");    
      if($resultado!=null)
      {
        $fin_gestion = $resultado[0]->fecha_fin_gestion;
        $ini_gestion = $resultado[0]->fecha_ini_gestion;
        $id_gestion = (int) $resultado[0]->id_gestion;
        $fecha_fin = strtotime($fin_gestion);
        $fecha_ini = strtotime($ini_gestion);        
          
        if($fecha_actual <= $fecha_fin  && $fecha_actual < $fecha_ini) 
        {
          $id_gestion = -1;
          $nombre_gestion = " inicia el ".$ini_gestion;
          $gestion_valida = false;
          $gestion_espera = true;
        }
        elseif($fecha_actual <= $fecha_fin  && $fecha_actual >= $fecha_ini)
        {
          $id_gestion = $resultado[0]->id_gestion;
          $nombre_gestion = $resultado[0]->gestion;
          $gestion_valida = true;
          $gestion_espera = false;
        }
        elseif($fecha_actual > $fecha_fin)
        {
          $id_gestion =- 1;
          $nombre_gestion = "no definida";
          $gestion_valida = false;
          $gestion_espera = false;
          $gestion->SetGestion($id_gestion);             
        }
      }
      $this->gestion = array('id_gestion' => $id_gestion,
                             'nombre_gestion'=> $nombre_gestion,
                             'gestion_valida'=> $gestion_valida,
                             'gestion_espera'=> $gestion_espera,
                             'fecha_ini' => $ini_gestion,
                             'fecha_fin' => $fin_gestion);
    }              
    public function controlActividades($id_usuario)
    {
      $numdoc=0;        
      $num_grupo_empresa=0;
      $num_consultor=0;
      $num_notificaciones=0;
      $noticia = new Noticias;
      $resultado_noticias= $noticia->GetNoticias($this->gestion['id_gestion']);
      $numdoc = $noticia->GetNumeroDocumentos($this->gestion['id_gestion']);
      $num_consultores= $noticia->GetNumeroConsultores();
      $num_grupo_empresa= $noticia->GetNumeroGrupoEmpresas();
      if($id_usuario!=0)
      {
        $num_notificaciones = (int) $noticia->GetNotificaciones($id_usuario,$this->gestion['fecha_fin'],$this->gestion['fecha_ini']);
      }

      $actividad = new Actividades;
      $actividad->Actividad1($this->gestion['id_gestion']);
      $actividad->Actividad2($this->gestion['id_gestion']);
      $actividad->Actividad3($this->gestion['id_gestion']);
      $actividad->Actividad4($this->gestion['id_gestion']);
      $actividad->Actividad5($this->gestion['id_gestion']);
      $actividad->Actividad6($this->gestion['id_gestion']);
      $actividad->Actividad7($this->gestion['id_gestion']);
      
      $this->datos = array('resultado_noticias' => $resultado_noticias,
                           'numdoc' => $numdoc,
                           'num_consultores'=>$num_consultores,
                           'num_grupo_empresa'=>$num_grupo_empresa,
                           'num_notificaciones'=>$num_notificaciones,
                           'men'=>0,
                           'actividad' => $actividad);
    } 
    public function inicio()
    {        
      $this->controlGestion();
         // MEjorar este if. no funciona correctamente
        if(Session::get('id')!=null)
        {
          $this->controlActividades(Session::get('id')); 
          return view('index')->with([
          'titulo' => 'Jefe Consultor',
          'sesion_valida' => true,
          'tipo_usuario'=>Session::get('tipo'),
          'gestion'=>$this->gestion,
          'datos'=>$this->datos,         
          'nombre_foto' => Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario')]);
        }
        else
        { 
          $this->controlActividades(0); 
          return view('index')->with([
          'titulo' => 'Sistema de Apoyo a la Empresa TIS',
          'sesion_valida' => false,
          'tipo_usuario'=>0,        
          'gestion'=>$this->gestion,
          'datos'=>$this->datos]);
        }
    }
    public function loginAdministrador()
    {
       
       return view('loginAdministrador')->with([
        'titulo' => 'Iniciar sesi&oacute;n Administrador del Sistema',
        'sesion_valida' => false,
        'tipo_usuario'=>0,
        'gestion'=>$this->gestion,
        'datos'=>$this->datos]);
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
      if(isset($nombre) && isset($pass))
      { 
        if( $this->existeUsuario($nombre,$pass)){
             return view('/paginas/administrador/home_admin')->with([
        'titulo' => 'Iniciar sesi&oacute;n Administrador del Sistema',
        'sesion_valida' => false,
        'tipo_usuario'=>1,
        'gestion'=>$this->gestion,
        'datos'=>$this->datos,
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
        return view('iniciar_sesion')->with([
        'titulo' => 'Iniciar sesi&oacute;n Administrador del Sistema',
        'sesion_valida' => false,
        'tipo_usuario'=>0,
        'error_sesion'=>"",
        'gestion'=>$this->gestion,
        'datos'=>$this->datos]);
    }  
    public function verificarUsuario()
    {          
      $nombre = $_POST['username'];
      $pass = $_POST['password'];
      $error_sesion="";
      if($this->existeUsuario($nombre,$pass))
      {      
        $this->controlGestion();
        $this->controlActividades(Session::get('id'));
        if(Session::get('tipo')==2)
        {

          return view('/paginas/consultor/homeJefeConsultor')->with([
          'titulo' => 'Jefe Consultor',
          'sesion_valida' => true,
          'tipo_usuario'=> 2,
          'gestion'=>$this->gestion,
          'datos'=>$this->datos,         
          'nombre_foto' => Session::get('nombre_foto'),
          'nombre_usuario' => Session::get('nombre_usuario')]);
       } 
       if(Session::get('tipo')==3)
       {
          return view('/paginas/consultor/home_consultor')->with([
          'titulo' => 'Consultor',
          'sesion_valida' => true,
          'tipo_usuario'=> 3,
          'gestion'=>$this->gestion,
          'datos'=>$this->datos,          
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
       }
       if(Session::get('tipo')==4)
       {
          return view('/paginas/grupo_Empresa/home_grupo_empresa')->with([
          'titulo' => 'home del representate de la grupo empresa',
          'sesion_valida' => true,
          'tipo_usuario'=> 4,
          'gestion'=>$this->gestion,
          'datos'=>$this->datos,          
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
       } 
       if(Session::get('tipo')==5)
       {
          return view('/paginas/grupo_Empresa/home_integrante')->with([
          'titulo' => 'home del integrante de la grupo empresa',
          'sesion_valida' => true,
          'tipo_usuario'=> 5,
          'gestion'=>$this->gestion,
          'datos'=>$this->datos,          
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
        'gestion'=>$this->gestion,
        'datos'=>$this->datos,
        'error_sesion'=>$error_sesion]);

      }
    }    
}

