<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Noticias extends Model
{
	private $documento;
	private $num;
	public function GetNoticias($id_gestion)
	{
	  $consulta = DB::select("SELECT  nombre_documento, ruta_documento, fecha_documento, descripsion_documento, consultor_tis, nombre,apellido
                            FROM documento_consultor d, usuario u
                            WHERE  documento_jefe= '1' AND d.gestion= :id_gestion AND d.consultor_tis=u.id_usuario", ['id_gestion' => $id_gestion]);	
	  if(!empty($consulta))
      {
    	$this->documento=$consulta;
      }
      else
      {
        $this->documento=null;
      }
      return $this->documento;
	}	
	public function GetNumeroDocumentos($id_gestion)
	{
      $this->numero = 0;

      $respuesta = DB::select("SELECT COUNT(*) as numer
                               FROM documento_consultor
                               WHERE  documento_jefe= '1' AND gestion=:id_gestion",['id_gestion'=>$id_gestion]);      
      if($respuesta[0] != null)
      {        
        $this->num =(int)$respuesta[0]->numer;  
      }
      else
      {
        $this->num=0;
      }
      return $this->num;
	}
  public function GetNotificaciones($usuario,$fecha_fin_gestion,$fecha_ini_gestion)
  {
    $consulta = DB::select("SELECT COUNT(*) as numer
                            FROM notificacion
                            WHERE usuario_destino = :usuario AND fecha <= :fecha_fin_gestion AND fecha>=:fecha_ini_gestion AND leido=0",['usuario'=>$usuario,'fecha_ini_gestion'=>$fecha_ini_gestion,'fecha_fin_gestion'=>$fecha_fin_gestion]);
    return $consulta;
  }
  public function GetNumeroConsultores()
  {
    $consulta_sql=DB::select("SELECT COUNT(*) as num
                              FROM usuario
                              WHERE (tipo_usuario = '2' || tipo_usuario = '3') AND habilitado = '0'");    
    return $consulta_sql[0]->num;
  }
  public function GetNumeroGrupoEmpresas()
  {
    $consulta_sql=DB::select("SELECT COUNT(*) as num
                              FROM usuario
                              WHERE tipo_usuario = '4' AND habilitado = '0'");
    return $consulta_sql[0]->num;
  }        
}
?>