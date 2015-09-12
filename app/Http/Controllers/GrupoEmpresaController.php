<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\GrupoEmpresa;
use Request;
use Session;
use App\noticias;
use App\Usuario;
use App\Http\Controllers\VerificadorDeSesiones;

class GrupoEmpresaController extends Controller
{
    public function homeGrupo()
    {
    	  $principal = new VerificadorDeSesiones;
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
          'numIntegrantes'=>$numIntegrantes[0]->numero,
          'roles'=>$roles,
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
    }
    public function entregaSubSistema()
    {
      
      $principal = new VerificadorDeSesiones;
    	$grupo = new GrupoEmpresa;
      $id_grupo = $grupo->getIdGrupo(Session::get('id'));
      $numIntegrantes = $grupo->getNumeroIntegrantes($id_grupo[0]->id_grupo_empresa);       
     
      $entregas=$grupo->getEntregaProductos($id_grupo[0]->id_grupo_empresa);
      $responsables  = array();
      if($entregas!=null)
      {
        $usuario = new Usuario;
        foreach ($entregas as $entrega) 
        {
           $aux = $entrega->id_responsable;
           $aux2 = $usuario->GetNombreUsuario($aux);          
           $responsables[] = $aux2[0]->nombre." ".$aux2[0]->apellido;
        }
      }
      
      return view('/paginas/grupo_Empresa/entrega_subsistema')->with([
          'titulo' => 'Entrega de Productos',
          'sesion_valida' => true,
          'tipo_usuario'=> 4,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'idGrupo'=>$id_grupo[0]->id_grupo_empresa,
          'numIntegrantes'=>$numIntegrantes[0]->numero,
          'responsables'=>$responsables,
          'entregas'=>$entregas,
          'contador'=>count($entregas),
          'aux'=>0,
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
    }
    public function informacionGrupo()
    {
        $principal = new VerificadorDeSesiones;
        $grupo = new GrupoEmpresa;
        $representante = $grupo->getInformacionIntegrante(Session::get('id'));
        $inf_grupo = $grupo->getInformacionGrupo($representante[0]->grupo_empresa);
        $roles = $grupo->getRolIntegrante(Session::get('id'));
        
        return view('/paginas/grupo_Empresa/informacion_grupo')->with([
          'titulo' => 'Informacion de la Grupo Empresa',
          'sesion_valida' => true,
          'tipo_usuario'=> 4,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'representante'=>$representante,
          'inf_grupo'=>$inf_grupo,
          'roles'=>$roles,
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
    }
    public function administrarIntegrantes()
    {
        $principal = new VerificadorDeSesiones;
        $grupo = new GrupoEmpresa;
        $aux = $grupo->getIdGrupo(Session::get('id'));
        $id_grupo = $aux[0]->id_grupo_empresa;
        $inf_integrantes=$grupo->getDatosIntegrantes($id_grupo);
        $roles=$grupo->getMetodologias($id_grupo); 
        $rolesIntegrantes = array();
        foreach ($inf_integrantes as $integrante) 
        {
          $aux=$grupo->getRolIntegrante($integrante->id_usuario);
          $rolesIntegrantes[]=$aux[0];
        }
        
        return view('/paginas/grupo_Empresa/administrar_integrantes')->with([
            'titulo' => 'Informacion de la Grupo Empresa',
            'sesion_valida' => true,
            'tipo_usuario'=> 4,
            'gestion'=>$principal->GetGestion(),
            'datos'=>$principal->GetDatos(),
            'integrantes'=>$inf_integrantes,
            'contador'=>0,
            'id_grupo'=>$id_grupo,
            'roles'=>$roles,
            'rolesIntegrantes'=>$rolesIntegrantes,
            'nombre_foto'=>Session::get('nombre_foto'),
            'nombre_usuario'=>Session::get('nombre_usuario') ]);
    }
    public function validarCambiosIntegrantes()
    {    
      $grupo = new GrupoEmpresa;      
      
      for ($i=0; $i < $_POST['numIntegrantes']; $i++) 
      { 
        $id_integrante=$_POST["a".$i];

        if(isset($_POST["b".$i]))
        {
          $grupo->setHabilitado(1,$id_integrante);
        }
        else
        {
          $grupo->setHabilitado(0,$id_integrante); 
        }
        if(isset($_POST["rol".$i]))
        {
          $grupo->setRolIntegrante($id_integrante,$_POST["rol".$i]);          
        }         
      }
      return redirect('administrar_integrante');
    }
    public function agregarIntegrantes()
    {
      $principal = new VerificadorDeSesiones;
      $grupo = new GrupoEmpresa;
      $id_grupo = $grupo->getIdGrupo(Session::get('id'));
      $numIntegrantes = $grupo->getNumeroIntegrantes($id_grupo[0]->id_grupo_empresa);       
      $aux=$grupo->getMetodoGrupo($id_grupo[0]->id_grupo_empresa);
      $id_metodo =$aux[0]->id_metodologia;
      $roles=$grupo->getRoles($id_metodo);
      
      return view('/paginas/grupo_Empresa/agregar_integrantes')->with([
          'titulo' => 'agregar integrantes a la grupo empresa',
          'sesion_valida' => true,
          'tipo_usuario'=> 4,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),          
          'numIntegrantes'=>$numIntegrantes[0]->numero,
          'roles'=>$roles,
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
      
    }
    public function validarNuevoIntegrante()
    {
     //return redirect('administrar_integrante');
      $error_user='';
      $error_carrera='';
      $error_rol='';
      $error_email='';
      $error_cod='';
      if(isset($_POST['agregar']))
      {
        $error=false;      
        $usuario=$_POST['username'];
        $clave=$_POST['password'];
        $eMail=$_POST['email'];
        $foto = "img/profiles/default.jpg";    
        $cod_sis = $_POST['codSIS'];
        $nombre_rep = $_POST['firstname'];
        $apellido_rep = $_POST['lastname'];
        $telefono_rep = $_POST['telf'];
        $carrera_rep = $_POST['choose_carrera'];        
        $rol = $_POST['rol'];
        
      }
      if ($carrera_rep=='-1' )
      {
        $error=true;
        $error_carrera="Debe seleccionar una carrera";
      }
      if($rol=='-1')
      {
        $error=true;
        $error_rol="Debe seleccionar un rol";
      }
      $principal = new VerificadorDeSesiones;      
      $user = new Usuario;
      $correo = $user->verificarEmail($eMail,$principal->getGestion()['id_gestion']);
      $nombre = $user->verificarUsuario($usuario,$principal->getGestion()['id_gestion']);
      $codsis = $user->verificarCodSis($cod_sis,$principal->getGestion()['id_gestion']);      
      if(is_array($nombre) && !empty($nombre))//ya existe usuario o email
      {
        if(strcmp($nombre[0]->nombre_usuario,$usuario)==0)
        { 
          $error_user="El usuario ya esta registrado";
          $error=true;
        }   
      }
      if(is_array($correo) && !empty($correo))
      {
        if(strcmp($correo[0]->email,$eMail)==0) 
        {
          $error_email="El correo electr&oacute;nico ya est&aacute; registrado";
          $error=true;
        } 
      }
      if(is_array($codsis) && !empty($codsis))
      {        
          $error_cod="El integrante ya est&aacute; registrado en esta gesti&oacute;n";
          $error=true;        
      }
      if(!$error)
      {        
        $user->iniciarSesion(Session::get('id'));
        $salt="$2x$07$./f4af7kJi1jdaxlswE34$";
        $clave1=crypt($clave, $salt);  
        $user->insertarUsuario($usuario,$clave1,$nombre_rep,$apellido_rep,$telefono_rep,$eMail,$foto,1,5,$principal->getGestion()['id_gestion']);                        
        $grupo = new GrupoEmpresa;        
        $id_grupo = $grupo->getIdGrupo(Session::get('id'))[0]->id_grupo_empresa;
        $id_user = $user->getIdUsuario($usuario,$clave1)[0]->id_usuario;                
        $grupo->insertarIntegrante($id_user,$cod_sis,$carrera_rep,$id_grupo);
        $user->insertarRol((int)$id_user,(int)$rol);
        return redirect('administrar_integrante');
      }
      else
      {
        return "ha ingresado mal los datos";
      }

    }
}
