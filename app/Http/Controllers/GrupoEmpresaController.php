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
          'idGrupo'=>$id_grupo,
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
}
