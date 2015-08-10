<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Usuario extends Model
{
    public function GetUsuario($nombre,$clave,$tipo)
    {
    	$consulta_sql = DB::select('select * 
    		                        from usuario
    		                        where nombre_usuario = :nombre and clave = :clave and tipo_usuario = :tipo',['nombre' => $nombre,'clave'=> $clave,'tipo' => $tipo]);
        return $consulta_sql;
    }
    public function SetBitacora($id)
    {
    	DB::insert("INSERT INTO bitacora_sesion(usuario,fecha_hora,operacion)
                     VALUES (:id,CURRENT_TIMESTAMP,0)",['id'=>$id]);
    }
}
