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
use Response;
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
      $user->iniciarSesion(Session::get('id'));
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
          'titulo' => 'Publicar contrato',
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
            'titulo' => 'Publicar contrato',
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
  public function administrarArchivos()
  {
    $principal= new PrincipalController;
    $principal->controlGestion();
    $principal->controlActividades(Session::get('id'));
    $archivo = new Archivos;
    $archivos = $archivo->getArchivos(Session::get('id'));
    return view('/paginas/consultor/AdministrarJefeConsultor')->with([
       'titulo' => 'Administrar archivos',
       'sesion_valida' => true,
       'tipo_usuario'=> 2,
       'gestion'=>$principal->gestion,
       'datos'=>$principal->datos,       
       'nombre_foto'=>Session::get('nombre_foto'),
       'nombre_usuario'=>Session::get('nombre_usuario'),       
       'identi'=>0,
       'archivos'=> $archivos]);  
  }
  public function validarArchivos()
  {
    $user = new Usuario;
    $user->iniciarSesion(Session::get('id'));
    $archivo = new Archivos;
    $numDoc = $archivo->getNumDocumentos(Session::get('id'));   
    $num = $numDoc[0]->numer;
    for($con=0;$con<$num;$con++)
    {
      $a = $_POST["a".$con];
      $b = 0;
      if(isset($_POST["b".$con]))
      {
        $b=1;
      }
      $archivo->actualizarDocumentos($b,$a);
    }     
    echo"<META HTTP-EQUIV='Refresh' CONTENT='0.5; URL=administrar_archivos'>";
  }
  public function planificarActividades()
  {
    $principal= new PrincipalController;
    $principal->controlGestion();
    $principal->controlActividades(Session::get('id'));
    $fase = array(1=>'lanzamiento',2=>'registro',3=>'documentos',4=>'contratos',5=>'desarrollo',6=>'productos',7=>'cierre');
    $titulos = array(1=>' 1. Lanzamiento de la Convocatoria P&uacute;blica' ,2=>' 2. Habilitar registro de Grupo Empresas e Integrantes',3=>' 3. Entrega de Documentos',4=>' 4. Firma de Contratos',5=>' 5. Proceso de Desarrollo',6=>' 6. Entrega de Producto Final',7=>' 7. Cierre de la Convocatoria');
    return view('/paginas/consultor/PlanificaActividadesJefeConsultor')->with([
       'titulo' => 'Planificar actividades',
       'sesion_valida' => true,
       'tipo_usuario'=> 2,
       'gestion'=>$principal->gestion,
       'datos'=>$principal->datos,
       'fase'=>$fase,
       'subtitulo'=>$titulos,
       'nombre_foto'=>Session::get('nombre_foto'),
       'nombre_usuario'=>Session::get('nombre_usuario')]);    
  }
  public function validarActividades($id)
  {
    return $id;  
    $fase = array(1=>'lanzamiento',2=>'registro',3=>'documentos',4=>'contratos',5=>'desarrollo',6=>'productos',7=>'cierre');   
    if(isset($_POST['enviar_'.$id]))
    {           
      if(isset($_POST['inicio_'.$id]) && isset($_POST['fin_'.$id]) && isset($_POST['newsletter_'.$id]))
      {
        $inicio = $_POST['inicio_'.$id];
        $fin = $_POST['fin_'.$id];
        $fecha = date("Y-m-d");
        $actividad="checked";
        $principal= new PrincipalController;
        $principal->controlGestion();  
        $gestion = $principal->gestion;
        if($inicio >= $fecha && $fin >= $inicio)
        {         
          if(strtotime($fin) <= $gestion['fecha_fin'])
          {
            $actividad = new Actividades;
            $actividad->setFaseConvocatoria($inicio,$fin,$gestion['id_gestion'],$id);
            echo "<script type='text/javascript'>
                  alert('la actividad $fase[$id] se ha actualizado correctamente')
                  </script>
                  <META HTTP-EQUIV='Refresh' CONTENT='1; URL=planificacion.php'> ";
          }
          else
          {
            $error = true;
            $error_fecha = "La gesti&oacute;n termina la fecha ".$gestion['fecha_fin'];
          }                   
        }
        else
        {
          $error = true;
          $error_fecha = "La fecha de finalizaci&oacute;n no debe ser menor que la fecha de inicio y La fecha de inicio no debe ser menor a la fecha presente";
        }             
      }
      else
      {
        $error = true;
        $error_fecha = "La fecha de inicio o de finalizacion no es v&aacute;lida";
      }      
    }     
  }
}