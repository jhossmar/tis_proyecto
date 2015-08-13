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
use App\Http\Controllers\PrincipalController;
class JefeConsultorController extends Controller
{
	 public function homeJefeConsultor()
    {
      $principal= new PrincipalController;
      $principal->controlGestion();
      $principal->controlActividades(Session::get('id'));
      return view('/paginas/consultor/homeJefeConsultor')->with([
          'titulo' => 'home Jefe Consultor',
          'sesion_valida' => true,
          'tipo_usuario'=> 2,
          'gestion'=>$principal->gestion,
          'datos'=>$principal->datos,          
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
    }
    public function informacionJefeConsultor()
    {
      $principal= new PrincipalController;
      $principal->controlGestion();
      $principal->controlActividades(Session::get('id'));
      $user = new Usuario;       
      $infUser = $user->GetInformacionConsultor(Session::get('id'));
      
      return view('/paginas/consultor/informacionJefeConsultor')->with([
          'titulo' => 'Informacion del Jefe Consultor TIS',
          'sesion_valida' => true,
          'tipo_usuario'=> 2,
          'gestion'=>$principal->gestion,
          'datos'=>$principal->datos,
          'infUser'=>$infUser,          
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario')]);
      
    }
    public function modificarJefeConsultor()
    {
      $principal= new PrincipalController;
      $principal->controlGestion();
      $principal->controlActividades(Session::get('id'));
      $user = new Usuario;       
      $infUser = $user->GetInformacionConsultor(Session::get('id'));
      return view('/paginas/consultor/modificarJefeConsultor')->with([
          'titulo' => 'Modificar datos Jefe Consultor TIS',
          'sesion_valida' => true,
          'tipo_usuario'=> 2,
          'gestion'=>$principal->gestion,
          'datos'=>$principal->datos,
          'infUser'=>$infUser,          
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario')]);
    }
    public function validarCambiosJefeConsultor()
    {
      $username=trim($_POST['username']);    
      $apellido=$_POST['lastname'];
      $nombre=$_POST['firstname'];
      $telf=trim($_POST['telf']);
      $email=trim($_POST['email']);
      $error=false;
      $error_email='';
      $error_usuario='';
      $this->controlGestion();
      $user = new Usuario;
      $infUser = $user->GetInformacionConsultor(Session::get('id'));
      $principal= new PrincipalController;
      $principal->controlGestion();
      $principal->controlActividades(Session::get('id'));
      if(strcmp($email,$infUser[0]->email)!=0)
      {
        $correo = $user->verificarEmail($email,$this->gestion['id_gestion']);
        if(!empty($correo))
        {
          $error=true;
          $error_email="El e-mail ya esta registrado";
        }        
      }
      if(strcmp($username,$infUser[0]->nombre_usuario)!=0)
      {
        $usuario = $user->verificarEmail($email,$this->gestion['id_gestion']);
        if(!empty($usuario))
        {
          $error=true;
          $error_usuario="El nombre de usuario ya esta registrado";
        }        
      }
      if(!$error)
      {
        $user->actualizarDatos(Session::get('id'), $username, $nombre, $apellido, $telf, $email);
          
        echo "<script type='text/javascript'>
              alert('Tus datos se han modificado de forma exitosa!')
              </script>
              <META HTTP-EQUIV='Refresh' CONTENT='1; URL=index'> ";
     }
     else
     {
      return view('/paginas/consultor/modificarJefeConsultor')->with([
          'titulo' => 'Modificar datos Jefe Consultor TIS',
          'sesion_valida' => true,
          'tipo_usuario'=> 2,
          'gestion'=>$principal->gestion,
          'datos'=>$principal->datos,          
          'error_email'=>$error_email,
          'error_usuarior'=>$error_usuario,
          'infUser'=>$infUser,
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario')]);
     }
    }
   public function subirJefeConsultor()
   {
      $principal= new PrincipalController;
      $principal->controlGestion();
      $principal->controlActividades(Session::get('id'));
      return view('/paginas/consultor/subirJefeConsultor')->with([
          'titulo' => 'Publicar avisos Jefe Consultor TIS',
          'sesion_valida' => true,
          'tipo_usuario'=> 2,
          'gestion'=>$principal->gestion,
          'datos'=>$principal->datos,          
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario')]);
    }

    public function validarAvisoJefeConsultor()
    {
      $descripcion=$_POST['descripcion'];
      $usuario=Session::get('nombre_usuario');
      $tituloD=$_POST['tituloD'];
      $error=false;
      $documento="";
      $tiene_doc=0;
      $ext_permitidas = array('.pdf','.doc','.docx','.xls','.xlsx','.ppt','.pptx','.txt');
      
      if(!empty($_FILES['documento']['name']))
      {
        $idUnico = time();
        $nombre_archivo = $_FILES['documento']['name'];
        $nombre_tmp = $_FILES['documento']['tmp_name'];
        $extension = substr($nombre_archivo, strpos($nombre_archivo, '.'));
        $tamano = $_FILES['documento']['size'];             
        $limite = 1000 * 1024;     
        if(in_array($extension, $ext_permitidas))
        {
          if($tamano <= $limite)
          {
            if($_FILES['documento']['error'] <= 0)
            {
              if(file_exists('archivos/'.$idUnico.'-'.$nombre_archivo))
              {
                $error_doc='El archivo ya existe';
                $error=true;
              }
              else
              { 
                move_uploaded_file($nombre_tmp,'archivos/'.$idUnico.'-'.$nombre_archivo);
                $documento='archivos/'.$idUnico.'-'.$nombre_archivo;
                $tiene_doc=1;
              }                      
            }
            else
            {
              $error_doc='Error al subir el archivo';
              $error=true;
            }
          }
          else
          {
            $error_doc='El archivo debe un tama&ntilde;o menor a 1 Mega Byte';
            $error=true;
          }
        }
        else
        {
          $error=true;
          $error_doc='El formato del archivo no esta permitido';
        }
      }
      if(!$error)
      {
        $principal= new PrincipalController;
        $principal->controlGestion();
        $archivo = new Archivos;
        $archivo->setArchivo($tituloD,$descripcion,$documento,Session::get('id'),$principal->gestion['id_gestion']);
        echo "<script type='text/javascript'>
              alert('Se ha subido el archivo de forma exitosa!')
              </script>
              <META HTTP-EQUIV='Refresh' CONTENT='1; URL=index'> ";
      }
      else
      {
        $principal= new PrincipalController;
        $principal->controlGestion();
        $principal->controlActividades(Session::get('id'));
        return view('/paginas/consultor/subirJefeConsultor')->with([
          'titulo' => 'Publicar avisos Jefe Consultor TIS',
          'sesion_valida' => true,
          'tipo_usuario'=> 2,
          'gestion'=>$principal->gestion,
          'datos'=>$principal->datos,
          'error'=>$error,
          'error_doc'=>$error_doc,
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario')]);
      }
    }
    public function subirContrato()
    {
      $principal= new PrincipalController;
      $principal->controlGestion();
      $principal->controlActividades(Session::get('id'));
      return view('/paginas/consultor/subirContratoJefeConsultor')->with([
          'titulo' => 'Publicar avisos Jefe Consultor TIS',
          'sesion_valida' => true,
          'tipo_usuario'=> 2,
          'gestion'=>$principal->gestion,
          'datos'=>$principal->datos,          
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario')]);
    }
    public function validarContrato()
    {
      if(isset($_POST['enviar']))
      {
        $descripcionA=$_POST['descripcionA'];
        $tituloD=$_POST['tituloD'];
        $usuario=Session::get('id');
        $nombre_usuario=Session::get('nombre_usuario');
        $errorA=false;  
        $contrato="";
        $tiene_doc=0;
        $ext_permitidas = array('.pdf','.doc','.docx','.xls','.xlsx','.ppt','.pptx','.txt');
        
        if(!empty($_FILES['contrato']['name']))
        {
          $idUnico = time();
          $nombre_archivo = $_FILES['contrato']['name'];
          $nombre_tmp = $_FILES['contrato']['tmp_name'];
          $ext = substr($nombre_archivo, strpos($nombre_archivo, '.'));
          $tamano = $_FILES['contrato']['size'];             
          $limite = 1000 * 1024;
          $idUnico = time();
          if(in_array($ext, $ext_permitidas))
          {
            if($tamano <= $limite)
            {
              if( $_FILES['contrato']['error'] <= 0 )
              {
                if( file_exists( 'archivos/'.str_replace(" ", "_", $nombre_usuario).'-'.$tituloD.'-'.$idUnico.$ext))
                {
                  $error_docA='Usted ya subio el contrato';
                  $errorA=true;
                }
                else
                {
                  move_uploaded_file($nombre_tmp, 'archivos/'.str_replace(" ", "_", $nombre_usuario).'-'.$tituloD.'-'.$idUnico.$ext);
                  $contrato='archivos/'.str_replace(" ", "_", $nombre_usuario).'-'.$tituloD.'-'.$idUnico.$ext;
                  $tiene_doc=1;
                }
              }
              else
              {
                $error_docA='Error al subir el archivo';
                $errorA=true;
              }
            }
            else
            {
              $error_docA='El archivo debe un tama&ntilde;o menor a 1 Mega Byte';
              $errorA=true;
            }
          }
          else
          {
            $errorA=true;
            $error_docA='El formato del archivo no esta permitido';
          }
        }
        else
        {
          $error_docA='Debe seleccionar un archivo';
          $errorA=true;
        }  
        if(!$errorA)
        {
          $principal= new PrincipalController;
          $principal->controlGestion();
          $archivo = new Archivos;
          $archivo->setContrato($tituloD,$descripcionA,$contrato,Session::get('id'),$principal->gestion['id_gestion']);
          echo "<script type='text/javascript'>
               alert('Se ha subido el contrato de forma exitosa!')
               </script>
               <META HTTP-EQUIV='Refresh' CONTENT='1; URL=index'> ";
        }
        else
        {
          $principal= new PrincipalController;
          $principal->controlGestion();
          $principal->controlActividades(Session::get('id'));
          return view('/paginas/consultor/subirContratoJefeConsultor')->with([
            'titulo' => 'Publicar avisos Jefe Consultor TIS',
            'sesion_valida' => true,
            'tipo_usuario'=> 2,
            'gestion'=>$principal->gestion,
            'datos'=>$principal->datos,
            'errorA'=>$errorA,
            'error_docA'=>$error_docA,
            'nombre_foto'=>Session::get('nombre_foto'),
            'nombre_usuario'=>Session::get('nombre_usuario')]);
        }
      }      
    }
}
