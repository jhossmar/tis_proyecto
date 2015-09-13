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
    public function documentosGrupo()
    {
      $principal = new VerificadorDeSesiones;
      $grupo = new GrupoEmpresa;
      $id_grupo = $grupo->getIdGrupo(Session::get('id'))[0]->id_grupo_empresa;  
      $numIntegrantes = $grupo->getNumeroIntegrantes($id_grupo);       
      $sobre=$grupo->getSobres($id_grupo)[0];      
      $documentos=$grupo->getDocumentoCompartido($id_grupo);

      return view('/paginas/grupo_Empresa/documentos_grupo')->with([
          'titulo' => 'Enviar Documentos Grupo Empresa',
          'sesion_valida' => true,
          'tipo_usuario'=> 4,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'numintegrantes'=>$numIntegrantes,
          'sobre'=>$sobre,
          'documentos'=>$documentos,
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
    }
    public function validarDocumentos()
    {      
      if(isset($_POST['enviar']))
      {  
         $sobreA=$_FILES['documentoA'];
         $sobreB=$_FILES['documentoB'];
         $usuario=Session::get('nombre_usuario');
         $errorA=false;  
         $documentoA="";
         $tiene_doc=0;
         $ext_permitidas = array('.pdf','.doc','.docx','.xls','.xlsx','.ppt','.pptx','.zip','.rar');
  
        if(!empty($_FILES['documentoA']['name']))
        {
          $idUnico = time();
          $nombre_archivo = $_FILES['documentoA']['name'];
          $nombre_tmp = $_FILES['documentoA']['tmp_name'];
          $ext = substr($nombre_archivo, strpos($nombre_archivo, '.'));
          $tamano = $_FILES['documentoA']['size'];             
          $limite = 1000 * 1024;
          if(in_array($ext, $ext_permitidas))
          {
            if($tamano <= $limite )
            {
              if( $_FILES['documentoA']['error']<= 0)
              {
                if( file_exists( 'archivos/'.str_replace(" ", "_", $usuario).'-'.'sobreA'.$ext) )
                {
                  $error_docA='El archivo ya existe';
                  $errorA=true;
                }
                else
                {
                  $nombre_tmp_A=$nombre_tmp;
                  $documentoA='archivos/'.$usuario.'-'.'sobreA'.$ext;
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
          $error_docA='No se subio el sobre A';
          $errorA=true;
        }
        $errorB=false;
        $documentoB="";
        $tiene_doc=0;
        if(!empty($_FILES['documentoB']['name']))
        {
          $idUnico = time();
          $nombre_archivo = $_FILES['documentoB']['name'];
          $nombre_tmp = $_FILES['documentoB']['tmp_name'];
          $ext = substr($nombre_archivo, strpos($nombre_archivo, '.'));
          $tamano = $_FILES['documentoB']['size'];
          $limite = 1000 * 1024;
          if(in_array($ext, $ext_permitidas))
          {
            if( $tamano <= $limite )
            {
              if( $_FILES['documentoB']['error'] <= 0 )
              {
                if(file_exists('archivos/'.str_replace(" ", "_", $usuario).'-'.'sobreB'.$ext))
                {
                  $error_docB='El archivo ya existe';
                  $errorB=true;
                }
                else
                {
                  if(!$errorA)
                  {
                    $documentoA = str_replace(" ", "_", $documentoA);
                    $documentoB='archivos/'.$usuario.'-'.'sobreB'.$ext;
                    $documentoB = str_replace(" ", "_", $documentoB);
                    move_uploaded_file($nombre_tmp_A, $documentoA);
                    move_uploaded_file($nombre_tmp, $documentoB);
                    $tiene_doc=1;
                    $grupo = new GrupoEmpresa;
                    $id_grupo = $grupo->getIdGrupo(Session::get('id'))[0]->id_grupo_empresa;
                    $grupo->setSobres($id_grupo,$documentoA,$documentoB);
                    return redirect('subir_grupo_empresa');
                  }
                }
              }
              else
              {
                $error_docB='Error al subir el archivo';
                $errorB=true;
              }
            }
            else
            {
              $error_docB='El archivo debe un tama&ntilde;o menor A 1 Mega Byte';
              $errorB=true;
            }
          }          
          else
          {
            $errorB=true;
            $error_docB='El formato del archivo no esta permitido';
          }
        }
        else
        {
          $error_docB='No se subio el sobre B';
          $errorB=true;
        }
      }
      if($errorA==true)
      {
        $principal = new VerificadorDeSesiones;
        $grupo = new GrupoEmpresa;
        $id_grupo = $grupo->getIdGrupo(Session::get('id'))[0]->id_grupo_empresa;  
        $numIntegrantes = $grupo->getNumeroIntegrantes($id_grupo);       
        $sobre=$grupo->getSobres($id_grupo)[0];      
        $documentos=$grupo->getDocumentoCompartido($id_grupo);
        
        return view('/paginas/grupo_Empresa/documentos_grupo')->with([
          'titulo' => 'Enviar Documentos Grupo Empresa',
          'sesion_valida' => true,
          'tipo_usuario'=> 4,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'numintegrantes'=>$numIntegrantes,
          'sobre'=>$sobre,
          'error_docA'=>$error_docA,
          'documentos'=>$documentos,
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
      }
      if($errorB==true)
      {
        $principal = new VerificadorDeSesiones;
        $grupo = new GrupoEmpresa;
        $id_grupo = $grupo->getIdGrupo(Session::get('id'))[0]->id_grupo_empresa;  
        $numIntegrantes = $grupo->getNumeroIntegrantes($id_grupo);       
        $sobre=$grupo->getSobres($id_grupo)[0];      
        $documentos=$grupo->getDocumentoCompartido($id_grupo);
        
        return view('/paginas/grupo_Empresa/documentos_grupo')->with([
          'titulo' => 'Enviar Documentos Grupo Empresa',
          'sesion_valida' => true,
          'tipo_usuario'=> 4,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'numintegrantes'=>$numIntegrantes,
          'sobre'=>$sobre,
          'error_docB'=>$error_docB,
          'documentos'=>$documentos,
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
      }
    }
    public function planificacionEntrega()
    {
      $principal = new VerificadorDeSesiones;
      $grupo = new GrupoEmpresa;
      $id_grupo = $grupo->getIdGrupo(Session::get('id'))[0]->id_grupo_empresa;
      $numIntegrantes = $grupo->getNumeroIntegrantes($id_grupo);
      $subsistemas=$grupo->getEntrgaSubsistema($id_grupo);
      $integrantes = $grupo->getNombreIntegrantes($id_grupo);
      $errores = array('','');
      return view('/paginas/grupo_Empresa/entrega_subsistema')->with([
          'titulo' => 'Cronograma de entrega de subsistemas',
          'sesion_valida' => true,
          'tipo_usuario'=> 4,
          'gestion'=>$principal->GetGestion(),
          'datos'=>$principal->GetDatos(),
          'numIntegrantes'=>$numIntegrantes,
          'subsistemas'=>$subsistemas,
          'contador'=>0,
          'errores'=>$errores,
          'integrantes'=>$integrantes,
          'nombre_foto'=>Session::get('nombre_foto'),
          'nombre_usuario'=>Session::get('nombre_usuario') ]);
    }
    public function validarEntrega()
    {
      if (isset($_POST['enviar']))
      {
        $error=false;
        $fecha = date("Y-m-d");
        $principal = new VerificadorDeSesiones;
        $gestion=$principal->GetGestion();
        $inigestion=strftime("%y/%m/%d",$gestion['fecha_ini']);
        $fingestion=strftime("%y/%m/%d",$gestion['fecha_fin']);
        $errores = array('','');//0-fin, 1-ini
        if(isset($_POST['inicio']) && isset($_POST['fin']))
        {
          $inicio = $_POST['inicio'];
          $fin = $_POST['fin'];
          $ini_dia = substr($inicio, 8);
          $ini_mes = substr($inicio, 5,2);
          $ini_year = substr($inicio, 0,4);
          $fin_dia = substr($fin, 8);
          $fin_mes = substr($fin, 5,2);
          $fin_year = substr($fin, 0,4);
          if(@checkdate($ini_mes, $ini_dia, $ini_year))
          {
            if(@checkdate($fin_mes, $fin_dia, $fin_year)) 
            {
              if($inicio>=$fecha)
              {
                if($fin>$inicio)
                {
                  if(strtotime($inicio)>=$gestion['fecha_ini']&&strtotime($inicio)<=$gestion['fecha_fin'])
                  {
                    if(strtotime($fin)<=$gestion['fecha_fin'])
                    {
                      $descripcion=$_POST['descripcionG'];
                      $pago=$_POST['pagos'];
                      $responsable=$_POST['responsable'];
                      $grupo = new GrupoEmpresa;
                      $id_grupo = $grupo->getIdGrupo(Session::get('id'))[0]->id_grupo_empresa;
                      $grupo->setEntregaProducto($descripcion,$inicio,$fin,$pago,$id_grupo,$responsable);                      
                      return redirect('entrega_producto');
                    }
                    else
                    {
                      $error = true;
                      $errores[0] = "La fecha de finalizaci&oacute;n debe encontrarse dentro de la gesti&oacute;n ".$inigestion." al ".$fingestion;
                    }
                  }
                  else
                  {
                    $error = true;
                    $errores[1] = "La fecha de inicio debe encontrarse dentro de la gesti&oacute;n ".$inigestion." al ".$fingestion;
                  }
                }
                else
                {
                  $error = true;
                  $errores[0] = "La fecha de finalizaci&oacute;n no debe ser menor o igual a la fecha de inicio";
                }
              }
              else
              {
                $error = true;
                $errores[1] = "La fecha de inicio no debe ser menor a la fecha presente";
              }
            }
            else
            {
              $error = true;
              $errores[0] = "La fecha de finalizacion no es valida";
            }
          }
          else
          {
            $error = true;
            $errores[1] = "La fecha de inicio no es valida";
          }
        }
        if($error = true)
        {
          $principal = new VerificadorDeSesiones;
          $grupo = new GrupoEmpresa;
          $id_grupo = $grupo->getIdGrupo(Session::get('id'))[0]->id_grupo_empresa;
          $numIntegrantes = $grupo->getNumeroIntegrantes($id_grupo);
          $subsistemas=$grupo->getEntrgaSubsistema($id_grupo);
          $integrantes = $grupo->getNombreIntegrantes($id_grupo);
          return view('/paginas/grupo_Empresa/entrega_subsistema')->with([
              'titulo' => 'Cronograma de entrega de subsistemas',
              'sesion_valida' => true,
              'tipo_usuario'=> 4,
              'gestion'=>$principal->GetGestion(),
              'datos'=>$principal->GetDatos(),
              'numIntegrantes'=>$numIntegrantes,
              'subsistemas'=>$subsistemas,
              'contador'=>0,
              'errores'=>$errores,
              'integrantes'=>$integrantes,
              'nombre_foto'=>Session::get('nombre_foto'),
              'nombre_usuario'=>Session::get('nombre_usuario') ]);
        }
      }
      if(isset($_POST['guardar']))
      {
        $contCEP=(int) $_POST['CEP'];
        $ccep=0;
        $grupo = new GrupoEmpresa;
        while($ccep<$contCEP)
        {
          $ide=(int)$_POST["A0".$ccep];
          if(isset($_POST["A1".$ccep]))
          {                         
            $actividades = $grupo->getIdActividad($ide);
            foreach ($actividades as $actividad) 
            {
              $grupo->eliminarTareas($actividad->id_actividad);
              $grupo->eliminarActividad($actividad->id_actividad);
            }                                    
            $grupo->eliminarEntregaProducto($ide);
            return redirect('entrega_producto');
          }
          $ccep++;
        }
      }
    }    
}
