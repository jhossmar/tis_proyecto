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
	public function GetNumero($id_gestion)
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
  public function GetNoticiasGestion($usuario,$fecha_fin_gestion,$fecha_ini_gestion)
  {
    $consulta = DB::select("SELECT COUNT(*) as numer
                            FROM notificacion
                            WHERE usuario_destino = :'usuario' AND fecha <= 'fecha_fin_gestion 23:59:59' AND fecha>='fecha_ini_gestion 00:00:01' AND leido=0",['usuario'=>$usuario,'fecha_ini_gestion'=>$fecha_ini_gestion,'fecha_fin_gestion'=>$fecha_fin_gestion]);
    return $consulta;
  }  
}
?>