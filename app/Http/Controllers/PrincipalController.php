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
use App\Http\Controllers\FormularioController;
use App\Usuario;
class PrincipalController extends Controller
{
  private $gestion;
  private $datos;
    private function controlGestion()
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
          $this->id_gestion =- 1;
          $this->nombre_gestion = "no definida";
          $this->gestion_valida = false;
          $gestion_espera = false;
          $gestion->SetGestion($id_gestion);             
        }
      }
      $this->gestion = array('id_gestion' => $id_gestion,
                             'nombre_gestion'=> $nombre_gestion,
                             'gestion_valida'=> $gestion_valida,
                             'fecha_ini' => $fecha_ini,
                             'fecha_fin' => $fecha_fin);
    }              
    private function controlActividades()
    {
      $numdoc=0;        
      $num_grupo_empresa=0;
      $num_consultor=0;

      $noticia = new Noticias;
      $resultado_noticias= $noticia->GetNoticias($this->gestion['id_gestion']);
      $numdoc = $noticia->GetNumeroDocumentos($this->gestion['id_gestion']);
      $num_consultores= $noticia->GetNumeroConsultores();
      $num_grupo_empresa= $noticia->GetNumeroGrupoEmpresas(); 

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
                           'men'=>0,
                           'actividad' => $actividad);
    } 
    public function inicio()
    {        
      $this->controlGestion();
      $this->controlActividades();
        return view('index')->with([
        'titulo' => 'Sistema de Apoyo a la Empresa TIS',
        'sesion_valida' => false,
        'tipo_usuario'=>0,        
        'gestion'=>$this->gestion,
        'datos'=>$this->datos]);
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
    private function existeUsuario($nombre,$pass){

        $user = new Usuario;
        $usuario = $user->GetUsuario($nombre,$pass);
  
        if($usuario!=null)
        {       
          Session::put('id',$usuario[0]->id_usuario);
          Session::put('tipo',$usuario[0]->tipo_usuario);
          Session::put('nombre_usuario',$usuario[0]->nombre_usuario);  
          Session::put('nombre_foto',$usuario[0]->foto);// OJO
          
          $user->SetBitacora($usuario[0]->id_usuario);
        return true;
        }else{
          return false;
        }
    }

    public function verificarAdministrador()
    {
      $nombre = $_POST['username'];
      $pass = $_POST['password'];
      //$nom = Request::get('password');
      if(isset($nombre) && isset($pass))
      { 
        if( $this->existeUsuario($nombre,$pass)){
          //header("Location: index");
          return view('loginAdministrador')->with([
        'titulo' => 'Administrador del Sistema',
        'sesion_valida' => true,
        'tipo_usuario'=> 1,
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
    



    public function tabla()
    {
       $condicional=false;
       return view('tabla')->with('condicional',$condicional);
    }
    public function modelo()    
    {
       $modelo = new App\functionLogin;
       $modelo->consulta();
    }
    public function paso()    
    {
        $actividad = new Actividades;
        $actividad->Actividad1(3);
        $actividad->Actividad2(3);
        $actividad->Actividad3(3);
        $actividad->Actividad4(3);
        $actividad->Actividad5(3);
        $actividad->Actividad6(3);
        $actividad->Actividad7(3);
       return view('master')->with('actividad',$actividad);
    }    
    public function mostrar($id)    
    {
       return view('prueba')->with('id',$id);
    }   
    public function padre()
    {
        return view('padre')->with([
        'hola'=>'jhon'
        ]);;
    }
    public function principal()
    {
      $aux = new Usuario;
      $b = $aux->GetUsuario('admin','admin',1);
      return $b[0]->clave;
    }

    public function iniciarSesion(){

     $this->controlGestion();
      $this->controlActividades();

     return view('iniciar_cesion')->with([
        'titulo' => 'Iniciar sesi&oacute;n Administrador del Sistema',
        'sesion_valida' => false,
        'tipo_usuario'=>0,
        'error_sesion'=>"",
        'gestion'=>$this->gestion,
        'datos'=>$this->datos]);

    }
  
    public function verificarUsuario(){
       $nombre = $_POST['username'];
       $pass = $_POST['password'];
       $error_sesion="";
      if( $this->existeUsuario($nombre,$pass)){
      
      if(Session::get('tipo')==2)
      {

          return view('/paginas/consultor/home_consultor')->with([
        'titulo' => 'Jefe Consultor',
        'sesion_valida' => true,
        'tipo_usuario'=> 2,
        'gestion'=>$this->gestion,
        'datos'=>$this->datos,
        'error_sesion'=>$error_sesion,
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);//------>>>?????
       } 
        if(Session::get('tipo')==3)
      {

          return view('/paginas/consultor/home_consultor')->with([
        'titulo' => 'Jefe Consultor',
        'sesion_valida' => true,
        'tipo_usuario'=> 3,
        'gestion'=>$this->gestion,
        'datos'=>$this->datos,
        'error_sesion'=>$error_sesion,
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);//------>>>?????
       }
        if(Session::get('tipo')==4)
      {

          return view('/paginas/grupo_Empresa/home_grupo_empresa')->with([
        'titulo' => 'Jefe Consultor',
        'sesion_valida' => true,
        'tipo_usuario'=> 4,
        'gestion'=>$this->gestion,
        'datos'=>$this->datos,
        'error_sesion'=>$error_sesion,
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);//------>>>?????
       } 
        if(Session::get('tipo')==5)
      {

          return view('/paginas/grupo_Empresa/home_integrante')->with([
        'titulo' => 'Jefe Consultor',
        'sesion_valida' => true,
        'tipo_usuario'=> 5,
        'gestion'=>$this->gestion,
        'datos'=>$this->datos,
        'error_sesion'=>$error_sesion,
        'nombre_foto'=>Session::get('nombre_foto'),
        'nombre_usuario'=>Session::get('nombre_usuario') ]);//------>>>?????
       }  
      }
      else
       {
        $error_sesion="Los datos incorrectos o usted no esta habilitado para esta gesti&oacute;n";
        return view('iniciar_cesion')->with([
        'titulo' => 'Jefe Consultor',
        'sesion_valida' => true,
        'tipo_usuario'=> 0,
        'gestion'=>$this->gestion,
        'datos'=>$this->datos,
        'error_sesion'=>$error_sesion]);//------>>>?????
       }

    }
   
    }//fin metodo verificarUsuario

